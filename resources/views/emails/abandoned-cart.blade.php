<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Cart is Waiting - Rizla Cosmetics</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f9fafb;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background: #fff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background: linear-gradient(135deg, #ec4899, #be185d); padding: 40px; text-align: center;">
                            <h1 style="color: #fff; margin: 0; font-size: 32px;">🛍️ Rizla Cosmetics</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="color: #1f2937;">Hi {{ $user->name }} 👋</h2>
                            <p style="color: #6b7280; font-size: 16px;">We noticed you left some amazing beauty products in your cart! 💄</p>
                            <p style="color: #6b7280;">Don't miss out on these beauties. Complete your purchase now!</p>
                            
                            <div style="background: #fef2f2; border-radius: 12px; padding: 20px; margin: 20px 0;">
                                <h3 style="color: #991b1b; margin: 0 0 15px;">Your Cart Items:</h3>
                                @foreach($cart->items as $item)
                                <div style="padding: 10px 0; border-bottom: 1px solid #fecaca;">
                                    <strong>{{ $item->product->name }}</strong>
                                    <p style="color: #6b7280; margin: 5px 0;">Qty: {{ $item->quantity }} × Rs {{ number_format($item->price, 0) }} = <strong>Rs {{ number_format($item->quantity * $item->price, 0) }}</strong></p>
                                </div>
                                @endforeach
                                <div style="padding: 20px 0 0; text-align: right;">
                                    <strong style="font-size: 24px;">Total: Rs {{ number_format($cartTotal, 0) }}</strong>
                                </div>
                            </div>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ route('cart') }}" style="display: inline-block; background: linear-gradient(135deg, #ec4899, #be185d); color: #fff; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-weight: bold; font-size: 18px;">
                                    Complete My Purchase →
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #f9fafb; padding: 30px; text-align: center;">
                            <p style="color: #6b7280; margin: 0;">© {{ date('Y') }} Rizla Cosmetics</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
