<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class B2BApprovalController extends Controller
{
    /**
     * Show pending B2B registrations
     */
    public function pending()
    {
        $profiles = BusinessProfile::with('user')
            ->pending()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.b2b.pending', compact('profiles'));
    }

    /**
     * Show approved B2B customers
     */
    public function approved()
    {
        $profiles = BusinessProfile::with(['user', 'salesRep'])
            ->approved()
            ->orderBy('approved_at', 'desc')
            ->paginate(20);

        return view('admin.b2b.approved', compact('profiles'));
    }

    /**
     * Show rejected B2B registrations
     */
    public function rejected()
    {
        $profiles = BusinessProfile::with('user')
            ->rejected()
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('admin.b2b.rejected', compact('profiles'));
    }

    /**
     * Show business profile details
     */
    public function show($id)
    {
        $profile = BusinessProfile::with(['user', 'approvedBy', 'salesRep'])
            ->findOrFail($id);

        // Get all users with staff role for sales rep assignment
        $salesReps = User::role(['admin', 'staff'])->orderBy('name')->get();

        return view('admin.b2b.show', compact('profile', 'salesReps'));
    }

    /**
     * Approve B2B registration
     */
    public function approve($id)
    {
        $profile = BusinessProfile::with('user')->findOrFail($id);

        if ($profile->status !== 'pending') {
            return back()->with('error', 'This application has already been processed.');
        }

        try {
            // Update profile
            $profile->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Update user
            $profile->user->update([
                'is_b2b_approved' => true,
            ]);

            // Send approval email
            $this->sendApprovalEmail($profile);

            // Log activity
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'b2b_registration_approved',
                'description' => "Approved B2B registration for {$profile->company_name}",
                'ip_address' => request()->ip()
            ]);

            return redirect()->route('admin.b2b.approved')
                ->with('success', 'B2B registration approved successfully! Customer can now login.');

        } catch (\Exception $e) {
            \Log::error('B2B Approval Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to approve registration. Please try again.');
        }
    }

    /**
     * Reject B2B registration
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        $profile = BusinessProfile::with('user')->findOrFail($id);

        if ($profile->status !== 'pending') {
            return back()->with('error', 'This application has already been processed.');
        }

        try {
            // Update profile
            $profile->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);

            // Keep user but mark as not approved
            $profile->user->update([
                'is_b2b_approved' => false,
            ]);

            // Send rejection email
            $this->sendRejectionEmail($profile);

            // Log activity
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'b2b_registration_approved',
                'description' => "Approved B2B registration for {$profile->company_name}",
                'ip_address' => request()->ip()
            ]);

            return redirect()->route('admin.b2b.rejected')
                ->with('success', 'B2B registration rejected. Email notification sent.');

        } catch (\Exception $e) {
            \Log::error('B2B Rejection Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to reject registration. Please try again.');
        }
    }

    /**
     * Update business profile (sales rep, notes, etc.)
     */
    public function update(Request $request, $id)
    {
        $profile = BusinessProfile::findOrFail($id);

        $request->validate([
            'sales_rep_id' => 'nullable|exists:users,id',
            'admin_notes' => 'nullable|string',
        ]);

        $profile->update([
            'sales_rep_id' => $request->sales_rep_id,
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Business profile updated successfully.');
    }

    /**
     * Send approval email to customer
     */
    private function sendApprovalEmail($profile)
    {
        try {
            // You can implement proper email sending here
            // Mail::to($profile->user->email)->send(new B2BApprovalMail($profile));

            // For now, just log
            \Log::info('B2B Approval email sent to: ' . $profile->user->email);

        } catch (\Exception $e) {
            \Log::error('Failed to send approval email: ' . $e->getMessage());
        }
    }

    /**
     * Send rejection email to customer
     */
    private function sendRejectionEmail($profile)
    {
        try {
            // You can implement proper email sending here
            // Mail::to($profile->user->email)->send(new B2BRejectionMail($profile));

            // For now, just log
            \Log::info('B2B Rejection email sent to: ' . $profile->user->email);

        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }
    }
}
