<template>
  <div class="form-group row">
    <label v-if="label" class="col-sm-3 form-control-label" :for="id">{{ label }}:</label>
    <div class="col-sm-9">
      <div class="i-checks">
        <input
          :id="id"
          ref="input"
          v-bind="$attrs"
          class="checkbox-template"
          type="checkbox"
          :value="value"
          :checked="checked"
          @change="change"
        />
      </div>
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
        return `checkbox-input-${this._uid}`;
      },
    },
    value: Boolean,
    label: String,
    error: {
      type: [String, Array],
      default: "",
    },
  },
  data() {
    return {
      checked: this.value,
    };
  },
  methods: {
    change: function () {
      this.checked = !this.checked;
      this.$emit("input", this.checked);
    },
  },
};
</script>
