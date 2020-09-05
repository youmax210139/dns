<template>
  <div>
    <div v-if="$page.flash.success && show" class="alert alert-success alert-dismissible fade show">
      <strong>{{ $page.flash.success }}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div v-if="$page.flash.error && show" class="alert alert-danger alert-dismissible fade show">
      <strong v-if="$page.flash.error">{{ $page.flash.error }}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: true,
    };
  },
  watch: {
    "$page.flash": {
      handler() {
        this.show = true;
      },
      deep: true,
    },
  },
};
</script>
