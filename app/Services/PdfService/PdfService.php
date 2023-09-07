<?php 

  namespace App\Services\PdfService;
  require ("tfpdf/tfpdf.php");

  class PdfService extends tFPDF
  {

    private $totalAmount = 0;

    function Header(){
      {
        if ( $this->PageNo() === 1 ) {
        //Display Company Info
        
        $this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
        $this->SetFont('DejaVu','',14);  
        $this->Cell(50,10,"Cisar",0,1);
        $this->Cell(50,7,"ICO,",0,1);
        $this->Cell(50,7,"Adresa.",0,1);
        $this->Cell(50,7,"Telefon",0,1);
        
        //Display CENOVA PONUKA text
        $this->SetY(15);
        $this->SetX(-60);
        $this->Cell(1,10,"Cenová ponuka",0,1);
        
        //Display Horizontal line
        $this->Line(0,9,210,9);
        $this->Line(0,48,210,48);
        }
      }
    }
    
    function body($customerInfo,$products_info){
      
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->Cell(50,10,"Zákazník:",0,1);
      $this->Cell(50,7,$customerInfo->name,0,1);
      // $this->Cell(50,7,$customerInfo["address"],0,1);
      // $this->Cell(50,7,$customerInfo["city"],0,1);
      
      //Display Invoice no

      // $this->SetY(55);
      // $this->SetX(-60);
      // $this->Cell(50,7,"Invoice No : ".$customerInfo["invoice_no"]);
      
      //Display Invoice date

      // $this->SetY(63);
      // $this->SetX(-60);
      // $this->Cell(50,7,"Invoice Date : ".$customerInfo["invoice_date"]);
      

      //Display Table headings
      $this->SetY(105);
      $this->SetX(10);
      $this->Cell(130,9,'Názov',1,0);
      $this->Cell(20,9,"Cena",1,0,"C");
      $this->Cell(12,9,"Počet",1,0,"C");
      $this->Cell(20,9,"Spolu",1,1,"C");
      
      //Display table product rows
      foreach($products_info as $row){
        $total = number_format((float)str_replace(',', '.', $row->price) * $row->amount, 2, '.', '');
        $this->totalAmount = $this->totalAmount + $total;

        $this->Cell(130,9,$row->name,"LR",0);
        $this->Cell(20,9,$row->price,"R",0,"R");
        $this->Cell(12,9,$row->amount,"R",0,"C");
        $this->Cell(20,9,str_replace('.', ',',$total),"R",1,"R");
      }
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell(130,9,"","LR",0);
        $this->Cell(20,9,"","R",0,"R");
        $this->Cell(12,9,"","R",0,"C");
        $this->Cell(20,9,"","R",1,"R");
      }
      //Display table total row

      $this->Cell(130,9,"Celkovo spolu",1,0,"R");
      $this->Cell(52,9,str_replace('.', ',',$this->totalAmount),1,1,"R");
      
      //Display amount in words 
      // $this->SetY(225);
      // $this->SetX(10);
      // $this->SetFont('Arial','B',12);
      // $this->Cell(0,9,"Amount in Words ",0,1);
      // $this->Cell(0,9,$customerInfo["words"],0,1);
      
    }
    function Footer(){
      
        //set footer position
        $this->SetY(-50);
        $this->Cell(0,10,"",0,1,"R");
        $this->Ln(15);
        
        //Display Footer Text
        $this->SetFont('DejaVu','',8); 
        $this->Cell(0,25,"Uvedená cenová ponuka slúži len ako orientačná informácia a konečná cena sa môže líšiť v závislosti na rôznych faktoroch a individuálnych potrebách.",0,1,"C");
    }
  }
?>