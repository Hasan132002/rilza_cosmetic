<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BulkInventoryController extends Controller
{
    public function index()
    {
        return view('admin.inventory.bulk-update');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:2048',
            'update_type' => 'required|in:stock,price,both'
        ]);

        try {
            $file = $request->file('file');
            $updateType = $request->input('update_type');

            // Read CSV file
            $csvData = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($csvData); // Remove header row

            // Expected headers: SKU, Stock, Price (optional)
            $results = [
                'success' => 0,
                'failed' => 0,
                'errors' => []
            ];

            DB::beginTransaction();

            foreach ($csvData as $index => $row) {
                $rowNumber = $index + 2; // +2 because: array starts at 0, and we removed header

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Validate row has minimum required columns
                if (count($row) < 2) {
                    $results['failed']++;
                    $results['errors'][] = "Row {$rowNumber}: Invalid format (needs at least SKU and one update column)";
                    continue;
                }

                $sku = trim($row[0]);
                $stock = isset($row[1]) && $row[1] !== '' ? intval($row[1]) : null;
                $price = isset($row[2]) && $row[2] !== '' ? floatval($row[2]) : null;

                // Find product by SKU
                $product = Product::where('sku', $sku)->first();

                if (!$product) {
                    $results['failed']++;
                    $results['errors'][] = "Row {$rowNumber}: Product with SKU '{$sku}' not found";
                    continue;
                }

                try {
                    $updated = false;
                    $changes = [];

                    // Update stock if requested
                    if (($updateType === 'stock' || $updateType === 'both') && $stock !== null) {
                        $oldStock = $product->stock_quantity;
                        $product->stock_quantity = $stock;
                        $changes[] = "Stock: {$oldStock} → {$stock}";
                        $updated = true;
                    }

                    // Update price if requested
                    if (($updateType === 'price' || $updateType === 'both') && $price !== null) {
                        $oldPrice = $product->base_price;
                        $product->base_price = $price;
                        $changes[] = "Price: {$oldPrice} → {$price}";
                        $updated = true;
                    }

                    if ($updated) {
                        $product->save();

                        // Log activity
                        ActivityLog::create([
                            'user_id' => auth()->id(),
                            'action' => 'bulk_inventory_update',
                            'description' => "Bulk updated {$product->name} (SKU: {$sku}): " . implode(', ', $changes),
                            'ip_address' => $request->ip()
                        ]);

                        $results['success']++;
                    }

                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = "Row {$rowNumber}: Error updating SKU '{$sku}' - " . $e->getMessage();
                }
            }

            DB::commit();

            // Prepare response message
            $message = "Bulk update completed! ";
            $message .= "✅ {$results['success']} products updated successfully. ";

            if ($results['failed'] > 0) {
                $message .= "❌ {$results['failed']} products failed. ";
            }

            if (!empty($results['errors'])) {
                session()->flash('bulk_errors', $results['errors']);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process file: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $csvContent = "SKU,Stock Quantity,Base Price\n";
        $csvContent .= "# Example rows (delete these before uploading):\n";
        $csvContent .= "PROD001,100,1500\n";
        $csvContent .= "PROD002,50,2500\n";
        $csvContent .= "PROD003,75,1200\n";
        $csvContent .= "\n";
        $csvContent .= "# Instructions:\n";
        $csvContent .= "# - SKU: Required (must match existing product SKU)\n";
        $csvContent .= "# - Stock Quantity: Enter new stock quantity\n";
        $csvContent .= "# - Base Price: Enter new base price (optional)\n";
        $csvContent .= "# - Delete example rows and instruction lines before uploading\n";

        $filename = 'bulk_inventory_template_' . date('Y-m-d') . '.csv';

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
