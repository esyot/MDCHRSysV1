<script>
export default {
    props: {
        personalDetails: Object,
    },
    name: "Page3",
};
</script>
<template>
  <div class="page-content">

        <div class="title">X. PARTICIPATION IN COMMUNITY OUTREACH AND CIVIC INVOLVEMENT (Organizer, Coordinator, Director, Moderator, Coach, Cultural Presentor, Chairman, Adviser, etc.) (last 2 years)</div>
    <div class="table-group">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">NAME & ADDRESS OF ORGANIZATION </br>
                    (Write in full)</th>
                    <th colspan="2">INCLUSIVE DATES </br>
                    (mm/dd/yyyy)</th>
                    <th rowspan="2">NUMBER OF HOURS</th>
                    <th rowspan="2">POSITION/NATURE OF INVOLVEMENT</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>

            <tbody v-for="participation in personalDetails.user_participations">
                <tr>
                    <td>{{ participation.title }}</td>
                    <td>{{ participation.date_from }}</td>
                    <td>{{ participation.date_to }}</td>
                    <td>{{ participation.hours_no }}</td>
                    <td>{{ participation.position }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="title">XII. SPECIAL TRAINING COURSES, SEMINARS, CONFERENCES, SYMPOSIA, ETC. PARTICIPATED(last 5 years) </br>
    (Start from the most recent training and include only the relevant training or program)</div>

    <div class="table-group">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">TITLE OF TRAINING/SEMINARS/ <br> CONFERENCES ATTENDED <br>
                    (Write in full)</th>
                    <th colspan="2">INCLUSIVE DATES OF ATTENDANCE </br>
                    (mm/dd/yyyy)</th>
                    <th rowspan="2">NUMBER OF DAYS</th>
                    <th rowspan="2">TYPE OF TRAINING </br>
                    (Managerial/Supervisory/ <br> Technical/etc)</th>
                    <th rowspan="2">Conducted/ <br> Sponsored By</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody v-for="training in personalDetails.user_special_trainings">
                <tr>
                    <td>{{ training.title }}</td>
                    <td>{{ training.attendance_from }}</td>
                    <td>{{ training.attendance_to }}</td>
                    <td>{{ training.days }}</td>
                    <td>{{ training.type }}</td>
                    <td>{{ training.conducted_by }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="title">VIII. OTHER INFORMATION</div>
    <div class="table-group">
        <table>
            <thead>
                <tr>
                    <th>SPECIAL SKILLS AND HOBBIES</th>
                    <th>NON-ACADEMIC DISTINCTIONS/RECOGNITION </br>
                        (Write in full)</th>
                    <th>MEMBERSHIP IN ASSOCIATION/ORGANIZATION </br>
                    (Write in full)</th>
                </tr>
            </thead>
            <tbody v-for="other_infos in personalDetails.user_other_infos"></br>
                <tr>
                    <td>{{ other_infos.skill }}</td>
                    <td>{{ other_infos.recognition_title }}</td>
                    <td>{{ other_infos.org_name }}</td>
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

        .table-group{
            width: 100%;
            overflow-x: auto;
        }


        table {

  border-collapse: collapse;
  table-layout: auto;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        td {
            height: 10px;

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
