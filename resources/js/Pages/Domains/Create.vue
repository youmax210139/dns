<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="submit">
            <text-select-input
              v-model="form.platform_id"
              :error="$page.errors.platform_id"
              :options="platforms"
              :placeholder="__('input_platform')"
              :label="__('platform')"
              :taggable="false"
            />
            <text-input
              v-model="form.name"
              :error="$page.errors.name"
              :label="__('domain')"
              :placeholder="__('input_domain')"
            />
            <checkbox-input v-model="form.backup" :label="__('backup')" />
            <checkbox-input v-model="form.renew" :label="__('renew')" />
            <div class="form-group">
              <loading-button
                :loading="sending"
                class="btn btn-primary"
                type="submit"
              >{{ __('create_domain') }}</loading-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoadingButton from "@/Shared/Forms/LoadingButton";
import TextInput from "@/Shared/Forms/TextInput";
import CheckboxInput from "@/Shared/Forms/CheckboxInput";
import TextSelectInput from "@/Shared/Forms/TextSelectInput";

export default {
  components: {
    LoadingButton,
    CheckboxInput,
    TextInput,
    TextSelectInput,
  },
  props: {
    platforms: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        platform_id: 0,
        name: "",
        backup: false,
        renew: false,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .post(this.route("domains.store"), this.form)
        .then(() => (this.sending = false));
    },
  },
};
</script>
