<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
        return view('frontend.account.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('frontend.account.addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|regex:/^(\+92|0)?[0-9]{10}$/',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:20',
            'is_default' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();

        // If this is set as default, unset other defaults
        if ($request->boolean('is_default')) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        Address::create($validated);

        return redirect()->route('account.addresses.index')->with('success', 'Address added successfully!');
    }

    public function edit(Address $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('frontend.account.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|regex:/^(\+92|0)?[0-9]{10}$/',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:20',
            'is_default' => 'boolean',
        ]);

        // If this is set as default, unset other defaults
        if ($request->boolean('is_default')) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('account.addresses.index')->with('success', 'Address updated successfully!');
    }

    public function destroy(Address $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('account.addresses.index')->with('success', 'Address deleted successfully!');
    }

    public function setDefault(Address $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Unset all defaults for this user
        Auth::user()->addresses()->update(['is_default' => false]);

        // Set this address as default
        $address->update(['is_default' => true]);

        return redirect()->route('account.addresses.index')->with('success', 'Default address updated!');
    }
}
