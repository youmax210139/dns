<template>
  <div class="form-group row">
    <label v-if="label" class="col-sm-3 form-control-label" :for="id">{{ label }}:</label>
    <div class="col-sm-9">
      <input
        :id="id"
        ref="input"
        v-bind="$attrs"
        class="form-control"
        :class="{ 'is-invalid': errors.length }"
        :type="type"
        :placeholder="placeholder"
        :value="value"
        @input="$emit('input', $event.target.value)"
      />
      <div v-if="errors.length" class="invalid-feedback">{{ errors[0] }}</div>
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
        return `text-input-${this._uid}`;
      },
    },
    type: {
      type: String,
      default: "text",
    },
    placeholder:{
      type: String,
      default: "",
    },
    value: String,
    label: String,
    errors: {
      type: Array,
      default: () => [],
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus();
    },
    select() {
      this.$refs.input.select();
    },
    setSelectionRange(start, end) {
      this.$refs.input.setSelectionRange(start, end);
    },
  },
};
</script>
