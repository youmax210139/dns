<template>
  <section class="forms">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="submit">
                <text-input v-model="form.name" :errors="$page.errors.name" label="Name" />
                <checkbox-input v-model="form.backup" label="Backup" option />
                <checkbox-input v-model="form.renew" label="Renew" option />
                <div class="form-group">
                  <loading-button
                    :loading="sending"
                    class="btn btn-primary"
                    type="submit"
                  >Edit Domain</loading-button>
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
import LoadingButton from "@/Shared/LoadingButton";
import TextInput from "@/Shared/Forms/TextInput";
import CheckboxInput from "@/Shared/Forms/CheckboxInput";

export default {
  components: {
    LoadingButton,
    CheckboxInput,
    TextInput,
  },
  props: {
    domain: Object,
  },
  data() {
    return {
      sending: false,
      form: {
        name: this.domain.name,
        backup: this.domain.backup,
        renew: this.domain.renew,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .put(this.route("domains.update", this.domain.id), this.form)
        .then(() => (this.sending = false));
    },
  },
};
</script>
