<template>
  <div class="page">
    <portal-target name="dropdown" slim />
    <app-navbar />
    <div class="page-content d-flex align-items-stretch">
      <app-sidebar />
      <div class="content-inner" :class="content_inner">
        <page-header />
        <bread-crumb />
        <flash-messages />
        <slot />
        <app-footer />
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";
import AppNavbar from "./AppNavbar";
import AppSidebar from "./AppSidebar";
import AppFooter from "./AppFooter";
import BreadCrumb from "@/Shared/Breadcrumb";
import PageHeader from "@/Shared/PageHeader";
import FlashMessages from "@/Shared/FlashMessages";

export default {
  components: {
    AppNavbar,
    AppSidebar,
    AppFooter,
    BreadCrumb,
    PageHeader,
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
