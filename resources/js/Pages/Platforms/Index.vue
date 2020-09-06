<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <search-filter v-model="form.search" @reset="reset">
            <div class="row">
              <label class="col-12 form-control-label">Trashed:</label>
              <div class="col-12">
                <select v-model="form.trashed" class="form-control mb-3">
                  <option :value="null">--</option>
                  <option value="with">With Trashed</option>
                  <option value="only">Only Trashed</option>
                </select>
              </div>
            </div>
            <inertia-link class="btn btn-primary" :href="route('platforms.create')" slot="append">
              <span class="d-none d-md-inline-block">创建平台</span>
              <span class="d-md-none">创建</span>
            </inertia-link>
          </search-filter>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
              <thead>
                <tr class="text-left font-bold">
                  <th scope="col">#</th>
                  <th scope="col">名称</th>
                  <th scope="col">创建日期</th>
                  <th scope="col">更新日期</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="platform in platforms.data"
                  :key="platform.id"
                  class="hover:bg-gray-100 focus-within:bg-gray-100"
                >
                  <th scope="row">{{ platform.id }}</th>
                  <td>{{ platform.name }}</td>
                  <td>{{ platform.created_at }}</td>
                  <td>{{ platform.updated_at }}</td>
                  <td>
                    <a :href="route('platforms.edit', platform.id)" class="btn btn-sm btn-info text-white">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a class="btn btn-sm btn-danger text-white" @click="destroy(platform)">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
                <tr v-if="platforms.data.length === 0">
                  <td colspan="4">No platforms found.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          <pagination :links="platforms.links" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import mapValues from "lodash/mapValues";
import Pagination from "@/Shared/Pagination";
import pickBy from "lodash/pickBy";
import SearchFilter from "@/Shared/SearchFilter";
import throttle from "lodash/throttle";

export default {
  components: {
    Pagination,
    SearchFilter,
  },
  props: {
    platforms: Object,
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
          this.route("platforms.index", Object.keys(query).length ? query : {})
        );
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    destroy(platform) {
      if (confirm("Are you sure you want to delete this platform?")) {
        this.$inertia.delete(this.route("platforms.destroy", platform.id));
      }
    },
  },
};
</script>
