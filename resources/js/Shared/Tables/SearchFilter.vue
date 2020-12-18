<template>
  <div class="card bg-transparent shadow-none">
    <div class="card-body p-0">
      <div class="row">
        <div class="col-md-7">
          <form class="form-inline">
            <div class="form-group justify-content-center justify-content-md-start">
              <dropdown :auto-close="false" placement="bottom-start">
                <span class="px-2">{{ __('filter') }}&nbsp;<i class="fas fa-caret-down" /></span>
                <div class="card" slot="dropdown">
                  <div class="card-body">
                    <form class="form-horizontal">
                      <slot />
                    </form>
                  </div>
                </div>
              </dropdown>
              <input
                autocomplete="off"
                type="text"
                name="search"
                placeholder="Search…"
                :value="value"
                class="form-control"
                @input="$emit('input', $event.target.value)"
              />
              <a class="btn-sm" type="button" @click="$emit('reset')">{{ __('reset') }}</a>
            </div>
          </form>
        </div>
        <div class="col-md-5 text-center text-md-right">
          <slot name="append" />
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~bootstrap/scss/functions";
@import "~bootstrap/scss/variables";
@import "~bootstrap/scss/mixins";
.form-inline {
  .form-group {
    width: 100%;
  }
  button {
    width: auto;
  }
  input {
    width: 40%;
  }
}

@include media-breakpoint-down(md) {
  .form-inline {
    .form-group {
      display: flex;
      align-items: center;
    }
    button {
      display: inline-flex;
      width: auto;
      align-items: center;
    }
    input {
      display: inline-flex;
    }
    a.btn {
      display: inline-flex;
    }
  }
}
</style>
<script>
import Dropdown from "@/Shared/Dropdown";

export default {
  components: {
    Dropdown,
  },
  props: {
    value: String,
  },
};
</script>
