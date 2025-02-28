<script>
import Layout from "@/Layouts/Layout.vue";
export default {
  layout: Layout,
  props: {
    developers: Array,
  },
};
</script>
<template>
  <div class="about-container">
    <div class="details">
      <div class="title">
        <span>About</span>
      </div>
      <div class="paragraph">
        This system is created and developed to assist the Human Resource (HR) department
        at Mater Dei College (MDC) in effectively managing, maintaining, and monitoring
        the staff. By providing a reliable and efficient platform, this system aims to
        streamline HR operations, reduce administrative burdens, and enhance productivity.
        It is designed to not only help with tracking employee information and performance
        but also to ensure that HR processes are carried out smoothly and accurately. This
        system ultimately contributes to a more organized and responsive HR management
        approach, benefiting both the staff and the institution as a whole.
      </div>
      <div class="paragraph">
        This system serves as an essential tool for MDC's HR department, empowering them
        to operate more efficiently while ensuring that staff members are managed
        effectively. With its comprehensive features and user-friendly design, the system
        supports the ongoing growth and success of both the staff and the college. Hence,
        this system is still in progress, with continuous improvements, maintenance, and
        the addition of more features planned for future OJTs here at MDC.
      </div>
    </div>
    <div class="title">
      <span>Developers</span>
    </div>
    <div class="cards-container">
      <div class="card" v-for="developer in developers" :key="developer.last_name">
        <div class="image-container">
          <a
            :href="`https://www.linkedin.com/in/${developer.linkedin_link}`"
            target="_blank"
            title="click to redirect 'Linkedin' page"
          >
            <img :src="`/assets/others/developers/images/${developer.img}`" alt="" />
            <i class="fa-brands fa-linkedin"></i>
          </a>
        </div>
        <div class="item">
          <label>Name:</label>
          <span>
            {{ developer.last_name }},
            {{ developer.first_name }}
            {{ developer.middle_name[0] }}.
          </span>
        </div>
        <div class="item">
          <label>Course:</label>
          <span>{{ developer.course }}</span>
        </div>
        <div class="item">
          <label>Date of Birth:</label>
          <span>{{ developer.DOB }}</span>
        </div>
        <div class="item">
          <label>Contact:</label>
          <span>{{ developer.contact_no }}</span>
        </div>
        <div class="item">
          <label>Email:</label>
          <span>{{ developer.email }}</span>
        </div>
        <div class="link">
          <i class="fa-brands fa-facebook"></i>
          <a :href="`https://wwww.facebook.com/${developer.fb_link}`" target="_blank"
            >/{{ developer.fb_link }}</a
          >
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@media (orientation: landscape) {
  .about-container {
    height: 100vh;
  }
}

@media (orientation: portrait) {
  .about-container {
    height: 81vh;
  }
}
.about-container {
  overflow-y: auto;
  background-color: #fff;
  padding-top: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.about-container .details {
  display: flex;
  flex-direction: column;
}

.title span {
  color: #333;
  font-size: 16pt !important;
  font-weight: bold;
  margin-left: 10px;
}

.about-container h3 {
  color: #333;
}

.about-container .paragraph {
  display: flex;
  line-height: 1.6;
  color: #555;
  padding: 20px;
}

.cards-container {
  display: flex;
  overflow-x: auto;
  white-space: nowrap;
  padding: 10px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card {
  display: inline-block;
  border: 1px solid #ddd;
  border-radius: 10px;
  margin-right: 10px;
  padding: 10px;
  text-align: center;
  width: 250px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.image-container {
  width: 100px;
  height: 100px;
  overflow: hidden;
  border-radius: 50%;
  margin: 0 auto 10px;
  border: 3px solid rgba(0, 174, 255, 1);
  box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.1);
}
.image-container:hover {
  opacity: 50%;
  cursor: pointer;
}
.image-container a {
  display: flex;
  position: relative;
}
.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-container i {
  z-index: 2;
  position: fixed;
  color: #007bff;
}

.card .item {
  display: flex;
  flex-direction: column;
  align-items: start;
  margin-bottom: 5px;
}

.card .item label {
  font-weight: bold;
  color: #333;
}

.card .item span,
.card .item a {
  color: #555;
}

.card .item a {
  text-decoration: none;

  color: #007bff;
}

.card .link {
  color: #007bff;
}

.card .item a:hover {
  text-decoration: underline;
}
</style>
