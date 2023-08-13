<?php

require __DIR__ . './../../vendor/autoload.php';

class MyPDF extends \tFPDF
{
    protected $height = 0;

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
    }

    function plot_table($line_height, $table, $border = 1, $aligns = array())
    {
        $this->SetFontSize(10);

        $rows = isset($table[0]) ? count($table[0]) : 1;
        $widths = array_fill(0, $rows, ceil($this->GetPageWidth() / $rows) - 15);
        $tx = $this;

        foreach ($table as $x => $line)
        {
            if ($x === 0) {
                $this->SetFillColor(23, 162, 184);
                $this->SetTextColor(255, 255, 255);
            } else {
                $this->SetTextColor(0, 0, 0);
            }

            $line = array_map(function ($text, $c_width) use ($tx) {
                $len = strlen($text);
                $split = floor($c_width * $len / $tx->GetStringWidth($text) - 2);
                return explode(PHP_EOL, wordwrap($text, $split, PHP_EOL, true));
            }, $line, $widths);

            $max_lines = max(array_map('count', $line));

            foreach ($line as $key => $cell)
            {
                $x_axis = $this->getx();
                $height = $line_height * $max_lines / count($cell);
                $len = count($line);

                $align = isset($aligns[$key]) ? $aligns[$key] : '';
                $fill  = $x === 0;

                foreach ($cell as $text_line) {
                    $this->cell($widths[$key], $height, $text_line, 0, 0, $align, $fill);
                    $height += 2 * $line_height * $max_lines / count($cell);
                    $this->SetX($x_axis);
                }

                $left_break = ($len - 1 === $key) ? 1 : 0;
                $this->cell($widths[$key], $line_height * $max_lines,  '', $border, $left_break);
            }
        }
    }
}

class MyPDF_NEXT extends \tFPDF
{
    public $widths;
    public $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb= 4; max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        if ($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb = mb_strlen($s);

        if ($nb>0 and $s[$nb-1]=="\n")
            $nb--;


        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}