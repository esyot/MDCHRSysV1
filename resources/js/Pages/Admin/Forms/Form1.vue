<template>
  <div class="personal-details-items">
    <div class="title-container">
      <span class="title">PERSONAL INFORMATION (Page 1)</span>
    </div>

    <div class="form-group">
      <label>Full Name:</label>
      <span
        >{{ personalDetails.first_name }}
        {{ personalDetails.middle_name }}
        {{ personalDetails.last_name }}
        <span v-if="personalDetails.personal_details.name_ext != 'none'">
          {{ personalDetails.personal_details.name_ext }}
        </span>
      </span>

      <label>Nickname:</label>
      <span> {{ personalDetails.personal_details.nickname }} </span>

      <label>Date of Birth:</label>
      <span>{{ personalDetails.personal_details.DOB }}</span>

      <label>Place of Birth:</label>
      <span>{{ personalDetails.personal_details.birthplace }}</span>

      <label>Sex:</label>
      <span>{{ personalDetails.personal_details.sex }}</span>

      <label>Civil Status:</label>
      <span>{{ personalDetails.personal_details.civil_status }}</span>

      <label>Religion:</label>
      <span>{{ personalDetails.personal_details.religion }}</span>

      <label>Height:</label>
      <span>{{ personalDetails.personal_details.height }}</span>

      <label>Weight:</label>
      <span>{{ personalDetails.personal_details.weight }}</span>

      <label>Blood Type:</label>
      <span>{{ personalDetails.personal_details.blood_type }}</span>

      <label>Contact no:</label>
      <span>{{ personalDetails.personal_details.contact_no }}</span>

      <label>Citizenship:</label>
      <span
        >{{ personalDetails.personal_details.citizenship }}

        {{ personalDetails.personal_details.citizenship_type }}</span
      >
    </div>
  </div>

  <div class="personal-details-items">
    <div class="title-container">
      <span class="title">PERSONAL INFORMATION (Page 2)</span>
    </div>

    <div class="form-group">
      <label>Residential Address:</label>
      <span>
        {{ personalDetails.personal_details.residential_address.house_no }},
        {{ personalDetails.personal_details.residential_address.street }},
        {{ personalDetails.personal_details.residential_address.subdv }},
        {{ personalDetails.personal_details.residential_address.brgy }},
        {{ personalDetails.personal_details.residential_address.municipality }},
        {{ personalDetails.personal_details.residential_address.province }},
        {{ personalDetails.personal_details.residential_address.zip_code }}
      </span>

      <label>Permanent Address:</label>
      <span>
        {{ personalDetails.personal_details.permanent_address.house_no }},
        {{ personalDetails.personal_details.permanent_address.street }},
        {{ personalDetails.personal_details.permanent_address.subdv }},
        {{ personalDetails.personal_details.permanent_address.brgy }},
        {{ personalDetails.personal_details.permanent_address.municipality }},
        {{ personalDetails.personal_details.permanent_address.province }},
        {{ personalDetails.personal_details.permanent_address.zip_code }}
      </span>

      <label>Messenger Account:</label>
      <span>{{ personalDetails.personal_details.fb_link }}</span>
    </div>
  </div>

  <div class="personal-details-items">
    <div class="title-container">
      <span class="title">Job Details</span>
    </div>
    <ul v-for="jobDetail in personalDetails.user_job_details" :key="jobDetail">
      <li>Department: {{ jobDetail.department }}</li>
      <li>Current Rank: {{ jobDetail.rank }}</li>
      <li>Date Hired: {{ jobDetail.date_hired }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    userDetails: Object,
    personalDetails: Object,
  },
};
</script>
