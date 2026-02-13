<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PopupCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PopupCampaignController extends Controller
{
    public function index()
    {
        $popups = PopupCampaign::latest()->paginate(20);
        return view('admin.popup-campaigns.index', compact('popups'));
    }

    public function create()
    {
        return view('admin.popup-campaigns.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:discount,newsletter,exit_intent,announcement',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'coupon_code' => 'nullable|string|max:255',
            'delay_seconds' => 'required|integer|min:0|max:60',
            'show_on_exit' => 'boolean',
            'is_active' => 'boolean',
            'display_frequency' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('popup-campaigns', 'public');
        }

        PopupCampaign::create($validated);

        return redirect()->route('admin.popup-campaigns.index')
            ->with('success', 'Popup campaign created successfully.');
    }

    public function edit(PopupCampaign $popupCampaign)
    {
        return view('admin.popup-campaigns.edit', compact('popupCampaign'));
    }

    public function update(Request $request, PopupCampaign $popupCampaign)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:discount,newsletter,exit_intent,announcement',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'coupon_code' => 'nullable|string|max:255',
            'delay_seconds' => 'required|integer|min:0|max:60',
            'show_on_exit' => 'boolean',
            'is_active' => 'boolean',
            'display_frequency' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            if ($popupCampaign->image) {
                Storage::disk('public')->delete($popupCampaign->image);
            }
            $validated['image'] = $request->file('image')->store('popup-campaigns', 'public');
        }

        $popupCampaign->update($validated);

        return redirect()->route('admin.popup-campaigns.index')
            ->with('success', 'Popup campaign updated successfully.');
    }

    public function destroy(PopupCampaign $popupCampaign)
    {
        if ($popupCampaign->image) {
            Storage::disk('public')->delete($popupCampaign->image);
        }

        $popupCampaign->delete();

        return redirect()->route('admin.popup-campaigns.index')
            ->with('success', 'Popup campaign deleted successfully.');
    }

    public function toggleActive(PopupCampaign $popupCampaign)
    {
        $popupCampaign->update(['is_active' => !$popupCampaign->is_active]);

        return back()->with('success', 'Popup campaign status updated.');
    }
}
