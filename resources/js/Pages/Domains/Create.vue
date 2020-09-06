<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="submit">
            <text-input
              v-model="form.name"
              :error="$page.errors.name"
              label="Name"
              placeholder="请输入域名"
            />
            <checkbox-input v-model="form.backup" label="Backup" option />
            <checkbox-input v-model="form.renew" label="Renew" option />
            <div class="form-group">
              <loading-button :loading="sending" class="btn btn-primary" type="submit">Create Domain</loading-button>
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

export default {
  components: {
    LoadingButton,
    CheckboxInput,
    TextInput,
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
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
