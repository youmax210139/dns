<template>
  <nav>
    <ul v-show="tablePagination && lastPage > firstPage" :class="$_css.wrapperClass">
      <li :class="[$_css.linkClass, isOnFirstPage ? $_css.disabledClass : '']">
        <a class="page-link" @click="loadPage(firstPage)">
          <span>
            <i v-if="$_css.icons.first != ''" :class="[$_css.icons.first]"></i>
            <span v-else>&laquo;</span>
          </span>
        </a>
      </li>
      <li :class="[$_css.linkClass, isOnFirstPage ? $_css.disabledClass : '']">
        <a class="page-link" @click="loadPage('prev')">
          <span>
            <i v-if="$_css.icons.next != ''" :class="[$_css.icons.prev]"></i>
            <span v-else>&nbsp;&lsaquo;</span>
          </span>
        </a>
      </li>
      <template v-if="notEnoughPages">
        <template v-for="(n, i) in totalPage">
          <li
            :key="i"
            :class="[$_css.pageClass, isCurrentPage(i+firstPage) ? $_css.activeClass : '']"
          >
            <a class="page-link" @click="loadPage(i+firstPage)">
              <span>{{ n }}</span>
            </a>
          </li>
        </template>
      </template>
      <template v-else>
        <template v-for="(n, i) in windowSize">
          <li
            :key="i"
            :class="[$_css.pageClass, isCurrentPage(windowStart+i+firstPage-1) ? $_css.activeClass : '']"
          >
            <a class="page-link" @click="loadPage(windowStart+i+firstPage-1)">
              <span>{{ windowStart+n-1 }}</span>
            </a>
          </li>
        </template>
      </template>
      <li :class="[$_css.linkClass, isOnLastPage ? $_css.disabledClass : '']">
        <a class="page-link" @click="loadPage('next')">
          <span>
            <i v-if="$_css.icons.next != ''" :class="[$_css.icons.next]"></i>
            <span v-else>&rsaquo;&nbsp;</span>
          </span>
        </a>
      </li>
      <li :class="[$_css.linkClass, isOnLastPage ? $_css.disabledClass : '']">
        <a class="page-link" @click="loadPage(lastPage)">
          <span>
            <i v-if="$_css.icons.last != ''" :class="[$_css.icons.last]"></i>
            <span v-else>&raquo;</span>
          </span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
import PaginationMixin from "vuetable-2/src/components/VuetablePaginationMixin";

export default {
  mixins: [PaginationMixin],
};
</script>
<style scoped>
.vuetable-pagination {
  background: #f9fafb !important;
}
</style>
