<template>
  <div>
  <el-table :data="tableData" style="width: 100%">
    <el-table-column v-for="item in skuTree" :prop="item.id.toString()" :label="item.name">
    </el-table-column>
    <el-table-column v-if="type === 1" label="价格（元）" width="180">
      <template scope="scope">
        <input v-model="scope.row.sell_price" class="form-control" type="number"></input>
      </template>
    </el-table-column>
    <el-table-column v-if="type === 1" prop="stock_num" label="库存" width="180">
      <template scope="scope">
        <input v-model="scope.row.stock_num" class="form-control" type="number"></input>
      </template>
    </el-table-column>
    <el-table-column v-if="type === 1" prop="products_no" label="商家编码">
      <template scope="scope">
        <input v-model="scope.row.products_no" class="form-control"></input>
      </template>
    </el-table-column>
    <el-table-column v-if="type === 1" prop="market_price" label="成本价">
      <template scope="scope">
        <input v-model="scope.row.market_price" class="form-control" type="number"></input>
      </template>
    </el-table-column>
    <el-table-column v-if="type === 2" prop="weight" label="重量Kg">
      <template scope="scope">
        <input v-model="scope.row.weight" class="form-control" type="number" min="0.000" step="0.001"></input>
      </template>
    </el-table-column>
  </el-table>
  <!-- <input type="text" name="products" v-model="productsData" style="display: none"> -->
  </div>
</template>
<script>
    import _ from 'underscore';
    import {Table, Input} from 'element-ui';
    export default{
      components: {
        ElTable: Table,
        ElInput: Input
      },
      watch: {
        productsData: {
          handler: function(){
            this.$emit('updateTableData', this.productsData);
          },
          deep: true
        }
      },
      props: {
        type: {
          type: Number,
          default: 1
        },
        skuTree: {
          type: Array,
          default: []
        },
        tableData: {
          type: Array,
          default: []
        }
      },
      created(){
        this.$emit('updateTableData', this.productsData);
      },
      computed: {
        productsData () {
          let self = this;
          let params = ['sell_price', 'stock_num', 'products_no', 'market_price'];
          let res = this.tableData.map(function(item){
            let specData = _.omit(item, ...params);
            item.spec_array = self.formatSpecArray(specData);
            return _.pick(item, 'spec_array', ...params);
          });
          return res;
        },
      },
      methods: {
        formatSpecArray (specData) {
          let obj = {};
          this.skuTree.forEach(function(item){
            obj[item.id] = _.clone(item);
            obj[item.id].value = specData ? specData[item.id] : '';
            obj[item.id].tip = specData ? specData[item.id] : '';
          });
          return obj;
        }
      }
    }
</script>
