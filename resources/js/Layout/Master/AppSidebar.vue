<template>
  <div class="sidebar" data-color="orange">
    <div class="logo">
      <a href="/" class="simple-text logo-normal">{{ $page.app.name }}</a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
      <ul class="nav">
        <li v-for="(v,index) in $page.sidebar" :key="index" :class="{active:route().current() == v.route}">
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
export default {
};
</script>
<style lang="scss" scoped>
.nav {
  p {
    font-size: 1rem;
    text-transform: none;
  }
}
</style>