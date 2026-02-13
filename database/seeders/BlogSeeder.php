<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin user as the author
        $author = User::where('email', 'admin@rizlacosmetics.com')->first();

        if (!$author) {
            $author = User::first();
        }

        $blogs = [
            [
                'title' => '10 Essential Skincare Tips for Glowing Skin',
                'slug' => '10-essential-skincare-tips-for-glowing-skin',
                'excerpt' => 'Discover the secrets to achieving radiant, healthy-looking skin with these expert-approved skincare tips.',
                'content' => "Achieving glowing, healthy skin doesn't have to be complicated. Here are 10 essential skincare tips that will transform your complexion:\n\n1. Cleanse Your Face Twice Daily\nProper cleansing removes dirt, oil, and makeup that can clog pores and lead to breakouts. Use a gentle cleanser suited to your skin type.\n\n2. Never Skip Sunscreen\nSPF is crucial for protecting your skin from harmful UV rays. Apply sunscreen daily, even on cloudy days.\n\n3. Stay Hydrated\nDrink at least 8 glasses of water daily to keep your skin hydrated from within.\n\n4. Use a Moisturizer\nEven oily skin needs moisture. Choose a lightweight, non-comedogenic moisturizer.\n\n5. Exfoliate Weekly\nRemove dead skin cells with gentle exfoliation 2-3 times per week.\n\n6. Get Enough Sleep\nYour skin repairs itself while you sleep. Aim for 7-9 hours of quality sleep.\n\n7. Eat a Balanced Diet\nInclude fruits, vegetables, and omega-3 fatty acids in your diet for healthy skin.\n\n8. Remove Makeup Before Bed\nSleeping with makeup can clog pores and cause breakouts.\n\n9. Use Serums\nIncorporate vitamin C and hyaluronic acid serums for extra nourishment.\n\n10. Be Gentle with Your Skin\nAvoid harsh scrubbing and hot water that can damage your skin's natural barrier.\n\nFollow these tips consistently for the best results!",
                'author_id' => $author->id,
                'published_at' => now()->subDays(7),
                'is_published' => true,
                'meta_title' => '10 Essential Skincare Tips for Glowing Skin | Rizla Cosmetics',
                'meta_description' => 'Learn the top 10 skincare tips recommended by experts to achieve radiant, glowing skin. Simple steps for a healthy complexion.',
            ],
            [
                'title' => 'The Ultimate Guide to Choosing the Perfect Lipstick Shade',
                'slug' => 'the-ultimate-guide-to-choosing-the-perfect-lipstick-shade',
                'excerpt' => 'Find your perfect lipstick match with our comprehensive guide to selecting the ideal shade for your skin tone.',
                'content' => "Choosing the right lipstick shade can make all the difference in your makeup look. Here's how to find your perfect match:\n\nUnderstand Your Undertone\nFirst, determine if you have warm, cool, or neutral undertones. This is the foundation for selecting flattering shades.\n\nWarm Undertones\nIf you have warm undertones, look for lipsticks with orange, coral, or peach bases. Nude shades with beige or brown tones work beautifully.\n\nCool Undertones\nCool undertones pair well with pink, berry, and blue-based reds. Mauve and plum shades are also stunning choices.\n\nNeutral Undertones\nLucky you! Most shades will complement neutral undertones. Experiment with both warm and cool tones.\n\nConsider Your Skin Tone\nFair Skin: Soft pinks, nudes with pink undertones, and berry shades\nMedium Skin: Rosy pinks, warm nudes, corals, and classic reds\nDeep Skin: Rich berries, deep reds, plums, and chocolate browns\n\nMatch the Occasion\nDaytime: Natural nudes, soft pinks, and subtle corals\nEvening: Bold reds, deep berries, and dramatic plums\nProfessional: Neutral nudes, rosy pinks, and subtle mauves\n\nTest Before You Buy\nAlways swatch lipsticks on your wrist or hand in natural lighting. The best way to know if a shade suits you is to try it!\n\nDon't Be Afraid to Experiment\nMakeup is fun! Try different shades and finishes to discover new favorites. Sometimes the most unexpected colors look amazing!",
                'author_id' => $author->id,
                'published_at' => now()->subDays(5),
                'is_published' => true,
                'meta_title' => 'How to Choose the Perfect Lipstick Shade | Beauty Guide',
                'meta_description' => 'Discover how to choose the perfect lipstick shade for your skin tone and undertone with our comprehensive guide.',
            ],
            [
                'title' => 'Summer Makeup Trends 2026: What\'s Hot This Season',
                'slug' => 'summer-makeup-trends-2026-whats-hot-this-season',
                'excerpt' => 'Stay ahead of the curve with the hottest makeup trends for summer 2026. From bold colors to natural looks, we\'ve got you covered.',
                'content' => "Summer 2026 is bringing fresh, exciting makeup trends that celebrate individuality and natural beauty. Here's what's trending:\n\n1. Glossy, Dewy Skin\nMatte is out, and glow is in! Achieve that fresh, dewy look with lightweight foundations and illuminating primers.\n\n2. Graphic Eyeliner\nBold, artistic eyeliner designs are making a statement. Think geometric shapes and colorful accents.\n\n3. Sunset-Inspired Eyeshadow\nWarm oranges, pinks, and purples reminiscent of beautiful summer sunsets are dominating eye looks.\n\n4. Glossy Lips\nHigh-shine glosses and lacquers are replacing traditional lipsticks for a youthful, fresh appearance.\n\n5. Minimalist Blush\nSoft, natural flush on the cheeks using cream blushes for a healthy, sun-kissed glow.\n\n6. Bold Brows\nFull, natural-looking brows continue to reign supreme. Embrace your natural shape!\n\n7. Pastel Accents\nSoft pastels on eyes and lips add a playful, feminine touch to summer looks.\n\n8. Skin-Tint Over Foundation\nLightweight tinted moisturizers and skin tints for breathable, natural coverage.\n\n9. Monochromatic Makeup\nUsing the same color family on eyes, cheeks, and lips for a cohesive, effortless look.\n\n10. Barely-There Makeup\nEmbracing natural beauty with minimal makeup that enhances rather than covers.\n\nWhich trend will you try first? Share your favorites with us!",
                'author_id' => $author->id,
                'published_at' => now()->subDays(3),
                'is_published' => true,
                'meta_title' => 'Summer Makeup Trends 2026 | Latest Beauty Trends',
                'meta_description' => 'Explore the hottest summer makeup trends for 2026. From glossy skin to bold eyeliner, discover what\'s trending this season.',
            ],
            [
                'title' => 'How to Build a Capsule Makeup Collection',
                'slug' => 'how-to-build-a-capsule-makeup-collection',
                'excerpt' => 'Learn how to create a minimalist makeup collection with versatile products that work for every occasion.',
                'content' => "A capsule makeup collection focuses on essential, versatile products that can create multiple looks. Here's how to build yours:\n\nThe Foundation\n- A foundation or tinted moisturizer that matches your skin tone perfectly\n- Concealer for blemishes and under-eye circles\n- Setting powder or spray to keep makeup in place\n\nEyes\n- One neutral eyeshadow palette with matte and shimmer shades\n- Black or brown eyeliner\n- Mascara that volumizes and lengthens\n\nCheeks\n- One blush in a universally flattering shade\n- A highlighter for that extra glow\n- Bronzer for warmth and definition\n\nLips\n- A nude lipstick close to your natural lip color\n- A classic red for special occasions\n- A tinted lip balm for everyday wear\n\nTools\n- Beauty blender or makeup sponge\n- Basic brush set (foundation, eyeshadow, blush brushes)\n- Eyelash curler\n\nWhy Go Capsule?\n- Saves money by avoiding duplicate purchases\n- Reduces clutter and simplifies routines\n- Forces you to master products you own\n- More sustainable and eco-friendly\n- Perfect for travel\n\nQuality Over Quantity\nInvest in high-quality products that perform well and last longer. It's better to have 10 products you love than 50 you never use.\n\nKnow Your Skin Type\nChoose products specifically formulated for your skin type to ensure the best performance.\n\nStart building your capsule collection today and experience the freedom of simplified beauty!",
                'author_id' => $author->id,
                'published_at' => now()->subDays(1),
                'is_published' => true,
                'meta_title' => 'How to Build a Capsule Makeup Collection | Minimalist Beauty',
                'meta_description' => 'Create a versatile capsule makeup collection with essential products. Learn which items you really need for a complete beauty routine.',
            ],
            [
                'title' => 'Understanding Different Skin Types and How to Care for Them',
                'slug' => 'understanding-different-skin-types-and-how-to-care-for-them',
                'excerpt' => 'Identify your skin type and discover the best skincare routine tailored to your specific needs.',
                'content' => "Knowing your skin type is essential for creating an effective skincare routine. Let's explore the different types:\n\nOily Skin\nCharacteristics: Shiny appearance, enlarged pores, prone to acne\nCare Tips:\n- Use gel-based or foaming cleansers\n- Choose oil-free, non-comedogenic products\n- Don't skip moisturizer! Use a lightweight formula\n- Clay masks can help control excess oil\n\nDry Skin\nCharacteristics: Tight feeling, flaky patches, dull appearance\nCare Tips:\n- Use cream-based cleansers\n- Apply rich, hydrating moisturizers\n- Look for ingredients like hyaluronic acid and ceramides\n- Avoid hot water and harsh soaps\n\nCombination Skin\nCharacteristics: Oily T-zone, dry or normal cheeks\nCare Tips:\n- Use gentle, balanced cleansers\n- Apply different products to different areas if needed\n- Lightweight moisturizers work best\n- Don't over-dry oily areas\n\nSensitive Skin\nCharacteristics: Easily irritated, redness, burning sensations\nCare Tips:\n- Choose fragrance-free, hypoallergenic products\n- Patch test new products before full application\n- Avoid harsh ingredients and physical exfoliants\n- Keep routines simple with minimal products\n\nNormal Skin\nCharacteristics: Well-balanced, no major concerns\nCare Tips:\n- Maintain your routine with gentle products\n- Focus on prevention with SPF and antioxidants\n- Don't over-complicate your routine\n\nHow to Determine Your Skin Type\nWash your face with a gentle cleanser, pat dry, and wait 30 minutes. Observe your skin:\n- Shiny all over? Oily\n- Tight and flaky? Dry\n- Shiny T-zone, normal cheeks? Combination\n- Feels comfortable? Normal\n- Red or irritated easily? Sensitive\n\nRemember, skin type can change with seasons, age, and hormones. Adjust your routine accordingly!",
                'author_id' => $author->id,
                'published_at' => now()->subHours(12),
                'is_published' => true,
                'meta_title' => 'Understanding Skin Types and Skincare | Complete Guide',
                'meta_description' => 'Learn about different skin types and how to care for each one. Discover the best skincare routine for your specific skin needs.',
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }

        $this->command->info('5 blog posts seeded successfully!');
    }
}
