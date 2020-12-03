<template>
  <div class="row">
    <div class="col-12">
      <data-table
        :fields="fields"
        :api-url="route('domains.index').url()"
        :info-template="infoTemplate"
        ref="domainDataTable"
      >
        <template v-slot:append="props">
          <a
            class="btn btn-primary"
            :href="route('domains.export', props.data.form)"
          >
            {{ __("export") }}
          </a>
          <inertia-link class="btn btn-primary" :href="route('domains.create')">
            <span class="d-none d-md-inline-block">{{
              __("domains.create")
            }}</span>
            <span class="d-md-none">{{ __("create") }}</span>
          </inertia-link>
        </template>
        <template v-slot:name="props">
          <a
            name="name"
            :href="urlTransform(props.rowData.name)"
            target="_blank"
            >{{ props.rowData.name }}</a
          >
        </template>
        <template v-slot:protocols="props">
          <span
            v-for="(protocol,index) in props.rowData.protocols"
            :key="index"
            class="badge badge-info"
          >
            {{ protocol }}
          </span>
        </template>
        <template v-slot:usage="props">
          <slot name="usage">{{ props.rowData.usage }}%</slot>
        </template>
        <template v-slot:backup="props">
          <slot name="usage">{{ props.rowData.backup ? "Y" : "N" }}</slot>
        </template>
        <template v-slot:enable="props">
          <slot name="enable">
            <toggle-button
              :value="props.rowData.enable"
              :sync="true"
              @change="enable(props.rowData)"
            />
          </slot>
        </template>
        <template v-slot:status_code="props">
          <span
            v-for="(protocol,_) in props.rowData.protocols"
            :key="protocol"
            :class="`badge-`+getStatusClass(props.rowData.status_code[protocol])"
            class="badge"
            >{{ props.rowData.status_code[protocol] }}</span
          >
        </template>
        <template v-slot:actions="props">
          <a
            v-if="props.rowData.deleted_at == null"
            class="btn btn-sm btn-info text-white"
            :href="route(`domains.edit`, props.rowData.id)"
          >
            <i class="fas fa-edit" />
          </a>
          <button
            v-else
            class="btn btn-sm btn-success text-white"
            @click="
              alert(
                __('restore', { name: __('domain') }),
                route('domains.restore', props.rowData.id),
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
                __('delete', { name: __('domain') }),
                route('domains.destroy', props.rowData.id),
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
import { ToggleButton } from "vue-js-toggle-button";

export default {
  components: {
    DataTable,
    ToggleButton,
  },
  props: {
    filters: Object,
    fields: Array,
  },
  data() {
    return {
      infoTemplate:
        "Total: {total}, Problem: <span class='text-danger'>{problem}</span>",
    };
  },
  methods: {
    enable(rowData) {
      this.$http
        .put(route("domains.update", rowData.id), {
          enable: !rowData.enable,
          platform_id: -1,
        })
        .then((res) => {
          rowData.enable = res.data.enable;
          this.$toasted.success(
            this.__("edit_success", { name: this.__("domain") })
          );
        })
        .catch((err) => {
          console.error(err);
          this.$toasted.error(this.__("error"));
        });
    },
    onDestroySuccess(res) {
      this.$refs.domainDataTable.reload();
      this.$toasted.success(
        this.__("delete_success", { name: this.__("domain") })
      );
    },
    onRestoreSuccess(res) {
      this.$refs.domainDataTable.reload();
      this.$toasted.success(
        this.__("restore_success", { name: this.__("domain") })
      );
    },
  },
};
</script>
