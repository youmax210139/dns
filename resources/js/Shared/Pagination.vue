<template>
  <nav>
    <ul class="pagination">
      <li v-for="(link, key) in links" :key="key" class="page-item">
        <div v-if="link.url === null" :key="key" :class="{ 'disabled': link.label === 'Next'}" class="page-link">{{ link.label }}</div>
        <inertia-link v-else :key="key" :href="link.url" class="page-link">{{ link.label }}</inertia-link>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: {
    links: Array,
  },
  data(){
    return {
      classObject:{

      }
    }
  },
  created: function () {
    console.log(this.links);
  },
};
</script>
