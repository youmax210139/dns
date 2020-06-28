<template>
  <nav class="side-navbar" :class="side_navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
      <div class="avatar">
        <img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle" />
      </div>
      <div class="title">
        <h1 class="h4">Mark Stephen</h1>
        <p>Web Designer</p>
      </div>
    </div>
    <!-- Sidebar Navidation Menus-->
    <span class="heading">Main</span>
    <ul class="list-unstyled">
      <li class="active">
        <a href="#dashboards" aria-expanded="false" data-toggle="collapse">
          <i class="icon-home"></i>仪表板
        </a>
        <ul id="dashboards" class="collapse list-unstyled">
          <li>
            <a href="#">域名分析</a>
          </li>
          <li>
            <a href="#">域名搜寻引擎</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="tables.html">
          <i class="fa fa-server"></i>平台管理
        </a>
      </li>
      <li>
        <a href="#tools" aria-expanded="false" data-toggle="collapse">
          <i class="fa fa-search"></i>检测工具
        </a>
        <ul id="tools" class="collapse list-unstyled">
          <li>
            <a href="#">ping在线检测</a>
          </li>
          <li>
            <a href="#">whois在线检测</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="#automation" aria-expanded="false" data-toggle="collapse">
          <i class="fa fa-reddit-alien"></i>自动化管理
        </a>
        <ul id="automation" class="collapse list-unstyled">
          <li>
            <a href="#">域名状态侦测</a>
          </li>
          <li>
            <a href="#">域名逾期告警</a>
          </li>
          <li>
            <a href="#">域名状态侦测</a>
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
      sidebar_toggle: state => state.sidebar_toggle
    }),
    side_navbar: function() {
      return {
        shrinked: this.sidebar_toggle
      };
    }
  }
};
</script>