<?php
require('librerias/pdf/fpdf.php');

require_once ('conexion/MysqliDb.php');
require_once ('conexion/variables.php');
$db = new MysqliDb (SERVIDOR, USUARIO, CONTRASEÑA, 'prueba');


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);




if(isset($_GET['naturaleza']) && $_GET['naturaleza']!=''){
	$db->where ('naturaleza', $_GET['naturaleza']);
}

if (isset($_GET['beneficiario']) && $_GET['beneficiario']!=''){
	$db->where ('beneficiario', $_GET['beneficiario']);
}

$movimientos = $db->ObjectBuilder()->get('movimientos');
$html='';
$pdf->Cell(20,7,'FECHA',1,0,'C');
$pdf->Cell(30,7,'BENEFICIARIO',1,0,'C');
$pdf->Cell(20,7,'SALIDAS',1,0,'C');
$pdf->Cell(30,7,'SALDO',1,0,'C');
$pdf->Cell(30,7,'TIPO MOV',1,0,'C');
$pdf->Cell(30,7,'EMPRESA',1,0,'C');
$pdf->Cell(30,7,'NATURALEZA',1,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
if ($db->count > 0){
	
	foreach ($movimientos as  $mov) {
		$pdf->Cell(20,7, $mov->fecha,1);
		$pdf->Cell(30,7,$mov->beneficiario,1);
		$pdf->Cell(20,7,$mov->salidas,1);
		$pdf->Cell(30,7,'$ '. $mov->saldo,1);
		$pdf->Cell(30,7,$mov->tipo_mov,1);
		$pdf->Cell(30,7,$mov->empresa,1);
		$pdf->Cell(30,7,$mov->naturaleza,1);
		$pdf->Ln();
	}
}else{
	$html='';
}

$pdf->Output();

?>