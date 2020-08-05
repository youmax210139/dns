<template>
  <header class="header">
    <nav class="navbar">
      <!-- Search Box-->
      <div class="search-box">
        <button class="dismiss">
          <i class="icon-close"></i>
        </button>
        <form id="searchForm" action="#" role="search">
          <input type="search" placeholder="What are you looking for..." class="form-control" />
        </form>
      </div>
      <div class="container-fluid">
        <div class="navbar-holder d-flex align-items-center justify-content-between">
          <!-- Navbar Header-->
          <div class="navbar-header">
            <!-- Navbar Brand -->
            <a href="/" class="navbar-brand d-none d-sm-inline-block">
              <div class="brand-text d-none d-lg-inline-block">
                <strong>{{ $page.app.name }}</strong>
              </div>
              <div class="brand-text d-none d-sm-inline-block d-lg-none">
                <strong>{{ $page.app.name.substr(0,4) }}</strong>
              </div>
            </a>
            <!-- Toggle Button-->
            <a @click="toggle" class="menu-btn" :class="btn_toggle">
              <span></span>
              <span></span>
              <span></span>
            </a>
          </div>
          <!-- Navbar Menu -->
          <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
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
                class="nav-link"
              >
                <i class="fa fa-bell-o" v-show="notifications.length > 0"></i>
                <span
                  class="badge bg-red badge-corner"
                  v-show="notifications.length > 0"
                >{{ notifications.length }}</span>
              </a>
              <ul
                aria-labelledby="notifications"
                class="dropdown-menu"
                v-show="notifications.length > 0"
              >
                <li v-for="note in notifications">
                  <a rel="nofollow" href="#" class="dropdown-item">
                    <div class="notification">
                      <div class="notification-content">
                        <i
                          class="fa"
                          :class="classObject.notification[note.type] || 'fa-comments bg-gray'"
                        ></i>
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
                <i class="fa fa-sign-out"></i>
              </inertia-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      notifications: [
        {
          type: "email",
          message: "You have 6 new messages",
          time: moment('2020-08-05 14:00:00').fromNow(),
        },
        {
          type: "twitter",
          message: "You have 4 followers",
          time: moment('2020-08-04 14:00:00').fromNow(),
        },
        {
          type: "server",
          message: "Server Rebooted",
          time: moment('2020-08-03 12:00:00').fromNow(),
        },
        {
          type: "twitter",
          message: "You have 2 followers",
          time:moment('2020-08-03 11:00:00').fromNow(),
        },
      ],
      classObject: {
        notification: {
          email: "fa-envelope bg-green",
          twitter: "fa-twitter bg-blue",
          server: "fa-upload bg-orange",
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