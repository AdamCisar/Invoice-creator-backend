<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\PdfService\PdfService;
use App\Services\PdfService\tFPDF;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function show($id) 
    {
        //customer and invoice details
        $customerInfo = Invoice::find($id);
        
        //invoice Products
        $products_info = DB::table('invoice_item')
            ->join('items', 'invoice_item.item_id', '=', 'items.id')
            ->where('invoice_item.invoice_id', $id)
            ->select('items.name', 'items.price', 'invoice_item.amount')
            ->get();

        $pdfService = new PdfService("P","mm","A4");
        $pdfService->AddPage();
        $pdfService->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
        $pdfService->SetFont('DejaVu','',12);  
        $pdfService->body($customerInfo, $products_info); 
        $pdfContent = $pdfService->Output($customerInfo->name . "-cenova-ponuka.pdf", "D");

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"" . $customerInfo->name . "-cenova-ponuka.pdf\"",
        ]);
    }
}
