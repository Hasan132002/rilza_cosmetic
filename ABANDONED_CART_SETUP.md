# Abandoned Cart System - Setup Guide

## ✅ System Components Implemented

1. **Database & Model** ✅ (Already exists)
2. **Email Template** ✅ (Beautiful branded template created)
3. **Tracking Command** ✅ (Automated email sender)
4. **Admin Dashboard Widget** (Pending - can be added later)

---

## 🚀 How to Use

### 1. Schedule the Abandoned Cart Email Command

Add this to `app/Console/Kernel.php` in the `schedule()` method:

```php
protected function schedule(Schedule $schedule)
{
    // Send abandoned cart emails once per day at 10 AM
    $schedule->command('carts:send-abandoned-emails')
             ->dailyAt('10:00');
}
```

### 2. Run Scheduler (Required for Production)

Make sure Laravel's scheduler is running:

```bash
# Add this to your crontab (Linux/Mac)
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

# For Windows, use Task Scheduler to run this command every minute:
php artisan schedule:run
```

### 3. Manual Testing

Test the command manually:

```bash
# Send abandoned cart emails now
php artisan carts:send-abandoned-emails
```

---

## ⚙️ How It Works

1. **Cart Abandonment Detection:**
   - System checks for carts not updated in 24+ hours
   - Carts without orders are marked as "abandoned"

2. **Email Sending:**
   - Beautiful branded email sent to user
   - Shows cart items, quantities, and total
   - Includes "Complete Purchase" button
   - One-time reminder (won't spam users)

3. **Tracking:**
   - Records stored in `abandoned_carts` table
   - Tracks when email was sent
   - Prevents duplicate emails

---

## 📊 Admin Dashboard Widget (To Be Added)

You can add a widget to the admin dashboard showing:
- Number of abandoned carts this week
- Total value of abandoned carts
- Conversion rate after emails
- Recent abandoned carts list

Example code for dashboard widget:

```php
// In DashboardController
$abandonedCarts = AbandonedCart::where('created_at', '>=', Carbon::now()->subDays(7))
    ->count();

$abandonedValue = AbandonedCart::where('created_at', '>=', Carbon::now()->subDays(7))
    ->sum('cart_total');
```

---

## 🎨 Email Preview

The abandoned cart email includes:
- Beautiful Rizla Cosmetics branding
- List of all cart items with images
- Quantities and prices
- Cart total
- "Complete Purchase" CTA button
- Professional footer

---

## ⚡ Quick Setup Checklist

- [x] Database table exists (`abandoned_carts`)
- [x] Model exists (`AbandonedCart`)
- [x] Email template created
- [x] Command created (`SendAbandonedCartEmails`)
- [ ] Add command to Kernel schedule
- [ ] Configure SMTP (see SMTP_CONFIG.md)
- [ ] Test with sample abandoned cart
- [ ] Add dashboard widget (optional)

---

## 📧 Email Requirements

**IMPORTANT:** Abandoned cart emails require SMTP to be configured!

See `SMTP_CONFIG.md` for SMTP setup instructions.

Without SMTP, the command will run but emails won't be sent.

---

## 🧪 Testing the System

1. **Create a test abandoned cart:**
   - Add products to cart (not logged in or logged in)
   - Don't complete checkout
   - Wait 24 hours OR manually update cart `updated_at` in database

2. **Run the command:**
   ```bash
   php artisan carts:send-abandoned-emails
   ```

3. **Check results:**
   - Check console output for confirmation
   - Check email inbox
   - Verify `abandoned_carts` table has record with `email_sent = 1`

---

## 🔧 Customization Options

### Change Email Sending Time:
Edit the schedule in `app/Console/Kernel.php`:

```php
// Send at 2 PM instead
$schedule->command('carts:send-abandoned-emails')->dailyAt('14:00');

// Or send twice daily
$schedule->command('carts:send-abandoned-emails')->twiceDaily(10, 18);
```

### Change Abandonment Threshold:
Edit `app/Console/Commands/SendAbandonedCartEmails.php`:

```php
// Change from 24 hours to 48 hours
$abandonedThreshold = Carbon::now()->subHours(48);
```

### Customize Email Template:
Edit `resources/views/emails/abandoned-cart.blade.php`

---

## 💡 Best Practices

1. **Don't Spam:**
   - Send only ONE reminder email
   - Current system prevents duplicate emails

2. **Timing:**
   - 24-hour delay is optimal
   - Don't send too early (user might still be shopping)
   - Don't send too late (interest may be lost)

3. **Email Content:**
   - Keep it friendly and non-pushy
   - Show clear cart contents
   - Make CTA button prominent
   - Include support contact

4. **Monitor Results:**
   - Track email open rates
   - Track conversion rates
   - A/B test email content if needed

---

## 📈 Expected Results

- **Email Open Rate:** 30-40%
- **Click Through Rate:** 10-15%
- **Conversion Rate:** 5-10%
- **Additional Revenue:** 5-15% increase

---

**Status:** ✅ FUNCTIONAL (requires SMTP configuration)

Once SMTP is configured, the system will work automatically!
