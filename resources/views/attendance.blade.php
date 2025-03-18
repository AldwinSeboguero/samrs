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
            width: 100%;
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
        .h-label {
    
            width: 100%;
            padding-right:10px;
            padding-left:10px;

        }
        .h-label td {
            padding: 5px;
           /* Border for clarity */
        }
        .h-label .bold {
            font-weight: bold; /* Bold text for venue */
        }
        .h-label .border-b {
            /* border-bottom: 2px solid black; Thicker bottom border for separation */
        }

 
    </style>
</head>

<body style="margin:-20px -20px;  margin-bottom: -30px;">


    <table class="headerTitle">
        <tr>
            <td class="logo" rowspan="3">
                <img src="images/psu_logo.png" alt="University Logo" width="60">
            </td>
            <td class="title">Republic of the Philippines</td>
        </tr>
        <tr>
            <td class="title">PARTIDO STATE UNIVERSITY</td>
        </tr>
        <tr>
            <td class="subtitle">Camarines Sur</td>
        </tr>
    </table>

    <div class="divider-container">
        <hr class="divider">
         
    </div>
    <h1>ParSU Examinees Attendance Sheet</h1>

  
    <table class="h-label">
            <tr>
                <td style="width:10px;">Date:</td>
                <td style="border-bottom: 1px solid black; ">{{strtoupper(\Carbon\Carbon::parse($exam_schedule->exam_date)->format('F j, Y')) }}</td>
                <td style="text-align: right">Venue:</td>
                <td style="border-bottom: 1px solid black; " class="bold">{{strtoupper( $exam_schedule->venue->name) }}</td>
            </tr>
            <tr class="border-b">
                <td>Time:</td>
                <td style="border-bottom: 1px solid black; ">{{strtoupper(\Carbon\Carbon::parse($exam_schedule->exam_date)->format('g:i A')) }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>

  
    

  

    <table style="border-collapse: collapse; width: 100%; padding:16px; padding-right: 40px; padding-left:40px;">
            <thead>
                <tr>
                    <th style="padding: 4px; font-size:12px; border: 1px solid #000000; background-color: #ffffff; text-align: center;">#</th> 
                    <th style="padding: 4px; font-size:12px; border: 1px solid #000000; background-color: #ffffff; text-align: center;">Name</th>
                    <th style="padding: 4px; font-size:12px; border: 1px solid #000000; background-color: #ffffff; text-align: center;">Signature</th>
                    <th style="padding: 4px; font-size:12px; border: 1px solid #000000; background-color: #ffffff; text-align: center;">Remarks</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($applicant as $applicant)
            <tr>
                <td style="padding: 6px; border: 1px solid #000000; font-size: 11px; width: 14px; text-align: center;">{{ $applicant['index'] }}</td>
                <td style="padding: 6px; border: 1px solid #000000; font-size: 11px;">{{ $applicant['name'] }}</td>
                <td style="padding: 6px; border: 1px solid #000000; font-size: 11px;"></td>
                <td style="padding: 6px; border: 1px solid #000000; font-size: 11px;"></td>
            </tr>
        @endforeach
            </tbody>
        </table>
     
    

</body>

</html>