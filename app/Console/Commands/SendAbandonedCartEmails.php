<?php

namespace App\Console\Commands;

use App\Models\AbandonedCart;
use App\Models\Cart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendAbandonedCartEmails extends Command
{
    protected $signature = 'carts:send-abandoned-emails';
    protected $description = 'Send reminder emails for abandoned carts (>24 hours old)';

    public function handle()
    {
        $this->info('Checking for abandoned carts...');

        // Find cart sessions that haven't been updated in 24 hours
        // and don't have an order
        $abandonedThreshold = Carbon::now()->subHours(24);

        $abandonedCarts = Cart::where('updated_at', '<=', $abandonedThreshold)
            ->whereDoesntHave('order')
            ->with(['user', 'items.product'])
            ->get();

        $emailsSent = 0;

        foreach ($abandonedCarts as $cart) {
            // Skip if already tracked
            $existingRecord = AbandonedCart::where('cart_id', $cart->id)->first();
            if ($existingRecord && $existingRecord->reminder_sent) {
                continue;
            }

            // Calculate cart total
            $cartTotal = $cart->items->sum(function($item) {
                return $item->quantity * $item->price;
            });

            // Create or update abandoned cart record
            $abandonedCart = AbandonedCart::updateOrCreate(
                ['session_id' => $cart->session_id],
                [
                    'user_id' => $cart->user_id,
                    'email' => $cart->user ? $cart->user->email : 'guest@unknown.com',
                    'cart_data' => json_encode($cart->items->toArray()),
                    'total_amount' => $cartTotal,
                    'reminder_sent' => false,
                    'abandoned_at' => $cart->updated_at
                ]
            );

            // Send email if user exists and email not already sent
            if ($cart->user && $cart->user->email && !$abandonedCart->reminder_sent) {
                try {
                    // Send abandoned cart email
                    Mail::send('emails.abandoned-cart', [
                        'user' => $cart->user,
                        'cart' => $cart,
                        'cartTotal' => $cartTotal
                    ], function($message) use ($cart) {
                        $message->to($cart->user->email, $cart->user->name)
                                ->subject('🛍️ Your Cart is Waiting - Rizla Cosmetics');
                    });

                    // Mark email as sent
                    $abandonedCart->update(['reminder_sent' => true, 'reminder_sent_at' => now()]);
                    $emailsSent++;

                    $this->info("✅ Email sent to: {$cart->user->email}");

                } catch (\Exception $e) {
                    $this->error("❌ Failed to send email to {$cart->user->email}: " . $e->getMessage());
                }
            }
        }

        $this->info("✅ Abandoned cart check complete. Emails sent: {$emailsSent}");

        return 0;
    }
}
