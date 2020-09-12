<template>
  <div class="sidebar" data-color="orange">
    <div class="logo">
      <a href="/" class="simple-text logo-normal">{{ $page.app.name }}</a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
      <ul class="nav">
        <li v-for="(v,index) in navs" :key="index" :class="{active:route().current() == v.route}">
          <a :href="route(v.route)">
            <i class="now-ui-icons" :class="v.icon" />
            <p>{{ v.label }}</p>
          </a>
        </li>
        <li class="active-pro">
            <p class="text-center text-white">IP: {{ $page.app.ip }}</p>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
import { mapState, mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      navs: [
        {
          label: "仪表板",
          icon: "business_chart-bar-32",
          route: "dashboards.index",
        },
        {
          label: "平台管理",
          icon: "business_globe",
          route: "platforms.index",
        },
        {
          label: "域名管理",
          icon: "business_money-coins",
          route: "domains.index",
        },
        {
          label: "Ping在線檢測",
          icon: "media-2_sound-wave",
          route: "pings.create",
        },
        {
          label: "DNS在線查詢",
          icon: "gestures_tap-01",
          route: "nslookups.create",
        },
        {
          label: "路由器追踪",
          icon: "education_paper",
          route: "traces.create",
        },
        {
          label: "Whois域名在線查詢",
          icon: "travel_info",
          route: "whois.create",
        },
        {
          label: "端口在線檢測工具",
          icon: "ui-2_settings-90",
          route: "netcats.create",
        },
      ],
    };
  },
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
<style lang="scss" scoped>
.nav {
  p {
    font-size: 1rem;
  }
}
</style>