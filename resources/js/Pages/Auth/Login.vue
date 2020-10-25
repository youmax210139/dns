<template>
  <div class="page-header" filter-color="orange">
    <div
      class="page-header-image"
      style="background-image: url(/images/login.jpg)"
    />
    <div class="content">
      <div class="container">
        <div class="col-md-5 ml-auto mr-auto">
          <div class="card card-login card-plain">
            <form
              class="form"
              method="post"
              :class="{ 'is-invalid': errors.email || errors.password }"
              @submit.prevent="submit"
            >
              <div class="card-header text-center">
                <!-- Logo & Information Panel-->
                <div class="logo-container">
                  <img src="/images/logo.png" alt />
                </div>
                <!-- End of Logo -->
              </div>
              <div class="card-body">
                <div
                  class="input-group form-group-no-border input-lg"
                  :class="{
                    'input-group-focus': emailActive,
                    'has-danger': errors.email,
                  }"
                >
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="now-ui-icons users_circle-08" />
                    </span>
                  </div>
                  <input
                    v-model="form.email"
                    class="form-control"
                    type="text"
                    name="email"
                    required
                    :placeholder="__('input', { name: __('email') })"
                    @blur="blur($event)"
                  />
                </div>
                <div
                  v-if="errors.email"
                  class="invalid-feedback text-center mb-2"
                >
                  {{ errors.email[0] }}
                </div>
                <div
                  class="input-group form-group-no-border input-lg"
                  :class="{
                    'input-group-focus': passwordActive,
                    'has-danger': errors.password,
                  }"
                >
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="now-ui-icons text_caps-small" />
                    </span>
                  </div>
                  <input
                    v-model="form.password"
                    type="password"
                    name="password"
                    class="form-control"
                    required
                    :class="{ 'is-invalid': errors.password }"
                    :placeholder="__('input', { name: __('password') })"
                    @blur="blur($event)"
                  />
                </div>
                <div
                  v-if="errors.password"
                  class="invalid-feedback text-center mb-2"
                >
                  {{ errors.password[0] }}
                </div>
              </div>
              <div class="card-footer text-center">
                <button
                  type="submit"
                  class="btn btn-primary btn-round btn-lg btn-block"
                >
                  {{ __("login") }}
                </button>
              </div>
              <!-- <div class="pull-left">
                <h6>
                  <a href="#register" class="link footer-link">
                    {{ __('signup') }}
                  </a>
                </h6>
              </div>
              <div class="pull-right">
                <h6>
                  <a href="#reset-password" class="link footer-link">
                    {{ __('forgot_password') }}
                  </a>
                </h6>
              </div> -->
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer">
      <div class="container">
        <div id="copyright" class="copyright">
          &copy; {{ $page.date }}, Maintained by Charlie. Coded by
          <a href="https://www.creative-tim.com" target="_blank">
            Creative Tim
          </a>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import Layout from "@/Layout/Login/Layout";
export default {
  metaInfo: { title: "Login" },
  layout: Layout,
  props: {
    errors: Object,
  },
  data() {
    return {
      emailActive: false,
      passwordActive: false,
      sending: false,
      form: {
        email: "admin@gmail.com",
        password: "P@ssw0rd",
        remember: null,
      },
    };
  },
  methods: {
    blur(event) {
      if (event.target.value == "") {
        this.$data[event.target.name + "Active"] = false;
      } else {
        this.$data[event.target.name + "Active"] = true;
      }
    },
    submit() {
      this.sending = true;
      this.emailActive = this.passwordActive = false;
      this.$inertia.post(this.route("login.attempt"), {
        email: this.form.email,
        password: this.form.password,
        remember: this.form.remember,
      });
    },
  },
};
</script>
<style lang="scss" scoped>
.page-header .container {
  position: relative;
}
.login-page .link {
  font-size: 10px;
  color: #ffffff !important;
  text-decoration: none;
}
.login-page .card-login.card-plain {
  .form-group.form-group-no-border .form-control,
  .input-group.form-group-no-border .form-control {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    border: none;
  }
}
.input-group-text {
  color: rgba(255, 255, 255, 0.8);
  border: none;
  background-color: rgba(255, 255, 255, 0.1);
}

.login-page .card-login.card-plain {
  .form-group.form-group-no-border.input-group-focus .input-group-text,
  .input-group.form-group-no-border.input-group-focus .input-group-text,
  .input-group.form-group-no-border.input-group-focus .form-control{
    background-color: rgba(255, 255, 255, 0.2);
    color: #ffffff;
  }
}
.login-page
  .card-login.card-plain
  .input-group.form-group-no-border
  .form-control::placeholder {
  color: rgba(255, 255, 255, 0.8);
}
.login-page .card-login .logo-container {
  margin-top: 55px;
  margin-bottom: 55px;
}
.copyright {
  text-align: center !important;
  float: none !important;
}
.login-page .card-login.card-plain form.is-invalid {
  .input-group.form-group-no-border.has-danger {
    .form-control,
    .input-group-prepend .input-group-text {
      color: #ff3636 !important;
      &:focus {
        color: #ff3636 !important;
      }
    }
  }
  .invalid-feedback {
    display: block;
  }
}
</style>