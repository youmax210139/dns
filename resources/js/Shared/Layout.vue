<template>
  <div class="page">
    <!-- Main Navbar-->
    <navbar />
    <div class="page-content d-flex align-items-stretch">
      <!-- Side Navbar -->
      <sidebar />
      <div class="content-inner" :class="content_inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <!-- <h2 class="no-margin-bottom">Dashboard</h2> -->
          </div>
        </header>
        <slot />
        <page-footer />
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";
import Navbar from "@/Shared/Navbar";
import Sidebar from "@/Shared/Sidebar";
import PageFooter from "@/Shared/PageFooter";
import Dropdown from "@/Shared/Dropdown";
import FlashMessages from "@/Shared/FlashMessages";
import Icon from "@/Shared/Icon";
import Logo from "@/Shared/Logo";
import MainMenu from "@/Shared/MainMenu";

export default {
  components: {
    Navbar,
    Sidebar,
    PageFooter,
    Dropdown,
    FlashMessages,
    Icon,
    Logo,
    MainMenu
  },
  data() {
    return {
      showUserMenu: false,
      accounts: null
    };
  },
    computed: {
    ...mapState('navbar',{
        sidebar_toggle: state => state.sidebar_toggle
    }),
    content_inner: function() {
      return {
        active: this.sidebar_toggle
      };
    }
  },
  methods: {
    url() {
      return location.pathname.substr(1);
    },
    hideDropdownMenus() {
      this.showUserMenu = false;
    }
  }
};
</script>
