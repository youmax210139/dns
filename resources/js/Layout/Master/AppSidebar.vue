<template>
  <div class="sidebar" data-color="orange">
    <div class="logo">
      <a href="/" class="simple-text logo-normal">{{ $page.app.name }}</a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
      <ul class="nav">
        <li v-for="(v,index) in navs" :key="index">
          <a :href="v.href">
            <i class="now-ui-icons design_app" />
            <p>{{ v.label }}</p>
          </a>
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
          href: "/",
        },
        {
          label: "平台管理",
          href: route("platforms.index"),
        },
        {
          label: "域名管理",
          href: route("domains.index"),
        },
        {
          label: "Ping在線檢測",
          href: route("pings.create"),
        },
        {
          label: "DNS在線查詢",
          href: route("nslookups.create"),
        },
        {
          label: "路由器追踪",
          href: route("traces.create"),
        },
        {
          label: "Whois域名在線查詢",
          href: route("whois.create"),
        },
        {
          label: "端口在線檢測工具",
          href: route("netcats.create"),
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