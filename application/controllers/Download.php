<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;


class Download extends CI_Controller
{
    function xls_neraca_saldo()
    {
        $this->load->model('Statement_model');
        $filter = $this->input->get();
        // var_dump($filter);
        // die();
        if (!empty($filter['laba_rugi'])) {
            $fn = 'LABA_RUGI';
            $filter['nature'] = "'Expense','Revenue'";
        } else {
            $fn = 'NERACA_SALDO';
            $filter['nature'] = "'Assets','Liability','Equity','Expense','Revenue'";
        }

        if (empty($filter['periode'])) {
            $filter['periode'] = 'bulanan';
            $filter['tahun'] =  (int)date('Y');
            $filter['bulan'] =  (int)date('m');
        }

        if ($filter['periode'] == 'tahunan') {
            if (empty($filter['tahun'])) {
                $filter['tahun'] =  (int)date('Y');
            }
            $filter['bulan'] = 0;
            $filename = $fn . '_THN_' . $filter['tahun'];
        }

        if ($filter['periode'] == 'bulanan') {
            if (empty($filter['tahun'])) {
                $filter['tahun'] =  (int)date('Y');
            }
            if (empty($filter['bulan']) or $filter['bulan'] == 0) {
                $filter['bulan'] = (int)date('m');
            }
            $filename = $fn . '_BLN_' . $filter['tahun'] . '_' . $filter['bulan'];
            // $filter['bulan'] = 0;
        }
        $data['filter'] = $filter;

        $spreadsheet = new Spreadsheet();
        $styleArray = array(
            'font'  => array(
                'size'  => 13,
                'name'  => 'Courier'
            )
        );
        $spreadsheet->getActiveSheet()->getProtection()->setPassword('indometalasiajaya');
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $spreadsheet->getActiveSheet()->getProtection()->setSort(true);
        $spreadsheet->getActiveSheet()->getProtection()->setInsertRows(true);
        $spreadsheet->getActiveSheet()->getProtection()->setFormatCells(true);

        $spreadsheet->getDefaultStyle()
            ->applyFromArray($styleArray);

        $spreadsheet->getActiveSheet()->setPrintGridlines(false);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setVisible(false);
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(2);
        $sheet->getColumnDimension('C')->setWidth(2);
        $sheet->getColumnDimension('D')->setWidth(2);
        $sheet->getColumnDimension('E')->setWidth(35);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        // $sheet->getColumnDimension('')->setWidth(23);
        $spreadsheet->getActiveSheet()->getStyle('A6:H6')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        // $spreadsheet->getActiveSheet()->getStyle('A6:H6')->getFont()->setSize(13)->setBold(true);
        // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(13)->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:A5')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);

        $sheet->getStyle('F:H')->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
        // $sheet->getStyle('F:H')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        $this->load->model('Statement_model');
        $sheet->mergeCells("A1:H1");
        $sheet->mergeCells("A2:H2");
        $sheet->mergeCells("A3:H3");
        $sheet->mergeCells("A4:H4");
        $sheet->mergeCells("A5:H5");

        $sheet->setCellValue('A1', 'PT INDOMETAL ASIA');
        $sheet->setCellValue('A2', 'Jalan Sanggul Dewa No.6, Kota Pangkalpinang, Bangka Belitung');
        if (!empty($filter['laba_rugi'])) {
            $sheet->setCellValue('A3', 'Laporan Laba Rugi');
        } else {
            $sheet->setCellValue('A3', 'Neraca Saldo');
        }

        $namaBulan = array("Januari", "Februaru", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        if ($filter['periode'] == 'bulanan') {
            $sheet->setCellValue('A4', 'Periode : 1 ' . $namaBulan[$filter['bulan'] - 1] . ' ' . $filter['tahun'] . ' s/d ' . date("t", strtotime($filter['tahun'] . '-' . $filter['bulan'] . '-1')) . ' ' . $namaBulan[$filter['bulan'] - 1] . ' ' . $filter['tahun']);
        } else {
            $sheet->setCellValue('A4', 'Periode : 1 Januari ' . $filter['tahun'] . ' s/d ' . date("t", strtotime($filter['tahun'] . '-12-1')) . ' Desember ' . $filter['tahun']);
        };
        if ($filter['periode'] == 'bulanan') {
            $sheet->setCellValue('A6', 'NO AKUN');
            $sheet->mergeCells("B6:E6")->setCellValue('B6', 'NAMA AKUN');
            $sheet->setCellValue('F6', 'SALDO PERIODE SEBELUMNYA');
            $sheet->setCellValue('G6', 'MUTASI');
            $sheet->setCellValue('H6', 'SALDO');
            // $sheet->setCellValue('F5', 'SALDO');
        } else {
            $sheet->setCellValue('A6', 'NO AKUN');
            $sheet->mergeCells("B6:E6")->setCellValue('B6', 'NAMA AKUN');
            $sheet->setCellValue('F6', 'SALDO PERIODE ' . ($filter['tahun'] - 1));
            $sheet->setCellValue('G6', 'MUTASI');
            $sheet->setCellValue('H6', 'SALDO');
            // $sheet->setCellValue('F5', 'SALDO');
        }
        $sheet->getStyle('A6:H6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('A6:H6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $data['accounts_records'] = $this->Statement_model->xls_neraca_saldo($filter, $sheet);
        $writer = new Xlsx($spreadsheet);

        // $filename = 'NERACA_SALDO_' . $filter['from'] . '_sd_' . $filter['to'];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 


    }

    public function add_event()
    {
        $data = $this->input->post();
        $this->load->model('Crud_model');
        $data['user_input'] = $this->session->userdata('user_id')['id'];
        if (!empty($data['label_event']) && !empty($data['nama_event']) && !empty($data['start_event']) && !empty($data['end_event']))
            $this->Crud_model->insert_data('mp_event', $data);
        echo json_encode(array('error' => false, 'data' => $data));
        redirect('dashboard');
    }
}
