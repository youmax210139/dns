<template>
  <button :disabled="loading">
    <template v-if="loading">
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      {{ __('loading') }}...
    </template>
    <slot v-else />
  </button>
</template>

<script>
export default {
  props: {
    loading: Boolean,
  },
};
</script>

<style lang="scss" scoped>
.spinner-border {
  vertical-align: middle;
}
</style>
