
<?php
    $pdf = new FPDF( '$p_orient', 'mm', '$p_size' );
    $pdf->AddPage();
    
    // define position and dimentions
    $x = 15;
    $y = 30; 
    $w = ($pdf->w - 20);
    $h = 80;
        
    // define title	
    $repTitle = "Visits";
?>
