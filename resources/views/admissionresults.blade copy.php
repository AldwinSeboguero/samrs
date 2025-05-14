<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Header</title>
    <style>
        body {
            font-family: 'Century Gothic', sans-serif;

        }

        .headerTitle {
            width: 88%;
            border-collapse: collapse;
            /* Remove space between cells */
            border: 0;
            /* Remove border */
        }

        .logo {
            width: 100px;
            /* Adjust logo size */
        }

        .title {
            font-size: 14px;
            padding: 0;
            /* Title size */
            font-weight: bold;
            text-align: center;
            color: navy;
        }

        .subtitle {
            color: navy;
            font-size: 14px;
            padding: 0;

            text-align: center;
        }

        .divider-container {
            width: 100%;
            position: relative;
            margin: 0px 0;
        }

        .divider {
            border: none;
            border-top: 2px solid black;
            width: 82%;
            /* Line width is 3/4 of the page */
            margin-right: 18%;
            /* Center the line */
        }

        .footer {
            /* font-weight: bold; */
            font-size: 16px;
            position: absolute;
            right: 0;
            top: -10px;
            padding-right: 10px;
        }

        h1 {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
            font-family: 'Century Gothic', sans-serif;
        }

        p {
            margin: 10px 0;
        }

        .instructions {
            margin-top: 10px;
            font-style: italic;
            font-size: 10px;
            font-family: 'Century Gothic', sans-serif;
        }

        .ballpen {
            color: navy;
            text-decoration: underline;
        }

        .pesonalInfo {
            width: 68%;


        }

        .pesonalInfo th,
        .pesonalInfo td {
            /* border: 0; */
            /* Remove borders from cells */

            text-align: center;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(270deg);
            background-color: #003366;
            /* Dark blue background */
            color: white;
            white-space: nowrap;
            font-size: 10px;
        }


        .form-container {
            border: 1px solid #000;
            padding: 20px;
            width: 800px;
            margin: auto;
        }

        .section {
            /* display: flex;
            justify-content: space-between; */
        }

        .column {
            /* width: 48%; */
        }

        .section h2 {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            /* margin: 10px 0; */
        }

        .checkbox {
            /* margin-bottom: 10px; */
        }

        .signature {
            margin-top: 20px;
            text-align: right;
        }

        .lastTable .otherInfo .container {
            /* background-color: #fff;  */
        }

        .lastTable .otherInfo table {
            width: 100%;
            border-collapse: collapse;
        }

        .lastTable .otherInfo th,
        td {
            /* padding: 10px; */
            /* No border */
            font-size: 10px;
            font-weight: bold;
        }

        .lastTable .otherInfo th {
            text-align: left;
        }

        .lastTable .otherInfo .specify {
            border: none;
            border-bottom: 1px solid #ccc;
            width: 60px;
            /* margin-right: 30px; */
            outline: none;
            margin-left: 10px;
        }

        .lastTable .otherInfo .specify:focus {
            border-bottom: 1px solid #007BFF;
            /* Change color on focus */
        }

        .lastTable table {
            width: 100%;
            border-collapse: collapse;
        }

        .lastTable td {
            /* border: 1px solid #ccc;       */
        }

        .lastTable .last-column {
            /* background-color: #002147; Dark blue background for the last column */
            /* color: white; */
            /* width: 200px; Fixed width for the last column */
        }

        .note {
            text-align: left;
            font-weight: normal;
            font-style: italic;
            margin-bottom: 10px;
            font-family: 'Century Gothic', sans-serif;
            margin-left: 10px;

        }

        .center-table {
            width: 600px;
            /* Fixed width */
            margin: auto;
            /* Centered */
            /* border-collapse: collapse; */

        }

        .center-table th,
        .center-table td {
            /* padding: 10px; */
            /* Padding for cells */
            text-align: left;
            /* Align text to the left */
        }

        .center-table .input-field {
            border: none;
            border-bottom: 1px solid #000;
            /* Underline effect */
            outline: none;
            width: 100%;
            /* Full width for input fields */
        }

        .schedule-table {
            width: 600px;
            /* Fixed width */
        }

        .schedule-table th,
        .schedule-table td {
            /* padding: 10px; */
            /* Padding for cells */
            text-align: left;
            /* Align text to the left */
        }

        .schedule-table .input-field {
            border: none;
            border-bottom: 1px solid #000;
            /* Underline effect */
            outline: none;
            width: 100%;
            /* Full width for input fields */
        }

        .schedule-table .bold {
            font-weight: bold;
            /* Bold text */
        }

        .checkbox-group {
            display: flex;
            align-items: center;
        }

        .checkbox-group label {
            margin-right: 15px;
            /* Space between checkboxes */
        }

        .id-picture {
            text-align: center;

        }
        #footer {
        position: fixed;
        bottom: -34px;
        }
        .watermark {
            border: 1px solid black;
            width: 250px;
            padding: 15px;
            padding-bottom: 20px;
            padding-top: 10px;
            position: relative;
            overflow: hidden;
        }
        .watermark img {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            width: 150px; /* Adjust size as needed */
            z-index: 1;
        }
        .content {
            z-index: 1;
            position: relative;
        }
    </style>
</head>

<body style="margin:-20px -20px;  margin-bottom: -30px; margin-right:10px;">

<table class="" style="width: 100%;">
        <thead>
            <th colspan="1"
                style="text-align: center; width:70%;  padding: 4px; font-size: 8px;">
                <div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td class="logo" rowspan="3" style="padding: 0; vertical-align: top;">
                            <img src="images/psu_logo.png" alt="University Logo" width="50" style="filter: brightness(100%);">
                        </td>
                        <td class="title" style=" vertical-align: top;">Republic of the Philippines</td>
                    </tr>
                    <tr>
                        <td class="title" style=" vertical-align: top;">PARTIDO STATE UNIVERSITY</td>
                    </tr>
                    <tr>
                        <td class="subtitle" style=" vertical-align: top;">Camarines Sur</td>
                    </tr>
                </table>

                    <div class="divider-container">
                        <hr class="divider">
                        <span class="footer">PSU-OF-GAP-06</span>
                    </div>
                  
                </div></th>
                <th colspan="1"
                style="text-align: center; width:30%;  padding: 4px; font-size: 28px; font-weight: normal; border-left: solid black 2px; border-right: solid black 2px;">
                {{ $applicant['type'] }}    
            </th>
        </thead>
    </table>
  

   

    <table class="otherInfo" style="width: 100%;">
        <thead>
            <th colspan="1"
                style="text-align: center; width:75%; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                EXAMINEE INFORMATION</th>
                <th colspan="1"
                style="text-align: center; width:25%; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                EQUITY GROUP</th>
        </thead>
<tbody>
<tr>
            <td style=" vertical-align:top; font-size: 18px;">

                <div class="" style="border: 1px solid grey;">
                <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="font-weight: normal; padding: 5px; width: 150px; font-size: 14px;">Name</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px; font-size: 14px;">{{ $applicant['name'] }}</td>
        </tr>
        <tr>
            <td style="font-weight: normal; padding: 5px; width: 150px; font-size: 14px;">School Last Attended</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px; font-size: 14px;">{{ $applicant['sla_name'] }}</td>
        </tr>
        <tr>
            <td style="font-weight: normal; padding: 5px; width: 150px; font-size: 14px;">Track & Strand/Course</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px; font-size: 14px;">{{ $applicant['sla_track'] }} {{ $applicant['course_major'] }}</td>
        </tr>
       
    </table>

                </div>

            </td>

            <td style=" vertical-align:top;  " >
            <div style="border: 1px solid grey; text-align: center; height: 80px; font-size: 16px;">
            {{ $applicant['equity_group'] }}
                </div>

                </td>

        </tr>
</tbody>

    </table>
 

    
    <table class="otherInfo" style="width: 100%;">
        <thead>
            <th colspan="2"
                style="text-align: center; width:100%; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                EXAMINATION RESULT</th> 
        </thead>

        <tr>
            <td style=" vertical-align:top; width: 20%;">

           
<div style="font-family: Arial, sans-serif; text-align: center;">
<div class="watermark">
    <img src="images/psu_logo.png" alt="Watermark">
    <div class="content">
    <div style="font-size: 16px; font-weight: bold;">Percentile Rank</div>
        <div style="font-size: 60px; font-weight: bold; margin: 10px 0;">      {{ $applicant['percentile_rank'] }}</div>
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <tr>
                <td style="border: none; text-align: center;">
                    <div style="font-weight: bold; font-size: 18px;">      {{ $applicant['reading'] }}</div>
                    <div style="font-weight: normal; font-size: 14px;">Reading</div>
                </td>
                <td style="border: none; text-align: center;">
                    <div style="font-weight: bold; font-size: 18px;">      {{ $applicant['math'] }}</div>
                    <div style="font-weight: normal; font-size: 14px;">Math</div>
                </td>
                <td style="border: none; text-align: center;">
                    <div style="font-weight: bold; font-size: 18px;">      {{ $applicant['language'] }}</div>
                    <div style="font-weight: normal; font-size: 14px;">Language</div>
                </td>
            </tr>
        </table>
    </div>
</div>
</div>

    </div>

            </td>
            <td style=" vertical-align:top; width: 80%;">
                <div >
                <table style="  border: 1px solid black; width: 100%; min-height:120px;">
        <tr>
            <th></th>
            <th style="border: none; text-align: center; padding: 10px; font-size:12px;">
                Course and Campus
            </th>
            <th style="border: none; text-align: center; padding: 10px; font-size:12px;">
                Status
            </th>
        </tr>
        <tr>
            <td>  <div style="font-style: italic; font-size:14px; font-weight:normal;">First Choice</div></td>
            <td style="padding: 10px; font-size:14px;">
              
                <div>{{ $applicant['dc_course'] }} {{ $applicant['dc_campus'] }}</div>
            </td>
            <td style="padding: 10px; text-align: center; font:size: 14px;">
                <div style="font-weight: bold; font-size:14px;">{{ $applicant['status_1'] }}</div>
            </td>
        </tr>
        <tr>
            <td>
            <div style="font-style: italic; font-size:14px; font-weight:normal;">Second Choice</div></td>
            <td style="padding: 10px; font-size:14px;">
                <div>{{ $applicant['dc_course1'] }} {{ $applicant['dc_campus1'] }}</div>
            </td>
            <td style="padding: 10px; text-align: center; font-size:14px;">
                <div style="font-weight: bold;">{{ $applicant['status_2'] }}</div>
            </td>
        </tr>
    </table>
                </div>
    <div>
        
    <table class="otherInfo" style="width: 100%;">
        <thead>
            <th colspan="1"
                style="text-align: center; width:100%; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                ENDORSED FOR</th> 
        </thead>

        <tr style="margin:0;padding:0;">
            <td style=" vertical-align:top; width: 100%;  border: 1px solid black;  padding-bottom:5px;  padding-top:5px;">

            <div style="text-align: center; font-size: 16px;  min-height:20px;">
            {{ $applicant['endorsed_for'] }}
                </div>

            </td>

        </tr>
    </table>

    </div>
            </td>

        </tr>
    </table>

    
    <table class="otherInfo" style="width: 100%;">
        <thead>
            <th colspan="1"
                style="text-align: center; width:100%; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                THIS RESULT IS VALID ONLY FOR THE FIRST SEMESTER OF THE 2025-2026 ACADEMIC YEAR</th> 
        </thead>

        <tr style="">
            <td style=" vertical-align:top; width: 100%;">


            <div style="border: 1px solid black; width: 100%;">
        <div style=" font-weight: 100;  font-size: 14px; margin-left:10px">Legend:</div>
        <table style="width: 100%; border-collapse: collapse; margin:10px;">
            <tr>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal; padding-right: 10px;">
                    <strong> <u>PASSED</u></strong>
                    - The applicant met the required cut-off score and is qualified or has secured a slot for the program they applied for.
                </td>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal">
                    <strong> <u>NOT QUALIFIED</u></strong>
                    - The applicant did not meet the cut-off score for both the board and non-board programs and is not qualified to enter any programs offered by the university.
                </td>
            </tr>
            <tr>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal; padding-right: 10px;">
                    <strong><u>WAITLISTED</u></strong>
                     - The applicant has not met the required cut-off scores but admission to the University will depend on the availability of slots open by qualified applicants who did not confirm their slots.
                </td>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal">
                    <strong><u>BELOW CUTOFF SCORE</u></strong>
                     - The applicant has met the required cutoff scores but was outperformed by other examinees in their chosen programs. Admission to the University will depend on the availability of slots.
                </td>
            </tr>
            <tr>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal; padding-right: 10px;">
                    <strong> <u>BELOW QUOTA</u> </strong>
                     - The applicant has met the required cut-off scores but was outperformed by
other examinees in their chosen programs. Admission to the University will depend on the
availability of slots.
                </td>
                <td style="width: 50%; border: none; font-size: 14px; font-weight: normal">
                <div style="margin-top: 20px; text-align: right; margin-right:30px">
           <strong> (SGD) MARIA KORINA P. ENRIQUEZ, Rn, RGC</strong><br>
            Director, Guidance and Placement Office
        </div>
                </td>
            </tr>
        </table>
       
    </div>

            </td>

        </tr>
    </table>


    
    <table class="otherInfo" style="width: 100%;">
        <thead>
            <th colspan="1"
                style="text-align: center; width:100%; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                NOTE: ANY ALTERATION OR FALSIFICATION OF THIS DOCUMENT MAY RESULT IN DISQUALIFICATION FROM ADMISSION TO THE UNIVERSITY</th>
        </thead>
 
    </table>



    </div>
    <div id="footer"  style="border-top: 1px solid black; width: 100% ;">  
    <table width="100%" style="margin:0; padding:0;">
                                        <tr>
                                            <td style="font-family: Calibri, sans-serif; font-size: 11px; font-weight: bolder; width: 50%;">
                                                Effectivity Date: May 8, 2025
                                            </td>
                                            <td style="font-family: Calibri, sans-serif; font-size: 11px; font-weight: bolder; width: 30%;">
                                                Rev.No.: 00
                                            </td>
                                            <td style="font-family: Calibri, sans-serif; font-size: 11px; font-weight: bolder; width: 20%; text-align:right;">
                                                Page 1 of 1
                                            </td>
                                        </tr>

                                    </table>
    </div>
    

</body>

</html>