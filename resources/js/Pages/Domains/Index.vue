<template>
  <div class="row">
    <div class="col-12">
      <data-table :fields="fields" :api-url="route('domains.index').url()" :info-template="infoTemplate">
        <template v-slot:append="props">
          <a class="btn btn-primary" :href="route('domains.export', props.data.form)">
            {{ __("export") }}
          </a>
          <inertia-link class="btn btn-primary" :href="route('domains.create')">
            <span class="d-none d-md-inline-block">{{
              __("create_domain")
            }}</span>
            <span class="d-md-none">{{ __("create") }}</span>
          </inertia-link>
        </template>
        <template v-slot:name="props">
          <a name="name" :href="urlTransform(props.rowData.name)" target="_blank">{{
            props.rowData.name
          }}</a>
        </template>
        <template v-slot:usage="props">
          <slot name="usage">{{ props.rowData.usage }}%</slot>
        </template>
        <template v-slot:backup="props">
          <slot name="usage">{{ props.rowData.backup?'Y':'N' }}</slot>
        </template>
        <template v-slot:http_status_code="props">
          <span
            name="http_status_code"
            :class="getStatusClass(props.rowData.http_status_code)"
            >{{ props.rowData.http_status_code }}</span
          >
        </template>
        <template v-slot:actions="props">
          <a
            class="btn btn-sm btn-info text-white"
            :href="route(`domains.edit`, props.rowData.id)"
          >
            <i class="fas fa-edit" />
          </a>
          <button
            class="btn btn-sm btn-danger text-white"
            @click="
              destroy(
                __('delete_domain'),
                route('domains.destroy', props.rowData.id)
              )
            "
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
  data(){
    return {
      infoTemplate: "Total: {total}, Problem: <span class='text-danger'>{problem}</span>",
    }
  },
  methods: {

  },
};
</script>
