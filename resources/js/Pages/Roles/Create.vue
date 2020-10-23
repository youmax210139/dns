<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="submit">
            <text-input
              v-model="form.first_name"
              :error="$page.errors.first_name"
              :label="__('role')"
              :placeholder="__('input_role')"
            />
            <dual-listbox
              v-model="form.permissions"
              :left-items="permissions"
              :right-items="form.permissions"
              :error="$page.errors.permission"
              :label="__('permission')"
            />
            <div class="form-group">
              <loading-button
                :loading="sending"
                class="btn btn-primary"
                type="submit"
              >
                {{ __("create_role") }}
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
import DualListbox from "@/Shared/Forms/DualListbox";
export default {
  components: {
    LoadingButton,
    TextInput,
    DualListbox,
  },
  props: {
    permissions: Array,
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
        name: "",
        permissions: []
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .post(this.route("roles.store"), this.form)
        .then(() => (this.sending = false));
    },
  },
};
</script>
