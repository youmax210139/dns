<template>
  <div>
    <div class="progress" :data-percentage="percentage">
      <span class="progress-left">
        <span class="progress-bar"></span>
      </span>
      <span class="progress-right">
        <span class="progress-bar"></span>
      </span>
      <div class="progress-value">
        <div v-html="label" />
      </div>
    </div>
    <p v-if="title" class="text-center mt-1" v-html="title" />
  </div>
</template>

<script>
export default {
  props: {
    percentage: {
      type: Number,
      default: 100,
    },
    label: {
      type: String,
      default: function () {
        return `${this.percentage}%<br/><span>completed</span>`;
      },
    },
    title: {
      type: String,
      default: function () {
        return "test";
      },
    },
  },
};
</script>
