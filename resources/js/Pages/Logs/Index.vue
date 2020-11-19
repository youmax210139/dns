<template>
  <div class="row">
    <div class="col-2 mb-3">
      <div class="card">
        <div class="list-group div-scroll">
          <a
            v-for="file in files"
            :key="file.name"
            :class="{ 'llv-active': current_file.name == file.name }"
            :href="`?l=${file.encrypted}`"
            class="list-group-item"
          >
            {{ file.name }}
          </a>
        </div>
      </div>
    </div>
    <div class="col-10">
      <data-table
        ref="logDataTable"
        :fields="fields"
        :api-url="route('logs.index').url()"
        :filters="filters"
        :table-header-class="'text-center font-bold'"
        @vuetable:row-clicked="rowClicked"
      >
        <template v-slot:header="props">
          <div class="row">
            <div class="col-6">
              <form class="form" style="margin: 10px 0">
                <div class="form-group">
                  <input
                    class="form-control"
                    autocomplete="off"
                    type="text"
                    name="search"
                    placeholder="Search…"
                    v-model="form.search"
                  />
                </div>
              </form>
            </div>
            <div class="col-6 text-right">
              <a href="" class="btn btn-primary">
                <span class="fa fa-download" />
                Download file
              </a>
              <a id="delete-log" href="" class="btn btn-primary">
                <span class="fa fa-trash" />
                Delete file
              </a>
            </div>
          </div>
        </template>
        <template v-slot:level="props">
          <span class="capitalize" :class="props.rowData.level_class">
            <span
              class="fa"
              :class="`fa-${props.rowData.level_img}`"
              aria-hidden="true"
            />
            &nbsp;&nbsp;
            {{ props.rowData.level_name }}
          </span>
        </template>
        <template v-slot:date="props">
          <span class="date">
            {{ props.rowData.date }}
          </span>
        </template>
        <template v-slot:content="props">
          <button
            v-if="props.rowData.stack"
            type="button"
            class="float-right expand btn btn-info btn-sm mb-2 ml-2"
            :data-display="`stack${props.rowIndex}`"
          >
            <span class="fa fa-search" />
          </button>
          {{ props.rowData.text }}
          <template v-if="props.rowData.in_file">
            <br />
            {{ props.rowData.in_file }}
          </template>
          <div
            v-if="props.rowData.stack"
            :id="`stack${props.rowIndex}`"
            class="stack"
            style="display: none; white-space: pre"
          >
            {{ props.rowData.stack.trim() }}
          </div>
        </template>
      </data-table>
    </div>
  </div>
</template>

<script>
import DataTable from "@/Shared/Tables/DataTable";
import throttle from "lodash/throttle";

export default {
  components: {
    DataTable,
  },
  props: {
    filters: Object,
    fields: Array,
    files: Array,
    current_file: Object,
  },
  data() {
    return {
      form: this.filters,
    };
  },
  watch: {
    form: {
      handler: throttle(function () {
        this.$nextTick(() => this.$refs.logDataTable.refresh());
      }, 150),
      deep: true,
    },
  },
  mounted() {
    $(".table-container tr").on("click", function () {
      console.log("#" + $(this).data("display"));
    });

    $("#delete-log, #clean-log, #delete-all-log").click(function () {
      return confirm("Are you sure?");
    });
  },

  methods: {
    rowClicked(data) {
      let ref = `#stack${data.index}`;
      $(ref).toggle();
    },
  },
};
</script>

<style scoped>
body {
  padding: 25px;
}
h1 {
  font-size: 1.5em;
  margin-top: 0;
}
#table-log {
  font-size: 0.85rem;
}
.sidebar {
  font-size: 0.85rem;
  line-height: 1;
}
.btn {
  font-size: 0.7rem;
}
.stack {
  font-size: 0.85em;
}
.date {
  min-width: 75px;
}
.text {
  word-break: break-all;
}
a.llv-active {
  z-index: 2;
  background-color: #f5f5f5;
  border-color: inherit;
  border-radius: unset;
}
.list-group-item {
  word-break: break-word;
  font-size: 1rem;
}
.div-scroll {
  height: 80vh;
  overflow: hidden auto;
}
.nowrap {
  white-space: nowrap;
}
.capitalize {
  text-transform: capitalize;
}
.date {
  font-size: 1rem;
}
</style>