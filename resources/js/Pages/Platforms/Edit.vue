<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="submit">
            <text-input v-model="form.name" :error="$page.errors.name" :label="__('platform')" />
            <div class="form-group">
              <loading-button
                :loading="sending"
                class="btn btn-primary"
                type="submit"
              >{{ __('edit_platform') }}</loading-button>
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
