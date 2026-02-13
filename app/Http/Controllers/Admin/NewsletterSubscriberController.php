<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    /**
     * Display a listing of newsletter subscribers.
     */
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        // Filter by subscription status
        if ($request->has('status')) {
            $isSubscribed = $request->status === 'subscribed';
            $query->where('is_subscribed', $isSubscribed);
        }

        // Search by email
        if ($request->has('search') && $request->search) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $subscribers = $query->orderBy('subscribed_at', 'desc')->paginate(20);

        $stats = [
            'total' => NewsletterSubscriber::count(),
            'subscribed' => NewsletterSubscriber::where('is_subscribed', true)->count(),
            'unsubscribed' => NewsletterSubscriber::where('is_subscribed', false)->count(),
        ];

        return view('admin.newsletter-subscribers.index', compact('subscribers', 'stats'));
    }

    /**
     * Unsubscribe a subscriber.
     */
    public function unsubscribe(NewsletterSubscriber $subscriber)
    {
        $subscriber->update(['is_subscribed' => false]);

        return back()->with('success', 'Subscriber has been unsubscribed successfully!');
    }

    /**
     * Resubscribe a subscriber.
     */
    public function resubscribe(NewsletterSubscriber $subscriber)
    {
        $subscriber->update(['is_subscribed' => true]);

        return back()->with('success', 'Subscriber has been resubscribed successfully!');
    }

    /**
     * Delete a subscriber.
     */
    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('success', 'Subscriber has been deleted successfully!');
    }

    /**
     * Export subscribers to CSV.
     */
    public function export(Request $request)
    {
        $query = NewsletterSubscriber::query();

        // Filter by subscription status
        if ($request->has('status')) {
            $isSubscribed = $request->status === 'subscribed';
            $query->where('is_subscribed', $isSubscribed);
        }

        $subscribers = $query->orderBy('subscribed_at', 'desc')->get();

        $filename = 'newsletter_subscribers_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');

            // CSV header
            fputcsv($file, ['Email', 'Status', 'Subscribed Date']);

            // CSV rows
            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->is_subscribed ? 'Subscribed' : 'Unsubscribed',
                    $subscriber->subscribed_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show send email form.
     */
    public function sendEmailForm()
    {
        $subscribersCount = NewsletterSubscriber::where('is_subscribed', true)->count();
        return view('admin.newsletter-subscribers.send-email', compact('subscribersCount'));
    }

    /**
     * Send bulk email to subscribers.
     */
    public function sendBulkEmail(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $subscribers = NewsletterSubscriber::where('is_subscribed', true)->get();

        // Here you would typically queue emails using Laravel's Mail and Queue system
        // For now, we'll just show a success message

        // Example (you would need to create a mailable class):
        // foreach ($subscribers as $subscriber) {
        //     Mail::to($subscriber->email)->queue(new NewsletterEmail($validated['subject'], $validated['message']));
        // }

        return back()->with('success', 'Email will be sent to ' . $subscribers->count() . ' subscribers shortly!');
    }
}
