<style>
.terminal-window pre {
  color: #aaa;
}
</style>
<template>
  <vue-command :commands="commands" prompt="ubuntu@localhost" />
</template>

<script>
import VueCommand, { createStdout } from "vue-command";
import "vue-command/dist/vue-command.css";
import Layout from "@/Shared/Layout";
import mapValues from "lodash/mapValues";
import Pagination from "@/Shared/Pagination";
import pickBy from "lodash/pickBy";
import SearchFilter from "@/Shared/SearchFilter";
import throttle from "lodash/throttle";

export default {
  metaInfo: { title: "Whois" },
  layout: Layout,
  components: {
    Pagination,
    SearchFilter,
    VueCommand
  },
  props: {
    contacts: Object,
    filters: Object
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed
      },
      commands: {
        "whois": () => {
          return createStdout('www.google.com.tw')
        }
      }
    };
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form);
        this.$inertia.replace(
          this.route(
            "contacts",
            Object.keys(query).length ? query : { remember: "forget" }
          )
        );
      }, 150),
      deep: true
    }
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null);
    }
  }
};
</script>
