<script>
export default {
      props: {
        personalDetails: Object,
    },
  name: "Page2",
};
</script>

<template>
  <div class="page-content">
        <div class="title">IV. PROFESSIONAL GOVERNMENT EXAMINATION PASSED/CIVIL SERVICE ELIGIBILITY</div>
        <div class="table-group">
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Professional/Board Examination</th>
                        <th rowspan="2">Rating (If Applicable)</th>
                        <th rowspan="2">Date of Examination/Conferment</th>
                        <th rowspan="2">Place of Examination/Conferment</th>
                        <th colspan="2">License (If Applicable)</th>
                    </tr>
                    <tr>
                        <th>Number</th>
                        <th>Date of Validity</th>
                    </tr>
                </thead>
                <tbody v-for="prof_examination in personalDetails.user_professional_examinations">
                    <tr>
                        <td>{{ prof_examination.title}}</td>
                        <td>{{ prof_examination.rating }}</td>
                        <td>{{ prof_examination.date }}</td>
                        <td>{{ prof_examination.place }}</td>
                        <td>{{ prof_examination.license_no }}</td>
                        <td>{{ prof_examination.validity }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="title">V. ACADEMIC AWARDS, HONORS, HONORARY DEGREES RECEIVED</div>
        <div class="table-group">
            <table>
                <thead>
                    <tr>
                        <th>DATE RECEIVED </br>
                        (mm/dd/yyyy)</th>
                        <th>NATURE/TITLE OF AWARD</th>
                        <th>PLACE OF RECOGNITION</th>
                        <th>AWARDED BY</th>
                    </tr>
                </thead>
                <tbody v-for="award in personalDetails.user_award_receives">
                    <tr>
                        <td>{{ award.date_received }}</td>
                        <td>{{ award.title }}</td>
                        <td>{{ award.recognition_place }}</td>
                        <td>{{ award.awarded_by }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="title">VI. ADMINISTRATIVE POSITIONS HELD</div>
            <div class="table-group">
                <table>
                    <thead>
                        <tr>
                            <th>INCLUSIVE DATES</th>
                            <th>NATURE/TITLE OF AWARD</th>
                            <th>PLACE OF RECOGNITION</th>
                            <th>AWARDED BY</th>
                        </tr>
                    </thead>
                    <tbody v-for="admin_pos in personalDetails.user_admin_pos_helds">
                        <tr>
                            <td>{{ admin_pos.date }}</td>
                            <td>{{ admin_pos.title }}</td>
                            <td>{{ admin_pos.recognition_place }}</td>
                            <td>{{ admin_pos.awarded_by }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <div class="title">VII. WORK/ TEACHING EXPERIENCE</div>
        <div class="table-group">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">INCLUSIVE DATES</br>
                        (mm/dd/yyyy)</th>
                        <th rowspan="2">POSITION TITLE</th>
                        <th rowspan="2">NAME OF COMPANY/SCHOOL</th>
                        <th rowspan="2">RANK</th>
                        <th rowspan="2">STATUS OF APPOINTMENT</th>
                    </tr>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>
                <tbody v-for="work_exp in personalDetails.user_work_experiences">
                     <tr>

                        <td>{{ work_exp.date_from }}</td>
                        <td>{{ work_exp.date_to }}</td>
                        <td>{{ work_exp.position }}</td>
                        <td>{{ work_exp.company_name }}</td>
                        <td>{{ work_exp.rank }}</td>
                        <td>{{ work_exp.status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="title"> VIII. ARTICLES, MONOGRAPHS, SCIENTIFIC REPORTS, RESEARCH STUDIES, SCIENTIFIC PROJECTS, BOOKS PUBLISHED</div>
        <div class="table-group">
            <table>
                <thead>
                    <tr>
                        <th>DATE PUBLISHED </br>
                        (mm/dd/yyyy)</th>
                        <th>RESEARCH TITLE</th>
                        <th>NAME OF JOURNAL</th>
                        <th>LINK OF JOURNAL/VOLUME NUMBER</th>
                    </tr>
                </thead>
                <tbody  v-for="research in personalDetails.user_studies">
                    <tr>

                        <td>{{ research.date_published }}</td>
                        <td>{{ research.research_title }}</td>
                        <td>{{ research.journal_name }}</td>
                        <td>{{ research.link }}</td>
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
</template>

<style scoped>
::-webkit-scrollbar {
  width: 5px;
  height: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.page-content {
  background-color: #fff;
  padding: 20px;
  width: 800px;
  text-align: center;
  display: flex; /* Changed from block to flex for better alignment */
  flex-direction: column;
  margin: auto; /* Center the content */
}

body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
}

.main-container {
  border: 2px solid black;
  max-width: 80%;
  width: 100%;
  background-color: white;
}


.title {
            font-size: 15px;
            font-weight: bold;
            padding: 5px;
            background-color: blue;
            width: auto;
            color: white;
        }

        .table-group {
            width: 100%;
            max-width: 100%;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        td {
            height: 10px;
            max-width: 100%;
        }

        th {
            background-color: #f2f2f2;
            border: 1px solid black;
            padding: 8px;
            text-align: center;
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
    padding: 0 5px 0 5px;
}

@media print {
    .main-container {
        max-width: 100%;
    }

    table {
        width: 100%;
    }

    th, td {
        border: 1px solid black;
    }
}

    </style>
