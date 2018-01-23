<template>
  <div>
    <div class="sku">
      <div v-for="spec in skuTree" class="sku-group">
        <!-- 标题 -->
        <h3 class="group-name">
          <el-select v-model="spec.id" @change="specChange" 
          allow-create filterable default-first-option>
            <el-option v-for="item in defaultSku" :value="item.id" :label="item.name"></el-option>
          </el-select>
          <span class="group-remove" @click="removeSpec(spec)">
            ×
          </span>
        </h3>
        <!-- 子类 -->
        <div class="group-container">
          <div class="sku-list">
            <sku-list :spec="spec" :optionList="defaultSku" v-on:updateSpec="updateSpec"></sku-list>
          </div>
        </div>
      </div>
      <div v-if="skuTree.length < specMax">
        <el-button @click="addSpec">添加规格项目</el-button>
      </div>
    </div>
  </div>
</template>
<script>
  import _ from 'underscore';
  import {Select, Button, Popover} from 'element-ui';
  import 'element-ui/lib/theme-default/index.css';
  import SkuList from './SkuList';
  export default{
    components: {
      ElSelect: Select,
      ElButton: Button,
      ElPopover: Popover,
      SkuList: SkuList
    },
    props: {
      goodsId: 0
    },
    data () {
      return {
        skuTree: [], // 用户已选的规格
        specMax: 3,  // 规格数量的最大值
        tableData: [], // 渲染表格数据的数据
        products: []
      }
    },
    // 获取店铺内已有的规格
    created() {
      let self = this;
      this.getAllSpec(function(defaultSku){
        self.defaultSku = defaultSku;
        if (self.goodsId) {
          self.getGoodsSpec();
        }
      })
    },
    // 监听skutree的变化，计算笛卡尔积，生成tableData
    watch: {
      skuTree: {
        handler: function(){
          let arr = this.skuTree.filter(function(item){
            return item.name && item.value.length > 0;
          }).map(function(item){
            return item.value.map(function(spec){
              let obj = {};
              obj[item.id] = spec;
              return obj;
            });
          });
          let params = ['sell_price', 'stock_num', 'products_no', 'market_price'];
          this.tableData = this.createTableData(arr, params);
          this.$emit('updateSku', [this.tableData, this.skuTree]);
        },
        deep: true
      }
    },
    methods: {
      // 序列化sku,生成tableData
      // params sku的参数
      createTableData (arr, params) {
        let table = [], self = this;
        if (arr.length > 0) {
          table = this.cartesian(arr).map(function(item){
            let obj = {};
            params.forEach(function (param) {
              obj[param] = 0;
            });
            item.forEach(function(spec){
                _.each(spec, function (value, index) {
                   obj[index] = value;
                });
            });
            for (let i = 0; i < self.tableData.length; i++) {
              let omitData = _.omit(self.tableData[i], 'spec_array', ...params);
              let omiObj = _.omit(obj, 'spec_array', ...params);
              if (_.isEqual(omitData, omiObj)) {
                obj = self.tableData[i];
                break;
              }
            }
            return obj;
          });
        }
        return table;
      },
      // 远程更新规格属性
      remoteUpdateSpec (spec) {
        let modelSku = this.findForId(spec.id, this.defaultSku);
        let modelSkuV = modelSku.value.map(function(item){
          return item.name;
        });
        let unionValue = _.union(modelSkuV, spec.value);
        if (unionValue.length === modelSkuV.length) {
          return;
        }
        modelSku.value = unionValue.map(function(item){
          return {
            name: item
          };
        });
        let newSpecValue = {};
        unionValue.forEach(function(item){
          newSpecValue[item] = item;
        });
        let newSpec = {
          id: modelSku.id,
          name: modelSku.name,
          type: 1,
          value: newSpecValue
        };
        this.$http.put(this.url + '/' + newSpec.id, newSpec)
            .then(function(res){

            });
      },
      // 新建规格
      createdSpec (id, callback) {
        let data = {
          name: id,
          value: '{}',
          type: 1,
          note: id
        };
        this.$http.post(this.url, data).then(function (res) {
          callback(res.data.data);
        });
      },
      // 获取所有规格
      getAllSpec (callback) {
        this.$http.get(this.url).then(function (res) {
          let defaultSku = res.data.data.map(item => {
            let arr = [];
            if (item.value instanceof Object) {
                _.each(item.value, function (value, index) {
                    arr.push({
                        name: value
                    });
                });
            }
            item.value = arr;
            return item;
          });
          callback(defaultSku)
        })
      },
      // 已有商品的规格获取
      getGoodsSpec (callback) {
        let self = this;
        let  url = '/ajax/merchandise/' + this.goodsId + '/specification';
        this.$http.get(url).then(function (res) {
          let data = res.data.data;
          if (data.length === 0) {
            return;
          }
          self.tableData = data.map(function(item){
            let productObj = {
              sell_price: item.sell_price,
              stock_num: item.stock_num,
              products_no: item.products_no,
              market_price: item.market_price,
            };
            item.spec_array.forEach(function(spec){
              productObj[spec.id] = spec.value
            });
            return productObj;
          });
          let productList = self.deepCopy(data);
          let tempList = [];
          productList.forEach(function (productItem) {
            if (tempList.length === 0) {
              tempList = tempList.concat(productItem.map(function (spec) {
                spec.value = [spec.value];
                return spec;
              }));
            } else {
              tempList = tempList.map(function (tempItem) {
                productItem.forEach(function (spec) {
                  if (spec.id === tempItem.id) {
                    tempItem.value.push(spec.value);
                  }
                });
                return tempItem;
              });
            }
          });
          self.skuTree = tempList.map(function(item){
            item.value = _.uniq(item.value);
            return item;
          })
        })
      },
      // 增加规格
      addSpec () {
        this.skuTree.push({id: '', name: '', value: []});
      },
      // 规格重复性验证
      specChange (id) {
        let self = this;
        if (id && (typeof(id) !== 'number')) {
          this.createdSpec(id, function(res){
            let currentSku = self.findForId(id, self.skuTree);
            res.value = [];
            self.defaultSku.push(res);
            currentSku.id = res.id;
          });
          return;
        }
        let modelSku = this.findForId(id, this.defaultSku);
        let repeat = this.skuTree.filter(function(item){
          return item.id === id;
        }).length > 1;

        if (repeat) {
          this.skuTree = this.skuTree.map(function(item){
            if (!item.name) {
              item.id = '';
            }
            if (item.id === id && item.name !== modelSku.name && modelSku) {
              let oldModelSku = self.findForName(item.name, self.defaultSku);
              item.id = oldModelSku.id;
            }
            return item;
          });
          alert('规格重复');
          return;
        }
          // 找到这个sku
          let currentSku = this.findForId(id, this.skuTree);
          currentSku.name = modelSku ? modelSku.name : id;
          currentSku.value = [];
      },
      // 移除规格
      removeSpec (spec) {
        this.skuTree.splice(this.skuTree.indexOf(spec),1);
      },
      // 更新规格子类
      updateSpec (spec) {
        this.remoteUpdateSpec(spec);
        this.skuTree = this.skuTree.map(function (item) {
          if (item.name === spec.name) {
            item.value = spec.value;
          }
          return item;
        });
      },

//-------计算方法--------//
      findForId (id, arr) {
        for (let i = 0; i < arr.length; i++) {
          if (arr[i].id === id) {
            return arr[i];
          }
        }
        return false;
      },
      findForName (name, arr) {
        for (let i = 0; i < arr.length; i++) {
          if (arr[i].name === name) {
            return arr[i];
          }
        }
        return false;
      },
      deepCopy (data) {
        let specList = [];
        for (let i = 0; i < data.length; i++) {
          let arr = data[i].spec_array;
          let arrCopy = [];
          for (let j = 0; j < arr.length; j++) {
            let item = {};
            item.id = arr[j].id;
            item.name = arr[j].name;
            item.tip = arr[j].tip;
            item.value = arr[j].value;
            arrCopy.push(item);
          }
          specList.push(arrCopy);
        }
        return specList;
      },
      cartesian (elements) {
          if (!Array.isArray(elements))
              throw new TypeError();
          let end = elements.length - 1,
              result = []; 
          function addTo(curr, start) {
              let first = elements[start],
                  last = (start === end);
              for (let i = 0; i < first.length; ++i) {
                  let copy = curr.slice();
                  copy.push(first[i]);
                  if (last) {
                      result.push(copy);
                  } else {
                      addTo(copy, start + 1);
                  }
              }
          }

          if (elements.length)
              addTo([], 0);
          else
              result.push([]);
          return result;
      }
    }
  }
</script>
<style>
  .sku {
    background-color: #fff;
    padding: 10px;
    border: 1px solid #e5e5e5;
  }

  .sku-pop {
    z-index: 1;
  }

  .sku-group {
    position: relative;
  }

  .sku-group:hover .group-remove {
    display: block;
  }

  .sku-group .group-name {
    position: relative;
    padding: 7px 10px;
    margin: 0;
    color: #666;
    background-color: #f8f8f8;
    font-size: 12px;
    line-height: 16px;
    font-weight: normal;
  }

  .sku-group .group-remove {
    display: none;
    position: absolute;
    top: 12px;
    right: 10px;
    color: #fff;
    text-align: center;
    cursor: pointer;
    width: 18px;
    height: 18px;
    font-size: 14px;
    line-height: 16px;
    background: rgba(153, 153, 153, 0.6);
    border-radius: 10px;
    text-indent: 0;
  }

  .sku-group .sku-group-cont {
    padding: 0 10px;
    margin-bottom: 10px;
  }

  .sku-group .sku-group-cont .help-block {
    line-height: 14px;
    font-size: 12px;
    margin-top: 6px;
    margin-bottom: 0;
  }
  .sku-group .sku-group-cont ul li {
    font-size: 12px;
    line-height: 12px;
  }

  .sku-group .sku-group-cont:empty {
    margin-top: 0 !important;
  }

  .sku-group h4 {
    font-size: 12px;
    font-weight: bold;
    margin: 0;
  }

  .sku-group .addImg-radio {
    display: inline-block;
    margin: 3px 0 0 30px;
  }

  .sku-group .addImg-radio input {
    vertical-align: 0;
    margin-right: 6px;
  }

  .sku-group .group-container {
    color: #666;
    padding: 10px;
    margin-bottom: 10px;
  }

  .sku-group .group-container .zent-sku-pop {
    margin: 0;
  }

  .sku-group .sku-list ul>li {
    float: left;
    width: 20%;
    text-align: left;
  }

  .sku-group .sku-add {
    display: inline-block;
    padding: 0 5px;
    margin: 9px 5px 0;
    vertical-align: top;
    font-size: 12px;
    color: #38f;
    text-decoration: none;
    cursor: pointer;
  }

  .sku-group .zent-sku-pop {
    cursor: pointer;
    font-size: 12px;
    display: inline-block;
    padding: 0 5px;
    margin: 9px 5px 0;
    vertical-align: top;
  }

  .sku-group .c-color-0 {
    color: #333;
  }

  .sku-group .c-color-1 {
    color: #999;
  }

  .sku-group .c-color-2 {
    color: #656565;
  }

  .sku-group .c-color-3 {
    color: #ac6100;
  }

  .sku-group .c-color-4 {
    color: #da0000;
  }

  .sku-group .c-color-5 {
    color: #fe6b00;
  }

  .sku-group .c-color-6 {
    color: #cdcb00;
  }

  .sku-group .c-color-7 {
    color: #bf00cc;
  }

  .sku-group .c-color-8 {
    color: #0036d2;
  }

  .sku-group .c-color-9 {
    color: #1ea100;
  }

  .zent-sku-item {
    background-color: #f8f8f8;
    padding: 5px;
    display: inline-block;
    margin-right: 10px;
    margin-bottom: 5px;
    margin-top: 5px;
    width: 80px;
    vertical-align: middle;
    text-align: center;
    position: relative;
    border-radius: 2px;
    cursor: pointer;
  }
  .zent-sku-item span {
    display: block;
    width: 74px;
    margin: 0 auto;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .zent-sku-item .item-remove {
    position: absolute;
    z-index: 2;
    top: -9px;
    right: -9px;
    width: 20px;
    height: 20px;
    font-size: 16px;
    line-height: 18px;
    color: #fff;
    text-align: center;
    cursor: pointer;
    background: rgba(153, 153, 153, 0.6);
    border-radius: 10px;
  }
  .zent-sku-item .item-remove:hover {
    color: #fff;
    background: #000;
  }

  .zent-sku-item .item-remove.small {
    top: -8px;
    right: -8px;
    width: 18px;
    height: 18px;
    font-size: 14px;
    line-height: 16px;
    border-radius: 9px;
  }

  .zent-sku-item .item-remove .item-remove {
    display: none;
  }

  .zent-sku-item:hover .item-remove {
      display: block;
  }

  .zent-sku-item.active {
    margin-bottom: 100px;
  }

  .zent-sku-item .upload-img-wrap {
    position: absolute;
    top: 36px;
    left: 0;
    padding: 2px;
    width: 84px;
    background: #fff;
    border-radius: 4px;
    border: 1px solid #dcdcdc;
  }

  .zent-sku-item .upload-img-wrap img {
    width: 100%;
    height: 100%;
    cursor: pointer;
  }

  .zent-sku-item .upload-img-wrap .add-image,
  .zent-sku-item .upload-img-wrap .zent-upload-trigger {
    width: 84px;
    height: 84px;
    line-height: 84px;
    text-align: center;
    background: #fff;
    font-size: 30px;
    color: #e5e5e5;
    cursor: pointer;
    border: 0;
  }

  .zent-sku-item .upload-img-wrap .upload-img{
    position: relative;
    width: 84px;
    height: 84px;
  }

  .zent-sku-item .upload-img-wrap .upload-img:hover .item-remove {
    display: inline;
  }

  .zent-sku-item .upload-img-wrap .upload-img:hover.img-edit {
    display: block;
  }

  .zent-sku-item .upload-img-wrap .arrow{
    position: absolute;
    width: 0;
    height: 0;
    top: -5px;
    left: 44%;
    border-style: solid;
    border-color: transparent;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-bottom: 5px solid #000;
  }

  .zent-sku-item .upload-img-wrap .arrow:after {
    position: absolute;
    display: block;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    top: 0;
    margin-left: -10px;
    border-bottom-color: #fff;
    border-width: 10px;
    border-top-width: 0;
    content: "";
  }

  .zent-sku-item .upload-img-wrap .img-edit {
    cursor: pointer;
    display: none;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    color: rgb(255, 255, 255);
    opacity: 0.5;
    background: rgb(0, 0, 0);
  }
</style>
