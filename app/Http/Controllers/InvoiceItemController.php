<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->all();

        foreach ($data as $invoiceItem) {
            $invoice = Invoice::find($invoiceItem['invoice_id']);
            $item = Item::find($invoiceItem['item_id']);
            
            $existingPivot = $invoice->items()->where('item_id', $item->id)->first();

            if ($existingPivot) {
                    $invoice->items()->sync([$item->id => ['amount' => $invoiceItem['amount']]], false);
            } else {
                $invoice->items()->attach($item, ['amount' => $invoiceItem['amount']]);
            }
                }
        return response("Invoice items have been saved to the database", 200);
    }


    public function show($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);
        return $invoice->items()->get();
    }
}
