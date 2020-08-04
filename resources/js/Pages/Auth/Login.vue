<style lang="scss">
.login-page {
  position: relative;
}

.login-page::before {
  content: "";
  width: 100%;
  height: 100%;
  display: block;
  z-index: -1;
  // background: url(../img/bg.jpg);
  background-size: cover;
  -webkit-filter: blur(10px);
  filter: blur(10px);
  z-index: 1;
  position: absolute;
  top: 0;
  right: 0;
}

.login-page .container {
  min-height: 100vh;
  z-index: 999;
  padding: 20px;
  position: relative;
}

.login-page .form-holder {
  width: 100%;
  border-radius: 5px;
  overflow: hidden;
  margin-bottom: 50px;
}

.login-page .form-holder .info,
.login-page .form-holder .form {
  min-height: 70vh;
  padding: 40px;
  height: 100%;
}

.login-page .form-holder div[class*="col-"] {
  padding: 0;
}

.login-page .form-holder .info {
  background: rgba(121, 106, 238, 0.9);
  color: #fff;
}

.login-page .form-holder .info h1 {
  font-size: 2.5em;
  font-weight: 600;
}

.login-page .form-holder .info p {
  font-weight: 300;
}

.login-page .form-holder .form .form-group {
  position: relative;
  margin-bottom: 30px;
}

.login-page .form-holder .form .content {
  width: 100%;
}

.login-page .form-holder .form form {
  width: 100%;
  max-width: 400px;
}

.login-page .form-holder .form #login,
.login-page .form-holder .form #register {
  margin-bottom: 20px;
  cursor: pointer;
}

.login-page .form-holder .form a.forgot-pass,
.login-page .form-holder .form a.signup {
  font-size: 0.9em;
  color: #85b4f2;
}

.login-page .form-holder .form small {
  color: #aaa;
}

.login-page .form-holder .form .terms-conditions label {
  cursor: pointer;
  color: #aaa;
  font-size: 0.9em;
}

.login-page .copyrights {
  width: 100%;
  z-index: 9999;
  position: absolute;
  bottom: 0;
  left: 0;
  color: #fff;
}

@media (max-width: 991px) {
  .login-page .info,
  .login-page .form {
    min-height: auto !important;
  }
  .login-page .info {
    padding-top: 100px !important;
    padding-bottom: 100px !important;
  }
}
</style>

<template>
  <div class="page login-page">
    <div class="container d-flex align-items-center">
      <div class="form-holder has-shadow">
        <div class="row">
          <!-- Logo & Information Panel-->
          <div class="col-lg-6">
            <div class="info d-flex align-items-center">
              <div class="content">
                <div class="logo">
                  <h1>Tools Dashboard</h1>
                </div>
                <p>工具管理系统</p>
              </div>
            </div>
          </div>
          <!-- Form Panel    -->
          <div class="col-lg-6 bg-white">
            <div class="form d-flex align-items-center">
              <div class="content">
                <form
                  method="post"
                  class="form-validate needs-validation was-validated"
                  novalidate
                  @submit.prevent="submit"
                >
                  <div class="form-group">
                    <input
                      v-model="form.email"
                      @focus="emailActive=true"
                      @blur="blur($event)"
                      type="text"
                      name="email"
                      required
                      class="input-material"
                      :class="{'is-invalid': $page.errors.email}"
                    />
                    <label
                      for="login-username"
                      class="label-material"
                      :class="{active:emailActive}"
                    >User Name</label>
                    <div class="invalid-feedback">{{ emailError }}</div>
                  </div>
                  <div class="form-group">
                    <input
                      v-model="form.password"
                      @focus="passwordActive=true"
                      @blur="blur($event)"
                      type="password"
                      name="password"
                      required
                      class="input-material"
                      :class="{'is-invalid': $page.errors.password}"
                    />
                    <label
                      for="login-password"
                      class="label-material"
                      :class="{active:passwordActive}"
                    >Password</label>
                    <div class="invalid-feedback">{{ passwordError }}</div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                  </div>
                  <div class="form-group">
                    <input v-model="form.remember" class="mr-1" type="checkbox" />
                    <label class="text-sm">Remember Me</label>
                  </div>
                  <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                </form>
                <a href="#reset-password" class="forgot-pass">Forgot Password?</a>
                <br />
                <small>Do not have an account?</small>
                <a href="register.html" class="signup">Signup</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copyrights text-center">
      <p>
        &copy; 2020
        <a href="https://bootstrapious.com/p/admin-template" class="external"></a>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
      </p>
    </div>
  </div>
</template>

<script>
export default {
  metaInfo: { title: "Login" },
  components: {},
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
        password: "123456",
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