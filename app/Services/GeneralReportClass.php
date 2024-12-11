<?php
//error_reporting ( E_ALL );
require_once('app/tcpdf/config/lang/eng.php');
require_once('app/tcpdf/tcpdf.php');

class GeneralReportClass extends TCPDF
{
    public $products;
    public $practice_name;
    public $practice_address;

    public function Header()
    {
        // Logo
        $image_file = 'images/logo.gif';
        $ormargins = $this->getOriginalMargins();
        $headerfont = $this->getHeaderFont();
        $headerdata = $this->getHeaderData();

        $this->Image($image_file, '', '', '30');

        $imgy = $this->getImageRBY();

        $cell_height = round(($this->getCellHeightRatio() * $headerfont [2]) / $this->getScaleFactor(), 2);

        $this->SetTextColor(82, 144, 195);
        // header title
        $this->SetFont('helvetica', 'B', '14');
        //$this->SetX ( 12 );

        $this->Cell(565, 12, $this->practice_name, 0, 1, 'R', 0, '', 0, false, 'T', 'B');
        $this->Cell(300, 0, "Top 200 Patients by Rewards", 0, 1, 'R', 0, '', 0, false, 'T', 'B');
        $this->SetX(120);
        /**********************************************/
        $this->SetY(15);
        $this->SetX(351);

        $this->SetTextColor(82, 144, 195);
        // header title
        $this->SetFont('helvetica', 'B', '10');

        $this->Cell(0, 0, $this->practice_address, 0, 1, 'R', 0, '', 0, false, 'T', 'B');
        /**********************************************/
        $this->Line(0, 20, 675, 20, array('width' => 0.85 / $this->getScaleFactor()));
        //$this->Cell ( 575, 12, "", 0, 1, 'R', 0, '', 0, false, 'T', 'B' );
        $this->SetY(13.5);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(565, 12, ' Date: ' . date("m/d/Y h:i A") . '', 0, 1, 'R', 0, '', 0, false, 'T', 'B');
        // header string
        $this->SetTextColor(0, 0, 0);
        // print an ending header line
        //$this->SetY ( 18 );
        //$this->Cell ( 575, 12, "", 0, 1, 'R', 0, '', 0, false, 'T', 'B' );
        //$this->SetLineStyle ( array ('width' => 0.85 / $this->getScaleFactor (), 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array (0, 0, 0 ) ) );


        //$this->SetTextColor ( 0, 0, 0 );
        //$this->SetFont ( 'helvetica', 'I', '7' );
        //$this->Line(0,20,700,20,array ('width' => 0.85 / $this->getScaleFactor ()));
        $this->SetY(20);
        $this->SetX(15);

        $this->Cell(0, 0, $this->products, 0, 1, 'L', 0, '', 0, false, 'T', 'B');


        //$this->Cell ( 0, 0, "", 0, 1, '', 0, '', 0, false, 'T', 'B' );

    }

    // Page footer
    public function Footer()
    {
        $cur_y = $this->GetY();
        $ormargins = $this->getOriginalMargins();
        $this->SetTextColor(0, 0, 0);
        //set style for cell border
        $line_width = 0.85 / $this->getScaleFactor();
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        //print document barcode
        $this->MultiCell(0, 10, 'Top 200 Patients by Rewards', 0, 'L', 0, 0);

        if (empty ($this->pagegroups)) {
            $pagenumtxt = $this->l ['w_page'] . ' ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages();
        } else {
            $pagenumtxt = $this->l ['w_page'] . ' ' . $this->getPageNumGroupAlias() . ' / ' . $this->getPageGroupAlias();
        }
        $this->SetY($cur_y);
        //Print page number
        if ($this->getRTL()) {
            $this->SetX($ormargins ['right']);
            $this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');
        } else {
            $this->SetX($ormargins ['left']);
            $this->Cell(0, 0, $pagenumtxt, 'T', 0, 'R');
        }

        //$page=$this->getAliasNumPage().' of '.$this->getAliasNbPages();


        //$this->Cell(10, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

//print_r($_POST);
$Practice_ID = "";
$user_id = "";
$role_id = "0";
$practice_name = "";
$practice_address = "";
//if (isset ($_SESSION [SESSION_OBJECT])) {
//    $obj = $_SESSION [SESSION_OBJECT];
//    $Practice_ID = $obj->getPracticeCode();
//    $user_id = $obj->getUserID();
//    $role_id = $obj->getRoleID();
//    $repLogOnID = $obj->getRep_log_on_id();
//    $practice_name = $obj->getPraciceName();
//    $practice_name = str_replace('&#039;', "'", $practice_name);
//    $practice_address = $obj->getPracticeAddress();
//}
//check_user_is_login($role_id);
//tep_db_connect() or die ("Unable to connect to server");
if (isset ($_POST ['data']) && $_POST ['data'] != "") {
    $products = $_POST ['data'];
    $products = rtrim($products, ',');
    $pdf = new General (PDF_PAGE_ORIENTATION, PDF_UNIT, "A1", true, 'UTF-8', false);
    $pdf->practice_name = $practice_name;
    $pdf->practice_address = $practice_address;
    $pdf->products = get_products_name($products);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('SSASoft');
    $pdf->SetTitle('Top 200 Patient by Rewards');
    $pdf->SetSubject('Top 200 Patient by Rewards');
    $pdf->SetKeywords('TCPDF, PDF, rxmobile, reports, guide');
    // set header and footer fonts
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 006', PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->SetFont('helvetica', '', 12);
    // add a page
    $pdf->AddPage();
    //lets start printing report data


    $query = "SELECT
SUM(promotion.Retail_WholeSale_Avg_Price*ps.Quantity) AS Total_Sale,
MAX(ps.Transaction_ID) AS Total_Visits,
ps.Patient_ID AS Patient_ID,
SUM(ps.Cost) AS Total_Rebates,
TIMESTAMPDIFF(DAY, MAX(ps.Effective_Date), NOW()) AS Days_Last_Program_Entry,
ps.Rebate_Source AS Rebate_Source,
patient.Patient_FName AS Patient_FName,
patient.Patient_LName AS Patient_LName,
DATE_FORMAT(patient.Patient_DOB,'%m-%d-%Y') AS Patient_DOB,
patient.Patient_Zip_Code AS Patient_Zip_Code,
patient.Patient_Phone_Number AS Patient_Phone_Number,
patient.Patient_Email,
DATE_FORMAT(MIN(ps.Effective_Date),'%m-%d-%Y %H:%i:%s') AS First_Program_Entry_Date, 
DATE_FORMAT(MAX(ps.Effective_Date),'%m-%d-%Y %H:%i:%s') AS Last_Program_Entry_Date,
DATE_FORMAT(patient.Effective_Date,'%m-%d-%Y %H:%i:%s') AS Enrollment_Date


FROM PatientServices ps

INNER JOIN Promotion promotion
ON ps.Promotion_ID = promotion.Promotion_ID

INNER JOIN PracticePhyPatient patient
ON ( 
ps.Practice_ID = patient.Practice_ID 
AND ps.Patient_ID = patient.Patient_Phone_Number 
)


where ps.Practice_ID='$Practice_ID' AND ps.Promotion_ID in ($products)
GROUP BY ps.Patient_ID
order by Total_Rebates DESC
";
    $query .= " limit 0, 200 ";
    $result = tep_db_query($query);
    if (tep_db_num_rows($result) > 0) {
        $html = <<<header
				<table cellspacing="4" style="font-family:Arial, Helvetica, sans-serif;background-color:#a1a0a0;"  cellpadding="2" align="center" border="0" width="1833">
			  <tr style="background-color:#4C87BD;color:#ffffff;">				
				 <td width="110">Last Name</td>
			    
			    <td width="110">First Name</td>	
			    <td width="105">Phone #</td>		    
			    <td width="245">Email</td>
			    <td width="100">DOB</td>
			    <td width="50">Zip Code</td>
			    <td width="160">Enrollment Date</td>
			    <td width="160">First Program Entry</td>
			    <td width="160">Last Program Entry</td>
			    <td width="80">Days Since Last Entry</td>
			    <td width="60">Office Visits</td>
			    <td width="100">Last Reminder Msg. Sent</td>
			    <td width="75">Delivered Msgs.</td>
			    <td width="150">Survey Delivered</td>
			    <td width="76">Survey ID</td>
			    <td width="95">Program Rewards</td>
			     <td width="94">Retail Sales</td>
			</tr>
header;
        $html .= get_report_content($result, $Practice_ID);

        $html .= '</table>';

        $pdf->writeHTML($html, true, false, true, false, '');
    } else {
        $html = '<table cellspacing="0"  cellpadding="0" border="0" width="100%">
				<tr><td align="center" style="color:red;">No record found.</td></tr>
				</table>';
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    $pdf->lastPage();
    $my_path = "reports/pdf/Top 200 Patient by Rewards" . date("mdyHisu") . $user_id . ".pdf";
    //Close and output PDF document
    $report = $pdf->Output($my_path, 'F');
    $content = $pdf->Output("", "S");

    $Handle = fopen($my_path, "r");
    $data = fread($Handle, filesize($my_path)) or die ("Could not read file!");
    header('Content-Type: application/pdf');
    header("Content-Length: " . strlen($content));
    echo $data;
} else
    echo "Invalid Access";
/***************************************************************************/
function get_report_content($result, $Practice_ID)
{
    $color = "#e1e1e1";
    $index = 0;
    $html = "";
    while ($row_rewards = tep_db_fetch_array($result)) {
        if ($index % 2 == 0)
            $color = "#f4f3f3";
        else
            $color = "#e1e1e1";
        $total_messages = MsgCount::get_messages_counter($row_rewards['Patient_Phone_Number'], $Practice_ID);
        //let's implement the client silly thoughts
        $sql = "SELECT Unique_Key,DATE_FORMAT(Effective_Date,'%m-%d-%Y %H:%i:%s') as Effective_Date FROM SurveyBridge WHERE Practice_ID='$Practice_ID' AND Patient_Phone_Number='1$row_rewards[Patient_Phone_Number]'";
        $result_survey = tep_db_query($sql);
        if (tep_db_num_rows($result_survey) > 0)
            while ($row_survey = tep_db_fetch_array($result_survey)) {
                $survey_result = $row_survey ['Unique_Key'];
                $survey_result = '<a target="_blank" href="' . SITE_WEB_ADDRESS . "survey_practice.php?key=" . $survey_result . '">' . $survey_result . "</a>";
                $survey_date = $row_survey ['Effective_Date'];
                if ($index % 2 == 0)
                    $color = "#f4f3f3";
                else
                    $color = "#e1e1e1";

                $html .= '<tr style="background-color:' . $color . ';color:#686868;">';
                $html .= '<td  align="center">';
                $html .= $row_rewards ['Patient_LName'];
                $html .= "</td>";

                $html .= '<td  align="center">';
                $html .= $row_rewards ['Patient_FName'];
                $html .= "</td>";

                $html .= '<td  align="right">';
                $html .= phone_number($row_rewards ['Patient_Phone_Number']);
                $html .= "</td>";

                $html .= '<td  align="center">';
                $html .= $row_rewards ['Patient_Email'];
                $html .= "</td>";

                $html .= '<td  align="center">';
                $html .= $row_rewards ['Patient_DOB'];
                $html .= "</td>";

                $html .= '<td  align="right">';
                $html .= $row_rewards ['Patient_Zip_Code'];
                $html .= "</td>";

                $html .= '<td  align="center">';
                $html .= $row_rewards ['Enrollment_Date'];
                $html .= "</td>";

                $html .= '<td  align="center">';

                $html .= $row_rewards ['First_Program_Entry_Date'];
                $html .= "</td>";

                $html .= '<td  align="center">';
                $html .= $row_rewards ['Last_Program_Entry_Date'];
                $html .= "</td>";

                $html .= '<td  align="right">';
                $html .= $row_rewards ['Days_Last_Program_Entry'];
                $html .= "</td>";
                $html .= '<td  align="right">';
                $html .= $row_rewards ['Total_Visits'];
                $html .= "</td>";
                $html .= '<td  align="right">';
                $html .= "";
                $html .= "</td>";

                $html .= '<td  align="right">';
                $html .= $total_messages;
                $html .= "</td>";

                $html .= '<td  align="right">';

                $html .= $survey_date;
                $html .= "</td>";

                $html .= '<td  align="right">';
                $html .= $survey_result;
                $html .= "</td>";

                $html .= '<td  align="right">$';
                $html .= number_format($row_rewards ['Total_Rebates'], 2);
                $html .= "</td>";

                $html .= '<td  align="right">$';
                $html .= number_format($row_rewards ['Total_Sale'], 2);
                $html .= "</td>";

                $html .= "</tr>";
                $index++;
            }
        else {
            $survey_result = "n/a";
            $survey_date = "n/a";

            $html .= '<tr style="background-color:' . $color . ';color:#686868;">';
            $html .= '<td  align="center">';
            $html .= $row_rewards ['Patient_LName'];
            $html .= "</td>";

            $html .= '<td  align="center">';
            $html .= $row_rewards ['Patient_FName'];
            $html .= "</td>";

            $html .= '<td  align="right">';
            $html .= phone_number($row_rewards ['Patient_Phone_Number']);
            $html .= "</td>";

            $html .= '<td  align="center">';
            $html .= $row_rewards ['Patient_Email'];
            $html .= "</td>";

            $html .= '<td  align="center">';
            $html .= $row_rewards ['Patient_DOB'];
            $html .= "</td>";

            $html .= '<td  align="right">';
            $html .= $row_rewards ['Patient_Zip_Code'];
            $html .= "</td>";

            $html .= '<td  align="center">';
            $html .= $row_rewards ['Enrollment_Date'];
            $html .= "</td>";

            $html .= '<td  align="center">';

            $html .= $row_rewards ['First_Program_Entry_Date'];
            $html .= "</td>";

            $html .= '<td  align="center">';
            $html .= $row_rewards ['Last_Program_Entry_Date'];
            $html .= "</td>";

            $html .= '<td  align="right">';
            $html .= $row_rewards ['Days_Last_Program_Entry'];
            $html .= "</td>";
            $html .= '<td  align="right">';
            $html .= $row_rewards ['Total_Visits'];
            $html .= "</td>";
            $html .= '<td  align="right">';
            $html .= "";
            $html .= "</td>";

            $html .= '<td  align="right">';
            $html .= $total_messages;
            $html .= "</td>";

            $html .= '<td  align="right">';

            $html .= $survey_date;
            $html .= "</td>";

            $html .= '<td  align="right">';
            $html .= $survey_result;
            $html .= "</td>";

            $html .= '<td  align="right">$';
            $html .= number_format($row_rewards ['Total_Rebates'], 2);
            $html .= "</td>";

            $html .= '<td  align="right">$';
            $html .= number_format($row_rewards ['Total_Sale'], 2);
            $html .= "</td>";

            $html .= "</tr>";
            $index++;
        }

    }
    return $html;

}
