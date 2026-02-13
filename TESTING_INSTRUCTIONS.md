# M·A·C Lipglass Showcase - Testing Instructions

## Quick Test Guide

### Prerequisites
1. ✅ View cache cleared: `php artisan view:clear`
2. ✅ Configuration cache cleared: `php artisan config:clear`
3. ✅ No PHP syntax errors detected
4. ✅ Section inserted at correct location (lines 519-665)

---

## STEP-BY-STEP TESTING

### Step 1: Access the Homepage
```
URL: http://your-domain.com/
Action: Navigate to homepage
Expected: Page loads without errors
```

### Step 2: Locate the Section
```
Location: Scroll down between:
  - "Trending Product Showcase" section
  - "New Arrivals" section

Expected: Section visible ONLY on desktop (screen width ≥ 1024px)
```

### Step 3: Test Color Swatch Buttons
Test each button in sequence:

**Button 1 - Rose Blush (#dc8289):**
```
1. Click the first color button (rose/pink color)
2. Observe:
   - Background changes to rose pink
   - Title color changes to rose pink
   - Transition is smooth (500ms)
```

**Button 2 - Coral Dream (#fc7675):**
```
1. Click the second color button (coral color)
2. Observe:
   - Background changes to coral
   - Title color changes to coral
   - Smooth transition
```

**Button 3 - Soft Pink (#fed4d5):**
```
1. Click the third color button (soft pink)
2. Observe:
   - Background changes to soft pink
   - Title color changes to soft pink
   - Smooth transition
```

**Button 4 - Peachy Nude (#ed7c67):**
```
1. Click the fourth color button (peachy color)
2. Observe:
   - Background changes to peachy nude
   - Title color changes to peachy nude
   - Smooth transition
```

**Button 5 - Hot Pink (#ff4f73):**
```
1. Click the fifth color button (hot pink)
2. Observe:
   - Background changes to hot pink
   - Title color changes to hot pink
   - Smooth transition
```

**Button 6 - Deep Berry (#96051f):**
```
1. Click the sixth color button (deep red/berry)
2. Observe:
   - Background changes to deep berry
   - Title color changes to deep berry
   - Smooth transition
```

### Step 4: Test Mini Image Gallery
Test each mini circular image:

**Each Mini Image (1-5):**
```
1. Click on a mini circular image
2. Observe:
   - Main large image fades out (300ms)
   - Main image source changes
   - Main image fades back in (300ms)
   - Clicked thumbnail bounces (scale animation)
   - Thumbnail returns to normal size after 300ms
```

**Hover Effects:**
```
1. Hover over each mini image
2. Observe:
   - Image scales to 125%
   - Border color changes to pink-300
   - Smooth transition (300ms)
```

### Step 5: Test Hover Effects

**Main Product Image:**
```
1. Hover over the large circular product image
2. Observe:
   - Image scales to 105%
   - Smooth transition (500ms)
```

**Color Swatch Buttons:**
```
1. Hover over each color button
2. Observe:
   - Button scales to 125%
   - Smooth transition (300ms)
   - Focus ring appears when focused
```

### Step 6: Test Keyboard Navigation

**Mini Images (Accessibility):**
```
1. Tab to mini images (they have tabindex="0")
2. Press Enter key on a focused image
3. Observe:
   - Same behavior as clicking
   - Main image swaps with fade effect
```

### Step 7: Test Responsive Behavior

**Desktop (≥1024px):**
```
1. View on desktop screen (or resize browser to ≥1024px)
2. Observe: Section is visible and properly formatted
```

**Tablet/Mobile (<1024px):**
```
1. Resize browser to <1024px
2. Observe: Section is completely hidden (hidden lg:block)
```

### Step 8: Test AOS Animations

**Scroll Behavior:**
```
1. Refresh page and scroll to section
2. Observe:
   - Left content fades in from right (data-aos="fade-right")
   - Right content fades in from left (data-aos="fade-left")
   - Animations are smooth (1000ms duration)
```

### Step 9: Check Browser Console

**Open Developer Tools:**
```
1. Press F12 or Right-click > Inspect
2. Go to Console tab
3. Check for:
   - ✅ No JavaScript errors
   - ✅ No CSS warnings
   - ✅ Functions are defined: changeColor1, updateTrending, swapTrendingImage
```

**Test Function Existence:**
```javascript
// Type in console:
typeof changeColor1
// Expected: "function"

typeof updateTrending
// Expected: "function"

typeof swapTrendingImage
// Expected: "function"

// Test element existence:
document.getElementById('trending-bg')
// Expected: <div> element

document.getElementById('trending-title')
// Expected: <h1> element

document.getElementById('trending-main-img')
// Expected: <img> element
```

---

## EXPECTED BEHAVIOR SUMMARY

### ✅ Color Buttons (All 6)
- Click changes background color instantly
- Click changes title color instantly
- Smooth transitions (500ms)
- Hover scales button to 125%
- Focus shows ring indicator

### ✅ Mini Image Gallery (5 images)
- Click swaps main image with fade effect
- Fade out: 0ms → 300ms (opacity 1 to 0)
- Image swap: at 300ms
- Fade in: 300ms → 600ms (opacity 0 to 1)
- Clicked thumbnail bounces (scale 1 → 1.25 → 1)
- Hover scales to 125% with border color change
- Keyboard (Enter) works same as click

### ✅ Main Image
- Displays product primary image or placeholder
- Hover scales to 105%
- Smooth transitions for all effects
- 360px × 360px circular shape
- Shadow: rgba(236, 72, 153, 0.4)

### ✅ Layout
- Two-column grid on desktop
- Left: Content with colors and gallery
- Right: Large product image with rotated text
- Angled pink background (45% width, right side)
- Hidden completely on mobile/tablet

### ✅ Typography
- Playfair Display: Headers and rotated text
- Poppins: Body text and labels
- Text shadow on main title: 3px 2px 0px rgba(55, 52, 67, 0.9)
- Highlighted words in pink-200 background

### ✅ Decorative Elements
- Pulse animation on bottom-left blur circle
- Bounce animation on top-right blur circle (0.5s delay)
- Decorative ring on main image with pulse

---

## TROUBLESHOOTING

### Issue: Section Not Visible
**Solution:**
1. Check screen width is ≥1024px
2. Verify `$featuredProducts->count() > 0` (products exist in database)
3. Clear cache: `php artisan view:clear`
4. Hard refresh browser: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)

### Issue: Color Buttons Don't Work
**Solution:**
1. Open browser console (F12)
2. Check for JavaScript errors
3. Verify functions exist: `typeof changeColor1` should return "function"
4. Check element IDs exist: `document.getElementById('trending-bg')`
5. Ensure script is loaded after DOM

### Issue: Image Swap Doesn't Work
**Solution:**
1. Check browser console for errors
2. Verify product has multiple images: `$productImages->count() > 1`
3. Check function exists: `typeof swapTrendingImage`
4. Verify main image ID: `document.getElementById('trending-main-img')`
5. Check image src attributes are valid

### Issue: No Smooth Transitions
**Solution:**
1. Check if CSS transitions are applied:
   - #trending-bg: `transition-colors duration-500`
   - #trending-title: `transition-colors duration-500`
   - #trending-main-img: Has inline transition style
2. Verify browser supports CSS transitions (all modern browsers do)

### Issue: Fonts Not Displaying Correctly
**Solution:**
1. Check if Playfair Display and Poppins are loaded
2. Verify font links in main layout file
3. Check browser console for font loading errors
4. Fonts should be in main layout's <head> section

---

## BROWSER TESTING CHECKLIST

Test in multiple browsers:

### Chrome/Edge (Chromium)
- ⬜ Section displays correctly
- ⬜ All interactions work
- ⬜ No console errors
- ⬜ Smooth animations

### Firefox
- ⬜ Section displays correctly
- ⬜ All interactions work
- ⬜ No console errors
- ⬜ Smooth animations

### Safari (if available)
- ⬜ Section displays correctly
- ⬜ All interactions work
- ⬜ No console errors
- ⬜ Smooth animations

---

## PERFORMANCE TESTING

### Check Performance:
1. Open DevTools → Performance tab
2. Record while interacting with section
3. Verify:
   - ⬜ No layout thrashing
   - ⬜ Smooth 60fps animations
   - ⬜ Quick paint times (<16ms per frame)
   - ⬜ No memory leaks

---

## ACCESSIBILITY TESTING

### Test with Keyboard Only:
1. ⬜ Tab through all interactive elements
2. ⬜ Color buttons focusable and clickable with Enter
3. ⬜ Mini images focusable and keyboard accessible
4. ⬜ Focus indicators visible

### Test with Screen Reader:
1. ⬜ ARIA labels read correctly
2. ⬜ Image alt text announced
3. ⬜ Button purposes clear
4. ⬜ Section structure makes sense

---

## FINAL VERIFICATION

### All Interactive Elements:
- ⬜ 6 color buttons (all working)
- ⬜ 5 mini images (all swapping)
- ⬜ All hover effects (working)
- ⬜ All transitions (smooth)
- ⬜ Responsive (hidden on mobile)
- ⬜ No console errors
- ⬜ No PHP errors
- ⬜ Product data displaying

### Visual Check:
- ⬜ Angled background correct
- ⬜ Circular images perfect circles
- ⬜ Rotated text readable
- ⬜ Colors match specification
- ⬜ Spacing/padding correct
- ⬜ Fonts correct (Playfair + Poppins)

---

## TEST RESULT TEMPLATE

```
Test Date: ___________
Tester Name: ___________
Browser: ___________
Screen Size: ___________

✅ Color Button 1 (Rose Blush): _____
✅ Color Button 2 (Coral Dream): _____
✅ Color Button 3 (Soft Pink): _____
✅ Color Button 4 (Peachy Nude): _____
✅ Color Button 5 (Hot Pink): _____
✅ Color Button 6 (Deep Berry): _____
✅ Mini Image 1 Swap: _____
✅ Mini Image 2 Swap: _____
✅ Mini Image 3 Swap: _____
✅ Mini Image 4 Swap: _____
✅ Mini Image 5 Swap: _____
✅ Hover Effects: _____
✅ Keyboard Navigation: _____
✅ Mobile Hidden: _____
✅ Desktop Display: _____
✅ AOS Animations: _____
✅ No Console Errors: _____

Overall Result: PASS / FAIL
Notes: _____________________________
```

---

**Ready for Testing!** ✅
