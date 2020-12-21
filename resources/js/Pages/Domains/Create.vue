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
              :placeholder="__('input', {name: __('platform')})"
              :label="__('platform')"
              :taggable="false"
            />
            <text-area-input
              v-model="form.names"
              :rows="10"
              :error="$page.errors.name"
              :label="__('domain')"
              :placeholder="__('input', { name: __('domain') }) + __('multiple_domain_tip')"
            />
            <text-select-input
              v-model="form.protocols"
              :error="$page.errors.protocols"
              :options="protocols"
              :placeholder="__('input', {name: __('protocol')})"
              :label="__('protocol')"
              :taggable="false"
              :multiple="true"
            />
            <toggle-input v-model="form.backup" :label="__('backup')" />
            <toggle-input v-model="form.renew" :label="__('renew')" />
            <toggle-input v-model="form.enable" :label="__('enable')" />
            <text-input
              v-model="form.remark"
              :error="$page.errors.remark"
              :label="__('remark')"
              :placeholder="__('input', { name: __('remark') })"
            />
            <div class="form-group">
              <loading-button
                :loading="sending"
                class="btn btn-primary"
                type="submit"
              >
                {{ __("domains.create") }}
              </loading-button>
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
import TextAreaInput from "@/Shared/Forms/TextAreaInput";
import ToggleInput from "@/Shared/Forms/ToggleInput";
import TextSelectInput from "@/Shared/Forms/TextSelectInput";

export default {
  components: {
    LoadingButton,
    ToggleInput,
    TextInput,
    TextAreaInput,
    TextSelectInput,
  },
  props: {
    platforms: Array,
    protocols: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        platform_id: 0,
        names: "",
        protocols: ["http"],  
        backup: false,
        renew: false,
        enable: true,
        remark: "",
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
