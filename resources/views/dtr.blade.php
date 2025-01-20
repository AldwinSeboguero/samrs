<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
        <style>
            table {
                width: 50%;
                border-collapse: collapse;
            }
            td, th {
                border: thin solid black;
                padding: 5px;
            }
            .left-table-wrapper, .right-table-wrapper {
                width: 49%;
                /* padding-left: 20px; */
                padding-right: 16px;
                float: left;
            }
            .right-table-wrapper {
                margin-left: -1px; /* To fix border overlap */
            }
            .time-in-out {
                text-align: center;
            }
            .time-in-out span {
                display: block;
                font-size: 12px;
            }
            .header {
                text-align: center;
                margin-bottom: 10px;
            }
            .header h2 {
                margin: 0;
            }
            .header p {
                margin: 0;
            }
            hr {
                border: none;
                border-top: 1px solid black;
                margin: 0px 0;
                padding: 0;
                height: 1px;
            }
            body {
                font-family: Arial, Helvetica, sans-serif;
                margin-right: 0;
                padding-left:0;
            }
            
            @page { margin: 1.5cm 1.5cm 1.5cm 1.5cm  }
        </style>
    </head>
    <body style="margin:-40px -40px; ">
       
        <div class="left-table-wrapper">
            <div class="header">
                <div style="display:flex; align-items:center;">
                <table width="100%" style="border: none !important;">
                    <tr height="1">
                        <td valign="top" style="border: none !important;"><img src="images/psu_logo.png" alt="" width="40"/></td>
                        <td align="left" width="200" style="border: none !important;" >
                            <p style="margin-top:-8px;">
                                <b><span style="text-align:left; font-size: 14px; color: navy; font-weight: bold;">PARTIDO STATE UNIVERSITY</span></b> 
                                

                            </p>
                            <p style="margin-top:-8px;">
                            <b><span style="text-align:left; font-size: 10px; font-weight: bold;">Camarines Sur</span></b> <br>

                            </p>
                        </td>
                    </tr>

                </table>
                <table>
               
                    
                  </div>
                <!-- <p style="text-align:left; font-size: 18px; color: navy; font-weight: bold;">PARTIDO STATE UNIVERSITY</p>
                <p style="text-align:left; font-size: 14px; font-weight: bold;">Goa, Camarines Sur</p> -->
                <p style="text-align:right; font-size: 10px; color:crimson; font-weight: bold;">{{ $employee['employee_code'] }}</p>
                <p style="text-align:center; font-size: 16px; color: navy; font-weight: bold; margin-top: 8px;">DAILY TIME RECORD</p>
                <p style="text-align:center; font-size: 12px; font-weight: bold; margin-bottom: 6px;">{{$month}}</p>
                
                <!-- <table>
                    <tbody>
                        <tr style="text-align: left; margin-top: 0;">
                            <td style="width: 10px;">Name:</td>
                            <th><u>SEBOGUERO, ALDWIN RICAFORT</u></th>
                        </tr>
                        <tr style="text-align: left; margin-top: 0;">
                            <td style="width: 10px;">Office:</td>
                            <th>ICTMO</th>
                        </tr>
                        <tr style="text-align: left; margin-top: 0;">
                            <td style="width: 10px;">Position:</td>
                            <th>Programmer</th>
                        </tr>
                    </tbody>
                </table> -->
                <p style="text-align:left; font-size: 12px; margin-top:10px">Name:&nbsp;&nbsp;<span style="font-weight: bold;">{{ $employee['name'] }}<</span></p>
                <p style="text-align:left; font-size: 12px;">Office:&nbsp;&nbsp;<span style="font-weight: bold;">{{ $employee['division'] }}</span></p>
                <p style="text-align:left; font-size: 12px;">Position:&nbsp;&nbsp;<span style="font-weight: bold;">{{ $employee['position'] }}</span></p>
                <p style="text-align:left; font-size: 12px;">Official Hours for Regular Days: <span style="font-weight: bold;">{{$employee['work_days']}}</span></p>


            </div>
            <hr>
            <table style="margin-bottom:1px">
                <thead style="background-color: lightgray; border: 1px solid black; font-size: 10px;">
                    <tr>
                        <th rowspan="2" style="max-width: 20px;">DAY</th>
                        <th colspan="2">AM TIME</th>
                        <th colspan="2">PM TIME</th>
                        <th colspan="2">OVERTIME</th>
                        <th rowspan="2" style="max-width: 36px; font-weight: normal; font-style: italic; font-size:9px; ">Tardy &amp; Undertime</th>
                    </tr>
                    <tr>
                        <th style="min-width: 40px;">IN</th>
                        <th style="min-width: 40px;">OUT</th>
                        <th style="min-width: 40px;">IN</th>
                        <th style="min-width: 40px;">OUT</th>
                        <th style="min-width: 40px;">IN</th>
                        <th style="min-width: 40px;">OUT</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($time_records as $dailyTimeRecord)
                            <tr>
                                <td style="text-align:center; font-size: 9px; ">{{ str_pad($dailyTimeRecord["date"], 2, '0', STR_PAD_LEFT) }}</td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;">
                                {{$dailyTimeRecord["amin"] }}
                                </td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;">
                                {{$dailyTimeRecord["amout"] }}
                                </td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;">
                                {{$dailyTimeRecord["pmin"] }}
                                </td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;">
                                {{$dailyTimeRecord["pmout"] }}
                                </td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>
                                </tr>
                            @endforeach
                        <tr>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">Tardy=</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">0</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">Under=</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">0</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">Absent=</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">0</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>

                        </tr>
                        
                    </tbody>
                </table>
                <hr>

                <p style="text-align:justify; font-size: 12px;">I Certify on my honor that the above is true and correct report of the hours of work performed, record of which was made daily of the time of arrival and departure from office.</p>
                
                <p style="text-align:center; font-size: 10px; margin-top: 18px;"><u style="text-align:center; font-size: 12px;">{{ $employee['name']}}</u><br>Employee Signature</p>
                <p style="font-size: 11px;">Verified as to the prescribed office hours.</p>

                <p style="text-align:center; font-size: 11px; margin-top:18px"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>Supervisor / Dept.Head Signature</p>
                
               
            </div>

            
            <div class="left-table-wrapper">
            <div class="header">
                <div style="display:flex; align-items:center;">
                <table width="100%" style="border: none !important;">
                    <tr height="1">
                        <td valign="top" style="border: none !important;"><img src="images/psu_logo.png" alt="" width="40"/></td>
                        <td align="left" width="200" style="border: none !important;" >
                            <p style="margin-top:-8px;">
                                <b><span style="text-align:left; font-size: 14px; color: navy; font-weight: bold;">PARTIDO STATE UNIVERSITY</span></b> 
                                

                            </p>
                            <p style="margin-top:-8px;">
                            <b><span style="text-align:left; font-size: 10px; font-weight: bold;">Camarines Sur</span></b> <br>

                            </p>
                        </td>
                    </tr>

                </table>
                <table>
               
                    
                  </div>
                <!-- <p style="text-align:left; font-size: 18px; color: navy; font-weight: bold;">PARTIDO STATE UNIVERSITY</p>
                <p style="text-align:left; font-size: 14px; font-weight: bold;">Goa, Camarines Sur</p> -->
                <p style="text-align:right; font-size: 10px; color:crimson; font-weight: bold;">{{ $employee['employee_code'] }}</p>
                <p style="text-align:center; font-size: 16px; color: navy; font-weight: bold; margin-top: 8px;">DAILY TIME RECORD</p>
                <p style="text-align:center; font-size: 12px; font-weight: bold; margin-bottom: 6px;">{{$month}}</p>
                
                <!-- <table>
                    <tbody>
                        <tr style="text-align: left; margin-top: 0;">
                            <td style="width: 10px;">Name:</td>
                            <th><u>SEBOGUERO, ALDWIN RICAFORT</u></th>
                        </tr>
                        <tr style="text-align: left; margin-top: 0;">
                            <td style="width: 10px;">Office:</td>
                            <th>ICTMO</th>
                        </tr>
                        <tr style="text-align: left; margin-top: 0;">
                            <td style="width: 10px;">Position:</td>
                            <th>Programmer</th>
                        </tr>
                    </tbody>
                </table> -->
                <p style="text-align:left; font-size: 12px; margin-top:10px">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">{{ $employee['name'] }}<</span></p>
                <p style="text-align:left; font-size: 12px;">Office:&nbsp;&nbsp;<span style="font-weight: bold;">{{ $employee['division'] }}</span></p>
                <p style="text-align:left; font-size: 12px;">Position:&nbsp;&nbsp;<span style="font-weight: bold;">{{ $employee['position'] }}</span></p>
                <p style="text-align:left; font-size: 12px;">Official Hours for Regular Days: <span style="font-weight: bold;">{{ $employee['work_days'] }}</span></p>


            </div>
            <hr>
            <table style="margin-bottom:1px">
                <thead style="background-color: lightgray; border: 1px solid black; font-size: 10px;">
                    <tr>
                        <th rowspan="2" style="max-width: 20px;">DAY</th>
                        <th colspan="2">AM TIME</th>
                        <th colspan="2">PM TIME</th>
                        <th colspan="2">OVERTIME</th>
                        <th rowspan="2" style="max-width: 36px; font-weight: normal; font-style: italic; font-size:9px; ">Tardy &amp; Undertime</th>
                    </tr>
                    <tr>
                        <th style="min-width: 40px;">IN</th>
                        <th style="min-width: 40px;">OUT</th>
                        <th style="min-width: 40px;">IN</th>
                        <th style="min-width: 40px;">OUT</th>
                        <th style="min-width: 40px;">IN</th>
                        <th style="min-width: 40px;">OUT</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($time_records as $dailyTimeRecord)
                            <tr>
                                <td style="text-align:center; font-size: 9px; ">{{ str_pad($dailyTimeRecord["date"], 2, '0', STR_PAD_LEFT) }}</td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;">
                                {{$dailyTimeRecord["amin"] }}
                                </td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;">
                                {{$dailyTimeRecord["amout"] }}
                                </td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;">
                                {{$dailyTimeRecord["pmin"] }}
                                </td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;">
                                {{$dailyTimeRecord["pmout"] }}
                                </td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>
                                <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>
                                </tr>
                            @endforeach
                        <tr>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">Tardy=</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">0</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">Under=</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">0</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">Absent=</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;">0</td>
                            <td style="text-align:center; font-size: 9px; font-weight: bold;"></td>

                        </tr>
                        
                    </tbody>
                </table>
                <hr>

                <p style="text-align:justify; font-size: 12px;">I Certify on my honor that the above is true and correct report of the hours of work performed, record of which was made daily of the time of arrival and departure from office.</p>
                
                <p style="text-align:center; font-size: 10px; margin-top: 18px;"><u style="text-align:center; font-size: 12px;">{{ $employee['name']}}</u><br>Employee Signature</p>
                <p style="font-size: 11px;">Verified as to the prescribed office hours.</p>

                <p style="text-align:center; font-size: 11px; margin-top:18px"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>Supervisor / Dept.Head Signature</p>
                
               
            </div>
            

            
            
            
    </body>
</html>