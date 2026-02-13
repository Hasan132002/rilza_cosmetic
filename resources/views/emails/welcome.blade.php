<x-mail::message>
# Welcome to Rizla Cosmetics!

Hi {{ $user->name }},

Thank you for joining Rizla Cosmetics! We're excited to have you as part of our beauty community.

At Rizla Cosmetics, we believe that everyone deserves to feel confident and beautiful. Our carefully curated collection of premium beauty products is designed to help you express your unique style.

## What's Next?

- Explore our latest products and collections
- Get exclusive member-only deals and offers
- Track your orders and manage your account
- Join our beauty community and share your looks

<x-mail::button :url="$shopUrl">
Start Shopping
</x-mail::button>

Follow us on social media for beauty tips, tutorials, and exclusive offers!

If you have any questions, our customer support team is always here to help.

Welcome aboard!

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
