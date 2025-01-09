<?php
require 'vendor/autoload.php';
require('./fpdf/fpdf.php');
require_once "./DBs/connect.php";

$conn = conn();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// دریافت مقادیر از متغیرهای $_GET
$export_as = isset($_GET['export_as']) ? $_GET['export_as'] : '';
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id == 0 || !in_array($export_as, ['w', 'p', 'e'])) {
    die("Invalid parameters.");
}


// کوئری برای گرفتن لیست کارها
$sql = "SELECT subject, explanation, neccessry, expo_work_datetime FROM works WHERE user_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // تابع برای تبدیل مقدار neccessry
    function getNeccessryText($neccessry) {
        switch ($neccessry) {
            case 0:
                return 'low';
            case 1:
                return 'middle';
            case 2:
                return 'high';
            default:
                return 'unknown';
        }
    }

    // تولید فایل براساس export_as
    if ($export_as == 'e') {
        // Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Subject');
        $sheet->setCellValue('B1', 'Explanation');
        $sheet->setCellValue('C1', 'Neccessry');
        $sheet->setCellValue('D1', 'Expo Work DateTime');

        $row = 2;
        while ($row_data = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $row, $row_data['subject']);
            $sheet->setCellValue('B' . $row, $row_data['explanation']);
            $sheet->setCellValue('C' . $row, getNeccessryText($row_data['neccessry']));
            $sheet->setCellValue('D' . $row, $row_data['expo_work_datetime']);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="works.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    } elseif ($export_as == 'w') {
        // Word
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $table = $section->addTable();

        $table->addRow();
        $table->addCell()->addText("Subject");
        $table->addCell()->addText("Explanation");
        $table->addCell()->addText("Neccessry");
        $table->addCell()->addText("Expo Work DateTime");

        while ($row_data = $result->fetch_assoc()) {
            $table->addRow();
            $table->addCell()->addText($row_data['subject']);
            $table->addCell()->addText($row_data['explanation']);
            $table->addCell()->addText(getNeccessryText($row_data['neccessry']));
            $table->addCell()->addText($row_data['expo_work_datetime']);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="works.docx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save('php://output');
        exit;
    } elseif ($export_as == 'p') {
        // PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(40, 10, 'Subject');
        $pdf->Cell(50, 10, 'Explanation');
        $pdf->Cell(20, 10, 'Neccessry');
        $pdf->Cell(40, 10, 'Expo Work DateTime');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);
        while ($row_data = $result->fetch_assoc()) {
            $pdf->Cell(40, 10, $row_data['subject']);
            $pdf->Cell(50, 10, $row_data['explanation']);
            $pdf->Cell(20, 10, getNeccessryText($row_data['neccessry']));
            $pdf->Cell(40, 10, $row_data['expo_work_datetime']);
            $pdf->Ln();
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="works.pdf"');
        header('Cache-Control: max-age=0');

        $pdf->Output('D', 'works.pdf');
        exit;
    }

    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

