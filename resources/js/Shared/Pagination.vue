<template>
  <nav>
    <ul class="pagination pagination-primary justify-content-center">
      <li class="page-item" :class="{ active: previous.active, disabled: previous.url==null}">
        <a class="page-link" :href="previous.url" :aria-label="previous.label">
          <span aria-hidden="true">
            <i class="fa fa-angle-double-left" aria-hidden="true"></i>
          </span>
        </a>
      </li>
      <li
        v-for="(link, key) in pages"
        :key="key"
        :class="{ active: link.active, disabled: link.url==null}"
        class="page-item"
      >
        <a v-if="link.url === null" :key="key" class="page-link">{{ link.label }}</a>
        <inertia-link v-else :key="key" :href="link.url" class="page-link">{{ link.label }}</inertia-link>
      </li>
      <li class="page-item" :class="{ active: next.active, disabled: next.url==null}">
        <a class="page-link" :href="next.url" :aria-label="next.label">
          <span aria-hidden="true">
            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
          </span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: {
    links: {
      type: Array,
      default: () => [
        { active: false, label: "previous" },
        { active: false, label: "next" },
      ],
    },
  },
  computed: {
    previous: function () {
      return this.links.slice(0, 1)[0];
    },
    pages: function () {
      return this.links.slice(1, -1);
    },
    next: function () {
      return this.links.slice(-1)[0];
    },
  },
};
</script>
