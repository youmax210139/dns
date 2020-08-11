<template>
  <section class="tables">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <search-filter v-model="form.search" @reset="reset">
            <div class="row">
              <label class="col-12 form-control-label">Trashed:</label>
              <div class="col-12">
                <select v-model="form.trashed" class="form-control mb-3">
                  <option :value="null" />
                  <option value="with">With Trashed</option>
                  <option value="only">Only Trashed</option>
                </select>
              </div>
            </div>
            <inertia-link class="btn btn-primary" :href="route('domains.create')" slot="append">
              <span class="d-none d-md-inline-block">创建域名</span>
              <span class="d-md-none">创建</span>
            </inertia-link>
          </search-filter>
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
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
                      <td>{{ domain.usage }}</td>
                      <td>{{ domain.backup ? 'Y' : 'N' }}</td>
                      <td>{{ domain.expired_at }}</td>
                    </tr>
                    <tr v-if="domains.data.length === 0">
                      <td colspan="4">No domains found.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card bg-transparent shadow-none">
            <div class="card-body p-0">
              <pagination :links="domains.links" />
            </div>
          </div>
        </div>
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
            "domains.index",
            Object.keys(query).length ? query : {}
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
