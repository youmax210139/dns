<template>
  <div class="row">
    <div class="col-12">
      <data-table :fields="fields" :api-url="route('domains.index').url()">
        <template v-slot:append>
          <inertia-link class="btn btn-primary" :href="route('domains.create')">
              <span class="d-none d-md-inline-block">{{ __('create_domain') }}</span>
              <span class="d-md-none">{{ __('create') }}</span>
            </inertia-link>
        </template>
        <template v-slot:usage="props">
          <slot name="usage">{{ props.rowData.usage }}%</slot>
        </template>
        <template v-slot:backup="props">
          <slot name="backup">{{ props.rowData.backup ? 'Y' : 'N' }}</slot>
        </template>
        <template v-slot:http_status_code="props">
          <span
            name="http_status_code"
            :class="getStatusClass(props.rowData.http_status_code )"
          >{{ props.rowData.http_status_code }}</span>
        </template>
        <template v-slot:actions="props">
          <a class="btn btn-sm btn-info text-white" :href="route(`domains.edit`, props.rowData.id)">
            <i class="fas fa-edit" />
          </a>
          <button
            class="btn btn-sm btn-danger text-white"
            @click="destroy(__('delete_domain'), route('domains.destroy', props.rowData.id))"
          >
            <i class="fas fa-trash-alt" />
          </button>
        </template>
      </data-table>
    </div>
  </div>
</template>

<script>
import DataTable from "@/Shared/Tables/DataTable";

export default {
  components: {
    DataTable,
  },
  props: {
    filters: Object,
    fields: Array,
  },
  data() {
    return {};
  },
  created() {
    console.log(route("domains.index"));
  },
  methods: {
    getStatusClass(code) {
      if (code >= 200 && code < 300) {
        return { "text-success": true };
      } else if (code >= 300 && code < 400) {
        return { "text-info": true };
      } else if (code >= 400 && code < 500) {
        return { "text-danger": true };
      } else if (code >= 500 && code < 600) {
        return { "text-danger": true };
      } else {
        return {};
      }
    },
  },
};
</script>
