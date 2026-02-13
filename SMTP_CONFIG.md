# SMTP Email Configuration Guide - Rizla Cosmetics

## Email Verification is Now ENABLED ✅

The User model now implements `MustVerifyEmail` interface, which means:
- New users must verify their email before accessing certain features
- Verification emails will be sent automatically upon registration
- Users cannot checkout without verifying their email

---

## SMTP Configuration

To enable email sending, configure your `.env` file with your SMTP settings:

### Option 1: Gmail (Recommended for Development)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Rizla Cosmetics"
```

**Note:** For Gmail, you need to create an "App Password":
1. Go to Google Account Settings
2. Security → 2-Step Verification → App passwords
3. Generate a new app password
4. Use this password in `MAIL_PASSWORD`

---

### Option 2: Mailtrap (Testing)

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@rizlacosmetics.com
MAIL_FROM_NAME="Rizla Cosmetics"
```

---

### Option 3: SendGrid (Production)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@rizlacosmetics.com
MAIL_FROM_NAME="Rizla Cosmetics"
```

---

### Option 4: Mailgun (Production)

```env
MAIL_MAILER=mailgun
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your-mailgun-smtp-username
MAIL_PASSWORD=your-mailgun-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@rizlacosmetics.com
MAIL_FROM_NAME="Rizla Cosmetics"

MAILGUN_DOMAIN=your-mailgun-domain
MAILGUN_SECRET=your-mailgun-api-key
```

---

## Testing Email Configuration

After configuring SMTP settings, test if emails are working:

```bash
php artisan tinker
```

Then run:

```php
Mail::raw('Test email from Rizla Cosmetics', function ($message) {
    $message->to('your-email@example.com')
            ->subject('SMTP Test');
});
```

---

## Email Features Implemented

1. **Email Verification** ✅
   - Sent automatically on user registration
   - Beautiful branded email template
   - Verification link expires after 60 minutes

2. **Order Confirmation** ✅
   - Sent when order is placed
   - Includes order details and tracking

3. **Order Status Updates** ✅
   - Sent when order status changes
   - Customer receives updates at each stage

4. **Newsletter Subscription** ✅
   - Confirmation email for newsletter subscriptions

5. **Password Reset** ✅
   - Laravel Breeze handles this automatically
   - Beautiful branded template

6. **Abandoned Cart Emails** (Pending)
   - Needs SMTP to be configured
   - Will send reminder after 24 hours

---

## Customizing Email Templates

Email templates are located in:
- `resources/views/emails/` (custom templates)
- Laravel default templates are in vendor folder

To customize the verification email template, create:
```bash
php artisan vendor:publish --tag=laravel-notifications
```

Then edit: `resources/views/vendor/notifications/email.blade.php`

---

## Email Queue Configuration (Optional - for Production)

For better performance, configure email queues:

```env
QUEUE_CONNECTION=database
```

Then run:
```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

---

## Troubleshooting

### Emails not sending?
1. Check `.env` settings are correct
2. Clear config cache: `php artisan config:clear`
3. Check `storage/logs/laravel.log` for errors
4. Verify SMTP credentials are correct

### Gmail not working?
1. Enable "Less secure app access" OR use App Password
2. Use port 587 with TLS encryption
3. Make sure 2FA is enabled if using App Password

### Email going to spam?
1. Add SPF and DKIM records to your domain
2. Use a verified sending domain
3. Avoid spammy words in subject/content
4. Use a professional email service (SendGrid, Mailgun)

---

## Production Checklist

Before going live:
- [ ] Configure production SMTP service (SendGrid/Mailgun)
- [ ] Set proper `MAIL_FROM_ADDRESS` with your domain
- [ ] Enable email queues for better performance
- [ ] Test all email types (verification, orders, etc.)
- [ ] Configure SPF/DKIM records
- [ ] Monitor email delivery rates

---

**Email Verification Status:** ✅ ENABLED
**SMTP Configuration:** ⚠️ NEEDS SETUP (add to .env file)

Once SMTP is configured, all email features will work automatically!
