<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class InvoiceController extends Controller
{
    public function delete($id)
    {
        Invoice::destroy($id);
        return response("Succesfuly deleted", 200);
    }


    public function save(Request $request)
    {
        $invoice = Invoice::create($request->all());
        return $invoice;
    }

    public function show()
    {
        return response()->json(Invoice::all() , HttpResponse::HTTP_OK);
    }
}
