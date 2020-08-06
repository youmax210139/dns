<template>
  <section class="tables">
    <div class="container-fluid">
      <div class="mb-6 flex justify-between items-center">
        <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
          <label class="block text-gray-700">Trashed:</label>
          <select v-model="form.trashed" class="mt-1 w-full form-select">
            <option :value="null" />
            <option value="with">With Trashed</option>
            <option value="only">Only Trashed</option>
          </select>
        </search-filter>
        <inertia-link class="btn-indigo" :href="route('domains.create')">
          <span>创建</span>
          <span class="hidden md:inline">域名</span>
        </inertia-link>
      </div>
      <div class="table-responsive bg-white">
        <table class="table table-striped table-hover">
          <thead>
            <tr class="text-left font-bold">
              <th scope="col">#</th>
              <th scope="col">域名</th>
              <th scope="col">使用状态</th>
              <th scope="col">备援状态</th>
              <th scope="col">过期日期</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="domain in domains.data"
              :key="domain.id"
              class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
              <th scope="row">{{ domain.id }}</th>
              <td>
                {{ domain.name }}
                <icon
                  v-if="domain.deleted_at"
                  name="trash"
                  class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2"
                />
              </td>
              <td>{{ domain.usage_status }}</td>
              <td>{{ domain.backup_status }}</td>
              <td>{{ domain.expired_at }}</td>
            </tr>
            <tr v-if="domains.data.length === 0">
              <td colspan="4">No domains found.</td>
            </tr>
          </tbody>
        </table>
        <pagination :links="domains.links" />
      </div>
    </div>
  </section>
</template>

<script>
import Icon from "@/Shared/Icon";
import mapValues from "lodash/mapValues";
import Pagination from "@/Shared/Pagination";
import pickBy from "lodash/pickBy";
import SearchFilter from "@/Shared/SearchFilter";
import throttle from "lodash/throttle";

export default {
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  props: {
    domains: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    };
  },
  watch: {
    form: {
      handler: throttle(function () {
        let query = pickBy(this.form);
        this.$inertia.replace(
          this.route(
            "domains",
            Object.keys(query).length ? query : { remember: "forget" }
          )
        );
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null);
    },
  },
};
</script>
