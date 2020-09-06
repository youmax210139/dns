<template>
  <div class="wrapper">
    <app-sidebar />
    <portal-target name="dropdown" slim />
    <div class="main-panel" id="main-panel">
      <app-navbar />
      <div class="panel-header panel-header-sm"></div>
      <!-- <bread-crumb /> -->
      <div class="content">
        <flash-messages />
        <slot />
      </div>
      <app-footer />
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";
import AppNavbar from "./AppNavbar";
import AppSidebar from "./AppSidebar";
import AppFooter from "./AppFooter";
import BreadCrumb from "@/Shared/Breadcrumb";
import FlashMessages from "@/Shared/FlashMessages";

export default {
  components: {
    AppNavbar,
    AppSidebar,
    AppFooter,
    BreadCrumb,
    FlashMessages,
  },
  data() {
    return {
      showUserMenu: false,
      accounts: null,
    };
  },
  computed: {
    ...mapState("navbar", {
      sidebar_toggle: (state) => state.sidebar_toggle,
    }),
    content_inner: function () {
      return {
        active: this.sidebar_toggle,
      };
    },
  },
  methods: {
    url() {
      return location.pathname.substr(1);
    },
    hideDropdownMenus() {
      this.showUserMenu = false;
    },
  },
};
</script>
