<?php

require_once __DIR__ . './MyPDF.php';

class PDFController extends MyPDF
{
    protected $summary = 0;
    protected $filename = 'test';
    protected $result = true;
    protected $keys = array();

    public function __construct($orientation = 'P', $unit = 'pt', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);

        $this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
        $this->SetFont('DejaVu','',14);

        $this->AddPage();
    }

    public function setters($setters)
    {
        foreach ($setters as $key => $value) {
            $this->{$key} = $value;
        }
    }

//    public function __destruct()
//    {
//        // TODO: Implement __destruct() method.
//        $this->Output();
//    }

    public function offset($sum)
    {
        $this->height += $sum;
    }

    public function Header()
    {
    }

    public function createData($data, $meta = null)
    {
        // $this->offset(-$this->height);

        $this->SetFontSize(20);
        $this->Ln();
        $this->Cell(0, $this->height, 'JUSTFUN', 0, 1, 'C');

        $this->SetFontSize(13);
        $this->Ln(20);
        // $this->offset(5);
        $this->Cell(0, $this->height, 'Мы дарим улыбки и воспоминания', 0, 1, 'C');

        $this->Ln(70);

        if (isset($meta)) {
            $this->Ln();
            $this->SetFillColor(23, 162, 184);
            $this->Cell(0, $this->height, $meta);
            $this->SetTextColor(0, 0, 0);
            $this->Ln(20);
        }

        if (count($this->keys)) {
            $data = array_merge($this->keys, $data);
        }

        $this->plot_table(20, $data);


        if ($this->result) {
            $this->SetFontSize(15);
            $this->Ln(25);
            $this->Cell(0, $this->height, "Итого: {$this->summary} руб.", 0, '', 'R');
            // $this->offset(70);
            $this->SetFontSize(10);
        }


        // $this->SetFontSize(10);
        $this->Ln(15);
        $this->Cell(0, $this->height, 'Документ создан: '.date('d.m.Y H:i'), 0, 10, 'R');

    }

    public function Footer()
    {

    }
}