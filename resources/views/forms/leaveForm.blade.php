<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leave Application Form</title>
    <style>

        label{
            font-size: 12px
        }

        p{
            font-size: 12px
        }
        .data{
            font-size: 12px
        }
        body {
            font-family: Arial, sans-serif;
        }

        .super-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .heading-container {
            display: flex;
            align-items: center;
            text-align: center;
            gap: 15px;
        }

        .heading-text {
            margin-right: 90px;
        }

        .heading-img img {
            width: 80px;
            height: auto;
        }

        .school-name {
            font-family: 'Old English Text MT', serif;
            margin: 0;
        }

        .title-container {
            text-align: center;
            margin-top: 10px;
        }

        .department {
            margin-top: -20px;
        }

        span {
            font-size: 25px;
        }

        .body-container {
            width: 100%;
            max-width: 900px;
            padding: 20px;
            padding-top: 0;
            border: 2px solid black;
            background-color: white;
        }

        .user-info {
            display: flex;
            gap: 10px;
        }

        .section {
            padding-bottom: 10px;
            border-bottom: 1px solid black;
            margin-top: 20px;
        }
        .new-section{
            padding-bottom: 10px;
            border-bottom: 1px solid black;
            margin-top: 20px;
        }
        .section-two{
            display: flex;
            margin-top: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid black;
        }
        .section-two div{
            min-width: 450px;
        }
        .section-two table{
            width: 96%;
        }
        .details-box{
            border-left: 1px solid black;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-group label {
            width: 48%;
            display: flex;
            align-items: center;
        }

        .checkbox-group input[type="checkbox"] {
            margin-right: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        th {
            font-size: 12px;
            background-color: #f0f0f0;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            text-align: center;
        }

        .signature div {
            width: 32%;
        }

        .signature p {
            margin: 5px 0;
        }

        @media print {
            .body-container {
                page-break-inside: avoid;
            }
        }
        .employee-sign{
            display: flex;
            justify-content: end;
            margin-top: 20px;
            text-align: center;
        }
        .employee-sign div {
            width: 32%;
        }
        .employee-sign p {
             margin: 5px 0;
        }
        .section-title{
            display: flex;
            justify-self: center;
        }
        .sub-section-title{
            display: flex;
            justify-self: center;
            margin-top: 0;
        }
        .sub-section{
            display: flex;
            flex-direction: column;
            margin: 5px 20px;
        }
        .sub-section-two{
            display: flex;
            flex-direction: column;
            margin-top: 20px;
            gap: 10px;
        }
        .sub-section label{
            display: flex;
            justify-items: center;
            margin-top: 5px;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="super-container">
        <div class="heading-container">
            <div class="heading-img">
                <img src="{{ asset('assets/images/mdc-logo.png')}}" alt="MDC LOGO">
            </div>
            <div class="heading-text">
                <h1 class="school-name">Mater Dei College</h1>
                <h4 class="location">Tubigon, Bohol</h4>
                <h4 class="department">HUMAN RESOURCE OFFICE</h4>
            </div>
        </div>
        <div class="title-container">
            <span class="form-title">LEAVE APPLICATION FORM</span>
        </div>
        <div class="body-container">
            <div class="section">
                <div class="user-info">
                    <label>Office/Department: <b>CAST DEPARTMENT</b></label>
                    <label>Name: <b>SAB, CHRISTOPER S.</b></label>
                    <label>Date of Filing: <b>JANUARY 27, 2025</b></label>
                </div>
                <div class="user-info">
                    <label>Position: <b>STAFF</b></label>
                    <label>Rank: <b>MYTHIC</b></label>
                </div>
            </div>

            <div class="section-two">
                <div>
                    <h5 class="sub-section-title">Details of Application</h5>
                    <div class="checkbox-group new-section">
                        <label><input type="checkbox" name="leave_type"> Vacation Leave</label>
                        <label><input type="checkbox" name="leave_type"> Personal Leave</label>
                        <label><input type="checkbox" name="leave_type"> Fiesta Leave</label>
                        <label><input type="checkbox" name="leave_type"> Birthday Leave</label>
                        <label><input type="checkbox" name="leave_type"> Maternity Leave</label>
                        <label><input type="checkbox" name="leave_type"> Paternity Leave</label>
                        <label><input type="checkbox" name="leave_type"> Sick Leave</label>
                        <label><input type="checkbox" name="leave_type"> Educational Leave</label>
                        <label><input type="checkbox" name="leave_type"> Others: <input type="text"></label>
                    </div>
                    <div class="sub-section-two">
                        <label>Number of Working Days Applied For: <input type="text" name="days_applied"></label>
                        <label>Inclusive Dates: <input type="text" name="inclusive_dates"></label>
                        <div class="employee-sign">
                            <p>_____________________________<br>Employee's Signature</p>
                        </div>
                    </div>
                </div>
                <div class="details-box">
                    <h5 class="sub-section-title">Details of Leave</h5>
                    <div class="checkbox-group">
                        <div class="sub-section">
                            <label>Incase of Vacation: </label>
                            <label><input type="checkbox" class="sub-checkbox" name="vacation_within"> Within Philippines</label>
                            <label><input type="checkbox" class="sub-checkbox" name="vacation_abroad"> Abroad (Specify): <input type="text"></label>
                        </div>
                        <div class="sub-section">
                            <label>Incase of Sick Leave: </label>
                            <label><input type="checkbox" class="sub-checkbox" name="sick_hospital"> Hospital: <input type="text"></label>
                            <label><input type="checkbox" class="sub-checkbox" name="sick_outpatient"> Outpatient: <input type="text"></label>
                            <label><input type="checkbox" class="sub-checkbox" name="sick_home"> Home Medication: <input type="text"></label>
                        </div>
                        <div class="employee-sign">
                            <p>_____________________________<br>School Physician/Nurse Signature</p>
                        </div>
                        <div class="sub-section">
                            <label>Incase of Educational Leave: </label>
                            <label><input type="checkbox" class="sub-checkbox" name="sick_hospital"> Completion of Doctor's Degree</label>
                            <label><input type="checkbox" class="sub-checkbox" name="sick_outpatient"> Completion of Master's Degree</label>
                            <label><input type="checkbox" class="sub-checkbox" name="sick_home"> Board Examination Review</label>
                            <label><input type="checkbox" class="sub-checkbox" name="sick_home"> Others, please specify: <input type="text"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h5 class="section-title">Teaching Substitution (For MDC Teaching Employee only)</h5>
                <table>
                    <tr>
                        <th>Subject & Time</th>
                        <th>Substitute Teacher</th>
                    </tr>
                    <tr>
                        <td><span class="data">Data Structure</span></td>
                        <td><span class="data">Benjie Lenteria</span></td>
                    </tr>
                </table>
                <div class="signature">
                    <div>
                        <br>
                        <p>_____________________________<br>Signature of Teacher</p>
                    </div>
                    <div>
                        <p>Noted by:</p>
                        <p>_____________________________<br>Signature of Dean/Chairman/Principal</p>
                    </div>
                    <div>
                        <br>
                        <p>MARIA NYMPA S. RESERVA, Ph.D<br>VP - Academic Affairs</p>
                    </div>
                </div>
            </div>

            <div class="section-two">
                <div>
                    <h5 class="section-title">Certification of Leave Credits</h5>
                    <label>As of: <b>JANUARY 27, 2025</b></label>
                    <label>Date Hired: <b>DECEMBER 12, 2000</b></label>
                    <table>
                        <tr>
                            <th>Leave Type</th>
                            <th>Personal Leave</th>
                            <th>Sick Leave</th>
                        </tr>
                        <tr>
                            <td class="data">Previous Leave</td>
                            <td><input type="number" class="data"></td>
                            <td><input type="number" class="data"></td>
                        </tr>
                        <tr>
                            <td class="data">Add this Application</td>
                            <td><input type="number" class="data"></td>
                            <td><input type="number" class="data"></td>
                        </tr>
                        <tr>
                            <td class="data">Total</td>
                            <td><input type="number" class="data"></td>
                            <td><input type="number" class="data"></td>
                        </tr>
                    </table>
                </div>
                <div class="details-box">
                    <h5 class="section-title">Recommendation</h5>
                </div>
            </div>

            <div class="signature">
                <div>
                    <p>Approved by:</p>
                    <p>_____________________________<br>VP for Admin and Finance</p>
                </div>
                <div>
                    <p>Noted by:</p>
                    <p>_____________________________<br>VP for Academics</p>
                </div>
                <div>
                    <p>Disapproved Due To:</p>
                    <p>_____________________________<br>President</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
