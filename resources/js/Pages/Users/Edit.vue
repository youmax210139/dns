<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="submit">
            <text-input v-model="form.first_name" :error="$page.errors.first_name" :label="__('first_name')" />
            <text-input v-model="form.last_name" :error="$page.errors.last_name" :label="__('last_name')" />
            <text-input v-model="form.email" :type="'email'" :error="$page.errors.email" :label="__('email')" />
            <text-select-input v-model="form.role_id" :error="$page.errors.role_id" :label="__('role')" :options="roles" :taggable="false"/>
            <text-input v-model="form.password" :type="'password'" :error="$page.errors.password" :label="__('password')" />
            <text-input v-model="form.password_confirmation" :type="'password'" :error="$page.errors.password_confirmation" :label="__('password_confirmation')" />
            <div class="form-group">
              <loading-button
                :loading="sending"
                class="btn btn-primary"
                type="submit"
              >{{ __('edit_user') }}</loading-button>
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
    user: Object,
    roles: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        first_name: this.user.first_name,
        last_name: this.user.last_name,
        email: this.user.email,
        password: null,
        password_confirmation: null,
        role_id: this.user.role_id,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .put(this.route("users.update", this.user.id), this.form)
        .then(() => (this.sending = false));
    },
  },
};
</script>
