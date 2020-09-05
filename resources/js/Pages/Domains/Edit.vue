<template>
  <section class="forms">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="submit">
                <text-select-input
                  v-model="form.platform_id"
                  :error="$page.errors.platform_id"
                  :options="platforms"
                  placeholder="平台名"
                  label="平台名"
                  :taggable="false"
                />
                <text-input v-model="form.name" :error="$page.errors.name" label="Name" />
                <checkbox-input v-model="form.backup" :error="$page.errors.backup" label="Backup" option />
                <checkbox-input v-model="form.renew" :error="$page.errors.renew" label="Renew" option />
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
import TextSelectInput from "@/Shared/Forms/TextSelectInput";
import CheckboxInput from "@/Shared/Forms/CheckboxInput";
import mapValues from "lodash/mapValues";

export default {
  components: {
    LoadingButton,
    CheckboxInput,
    TextInput,
    TextSelectInput,
  },
  props: {
    domain: Object,
    platforms: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        platform_id: this.domain.platform_id,
        name: this.domain.name,
        backup: this.domain.backup,
        renew: this.domain.renew,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$page.errors = mapValues(this.form, () => "");
      this.$inertia
        .put(this.route("domains.update", this.domain.id), this.form)
        .then(() => {
          this.sending = false;
        });
    },
  },
};
</script>
