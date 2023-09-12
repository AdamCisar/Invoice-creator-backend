<?php

namespace App\Http\Controllers;

use App\Models\CustomItem;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;

class CustomItemController extends Controller
{
    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'amount' => 'required',
            'invoice_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }else{
            //check if item exists
            $item = CustomItem::firstOrNew([ 
                'name' => $request->input('name'),
            ]);

            $item->price = $request->input('price');
            $item->amount = $request->input('amount');
            $item->invoice_id = $request->input('invoice_id');
            $item->save();

            return response('Item has been saved to the database!', 200);
        }
    }
}
