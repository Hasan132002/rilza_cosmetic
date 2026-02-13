<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BusinessProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class BusinessRegistrationController extends Controller
{
    /**
     * Show B2B registration form
     */
    public function showRegistrationForm()
    {
        return view('frontend.auth.business-register');
    }

    /**
     * Process B2B registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            // Personal Information
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],

            // Business Information
            'company_name' => ['required', 'string', 'max:255'],
            'business_registration_number' => ['nullable', 'string', 'max:255'],
            'tax_id_number' => ['nullable', 'string', 'max:255'],
            'company_address' => ['required', 'string'],
            'company_city' => ['required', 'string', 'max:255'],
            'company_phone' => ['required', 'string', 'max:20'],
            'company_email' => ['required', 'email', 'max:255'],
            'business_type' => ['required', 'in:small_business,distributor,retailer,wholesaler'],
        ]);

        try {
            DB::beginTransaction();

            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'customer_type' => 'b2b',
                'is_b2b_approved' => false,
                'is_active' => true,
            ]);

            // Create business profile
            BusinessProfile::create([
                'user_id' => $user->id,
                'company_name' => $validated['company_name'],
                'business_registration_number' => $validated['business_registration_number'],
                'tax_id_number' => $validated['tax_id_number'],
                'company_address' => $validated['company_address'],
                'company_city' => $validated['company_city'],
                'company_phone' => $validated['company_phone'],
                'company_email' => $validated['company_email'],
                'business_type' => $validated['business_type'],
                'status' => 'pending',
            ]);

            DB::commit();

            // Send notification email to admin
            $this->notifyAdminOfNewRegistration($user);

            // Redirect to pending page
            return redirect()->route('business.pending')->with('success', 'Your B2B registration has been submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }

    /**
     * Show pending approval page
     */
    public function pending()
    {
        return view('frontend.auth.business-pending');
    }

    /**
     * Notify admin of new B2B registration
     */
    private function notifyAdminOfNewRegistration($user)
    {
        // This would send an email to admin
        // Implementation depends on your email setup
        try {
            $adminEmail = config('mail.admin_email', 'admin@rizlacosmetics.com');

            // You can implement proper email sending here
            // Mail::to($adminEmail)->send(new NewB2BRegistration($user));

        } catch (\Exception $e) {
            // Log error but don't fail registration
            \Log::error('Failed to send admin notification: ' . $e->getMessage());
        }
    }
}
