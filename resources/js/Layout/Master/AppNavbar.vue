<template>
  <nav class="navbar navbar-expand-lg navbar-transparent bg-primary navbar-absolute">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <page-header />
      </div>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navigation"
        aria-controls="navigation-index"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <form>
          <div class="input-group no-border">
            <input type="text" value class="form-control" placeholder="Search..." />
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="now-ui-icons ui-1_zoom-bold"></i>
              </div>
            </div>
          </div>
        </form>
        <!-- Navbar Menu -->
        <ul class="navbar-nav">
          <!-- Notifications-->
          <li class="nav-item dropdown">
            <a
              id="notifications"
              rel="nofollow"
              data-target="#"
              href="#"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              class="nav-link dropdown-toggle"
            >
              <i class="far fa-bell" v-show="notifications.length > 0" />
              <p>
                <span
                  class="badge bg-red badge-corner"
                  v-show="notifications.length > 0"
                >{{ notifications.length }}</span>
              </p>
            </a>
            <ul
              aria-labelledby="notifications"
              class="dropdown-menu"
              v-show="notifications.length > 0"
            >
              <li v-for="(note,index) in notifications" :key="note.id">
                <a rel="nofollow" href="#" class="dropdown-item">
                  <div class="notification">
                    <div class="notification-content">
                      <i :class="classObject.notification[note.type] || 'fa fa-comments bg-gray'" />
                      {{ note.message }}
                    </div>
                    <div class="notification-time">
                      <small>{{ note.time }}</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a rel="nofollow" href="#" class="dropdown-item all-notifications text-center">
                  <strong>检视所有讯息</strong>
                </a>
              </li>
            </ul>
          </li>
          <!-- Languages dropdown    -->
          <li class="nav-item dropdown">
            <a
              id="languages"
              rel="nofollow"
              data-target="#"
              href="#"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              class="nav-link language dropdown-toggle"
            >
              <img src="/img/flags/16/CN.png" alt="中文" />
              <span class="d-none d-sm-inline-block">中文</span>
            </a>
            <ul aria-labelledby="languages" class="dropdown-menu">
              <li>
                <a rel="nofollow" href="#" class="dropdown-item">
                  <img src="/img/flags/16/GB.png" alt="English" class="mr-2" />英文
                </a>
              </li>
            </ul>
          </li>
          <!-- Logout    -->
          <li class="nav-item">
            <inertia-link class="nav-link logout" :href="route('logout')" method="post">
              <span class="d-none d-sm-inline">登出</span>
              <i class="fas fa-sign-out-alt" />
            </inertia-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
import PageHeader from "@/Shared/PageHeader";
import { mapState, mapActions } from "vuex";
export default {
  components: {
    PageHeader,
  },
  data() {
    return {
      notifications: [
        {
          id: 1,
          type: "email",
          message: "You have 6 new messages",
          time: moment("2020-08-05 14:00:00").fromNow(),
        },
        {
          id: 2,
          type: "twitter",
          message: "You have 4 followers",
          time: moment("2020-08-04 14:00:00").fromNow(),
        },
        {
          id: 3,
          type: "server",
          message: "Server Rebooted",
          time: moment("2020-08-03 12:00:00").fromNow(),
        },
        {
          id: 4,
          type: "twitter",
          message: "You have 2 followers",
          time: moment("2020-08-03 11:00:00").fromNow(),
        },
      ],
      classObject: {
        notification: {
          email: "fa fa-envelope bg-green",
          twitter: "fab fa-twitter bg-blue",
          server: "fa fa-upload bg-orange",
        },
      },
    };
  },
  props: {
    Page: Object,
  },
  computed: {
    ...mapState("navbar", {
      sidebar_toggle: (state) => state.sidebar_toggle,
    }),
    btn_toggle: function () {
      return {
        active: !this.sidebar_toggle,
      };
    },
  },
  methods: {
    ...mapActions({
      toggle: "navbar/toggle",
    }),
  },
};
</script>