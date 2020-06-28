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
                <span>域名</span>
                <strong>监控系统</strong>
              </div>
              <div class="brand-text d-none d-sm-inline-block d-lg-none">
                <strong>域名</strong>
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
                <i class="fa fa-bell-o"></i>
                <span class="badge bg-red badge-corner">12</span>
              </a>
              <ul aria-labelledby="notifications" class="dropdown-menu">
                <li>
                  <a rel="nofollow" href="#" class="dropdown-item">
                    <div class="notification">
                      <div class="notification-content">
                        <i class="fa fa-envelope bg-green"></i>You have 6 new messages
                      </div>
                      <div class="notification-time">
                        <small>4 minutes ago</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a rel="nofollow" href="#" class="dropdown-item">
                    <div class="notification">
                      <div class="notification-content">
                        <i class="fa fa-twitter bg-blue"></i>You have 2 followers
                      </div>
                      <div class="notification-time">
                        <small>4 minutes ago</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a rel="nofollow" href="#" class="dropdown-item">
                    <div class="notification">
                      <div class="notification-content">
                        <i class="fa fa-upload bg-orange"></i>Server Rebooted
                      </div>
                      <div class="notification-time">
                        <small>4 minutes ago</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a rel="nofollow" href="#" class="dropdown-item">
                    <div class="notification">
                      <div class="notification-content">
                        <i class="fa fa-twitter bg-blue"></i>You have 2 followers
                      </div>
                      <div class="notification-time">
                        <small>10 minutes ago</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a rel="nofollow" href="#" class="dropdown-item all-notifications text-center">
                    <strong>view all notifications</strong>
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
                <img src="img/flags/16/CN.png" alt="中文" />
                <span class="d-none d-sm-inline-block">中文</span>
              </a>
              <ul aria-labelledby="languages" class="dropdown-menu">
                <li>
                  <a rel="nofollow" href="#" class="dropdown-item">
                    <img src="img/flags/16/GB.png" alt="English" class="mr-2" />英文
                  </a>
                </li>
              </ul>
            </li>
            <!-- Logout    -->
            <li class="nav-item">
              <inertia-link class="nav-link logout" :href="route('logout')" method="post">
                <span class="d-none d-sm-inline">Logout</span>
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
import { mapState, mapGetters, mapActions } from "vuex";
export default {
  props: {
    Page: Object
  },
  computed: {
    ...mapState("navbar", {
      sidebar_toggle: state => state.sidebar_toggle
    }),
    btn_toggle: function() {
      return {
        active: !this.sidebar_toggle
      };
    }
  },
  methods: {
    ...mapActions({
      toggle: "navbar/toggle"
    })
  }
};
</script>