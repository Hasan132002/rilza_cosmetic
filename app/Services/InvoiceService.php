<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService
{
    /**
     * Generate PDF invoice for an order
     */
    public function generateInvoice(Order $order)
    {
        // Load order with relationships
        $order->load(['items.product', 'user.businessProfile']);

        // Calculate tax (18% GST example)
        $taxRate = 0.18;
        $subtotalBeforeTax = $order->subtotal - $order->discount_amount;
        $taxAmount = $subtotalBeforeTax * $taxRate;
        $totalWithTax = $subtotalBeforeTax + $taxAmount;

        // Prepare invoice data
        $invoiceData = [
            'order' => $order,
            'tax_rate' => $taxRate * 100, // Convert to percentage
            'tax_amount' => $taxAmount,
            'total_with_tax' => $totalWithTax,
            'invoice_date' => now()->format('d M, Y'),
            'invoice_number' => 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
        ];

        // Generate PDF
        $pdf = Pdf::loadView('invoices.b2b-invoice', $invoiceData);
        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * Download invoice as PDF
     */
    public function downloadInvoice(Order $order)
    {
        $pdf = $this->generateInvoice($order);
        $filename = 'invoice-' . $order->order_number . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Stream invoice in browser
     */
    public function streamInvoice(Order $order)
    {
        $pdf = $this->generateInvoice($order);
        $filename = 'invoice-' . $order->order_number . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Get invoice as string (for email attachments)
     */
    public function getInvoicePdfString(Order $order)
    {
        $pdf = $this->generateInvoice($order);
        return $pdf->output();
    }
}
