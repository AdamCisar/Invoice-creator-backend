<?php 

  namespace App\Services\PdfService;
  require ("fpdf/fpdf.php");

  class PdfService extends FPDF
  {
    function Header(){
      
      //Display Company Info
      $this->SetFont('Arial','B',14);
      $this->Cell(50,10,"ABC COMPUTERS",0,1);
      $this->SetFont('Arial','',14);
      $this->Cell(50,7,"West Street,",0,1);
      $this->Cell(50,7,"Salem 636002.",0,1);
      $this->Cell(50,7,"PH : 8778731770",0,1);
      
      //Display INVOICE text
      $this->SetY(15);
      $this->SetX(-40);
      $this->SetFont('Arial','B',18);
      $this->Cell(1,10,"FAKTURA",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($customerInfo,$products_info){
      
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Bill To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,7,iconv('UTF-8', 'ISO-8859-2',$customerInfo->name),0,1);
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
      

      //NEED TO USE TFPDF INSTEAD OF FPDF
      //Display Table headings
      $this->SetY(105);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(100,9,iconv('UTF-8', 'ISO-8859-2', 'Názov'),1,0);
      $this->Cell(20,9,iconv('UTF-8', 'ISO-8859-2',"Cena"),1,0,"C");
      $this->Cell(30,9,iconv('UTF-8', 'ISO-8859-2',"Počet"),1,0,"C");
      $this->Cell(40,9,iconv('UTF-8', 'ISO-8859-2',"Spolu"),1,1,"C");
      $this->SetFont('Arial','',12);
      
      //Display table product rows
      foreach($products_info as $row){
        $this->Cell(100,9,iconv('UTF-8', 'ISO-8859-2',$row->name),"LR",0);
        $this->Cell(20,9,iconv('UTF-8', 'ISO-8859-2',$row->price),"R",0,"R");
        $this->Cell(30,9,iconv('UTF-8', 'ISO-8859-2',$row->amount),"R",0,"C");
        $this->Cell(40,9,((float)str_replace(',','.',$row->price) * $row->amount),"R",1,"R");
      }
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell(100,9,"","LR",0);
        $this->Cell(20,9,"","R",0,"R");
        $this->Cell(30,9,"","R",0,"C");
        $this->Cell(40,9,"","R",1,"R");
      }
      //Display table total row

      // $this->SetFont('Arial','B',12);
      // $this->Cell(150,9,"TOTAL",1,0,"R");
      // $this->Cell(40,9,$customerInfo["total_amt"],1,1,"R");
      
      //Display amount in words 
      // $this->SetY(225);
      // $this->SetX(10);
      // $this->SetFont('Arial','B',12);
      // $this->Cell(0,9,"Amount in Words ",0,1);
      // $this->SetFont('Arial','',12);
      // $this->Cell(0,9,$customerInfo["words"],0,1);
      
    }
    function Footer(){
      
      //set footer position
      $this->SetY(-50);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,10,"for ABC COMPUTERS",0,1,"R");
      $this->Ln(15);
      $this->SetFont('Arial','',12);
      $this->Cell(0,10,"Authorized Signature",0,1,"R");
      $this->SetFont('Arial','',10);
      
      //Display Footer Text
      $this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
      
    }
    
  }
?>