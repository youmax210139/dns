<template>
  <div v-show="$page.breadcrumb.length>1" class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
      <li
        v-for="(item,index) in $page.breadcrumb"
        :key="index"
        class="breadcrumb-item"
        :class="{ active: index==($page.breadcrumb.length-1) }"
      >
        <a :href="item.link">{{ item.label }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {};
</script>
