<template>
  <div class="form-group row">
    <label v-if="label" class="col-sm-3 form-control-label" :for="id">{{ label }}:</label>
    <div class="col-sm-9">
      <v-select
        ref="select"
        v-bind="$attrs"
        :tabindex="0"
        :value="value"
        :options="options"
        :taggable="taggable"
        :placeholder="placeholder"
        @input="select"
      />
      <div v-if="error" class="invalid-feedback">{{ error }}</div>
    </div>
  </div>
</template>

<script>
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

export default {
  components: { vSelect },
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
    placeholder: {
      type: String,
      default: "",
    },
    value: String,
    label: String,
    error: {
      type: String,
      default: "",
    },
    options: {
      type: Array,
      default: null,
    },
    taggable: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    select(value) {
      // console.log(value);
      if(value instanceof Object){
        return this.$emit("input", value['code']);
      }
      return this.$emit("input", value);
    },
  },
};
</script>

<style lang="scss">
.vs--searchable {
  height: calc(2.25rem + 2px);
  border: 1px solid #dee2e6;
  border-radius: 0;
  padding: 0.275rem 0.75rem;
  .vs__dropdown-toggle {
    border: none;
    padding: 0;
  }

  input::-webkit-input-placeholder {
    color: #dee2e6;
  }

  &.vs--open {
    color: #495057;
    background-color: #fff;
    border-color: #796aee;
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(121, 106, 238, 0.25);
  }
}
</style>