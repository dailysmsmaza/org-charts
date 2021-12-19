<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$html =
       '<html><head><link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://192.168.0.11/orgchart/assets/chart/css/jquery.orgchart.css">
    <link rel="stylesheet" href="http://192.168.0.11/orgchart/assets/chart/css/style.css">
    <link rel="stylesheet" href="http://192.168.0.11/orgchart/assets/chart/css/sidebar.css">
    <style type="text/css">h1 {color: #005ddb; font-size: 35px; } .center { position: absolute; height: 50px; top: 45%; left: 45%;  margin-left: -50px;  margin-top: -25px; } .rightEdge, .leftEdge { display: none; }​ </style>
</head><body>
	<table style="width: 100%">
		<tr>
			<td>
				<h3> Aleman Nieves, Alexis</h3>
                <p>Student Number: <span>STUD0465</span></p>
			</td>
			<td>
				<h5>Covenant Private School</h5>
                        <p><span class="schooladdressspan">Km 5.0 Marginal Expreso, PR-181, Trujillo Alto, 00976<br></span>Tel: (787) 296-4852</p>
			</td>
		</tr>
	</table>

       <div class="printableprivew">
            <div class="printableheader">
                <div class="studentname">
                    <h3> Aleman Nieves, Alexis</h3>
                    <p>Student Number: <span>STUD0465</span></p>
                </div>
                                <div class="schooladdresslogo">
                    <div class="schooladdress">
                        <h5>Covenant Private School</h5>
                        <p><span class="schooladdressspan">Km 5.0 Marginal Expreso, PR-181, Trujillo Alto, 00976<br></span>Tel: (787) 296-4852</p>
                    </div>
                                            <div class="Schoolprivewlogo">
                            <img src="http://192.168.0.11/test/karishma/schoolportal/uploads/sch_logo/CPS_Logo.jpg" alt="School">
                        </div>                </div>
            </div> <div class="clear"></div>
            <div class="studentdetail"><div class="studentimage">
                        <img src="http://192.168.0.11/test/karishma/schoolportal/uploads/user_document/user-placeholder.jpg" alt=" Aleman Nieves, Alexis">
                    </div> <div class="studentdetailcontent">
                    <div class="studentquarterheader">
                        <h4>August 2020 - April 2021 - First Semester</h4>
                        <p>Generated: 01/08/2020</p>
                    </div>
                    <div class="studentdetailcontentbox">
                        <div class="studentdetailleft">
                            <div class="studentdetailbox">
                                <h6>Birth date:</h6>
                                <p>9/30/2005</p>
                            </div>                                <div class="studentdetailbox">
                                    <h6>Class Teacher:</h6>
                                    <p>María Colón Colón</p>
                                </div>                            <div class="studentdetailbox">
                                <h6>Class:</h6>
                                <p>Noveno Monteverdi</p>
                            </div>                            <div class="studentdetailbox">
                                <h6>Section:</h6>
                                <p>Monteverdi</p>
                            </div>
                            
                        </div>
                        <div class="studentdetailright">
                            <div class="studentdetailbox">
                                <h6>Gender:</h6>
                                <p>Male</p>
                            </div>
                            <div class="studentdetailbox">
                                <h6>Phone:</h6>
                                <p>787-392-7682</p>
                            </div>                            <div class="studentdetailbox">
                                <h6>Email:</h6>
                                <p>student463@covenantpr.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                <div class="printableparentssec">
                    <div class="parentstitle">
                        <h4>Subjects</h4>
                    </div>
                    <div class="parentsdetailcontent">
                        <div class="parentsdetailbox">
                            <p>1234578</p>
                        </div>
                        <div class="parentsdetailbox">
                            <p>1234578</p>
                        </div>
                        <div class="parentsdetailbox">
                            <p>1234578</p>
                        </div>
                        <div class="parentsdetailbox">
                            <p>1234578</p>
                        </div>
                    </div>
                </div>
            <div class="printableparentssec">
                <div class="parentstitle">
                    <h4>Parents</h4>
                </div>                    <div class="parentsdetailcontent">
                        <div class="parentrelations">
                            <h4>My Mother</h4>
                            <p>Karol Nieves</p>
                        </div>
                        <div class="parentsdetailleft">
                            <div class="parentsdetailbox">
                                <h6>Email:</h6>
                                <p>kanieves0279@gmail.com</p>
                            </div>
                            <div class="parentsdetailbox">
                                <h6>Phone:</h6>
                                <p>787-392-7682</p>
                            </div>                        </div>                    </div>                        <div class="parentsdetailcontent">
                            <div class="parentrelations">
                                <h4>My Father</h4>
                                <p>Edwin A. Aleman Marquez</p>
                            </div>
                            <div class="parentsdetailleft">
                                <div class="parentsdetailbox">
                                    <h6>Email:</h6>
                                    <p>alexisaleman90@gmail.com</p>
                                </div>
                                <div class="parentsdetailbox">
                                    <h6>Phone:</h6>
                                    <p>787-392-8384</p>
                                </div>                            </div>                        </div>            </div>
        </div>

       </body></html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
$dompdf->set_option('enable_css_float', true);
// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('test',array("Attachment"=>0));

