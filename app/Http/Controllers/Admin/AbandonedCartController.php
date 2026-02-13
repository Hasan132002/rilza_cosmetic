<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbandonedCart;
use Illuminate\Http\Request;

class AbandonedCartController extends Controller
{
    public function index(Request $request)
    {
        $query = AbandonedCart::with('user')->latest('abandoned_at');

        // Filter by reminder sent status
        if ($request->has('reminder_sent')) {
            $query->where('reminder_sent', $request->reminder_sent);
        }

        // Search by email
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $abandonedCarts = $query->paginate(20);

        $stats = [
            'total' => AbandonedCart::count(),
            'reminder_sent' => AbandonedCart::where('reminder_sent', true)->count(),
            'pending' => AbandonedCart::where('reminder_sent', false)->count(),
            'total_value' => AbandonedCart::sum('total_amount'),
        ];

        return view('admin.abandoned-carts.index', compact('abandonedCarts', 'stats'));
    }

    public function show(AbandonedCart $abandonedCart)
    {
        $abandonedCart->load('user');
        return view('admin.abandoned-carts.show', compact('abandonedCart'));
    }

    public function sendReminder(AbandonedCart $abandonedCart)
    {
        // Send email reminder (implement email logic)
        $abandonedCart->update([
            'reminder_sent' => true,
            'reminder_sent_at' => now(),
        ]);

        return back()->with('success', 'Reminder sent successfully.');
    }

    public function destroy(AbandonedCart $abandonedCart)
    {
        $abandonedCart->delete();
        return redirect()->route('admin.abandoned-carts.index')
            ->with('success', 'Abandoned cart deleted successfully.');
    }
}
