<template>
  <div class="page-header" filter-color="orange">
    <div class="page-header-image" style="background-image:url(/images/login.jpg)"></div>
    <div class="content">
      <div class="container">
        <div class="col-md-5 ml-auto mr-auto">
          <div class="card card-login card-plain">
            <form class="form" method="post" @submit.prevent="submit">
              <div class="card-header text-center">
                <!-- Logo & Information Panel-->
                <div class="logo-container">
                  <img src="/images/logo.png" alt />
                </div>
                <!-- End of Logo -->
              </div>
              <div class="card-body">
                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </span>
                  </div>
                  <input
                    v-model="form.email"
                    @focus="emailActive=true"
                    @blur="blur($event)"
                    type="text"
                    name="email"
                    required
                    class="form-control"
                    :placeholder="__('input_email')"
                    :class="{'is-invalid': $page.errors.email}"
                  />
                </div>
                <div class="input-group form-group-no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="now-ui-icons text_caps-small"></i>
                    </span>
                  </div>
                  <input
                    v-model="form.password"
                    @focus="passwordActive=true"
                    @blur="blur($event)"
                    type="password"
                    name="password"
                    required
                    :placeholder="__('input_password')"
                    class="form-control"
                    :class="{'is-invalid': $page.errors.password}"
                  />
                </div>
              </div>
              <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary btn-round btn-lg btn-block">
                  {{ __('login') }}
                  </button>
              </div>
              <div class="pull-left">
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
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer">
      <div class="container">
        <div class="copyright" id="copyright">
          &copy; {{ $page.date }}, Maintained by Charlie. Coded by
          <a
            href="https://www.creative-tim.com"
            target="_blank"
          >Creative Tim</a>.
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
      emailActive: true,
      passwordActive: true,
      loading: false,
      sending: false,
      form: {
        email: "admin@gmail.com",
        password: "P@ssw0rd",
        remember: null,
      },
      validation: {
        email: true,
        password: true,
      },
    };
  },
  computed: {
    emailError() {
      if (this.$page.errors.email) {
        return this.$page.errors.email[0];
      }
      return "";
    },
    passwordError() {
      if (this.$page.errors.password) {
        return this.$page.errors.password[0];
      }
      return "";
    },
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
      this.$inertia
        .post(this.route("login.attempt"), {
          email: this.form.email,
          password: this.form.password,
          remember: this.form.remember,
        })
        .then(() => (this.sending = false));
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

.login-page
  .card-login.card-plain
  .form-group.form-group-no-border.input-group-focus
  .input-group-text,
.login-page
  .card-login.card-plain
  .input-group.form-group-no-border.input-group-focus
  .input-group-text,
.login-page
  .card-login.card-plain
  .input-group.form-group-no-border
  .form-control:focus {
  background-color: rgba(255, 255, 255, 0.2);
  color: #ffffff;
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
</style>