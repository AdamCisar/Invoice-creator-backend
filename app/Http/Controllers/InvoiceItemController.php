<?php

namespace App\Http\Controllers;

use App\Models\CustomItem;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceItemController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->all();

        foreach ($data as $invoiceItem) {

            if($invoiceItem['id'] < 5000) {
                
                $customItem = CustomItem::firstOrNew(
                   ['name' => $invoiceItem['name']]
                );
                $customItem->amount = $invoiceItem['pivot']['amount'];
                $customItem->save();
            }else{
                $invoice = Invoice::find($invoiceItem['pivot']['invoice_id']);
                $item = Item::find($invoiceItem['pivot']['item_id']);
                
                $existingPivot = $invoice->items()->where('item_id', $item->id)->first();

                if ($existingPivot) {
                        $invoice->items()->sync([$item->id => ['amount' => $invoiceItem['pivot']['amount']]], false);
                } else {
                    $invoice->items()->attach($item, ['amount' => $invoiceItem['pivot']['amount']]);
                }
            }
        }
        return response("Invoice items have been saved to the database", 200);
    }

    public function delete(Request $request)
    {
        $data = $request->all();

        if($data["item_id"] > 5000)
        {
            DB::table('invoice_item')
            ->where('invoice_id', $data["invoice_id"])
            ->where('item_id', $data["item_id"])
            ->delete();
        }else{
            DB::table('custom_items')
            ->where('invoice_id', $data["invoice_id"])
            ->delete();
        }
        return response("Invoice item has been deleted from database", 200);
    }

    public function show($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);
        $items = $invoice->items()->get()->toArray();
        $customItems = $invoice->customItems()->get();
        
        $modifiedItems = $customItems->map(function ($item) {
            return [
                "id" => $item->id,
                "name" => $item->name,
                "price" => $item->price,
                "pivot" => [
                    "amount" => $item->amount
                    ]
            ];
        })->toArray();
        
        return array_merge($items, $modifiedItems);
    }
}