<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="submit">
            <text-input
              v-model="form.name"
              :error="$page.errors.name"
              label="平台名"
              placeholder="请输入平台"
            />
            <div class="form-group">
              <loading-button :loading="sending" class="btn btn-primary" type="submit">创建平台</loading-button>
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

export default {
  components: {
    LoadingButton,
    TextInput,
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
        name: "",
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .post(this.route("platforms.store"), this.form)
        .then(() => (this.sending = false));
    },
  },
};
</script>
