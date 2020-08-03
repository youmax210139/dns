<template>
  <nav class="side-navbar" :class="side_navbar">
    <!-- Sidebar Navidation Menus-->
    <span class="heading">工具列</span>
    <ul class="list-unstyled">
      <!-- <li class="active">
        <a href="#dashboards" aria-expanded="false" data-toggle="collapse">
          <i class="icon-home"></i>仪表板
        </a>
      </li> -->
      <li>
        <a href="#dns-tools" aria-expanded="false" data-toggle="collapse">
          <i class="fa fa-server"></i>域名管理
        </a>
        <ul id="dns-tools" class="collapse list-unstyled">
          <li>
            <a href="#">Ping在線檢測</a>
          </li>
          <li>
            <a href="#">DNS在線查詢</a>
          </li>
          <li>
            <a href="#">路由器追踪</a>
          </li>
          <li>
            <a href="#">Whois域名在線查詢</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</template>
<script>
import { mapState, mapGetters, mapActions } from "vuex";
export default {
  computed: {
    ...mapState("navbar", {
      sidebar_toggle: (state) => state.sidebar_toggle,
    }),
    side_navbar: function () {
      return {
        shrinked: this.sidebar_toggle,
      };
    },
  },
};
</script>