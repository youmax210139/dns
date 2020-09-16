<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <search-filter v-model="form.search" @reset="reset">
            <div class="row">
              <label class="col-12 form-control-label">{{ __('trashed') }}:</label>
              <div class="col-12">
                <select v-model="form.trashed" class="form-control mb-3">
                  <option :value="null">--</option>
                  <option value="with">{{ __('with_trashed') }}</option>
                  <option value="only">{{ __('only_trashed') }}</option>
                </select>
              </div>
            </div>
            <inertia-link class="btn btn-primary" :href="route('domains.create')" slot="append">
              <span class="d-none d-md-inline-block">{{ __('create_domain') }}</span>
              <span class="d-md-none">{{ __('create') }}</span>
            </inertia-link>
          </search-filter>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
              <thead>
                <tr class="text-left font-bold">
                  <th scope="col">#</th>
                  <th scope="col">{{ __('platform') }}</th>
                  <th scope="col">{{ __('main_domain') }}</th>
                  <th scope="col">{{ __('domain') }}</th>
                  <th scope="col">{{ __('usage') }}</th>
                  <th scope="col">{{ __('backup') }}</th>
                  <th scope="col">{{ __('expired_at') }}</th>
                  <th scope="col">{{ __('operation') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="domain in content"
                  :key="domain.id"
                  class="hover:bg-gray-100 focus-within:bg-gray-100"
                >
                  <th scope="row">{{ domain.id }}</th>
                  <th scope="row">{{ domain.platform_name }}</th>
                  <td>{{ domain.hostname }}</td>
                  <td>{{ domain.name }}</td>
                  <td>{{ domain.usage }}％</td>
                  <td>{{ domain.backup ? 'Y' : 'N' }}</td>
                  <td>{{ domain.expired_at }}</td>
                  <td>
                    <a
                      :href="route('domains.edit', domain.id)"
                      class="btn btn-sm btn-info text-white"
                    >
                      <i class="fas fa-edit"></i>
                    </a>
                    <a class="btn btn-sm btn-danger text-white" @click="destroy(domain)">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
                <tr v-if="content.length === 0">
                  <td colspan="4">{{ __('domain_not_found') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          <pagination v-show="domains.links" :links="domains.links" />
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
    domains: {
      type: [Object, Array],
      default: () => [],
    },
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
  computed: {
    content: function () {
      if (Array.isArray(this.domains )) {
        console.log(this.domains);
        return this.domains;
      }
      return this.domains.data;
    },
  },
  watch: {
    form: {
      handler: throttle(function () {
        let query = pickBy(this.form);
        this.$inertia.replace(
          this.route("domains.index", Object.keys(query).length ? query : {})
        );
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    destroy(domain) {
      if (confirm(this.__("delete_domain"))) {
        this.$inertia.delete(this.route("domains.destroy", domain.id));
      }
    },
  },
};
</script>
