<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Translation extends Model
{
    protected $fillable = [
        'group',
        'key',
        'locale',
        'value',
    ];

    /**
     * Get all translations for a specific group and locale
     */
    public static function getByGroupAndLocale($group, $locale)
    {
        return self::where('group', $group)
            ->where('locale', $locale)
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Get all unique groups
     */
    public static function getAllGroups()
    {
        return self::distinct('group')->pluck('group');
    }

    /**
     * Sync translations from database to language files
     */
    public static function syncToFiles()
    {
        $locales = ['en', 'ur'];
        $groups = self::getAllGroups();

        foreach ($locales as $locale) {
            foreach ($groups as $group) {
                $translations = self::getByGroupAndLocale($group, $locale);

                // Create directory if it doesn't exist
                $directory = lang_path($locale);
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }

                // Write to file
                $filePath = lang_path("{$locale}/{$group}.php");
                $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
                File::put($filePath, $content);
            }
        }

        return true;
    }

    /**
     * Import translations from language files to database
     */
    public static function importFromFiles()
    {
        $locales = ['en', 'ur'];
        $imported = 0;

        foreach ($locales as $locale) {
            $langPath = lang_path($locale);

            if (!File::exists($langPath)) {
                continue;
            }

            $files = File::files($langPath);

            foreach ($files as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $group = $file->getBasename('.php');
                $translations = include $file->getPathname();

                if (!is_array($translations)) {
                    continue;
                }

                foreach ($translations as $key => $value) {
                    self::updateOrCreate(
                        [
                            'group' => $group,
                            'key' => $key,
                            'locale' => $locale,
                        ],
                        [
                            'value' => $value,
                        ]
                    );
                    $imported++;
                }
            }
        }

        return $imported;
    }
}
