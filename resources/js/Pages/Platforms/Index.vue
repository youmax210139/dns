<template>
  <div class="row">
    <div class="col-12">
            <data-table :fields="fields" :api-url="route('platforms.index').url()">
        <template v-slot:append="props">
          <a class="btn btn-primary" :href="route('platforms.export', props.data.form)">
            {{ __("export") }}
          </a>
          <inertia-link class="btn btn-primary" :href="route('platforms.create')">
              <span class="d-none d-md-inline-block">{{ __('create_platform') }}</span>
              <span class="d-md-none">{{ __('create') }}</span>
            </inertia-link>
        </template>
        <template v-slot:actions="props">
          <a class="btn btn-sm btn-info text-white" :href="route(`platforms.edit`, props.rowData.id)">
            <i class="fas fa-edit" />
          </a>
          <button
            class="btn btn-sm btn-danger text-white"
            @click="destroy(__('delete_platform'), route('platforms.destroy', props.rowData.id))"
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
  methods: {
  },
};
</script>
