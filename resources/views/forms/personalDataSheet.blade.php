
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @font-face {
    font-family: "RM New Albion";
    src: url("/assets/fonts/rm_new_albion.woff") format("woff");
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}
        h3, p, h2 {
            text-align: center;
            margin: 0;
            padding: 0;
        }
        body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    width: 100%;
}
       .main-container {
    border: 2px solid black;
    max-width: 100%;
    width: 100%;
   
    background-color: white;
}

        .sub-container {
            font-size: 12px;
          
            width: auto;
            max-width: auto;


        }

        .sub-container input {
            border: none;
           
        }

        .title {
            font-weight: bold;
            padding: 5px;
            background-color: blue;
            width: auto;
            color: white;
        }

        .id-number{
            display: flex;
            justify-content: flex-end;
            margin-bottom: 2px;
            align-items: center;
            font-size: 12px;
        }

        .forms {
            display: flex;
            flex-direction: row;
            width: auto;
        }

        .form-group {
            padding: 5px 5px 0 5px;
            width: 50%;
            display: flex;
            flex-direction: column;
        }

        .checkbox-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: start;
        }

        .items {
           
            display: flex;
            align-items: center;
            gap: 5px;
            width: 100%;
            max-width: 100%;
            border-bottom: 1px solid black;
           
        }

        .family-items {
            padding: 5px 0px 5px 0px;
            display: flex;
            align-items: center;
            gap: 5px;
            width: 100%;
            max-width: 100%;
            border-bottom: 1px solid black;
        }

        .item {
            
            display: flex;
            gap: 30px;
            border-bottom: 1px solid black;
           
        }



        .items label {
            margin-right: 10px;
            width: 100%;
            max-width: 100%;
        }
         .citizen-container {
            display: flex;
            flex-direction: row;
            align-items: center;

         }

        .citizenship {
            display: flex;
            justify-content: center;
            align-items: center;
            width: auto;


        }

        .sex {
            display: flex;
            flex-direction: row;
           
            align-items: center;
           
        }

        .civil-status{
            display: flex;
            flex-direction: column ;
            justify-content: center;
            align-items: left;
            
        }

        .civil-group {
            display: flex;
            flex-direction: row;
            align-items: center;

        }
        .civil-status label {
            margin-right: 5px;
        }
        .dual-option {
            width: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-bottom: 5px;
            border-bottom: 1px solid black;
        }

        .address-container{
            display: flex;
            flex-direction: row;
            margin-left: -5px;
            width: auto;
            border-bottom: 1px solid black;


        }
        .address {

            flex-direction: column;


            padding: 5px 5px 5px 5px;
            display: flex;
            align-items: center;
            gap: 2px;
            width: auto;
            /* border-bottom: 1px solid black; */

        }


        .address-input {
            display: flex;
            flex-direction: row;
            width: auto;

        }

        .address-input input {
            width: 100%;
            max-width: 100%;
            border: none;
            border-bottom: 1px solid black;
        }
        .children-container {
            display: flex;
            flex-direction: row;
            display: flex;
    justify-content: center;
    align-items: center;
        }

        .children-container label {
    display: block;
    text-align: center;
    font-weight: bold; /* Optional for emphasis */
}


        .children-container input {
            width: 100%;
            max-width: 100%;
            border-bottom: 1px solid black;
        }

        .children-name,
.birthdate {
    flex: 1; /* Make both sections equal width */
    padding: 5px 5px 0 0; /* Add spacing inside */
    border-right: 2px solid black; /* Creates a vertical border between sections */
}

.birthdate {
    border-right: none; /* Removes border from the last column */
}


.education-table-container {
    width: 100%;
    overflow-x: auto; /* Enables horizontal scrolling if needed */
}

.education-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto; /* Allows columns to adjust dynamically */
}
.education-table td {
    height: 5px;
}

.education-table th,
.education-table td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
    white-space: nowrap; /* Prevents text from wrapping in headers */
}

.education-table input {
    width: 100%; /* Ensures inputs take full width */
    min-width: 80px; /* Prevents inputs from shrinking too much */
    /* padding: 4px; */

}

@media (max-width: 768px) {
    .education-table th,
    .education-table td {
        font-size: 12px;
        padding: 5px;
    }

    .education-table input {
        min-width: 60px;
    }
}

.signature-container {
    padding: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.signature-container label {
    margin-right: 5px;
    font-weight: bold;
}


.signature, .date {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 0 5px; 0 5px;
}

.form-group.left {
    border-right: 1px solid black;

}


.form-group.right {
    border-left: 1px solid black;
}

.small-input {
    margin-right: 5px;
    border: none;
    border-bottom: 1px solid black;
    width: 70px;
}
.header-container {

    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    padding: 10px;
}
.header{
   text-align: center
}

.logo img {
    margin-right: 10px;
    width: 80px;  /* Adjust width */
    height: auto;  /* Maintain aspect ratio */
}



span {

    font-size: 12px;
    font-weight: bold;
    padding: 0 10px 0 10px;
}

.school-name{
    font-family: "RM New Albion";
}


    </style>
</head>
<body>
    <div class="main-container">
        <div class="header-container">
           
        <div class="header">
            <div class="logo">
                <img src="{{ public_path('assets/images/mdc-logo.png') }}" alt="logo">
            </div>
            <h1 class="school-name">Mater Dei College</h1>
            <p>Tubigon, Bohol</p>
        </div>
        </div>
        <h3>PERSONAL DATA SHEET</h3>
        <span>In compliance with DATA Privacy Act of 2012(RA 1073), I hereby allow Mater Dei College, Tubigon, Bohol to collect and process my personal information in relation to my job.</span>
    </br>
    <span>Instruction: Please provide the correct information of the following:</span>

        <div class="id-number">
            <label for="">MDC-ID No.</label>
            <input type="text" class="small-input">
        </div>
        <div class="sub-container">
            <div class="title">I. PERSONAL INFORMATION</div>
            <div class="forms">
                <div class="form-group left">
                    <div class="items">
                        <label>Surname:</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">First Name:</label>
                        <div class="input-group">
                        <input type="text">
                    </div>
                        <input type="text" placeholder="Ext:" class="small-input">

                    </div>

                    <div class="items">
                        <label for="">Middle Name:</label>
                        <input type="text" >
                        <label for="">Nickname:</label>
                        <input type="text" name="" id="">
                    </div>

                    <div class="items">
                        <label for="">Date of Birth:</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">Place of Birth:</label>
                        <input type="text">
                    </div>

                    <div class="item">
                        <label for="">Sex:</label>
                        <div class="checkbox-group">
                            <input type="checkbox">
                            <label for="">Male</label>

                            <input type="checkbox">
                            <label for="">Female</label>
                        </div>
                    </div>

                    <div class="item">
                        <label for="">Civil Status:</label>
                        <div class="civil-status">
                            <div class="civil-group">
                            <input type="checkbox" id="single">
                            <label for="single">Single</label>

                            <input type="checkbox" id="married">
                            <label for="married">Married</label>
                        </div>
                        <div class="civil-group">
                            <input type="checkbox" id="widowed">
                            <label for="widowed">Widowed</label>

                            <input type="checkbox" id="separated">
                            <label for="separated">Separated</label>
                        </div>
                        <div class="civil-group">
                            <label for="other">Other:</label>
                            <input type="text" name="" id="" class="small-input">
                        </div>
                        </div>
                    </div>

                    <div class="items">
                        <label for="">Religion:</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">Height (m):</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">Weight (kg):</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">Blood:</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">Tel No./Mobile No.:</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">SSS ID No.:</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">PAG-IBIG No.:</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">PHILHEALTH No.:</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">TIN No.:</label>
                        <input type="text">
                    </div>
                </div>

                <div class="form-group right">
                    <div class="citizen-container">
                        <label for="">Citizenship:</label>
                        <div class="citizenship">
                            <input type="checkbox">
                            <label for="">Filipino</label>

                            <input type="checkbox">
                            <label>Dual Citizenship
                            </label>
                        </div>
                    </div>
                    <div class="dual-option">
                        <input type="checkbox">
                        <label for="">by birth</label>

                        <input type="checkbox">
                        <label for="">by naturalization</label>
                    </div>

                    <div class="items">
                        <label for="">Email Address:</label>
                        <input type="text">
                    </div>

                    <div class="items">
                        <label for="">Messenger Account:</label>
                        <input type="text">
                    </div>

                <div class="address-container">
                    <div class="address">
                        <label for="">Residential Address:</label>
                    </div>
                    <div class="address">
                        <div class="address-input">
                            <input type="text" placeholder="House/Block/Lot No.">
                            <input type="text" name="" id="" placeholder="Street">
                        </div>
                        <div class="address-input">
                            <input type="text" placeholder="Subdivision/Village">
                            <input type="text" name="" id="" placeholder="Barangay">
                        </div>
                        <div class="address-input">
                            <input type="text" placeholder="City/Municipality">
                            <input type="text" name="" id="" placeholder="Province">
                        </div>

                    </div>
                </div>

            <div class="items">
                <label for="">Zip Code:</label>
                <input type="text">
            </div>
            <div class="address-container">
                <div class="address">
                    <label for="">Residential Address:</label>
                </div>
                <div class="address">
                    <div class="address-input">
                        <input type="text" placeholder="House/Block/Lot No.">
                        <input type="text" name="" id="" placeholder="Street">
                    </div>
                    <div class="address-input">
                        <input type="text" placeholder="Subdivision/Village">
                        <input type="text" name="" id="" placeholder="Barangay">
                    </div>
                    <div class="address-input">
                        <input type="text" placeholder="City/Municipality">
                        <input type="text" name="" id="" placeholder="Province">
                    </div>

                </div>
            </div>
            <div class="items">
                <label for="">Zip Code:</label>
                <input type="text">
            </div>

            <div class="items">
                <label for="">Date Hired:</label>
                <input type="text">
            </div>

            <div class="items">
                <label for="">Present Rank in MDC:</label>
                <input type="text">
            </div>

            <div class="items">
                <label for="">Department:</label>
                <input type="text">
            </div>
        </div>


    </div>
    <div class="sub-container">
        <div class="title">II. FAMILY BACKGROUND</div>
        <div class="forms">
            <div class="form-group left">
                <div class="family-items">
                    <label for="">Spouse's Surname:</label>
                    <input type="text">
                </div>

                <div class="family-items">
                    <label for="">First Name:</label>
                    <div class="input-group">
                    <input type="text" name="" id="">
                </div>
                    <input type="text" placeholder="Ext:" class="small-input">
                </div>

                <div class="family-items">
                    <label for="">Occupation:</label>
                    <input type="text" name="" id="">
                </div>

                <div class="family-items">
                    <label for="">Father's Surname:</label>
                    <input type="text" name="" id="">
                </div>

                <div class="family-items">
                    <label for="">First Name:</label>
                    <div class="input-group">
                    <input type="text">
                </div>
                    <input type="text" placeholder="Ext:" class="small-input">
                </div>

                <div class="family-items">
                    <label for="">Middle Name:</label>
                    <input type="text" name="" id="">
                </div>

                <div class="family-items">
                    <label for="">Mother's Surname:</label>
                    <input type="text" name="" id="">
                </div>

                <div class="family-items">
                    <label for="">First Name:</label>
                    <div class="input-group">
                    <input type="text">
                </div>
                    <input type="text" placeholder="Ext:" class="small-input">
                </div>

                <div class="family-items">
                    <label for="">Middle Name:</label>
                    <input type="text" name="" id="">
                </div>
            </div>

            <div class="form-group right">
                <div class="children-container">
                    <div class="children-name">
                        <label for="">Name of Children</label>
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                    </div>

                    <div class="birthdate">
                        <label for="">Date of Birth(mm/dd/yy)</label>
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">
                        <input type="text" name="" id="">

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="sub-container">
        <div class="title">III. EDUCATIONAL BACKGROUND</div>

        <div class="education-table-container">
            <table class="education-table">
                <thead>
                    <tr>
                        <th rowspan="2">Level</th>
                        <th rowspan="2">Name of School</th>
                        <th rowspan="2">Degree/Course</th>
                        <th colspan="2">Period of Attendance</th>
                        <th rowspan="2">Highest Level/Units Earned (If not graduated)</th>
                        <th rowspan="2">Year Graduated</th>
                        <th rowspan="2">Scholarship/Academic Honors Received</th>
                    </tr>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Elementary</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Secondary</td>
                        <td> </td>
                        <td> </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>College</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Graduate Studies</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Post-Graduate Studies</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> </td>
                    </tr>
                </tbody>
            </table>
        </div>



                    <div class="signature-container">
                        <div class="signature">
                            <label for="">SIGNATURE</label>
                            <input type="text">
                        </div>

                        <div class="date">
                            <label for="">DATE</label>
                            <input type="date">
                        </div>
                    </div>




    </div>
</body>
</html>
