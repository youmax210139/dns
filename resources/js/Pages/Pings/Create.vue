<template>
  <section>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form class="form-horizontal" @submit.prevent="submit">
              <text-select-input
                v-model="form.url"
                :error="errors.url"
                :options="domains"
                placeholder="example.com"
                :label="__('domain_or_ip')"
              />
              <div class="form-group row">
                <div class="col-12">
                  <a class="btn btn-primary mr-2 text-white" @click="reset">
                    <i class="far fa-trash-alt" />
                    {{ __('reset') }}
                  </a>
                  <loading-button
                    :loading="sending"
                    class="btn btn-primary mr-2"
                    type="submit"
                  >
                    {{ __('ping_check') }}
                  </loading-button>
                  <a
                    ref="copy"
                    @click="copy"
                    class="btn btn-primary text-white"
                    data-clipboard-action="copy"
                    data-clipboard-target="#output"
                  >
                    <i class="far fa-copy" />
                    {{ __('copy_result') }}
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form class="form-horizontal" @submit.prevent="submit">
              <div class="form-group">
                <textarea id="output" class="form-control" v-model="output" readonly></textarea>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import mapValues from "lodash/mapValues";
import TextSelectInput from "@/Shared/Forms/TextSelectInput";
import LoadingButton from "@/Shared/Forms/LoadingButton";

export default {
  components: {
    TextSelectInput,
    LoadingButton,
  },
  props: {
    domains: Array,
  },
  data() {
    return {
      output: "",
      form: {
        url: "",
      },
      sending: false,
      errors: {
        url: "",
      },
      // copyBtn: null,
    };
  },
  mounted() {
    new this.clipboard(this.$refs.copy);
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    submit() {
      this.sending = true;
      this.output = "";
      this.errors = mapValues(this.errors, () => "");
      this.$http
        .post(route("pings.store"), this.form)
        .then((res) => {
          this.output = res.data;
          this.sending = false;
        })
        .catch((err) => {
          this.sending = false;
          this.errors = err;
        });
    },
  },
};
</script>
<style lang=scss scoped>
textarea#output {
  min-height: 50vh;
}
</style>