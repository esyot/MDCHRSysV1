<script>
import Layout from "@/Layouts/Layout.vue";
export default {
  layout: Layout,
  props: {
    developers: Object,
  },
};
</script>
<template>
  <div>
    <div v-for="developer in developers" :key="developer">
      <img
        :src="`/public/assets/others/developers/${developer.first_name}_${developer.last_name}.png`"
        alt=""
      />
      <span>{{ developer.last_name }}, </span>
      <span>{{ developer.first_name }} </span>
      <span> {{ developer.middle_name }}.</span>
    </div>
  </div>
</template>
