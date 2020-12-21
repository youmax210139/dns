<template>
  <div class="form-group row">
    <label v-if="label" class="col-sm-3 form-control-label" :for="id">{{ label }}:</label>
    <div class="col-sm-9">
      <textarea
        :id="id"
        ref="input"
        v-bind="$attrs"
        class="form-control"
        :class="{ 'is-invalid': error.length > 1 }"
        :rows="rows"
        :placeholder="placeholder"
        :value="value"
        @input="$emit('input', $event.target.value)"
      />
      <div v-if="error instanceof Array" class="invalid-feedback d-block">{{ error[0] }}</div>
      <div v-else-if="error" class="invalid-feedback d-block">{{ error }}</div>
    </div>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `text-area-${this._uid}`;
      },
    },
    rows: {
      type: Number,
      default: 4,
    },
    placeholder: {
      type: String,
      default: "",
    },
    value: String,
    label: String,
    error: {
      type: [String, Array],
      default: "",
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus();
    },
    select() {
      this.$refs.input.select();
    }
  },
};
</script>
