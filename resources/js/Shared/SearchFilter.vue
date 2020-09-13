<template>
  <div class="card bg-transparent shadow-none">
    <div class="card-body p-0">
      <div class="row">
        <div class="col-9">
          <form class="form-inline">
            <div class="form-group">
              <dropdown :auto-close="false" placement="bottom-start">
                <span class="d-none d-md-inline-block px-2">{{ __('filter') }}</span>
                <i class="fas fa-caret-down" />
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
        <div class="col-3 text-right">
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
    width: 15%;
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
