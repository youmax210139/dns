<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="submit">
            <text-input
              v-model="form.first_name"
              :error="$page.errors.first_name"
              :label="__('first_name')"
              :placeholder="__('input_first_name')"
            />
            <text-input
              v-model="form.last_name"
              :error="$page.errors.last_name"
              :label="__('last_name')"
              :placeholder="__('input_last_name')"
            />
            <text-input
              v-model="form.email"
              :type="'email'"
              :error="$page.errors.email"
              :label="__('email')"
              :placeholder="__('input_email')"
            />
            <text-select-input
              v-model="form.role_id"
              :error="$page.errors.role_id"
              :options="roles"
              :placeholder="__('input_role')"
              :label="__('role')"
              :taggable="false"
            />
            <text-input
              v-model="form.password"
              :type="'password'"
              :error="$page.errors.password"
              :label="__('password')"
              :placeholder="__('input_password')"
            />
            <text-input
              v-model="form.password_confirmation"
              :type="'password'"
              :error="$page.errors.password_confirmation"
              :label="__('password_confirmation')"
              :placeholder="__('input_password_confirmation')"
            />
            <div class="form-group">
              <loading-button
                :loading="sending"
                class="btn btn-primary"
                type="submit"
              >
                {{ __("create_user") }}
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
import TextSelectInput from "@/Shared/Forms/TextSelectInput";

export default {
  components: {
    LoadingButton,
    TextInput,
    TextSelectInput,
  },
  props: {
    roles: Array,
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: "",
        role_id: 0,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .post(this.route("users.store"), this.form)
        .then(() => (this.sending = false));
    },
  },
};
</script>
