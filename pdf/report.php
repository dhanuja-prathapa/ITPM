<?php
require('fpdf.php');
//SESSION START
session_start();

class PDF extends FPDF
{
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // HTML parser
        $html = str_replace("\n",' ',$html);
        $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                // Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,$e);
            }
            else
            {
                // Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    // Extract attributes
                    $a2 = explode(' ',$e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF = $attr['HREF'];
        if($tag=='BR')
            $this->Ln(5);
    }

    function CloseTag($tag)
    {
        // Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modify style and select corresponding font
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach(array('B', 'I', 'U') as $s)
        {
            if($this->$s>0)
                $style .= $s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
        // Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
}
//SESSION VALUES FROM ACTION_PAGE.PHP
$CS_COL = $_SESSION['CS_COL'];
$NKW_COL = $_SESSION['NKW_COL'];
$NID_COL = $_SESSION['NID_COL'];
$NOP_COL = $_SESSION['NOP_COL'];
$NNV_COL = $_SESSION['NNV_COL'];
$NSL_COL = $_SESSION['NSL_COL'];
$WVS_COL = $_SESSION['WVS_COL'];
$NPDTV_COL = $_SESSION['NPDTV_COL'];
$NPCTV_COL = $_SESSION['NPCTV_COL'];
$CV_COL = $_SESSION['CV_COL'];
$WMRT_COL = $_SESSION['WMRT_COL'];
$NPDTP_COL = $_SESSION['NPDTP_COL'];
$NCDTP_COL = $_SESSION['NCDTP_COL'];
$CM_COL = $_SESSION['CM_COL'];
$CCS_COL = $_SESSION['CCS_COL'];
$WTCS_COL = $_SESSION['WTCS_COL'];
$NC_COL = $_SESSION['NC_COL'];
$CCSPPS_COL = $_SESSION['CCSPPS_COL'];


$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$total =0;


$pdf->WriteHTML("<?php 
echo <td>$total</td>
");
$pdf->Output();
?>