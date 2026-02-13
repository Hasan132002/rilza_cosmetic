<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Translation::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('key', 'like', "%{$search}%")
                  ->orWhere('value', 'like', "%{$search}%")
                  ->orWhere('group', 'like', "%{$search}%");
            });
        }

        // Filter by locale
        if ($request->filled('locale')) {
            $query->where('locale', $request->locale);
        }

        // Filter by group
        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        $translations = $query->orderBy('group')->orderBy('key')->orderBy('locale')->paginate(50);

        // Get unique groups for filter dropdown
        $groups = Translation::distinct('group')->pluck('group');

        return view('admin.translations.index', compact('translations', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Translation::distinct('group')->pluck('group');
        return view('admin.translations.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'group' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'value_en' => 'required|string',
            'value_ur' => 'required|string',
        ]);

        // Create English translation
        Translation::create([
            'group' => $validated['group'],
            'key' => $validated['key'],
            'locale' => 'en',
            'value' => $validated['value_en'],
        ]);

        // Create Urdu translation
        Translation::create([
            'group' => $validated['group'],
            'key' => $validated['key'],
            'locale' => 'ur',
            'value' => $validated['value_ur'],
        ]);

        return redirect()->route('admin.translations.index')
            ->with('success', 'Translation created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Translation $translation)
    {
        // Get the corresponding translation in the other locale
        $otherLocale = $translation->locale === 'en' ? 'ur' : 'en';
        $pairedTranslation = Translation::where('group', $translation->group)
            ->where('key', $translation->key)
            ->where('locale', $otherLocale)
            ->first();

        $groups = Translation::distinct('group')->pluck('group');

        return view('admin.translations.edit', compact('translation', 'pairedTranslation', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Translation $translation)
    {
        $validated = $request->validate([
            'group' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'value_en' => 'required|string',
            'value_ur' => 'required|string',
        ]);

        // Update or create English translation
        Translation::updateOrCreate(
            [
                'group' => $validated['group'],
                'key' => $validated['key'],
                'locale' => 'en',
            ],
            [
                'value' => $validated['value_en'],
            ]
        );

        // Update or create Urdu translation
        Translation::updateOrCreate(
            [
                'group' => $validated['group'],
                'key' => $validated['key'],
                'locale' => 'ur',
            ],
            [
                'value' => $validated['value_ur'],
            ]
        );

        return redirect()->route('admin.translations.index')
            ->with('success', 'Translation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Translation $translation)
    {
        // Delete both English and Urdu translations
        Translation::where('group', $translation->group)
            ->where('key', $translation->key)
            ->delete();

        return redirect()->route('admin.translations.index')
            ->with('success', 'Translation deleted successfully!');
    }

    /**
     * Sync database translations to language files
     */
    public function sync()
    {
        try {
            Translation::syncToFiles();

            // Clear translation cache
            Artisan::call('cache:clear');

            return redirect()->route('admin.translations.index')
                ->with('success', 'Translations synced to files successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.translations.index')
                ->with('error', 'Failed to sync translations: ' . $e->getMessage());
        }
    }

    /**
     * Import translations from language files to database
     */
    public function import()
    {
        try {
            $count = Translation::importFromFiles();

            return redirect()->route('admin.translations.index')
                ->with('success', "Imported {$count} translations from language files!");
        } catch (\Exception $e) {
            return redirect()->route('admin.translations.index')
                ->with('error', 'Failed to import translations: ' . $e->getMessage());
        }
    }
}
