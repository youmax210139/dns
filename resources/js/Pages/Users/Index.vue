<template>
  <div class="row">
    <div class="col-12">
      <data-table :fields="fields" :api-url="route('users.index').url()" ref="userDataTable">
        <template v-slot:append="props">
          <inertia-link
            class="btn btn-primary"
            :href="route('users.create')"
          >
            <span class="d-none d-md-inline-block">{{
              __("users.create")
            }}</span>
            <span class="d-md-none">{{ __("create") }}</span>
          </inertia-link>
        </template>
        <template v-slot:actions="props">
          <a
            v-if="props.rowData.deleted_at == null"
            class="btn btn-sm btn-info text-white"
            :href="route(`users.edit`, props.rowData.id)"
          >
            <i class="fas fa-edit" />
          </a>
          <button
            v-else
            class="btn btn-sm btn-success text-white"
            @click="
              alert(
                __('restore', {name: __('user')}),
                route('users.restore', props.rowData.id),
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
                __('delete', {name: __('user')}),
                route('users.destroy', props.rowData.id),
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
      this.$refs.userDataTable.reload();
      this.$toasted.success(this.__("delete_success", {name: this.__('user')}));
    },
    onRestoreSuccess(res) {
      this.$refs.userDataTable.reload();
      this.$toasted.success(this.__("restore_success", {name: this.__('user')}));
    },
  },
};
</script>
