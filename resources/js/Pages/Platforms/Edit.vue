<template>
  <section class="forms">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="submit">
                <text-input v-model="form.name" :errors="$page.errors.name" label="Name" />
                <div class="form-group">
                  <loading-button
                    :loading="sending"
                    class="btn btn-primary"
                    type="submit"
                  >Edit Platform</loading-button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
  props: {
    platform: Object,
  },
  data() {
    return {
      sending: false,
      form: {
        name: this.platform.name,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .put(this.route("platforms.update", this.platform.id), this.form)
        .then(() => (this.sending = false));
    },
  },
};
</script>
