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
                  <a class="btn btn-primary text-white mr-2" @click="reset">
                    <i class="far fa-trash-alt"></i>
                    {{ __('reset') }}
                  </a>
                  <loading-button
                    :loading="sending"
                    class="btn btn-primary mr-2"
                    type="submit"
                  >{{ __('whois_check') }}</loading-button>
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
            <div class="table-responsive">
              <table class="table table-striped table-hover" v-if="output">
                <tbody>
                  <tr v-for="v in Object.keys(attributes)" :key="v">
                    <td>{{ attributes[v]}}</td>
                    <td :class="v">{{ transformValue(output[v]) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
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
      form: {
        url: "",
      },
      sending: false,
      errors: {
        url: "",
      },
      output: null,
      attributes: {
        domain: this.__("domain"),
        registrar: this.__("registrar"),
        email: this.__("contact_email"),
        phone: this.__("contact_phone"),
        expired_at: this.__("expired_at"),
        created_at: this.__("created_at"),
        updated_at: this.__("updated_at"),
        whois: this.__("whois_server"),
        ns: "DNS",
      },
    };
  },
  mounted() {
  },
  methods: {
    transformValue($v) {
      if ($v == null || $v == undefined) {
        return "--";
      }
      if ($v instanceof String) {
        return $v;
      }
      if ($v instanceof Array) {
        return $v.join("\n");
      }
      return $v;
    },
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    submit() {
      this.sending = true;
      this.output = "";
      this.errors = mapValues(this.errors, () => "");
      this.$http
        .post(route("whois.store"), this.form)
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
<style lang="scss" scoped>
td.ns {
  white-space: pre;
}
</style>