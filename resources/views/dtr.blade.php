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
        <span class="footer">PSU-OF-GAP-01</span>
    </div>
    <h1>ParSU COLLEGE ADMISSION TEST APPLICATION FORM</h1>

    <p class="instructions">
        Instructions: Kindly fill out this information sheet accordingly and
        make sure not to leave any blank fields. Use <span class="ballpen">BLUE</span> Ink only.
    </p>


    <table class="personalInfo" style="width: 700px; ">
        <thead>
            <th colspan="2"
                style="text-align: left; background-color: #003366; color: white;   padding: 8px; font-size: 12px;">
                Personal Information</th>

            <th rowspan="2" style="   border: 1px dashed #000; width:200px;    font-size: 10px;">
                <span style="padding-left:30px;padding-right:30px; font-style:italic; text-align:justify">
                    Paste 2x2 latest ID picture in formal attire and white background here.
                </span>
            </th>
        </thead>
        <tbody style="border: 1px solid grey; height: 200px;">

            <tr>
                <td style=" vertical-align:top; width: 550px;">

                    <div style="border: 1px solid grey;">
                        <table style="">

                            <tr style="">

                                <td style=" vertical-align:top;  ">

                                    <table style="width: 540px; ">
                                        <tr>
                                            <!-- <td class="vertical-text" rowspan="7"><span>Personal Information</span></td> -->
                                            <td style="font-size: 12px; font-weight: bold; text-align: left; vertical-align:bottom; width: 50px;"
                                                rowspan="2">Name</td>

                                            <td style="font-size: 6px; font-weight: bold;" colspan="">Surname</td>
                                            <td style="font-size: 6px; font-weight: bold;" colspan="">First Name</td>
                                            <td style="font-size: 6px; font-weight: bold;" colspan="">Middle Name</td>
                                            <td style="font-size: 6px; font-weight: bold;" colspan="">Ext. (e.g Jr., II)
                                            </td>
                                        </tr>
                                        <tr style="font-size: 12px; font-weight: bold; width: 600px;">
                                            <td style="padding: 5px;  border-bottom: 1px solid grey; ">
                                                {{strtoupper($applicant->last_name)}}</td>
                                            <td style="padding: 5px;  border-bottom: 1px solid  grey;">
                                                {{strtoupper($applicant->first_name)}}</td>
                                            <td style="padding: 5px;  border-bottom: 1px solid  grey;">
                                                {{strtoupper($applicant->middle_name)}}</td>
                                            <td style="padding: 5px;  border-bottom: 1px solid  grey;">
                                                {{strtoupper($applicant->suffix)}}</td>
                                        </tr>
                                    </table>


                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <table style="width: 540px;">
                                        <tr>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Complete Address</td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:330px;">
                                                {{strtoupper($applicant->city_address)}},
                                                {{strtoupper($applicant->province_address)}}
                                            </td>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Zip Code</td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:50px;">
                                                {{strtoupper($applicant->zip)}}
                                            </td>

                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table style="width: 540px;">
                                        <tr>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Civil Status </td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:130px;">
                                                {{strtoupper($applicant->civilStatus->name)}}
                                            </td>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Sex </td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:30px;">
                                                {{strtoupper($applicant->sex->name)}}

                                            </td>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Age </td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:30px;">
                                                {{strtoupper(\Carbon\Carbon::parse($applicant->birthday)->age)}}

                                            </td>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Date of Birth (mm/dd/yy)</td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:90px;">
                                                {{
                                                strtoupper(\Carbon\Carbon::parse($applicant->birthday)->format('m/d/y'))
                                                }}
                                            </td>

                                        </tr>
                                    </table>

                                </td>
                            <tr>
                                <td>
                                    <table style="width: 540px;">
                                        <tr>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Contact Number</td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:180px;">
                                                {{strtoupper($applicant->contact_no)}}

                                            </td>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Email Address</td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:175px;">
                                                {{strtoupper($applicant->email)}}

                                            </td>

                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table style="width: 540px;">
                                        <tr>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Person to contact in case of emergency </td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:340px;">
                                                {{strtoupper($applicant->emergency_contact_name)}}

                                            </td>


                                        </tr>
                                    </table>

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <table style="width: 540px;">
                                        <tr>
                                            <td
                                                style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                                Contact Number </td>

                                            <td
                                                style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:440px;">
                                                {{strtoupper($applicant->emergency_contact_no)}}

                                            </td>


                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

            </tr>
        </tbody>
    </table>

    <table class="otherInfo" style="width: 100%;">
        <thead>
            <th colspan="2"
                style="text-align: left; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                Educational Background</th>
        </thead>

        <tr>
            <td style=" vertical-align:top; width: 100%;">

                <div class="" style="border: 1px solid grey;">
                    <table>

                        <tr style="width: 100%;">

                            <td style="width: 100%;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="vertical-align: middle; white-space: nowrap;">
                                            <input type="checkbox" name="educationLevel" value="seniorHigh"
                                                style="width: 12px; height: 12px; margin-bottom:10px; margin-right: 10px;"
                                                @if($applicant->curriculum == 'SENIOR HIGH SCHOOL') checked @endif>
                                        </td>
                                        <td style="vertical-align: middle; white-space: nowrap;">SENIOR HIGH SCHOOL</td>
                                        <td style="vertical-align: middle; white-space: nowrap;">
                                            <input type="checkbox" name="educationLevel" value="oldCurriculum"
                                                style="width: 12px; height: 12px; margin-bottom:10px; margin-right:6px; margin-left: 6px;"
                                                @if($applicant->curriculum == 'OLD CURRICULUM') checked @endif>
                                        </td>
                                        <td style="vertical-align: middle; white-space: nowrap;">OLD CURRICULUM</td>
                                        <td style="vertical-align: middle; white-space: nowrap;">
                                            <input type="checkbox" name="educationLevel" value="als"
                                                style="width: 12px; height: 12px; margin-bottom:10px; margin-right:6px; margin-left: 6px;"
                                                @if($applicant->curriculum == 'ALS') checked @endif>
                                        </td>
                                        <td style="vertical-align: middle; white-space: nowrap;">ALS</td>
                                        <td style="vertical-align: middle; white-space: nowrap;">
                                            <input type="checkbox" name="educationLevel" value="transferee"
                                                style="width: 12px; height: 12px; margin-bottom:10px; margin-right:6px; margin-left: 6px;"
                                                @if($applicant->curriculum == 'TRANSFEREE') checked @endif>
                                        </td>
                                        <td style="vertical-align: middle; white-space: nowrap;">TRANSFEREE</td>
                                        <td style="vertical-align: middle; white-space: nowrap;">
                                            <input type="checkbox" name="educationLevel" value="secondCourse"
                                                style="width: 12px; height: 12px; margin-bottom:10px; margin-right:6px; margin-left: 6px;"
                                                @if($applicant->curriculum == 'SECOND COURSE') checked @endif>
                                        </td>
                                        <td style="vertical-align: middle; white-space: nowrap;">SECOND COURSE</td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                        <tr style="width: 100%;">
                            <td style="font-size: 10px; font-weight: bold; text-align: left;   vertical-align:top;">SCHOOL LAST ATTENDED
                                (please
                                do not abbreviate)</td>

                        </tr>
                        @php
                        $parts = explode('-', $applicant->sla_name);
                        $schoolName = isset($parts[0]) ? trim($parts[0]) : '';
                        $address = isset($parts[1]) ? trim($parts[1]) : '';
                        @endphp
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td
                                            style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                            Name of School</td>

                                        <td
                                            style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:600px;">
                                            {{ strtoupper($schoolName) }}

                                        </td>

                                    </tr>
                                </table>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td
                                            style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                            Address</td>

                                        <td
                                            style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:400px;">
                                            {{ $address }}

                                        </td>
                                        <td
                                            style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                            Year Completed</td>

                                        <td
                                            style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:150px;">
                                            {{strtoupper($applicant->sla_completed_year)}}

                                        </td>

                                    </tr>
                                </table>

                            </td>
                        </tr>


                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td
                                            style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                            Track & Strand</td>

                                        <td
                                            style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:330px;">
                                            {{strtoupper($applicant->sla_track)}}

                                        </td>
                                        <td
                                            style="vertical-align: middle; white-space: nowrap; font-size: 10px; font-weight: bold;">
                                            Course/Major</td>

                                        <td
                                            style="vertical-align: middle; white-space: nowrap; border-bottom: 1px solid grey; width:200px;">

                                        </td>

                                    </tr>
                                </table>

                            </td>
                        </tr>

                    </table>

                </div>

            </td>

        </tr>
    </table>

    <table class="otherInfo" style="width: 100%;">
    <thead>
    <tr>
        <th colspan="2" style="text-align: center; background-color: #003366; color: white; font-style: italic; padding: 4px; font-size: 12px;">
        <div style="text-align: left; vertical-align:bottom; font-size:8px;">For Transferee:</div>

            <div>To be filled-out by the College Dean/Program Director/Department Chair</div>

        </th>
    </tr>
</thead>

        <tr>
            <td style=" border: 1px solid gray; padding-left: 10px; vertical-align:top">

                <div class="section" style="margin: 0;">
                    <div class="column" style="margin: 0;">
                        <h3 style="text-align: left; margin: 0;">EVALUATION</h3>
                        <div class="checkbox">( &nbsp; &nbsp;) Evaluated as transferee with no failing/incomplete
                            grades.</div>
                        <div class="checkbox">( &nbsp; &nbsp;) Evaluated as transferee with one or two
                            failing/incomplete grades.</div>
                        <div class="checkbox">( &nbsp; &nbsp;) Evaluated as transferee with three or more
                            failing/incomplete grades.</div>
                        <p style="margin: 0; padding:0;"><strong>COURSE TO ENROLL:</strong><br><br> _____________________________________________</p>
                        <p style="margin: 0; padding:0;"><strong>CAMPUS:</strong> <br><br>_____________________________________________</p>
                    </div>


                </div>

            </td>
            <td style=" border: 1px solid gray; padding-left: 10px;">
            <div class="section" style="margin: 0;">
                    <div class="column" style="margin: 0;">
                        <h3 style="text-align: left; margin: 0;">RECOMMENDATIONS</h3>
                        <div class="checkbox">( &nbsp; &nbsp;) For admission as transferee no need to take the
                            ParSUCAT.</div>
                        <div class="checkbox">( &nbsp; &nbsp;) For admission as transferee to take the ParSUCAT.
                        </div>
                        <div style="margin-top:5px;">Others: _________________________________________</div>
                        <p style="margin-top: 10px; padding:0;"> ___________________________________</p>
                        <strong>Signature over Printed Name/Date</strong>
                        </p>
                        <p>
                            <strong>Designation:</strong> ______________________
                        </p>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table>
                            <thead>
                                <th colspan="2"
                                    style="text-align: left; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                                    Other Information</th>
                            </thead>
                            <tbody style="border: 1px solid grey; height: 200px;">

                                <tr>
                                    <td style=" vertical-align:top; width: 760px;">
                                        <div class="" style="border: 1px solid grey;">
                                            <table>

                                                <tr style="padding:0px;margin:0px;">
                                                    <td
                                                        style=" font-size:10px; white-space: nowrap; font-weight:normal;">
                                                        1. Are you a person with a disability?</td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><input type="checkbox" name="disability" value="no"
                                                                        @if($applicant->isPWD != 'true') checked @endif>
                                                                </td>
                                                                <td>No</td>
                                                                <td><input type="checkbox" name="disability" value="yes"
                                                                        @if($applicant->isPWD == 'true') checked @endif>
                                                                </td>
                                                                <td>Yes</td>
                                                            </tr>
                                                        </table>

                                                    </td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><label for="indigenous-specify"
                                                                        style=" font-size:10px; white-space: nowrap; font-weight:normal;">If
                                                                        YES, please specify:</label>
                                                                </td>
                                                                <td style="border-bottom:1px solid grey; width:80px;">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style=" font-size:10px; white-space: nowrap; font-weight:normal;">
                                                        2. Are you a member of an indigenous group/community?</td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><input type="checkbox" name="disability" value="no"
                                                                        @if($applicant->isIPs != 'true') checked @endif>
                                                                </td>
                                                                <td>No</td>
                                                                <td><input type="checkbox" name="disability" value="yes"
                                                                        @if($applicant->isIPs == 'true') checked @endif>
                                                                </td>
                                                                <td>Yes</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><label for="indigenous-specify"
                                                                        style=" font-size:10px; white-space: nowrap; font-weight:normal;">If
                                                                        YES, please specify:</label>
                                                                </td>
                                                                <td style="border-bottom:1px solid grey; width:80px;">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style=" font-size:10px; white-space: nowrap; font-weight:normal;">
                                                        3. Are you a Solo Parent or Child of a Solo Parent?</td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><input type="checkbox" name="disability" value="no"
                                                                        @if($applicant->isSoloParent != 'true') checked
                                                                    @endif></td>
                                                                <td>No</td>
                                                                <td><input type="checkbox" name="disability" value="yes"
                                                                        @if($applicant->isSoloParent == 'true') checked
                                                                    @endif></td>
                                                                <td>Yes</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"
                                                        style=" font-size:10px; white-space: nowrap; font-weight:normal;">
                                                        4. Are you a resident of Geographically Isolated and
                                                        Disadvantaged Areas (GIDAs)?</td>
                                                    <td colspan="2">
                                                        <table>
                                                            <tr>
                                                                <td><input type="checkbox" name="disability" value="no"
                                                                        @if($applicant->isGIDAs != 'true') checked
                                                                    @endif></td>
                                                                <td>No</td>
                                                                <td><input type="checkbox" name="disability" value="yes"
                                                                        @if($applicant->isGIDAs == 'true') checked
                                                                    @endif></td>
                                                                <td>Yes</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <p style="margin:0;">*Please attach proof of membership, copy of ID or certification if
                                                applicable.
                                            </p>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>



                        <table>
                            <thead>
                                <th colspan="2"
                                    style="text-align: left; background-color: #003366; color: white;   padding: 4px; font-size: 12px;">
                                    Desired Course(s)</th>
                            </thead>
                            <tbody style="border: 1px solid grey; height: 200px;">

                                <tr>
                                    <td style=" vertical-align:top; width: 760px;">

                                        <div class="" style="border: 1px solid grey;">
                                            <table class="otherInfo" style="width: 700px;">

                                                <tr>
                                                    <td>


                                                        <div class="note">Note: Write down your desired course(s) you
                                                            wish to pursue in the
                                                            University and indicate its corresponding campus.</div>

                                                        <table style="margin-left: 10px; width: 700px;  margin-top:0px; padding-top:0px;">
                                                            <tr style="text-align: center;">
                                                                <th></th>
                                                                <th>Course</th>
                                                                <th>Campus</th>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>First Choice:</strong></td>
                                                                <td style="
          border: none;
            border-bottom: 1px solid #ccc;
            width: 475px;  
             ">

                                                                    {{strtoupper($applicant->course->name)}}
                                                                </td>
                                                                <td style="
            border: none;
              border-bottom: 1px solid #ccc;
              width: 125px;  text-align:center
               ">
                                                                    {{strtoupper($applicant->course->campus->name)}}

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Second Choice:</strong></td>
                                                                <td style="
            border: none;
              border-bottom: 1px solid #ccc;
              width: 475px;  
               ">
                                                                    {{strtoupper($applicant->course1->name)}}

                                                                </td>
                                                                <td style="
            border: none;
              border-bottom: 1px solid #ccc;
              width: 125px;   text-align:center
               ">
                                                                    {{strtoupper($applicant->course1->campus->name)}}

                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>

                                </tr>


                                <tr>
                                    <td style=" vertical-align:top; text-align:left; width: 700px;">

                                        <div class="" style=" ">
                                            <table class="otherInfo" style="width: 100%;">

                                                <tr>
                                                    <td style=" border: 1px grey solid;">

                                                        <table  style="width: 700px;">
                                                            <tr>
                                                                <td><strong>Testing Center you want to submit your
                                                                        requirements: </strong> {{
                                                                    strtoupper(\Carbon\Carbon::parse($applicant->Subschedule->submission_date)->format('M
                                                                    d, Y')) }} -
                                                                    {{strtoupper($applicant->Subschedule->venue->name)}}</td>
                                                            </tr>
                                                   
                                                        </table>

                                                    </td>
                                             
                                                </tr>
                                            </table>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
    <table class="personlInfo" style="width: 760px; ">
        <thead>
          


            <th style="  font-size: 10px; vertical-align: top; ">
                <h2 style="text-align: center; vertical-align: top; background: #003366; color: white; margin: 0; ">
                    Declaration</h2>
                <div
                    style=" border: 1px solid grey; text-align: justify; font-size:12px; font-weight:normal">
                    <p style="padding-left: 10px; padding-right: 10px;">I hereby certify that all information
                        written in
                        this form is complete and accurate. I also allow the PSU-GAP Office to process and store the
                        data that I have provided in this form subject to the provisions of the Data Privacy Act of
                        2021
                        (RA 10173). By affixing my signature below, I hereby acknowledge that I have read and
                        understood
                        the terms of this form with regard to my personal information and agree to abide by the
                        University’s Admission Policy.</p>

                    <div class="signature" style="text-align: center;">
                        <span>__________________________</span><br>

                        <span>Signature over Printed Name</span><br>
                        <span class="date">Date: __________</span>
                    </div>
                </div>
            </th>
        </thead>

    </table>


    </div>
    <div id="footer"  style="border-top: 1px solid black; width: 760px ;">  
    <table width="800px" style="margin:0; padding:0;">
                                        <tr>
                                            <td style="font-family: Calibri, sans-serif; font-size: 11px; font-weight: bolder; width: 50%;">
                                                Effectivity Date: January 21, 2025
                                            </td>
                                            <td style="font-family: Calibri, sans-serif; font-size: 11px; font-weight: bolder; width: 30%;">
                                                Rev.No.: 00
                                            </td>
                                            <td style="font-family: Calibri, sans-serif; font-size: 11px; font-weight: bolder; width: 20%;">
                                                Page 1 of 1
                                            </td>
                                        </tr>

                                    </table>
    </div>
    

</body>

</html>