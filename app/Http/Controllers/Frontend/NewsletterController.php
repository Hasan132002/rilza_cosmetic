<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:newsletter_subscribers,email',
            ]);

            $subscriber = NewsletterSubscriber::create([
                'email' => $validated['email'],
                'is_subscribed' => true,
                'subscribed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing to our newsletter!',
                'data' => $subscriber,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while subscribing. Please try again.',
            ], 500);
        }
    }
}
