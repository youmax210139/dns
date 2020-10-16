<template>
  <div class="form-group row">
    <label v-if="label" class="col-sm-3 form-control-label" :for="id"
      >{{ label }}:</label
    >
    <div class="col-sm-9">
      <div class="i-checks">
        <toggle-button 
          :id="id"
          ref="input"
          v-bind="$attrs"
          :color="color"
          :value="checked"
          :sync="true"
          @change="change"
        />
      </div>
      <div v-if="error instanceof Array" class="invalid-feedback d-block">
        {{ error[0] }}
      </div>
      <div v-else-if="error" class="invalid-feedback d-block">{{ error }}</div>
    </div>
  </div>
</template>

<script>
import { ToggleButton } from "vue-js-toggle-button";
export default {
  components: {
    ToggleButton,
  },
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `toggle-input-${this._uid}`;
      },
    },
    value: Boolean,
    label: String,
    labels: {
      type: [Object, Boolean],
      default: true,
    },
    color:{
      type: String,
      default: '#75C791'
    },
    error: {
      type: [String, Array],
      default: "",
    },
  },
  data(){
    return {
      checked: this.value,
    }
  },
  methods: {
    change: function () {
      this.checked = !this.checked
      this.$emit("input", this.checked)
    },
  },
};
</script>
