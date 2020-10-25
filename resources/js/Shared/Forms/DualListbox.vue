<template>
  <div class="form-group row">
    <label v-if="label" class="col-sm-12 form-control-label" :for="id"
      >{{ label }}:</label
    >
    <div class="col-sm-12" @click.stop="click">
      <vue-list-picker
        :content-class="contentClass"
        :button-class="buttonClass"
        :left-items="left"
        :right-items="right"
        :title-left="titleLeft"
        :title-right="titleRight"
        :min-height="minHeight"
        :height="height"
      >
        <template v-slot:moveAllLeft>
          <i class="fas fa-angle-double-left" />
        </template>
        <template v-slot:moveLeft>
          <i class="fas fa-angle-left" />
        </template>
        <template v-slot:moveRight>
          <i class="fas fa-angle-right" />
        </template>
        <template v-slot:moveAllRight>
          <i class="fas fa-angle-double-right" />
        </template>
        <template v-slot:unselectAll>
          <i class="fas fa-undo" />
        </template>
      </vue-list-picker>
      <div v-if="error instanceof Array" class="invalid-feedback d-block">
        {{ error[0] }}
      </div>
      <div v-else-if="error" class="invalid-feedback d-block">{{ error }}</div>
    </div>
  </div>
</template>

<script>
import { VueListPicker } from "vue-list-picker";

export default {
  components: { VueListPicker },
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `text-input-${this._uid}`;
      },
    },
    label: String,
    error: {
      type: [String, Array],
      default: "",
    },
    leftItems: {
      type: Array,
      default: null,
    },
    rightItems: {
      type: Array,
      default: null,
    },
    titleLeft: {
      type: String,
      default: "",
    },
    titleRight: {
      type: String,
      default: "",
    },
    buttonClass: {
      type: String,
      default: "btn btn-primary text-white",
    },
    contentClass: {
      type: String,
      default: "list-group-item text-center",
    },
    minHeight: {
      type: String,
      default: "280px",
    },
    height: {
      type: String,
      default: "500px",
    },
  },
  data() {
    return {
      left: this.leftItems,
      right: this.rightItems,
    };
  },
  methods: {
    click(event){
      event.preventDefault()
    }
  },
};
</script>

<style lang="scss">
.list-picker-actions {
  .btn.btn-primary {
    width: 50px;
  }
}
</style>