<template>
  <k-field :disabled="disabled" :label="label" :name="name" :required="required" :type="type" class="k-table-field" v-bind="$props">
    <div class="table-field field field-name" v-cloak data-field='table'>
      <!-- Column Controls -->
      <div class="table-ctrl">
        <div class="row-cell column-ctrl" v-for="n in columnCount">
          <div class="centering">
            <k-button icon="angle-left" v-bind:class="{ disabled: n == 1 }" @click="moveColumn(n-1, 'left')"></k-button>
            <k-button icon="remove" v-bind:class="{ disabled: columnCount <= minColumns }" @click="deleteColumn(n)"></k-button>
            <k-button icon="angle-right" v-bind:class="{ disabled: n == columnCount }"  @click="moveColumn(n-1, 'right')"></k-button>
          </div>
        </div>
        <div class="row-ctrl add-column">
          <k-button icon="add" v-bind:class="{ disabled: columnCount >= maxColumns }" @click="addColumn()"></k-button>
        </div>
      </div>
      <!-- Table Body -->
      <div class="table-container">
        <!-- Row -->
        <div class="table-row" v-for="(row, rowIndex) in value">
          <div class="row-ctrl move-row">
            <k-button icon="angle-up" v-bind:class="{ disabled: rowIndex == 0 }" @click="moveRow(rowIndex, 'up')"></k-button>
            <k-button icon="angle-down" v-bind:class="{ disabled: rowIndex == rowCount-1 }" @click="moveRow(rowIndex,	'down')"></k-button>
          </div>
          <input class="row-cell input" :name="'name[table]['+ rowIndex +']'" v-model="row[cellIndex]" v-on:change="updateTable()" v-for="(cell, cellIndex) in row" />
          <div class="row-ctrl delete-row">
            <k-button icon="remove" @click="deleteRow(rowIndex)" v-show="rowCount > 1"></k-button>
          </div>
        </div>
      </div>
      <!-- Add Row Btn-->
      <div class="table-add-row">
        <div class="row-cell">
          <k-button icon="add" @click="addRow()">Add</k-button>
        </div>
      </div>
    </div>
  </k-field>
</template>

<script>
  import _ from '../assets/js/lodash.js'
  export default {
    props: {
      minColumns: Number,
      maxColumns: Number,

      // general options
      label: String,
      disabled: Boolean,
      help: String,
      parent: String,
      value: Array,
      name: [String, Number],
      required: Boolean,
      type: String
    },
    created: function () {
      this.value = this.getData(this.value, [_.fill(Array(this.minColumns), '')]);
    },
    data: {
      minColumns: 0,
      maxColumns: 0
    },
    computed: {
      columnCount: function () {
        return this.value[0].length;
      },
      rowCount: function () {
        return this.value.length;
      }
    },
    methods: {
      getData: function (value, defaultValues) {
        if (_.isEmpty(value)) {
          value = defaultValues;
        } else {
          // Maybe a kirby bug has to parse markdown to array manually (just sometimes)
          if(typeof value === 'string'){
            let spittedString = value.split("\n"); 
            const selfmadeValue = [];
            let row = [];
            spittedString.forEach((val) => {
              if(val == '- '){
                if(row.length > 0){
                  selfmadeValue.push(row);
                }
                row = [];
              } else {
                row.push(val.split("- ").pop());
              }
            });
            selfmadeValue.push(row);
            value = selfmadeValue;
          }
        }
        return value;
      },
      addRow: function () {
        // Pushes an array of length columnCount filled with ''
        this.value.push(_.fill(Array(this.columnCount), ''));
        this.updateTable();
      },
      deleteRow: function (rowNum) {
        this.value.splice(rowNum, 1);
        this.updateTable();
      },
      moveRow: function (rowIndex, direction) {
        if (direction == 'up') {
          direction = -1;
        } else if (direction == 'down') {
          direction = 1;
        } else {
          console.error('Wrong direction!')
        }

        if (!((rowIndex == 0 && direction == -1) || ((rowIndex == (this.rowCount - 1)) && direction == 1))) {
          var changing = this.value[rowIndex];
          this.value.splice(rowIndex, 1);
          this.value.splice(rowIndex + direction, 0, changing);
        }
        this.updateTable();
      },
      addColumn: function () {
        _.forEach(this.value, function (value) {
          value.push("");
        });
        this.updateTable();
      },
      deleteColumn: function (colNum) {
        _.forEach(this.value, function (value) {
          value.splice(colNum - 1, 1);
        });
        this.updateTable();
      },
      moveColumn: function (colNum, direction) {
        if (direction == 'left') {
          direction = -1;
        } else if (direction == 'right') {
          direction = 1;
        } else {
          console.error('Wrong direction!');
        }
        if (!((colNum == 0 && direction == -1) || ((colNum + 1 == this.columnCount) && direction == 1))) {
          _.forEach(this.value, function (value) {
            value.splice(colNum + direction, 0, value.splice(colNum, 1)[0]);
          });
        }
        this.updateTable();
      },
      updateTable: function () {
        this.$emit("input", this.value);
      }
    }
  };
</script>

<style lang="scss">
  @import '../assets/scss/index.scss'
</style>