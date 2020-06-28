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
        <a href="/">
          <i class="icon-home"></i>仪表板
        </a>
      </li>
      <li>
        <a href="tables.html">
          <i class="icon-grid"></i>平台管理
        </a>
      </li>
      <li>
        <a href="charts.html">
          <i class="fa fa-bar-chart"></i>工具
        </a>
      </li>
      <li>
        <a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse">
          <i class="icon-padnote"></i>自动化管理
        </a>
        <ul id="exampledropdownDropdown" class="collapse list-unstyled">
          <li>
            <a href="#">Page</a>
          </li>
          <li>
            <a href="#">Page</a>
          </li>
          <li>
            <a href="#">Page</a>
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