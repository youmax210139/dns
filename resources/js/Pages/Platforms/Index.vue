<template>
  <div class="row">
    <div class="col-12">
      <data-table :fields="fields" :api-url="route('platforms.index').url()" ref="platformDataTable">
        <template v-slot:append="props">
          <a
            class="btn btn-primary"
            :href="route('platforms.export', props.data.form)"
          >
            {{ __("export") }}
          </a>
          <inertia-link
            class="btn btn-primary"
            :href="route('platforms.create')"
          >
            <span class="d-none d-md-inline-block">{{
              __("platforms.create")
            }}</span>
            <span class="d-md-none">{{ __("create") }}</span>
          </inertia-link>
        </template>
        <template v-slot:actions="props">
          <a
            v-if="props.rowData.deleted_at == null"
            class="btn btn-sm btn-info text-white"
            :href="route(`platforms.edit`, props.rowData.id)"
          >
            <i class="fas fa-edit" />
          </a>
          <button
            v-else
            class="btn btn-sm btn-success text-white"
            @click="
              alert(
                __('restore', {name: __('platform')}),
                route('platforms.restore', props.rowData.id),
                'put',
                onRestoreSuccess
              )
            "
          >
            <i class="fas fa-trash-restore" />
          </button>
          <button
            class="btn btn-sm btn-danger text-white"
            @click="
              alert(
                __('delete', {name: __('platform')}),
                route('platforms.destroy', props.rowData.id),
                'delete',
                onDestroySuccess
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
  methods: {
    onDestroySuccess(res) {
      this.$refs.platformDataTable.reload();
      this.$toasted.success(this.__("delete_success", {name: this.__('platform')}));
    },
    onRestoreSuccess(res) {
      this.$refs.platformDataTable.reload();
      this.$toasted.success(this.__("restore_success", {name: this.__('platform')}));
    },
  },
};
</script>
