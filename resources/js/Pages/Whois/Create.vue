<template>
  <section class="forms">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" @submit.prevent="submit">
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">域名或IP地址</label>
                  <div class="col-sm-9">
                    <input
                      id="inputHorizontalSuccess"
                      v-model="form.url"
                      placeholder="example.com"
                      class="form-control form-control-success"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-12">
                    <button class="btn btn-primary mr-2" @click="reset">
                      <i class="far fa-trash-alt"></i>
                      淸空
                    </button>
                    <loading-button
                      :loading="sending"
                      class="btn btn-primary mr-2"
                      type="submit"
                    >Whois检测</loading-button>
                    <button
                      class="btn btn-primary"
                      ref="copy"
                      data-clipboard-action="copy"
                      data-clipboard-target="#output"
                    >
                      <i class="far fa-copy"></i>
                      复制结果
                    </button>
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
                  <textarea id="output" class="form-control" v-model="output" rows="10"></textarea>
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
import mapValues from "lodash/mapValues";
import LoadingButton from "@/Shared/Forms/LoadingButton";

export default {
  components: {
    LoadingButton,
  },
  data() {
    return {
      output: "",
      form: {
        url: "",
      },
      sending: false,
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
      this.$http.post(route("whois.store"), this.form).then((res) => {
        this.output = res.data;
        this.sending = false;
      });
    },
  },
};
</script>
