<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class InvoiceController extends Controller
{
    public function save(Request $request)
    {
        Invoice::create($request->all());
        return response("Succesfuly created", 200);
    }

    public function show()
    {
        return response()->json(Invoice::all() , HttpResponse::HTTP_OK);
    }
}
