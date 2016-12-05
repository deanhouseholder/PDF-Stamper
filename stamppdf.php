<?php
require __DIR__ . '/vendor/autoload.php';

$name = "User Name";
$email = "email@domain.com";
$text_to_stamp = "Licensed to: $name ($email)";
$doc = "example.pdf";
$path = "./";
$author = "Author here";
$title = "My eBook";
$keywords = "keywords go here";
$subject = str_replace(".pdf", "", str_replace("_", " ", $doc));
$file = $path . $doc;

$pdf = new FPDI();

$pdf->SetAuthor($author);
$pdf->SetTitle($title);
$pdf->SetKeywords($keywords);
$pdf->SetSubject($subject);

$pagecount = $pdf->setSourceFile($file);
for ($i = 1; $i <= $pagecount; $i++) {
	$tplidx = $pdf->ImportPage($i);
	$s = $pdf->getTemplatesize($tplidx);
	$pdf->AddPage($s['h'] > $s['w'] ? 'P' : 'L');
	$pdf->useTemplate($tplidx);
	$pdf->SetAutoPageBreak(1);
	$pdf->SetDisplayMode('real');

	// write text on each page
	$pdf->SetY(-15);
	$pdf->SetFont('Arial', 'IB', 10);
	$pdf->Cell(0, 5, $text_to_stamp, 0, 0, 'C');
}

$pdf->Output($doc, 'D');
