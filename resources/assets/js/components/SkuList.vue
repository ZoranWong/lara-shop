<template>
  <div class="spec-list">
      <el-popover
        ref="pop"
        placement="bottom"
        width="200"
        v-model="visible">
        <div style="text-align: right; margin-bottom: 10px">
          <el-button size="mini" type="text" @click="cancelPop">取消</el-button>
          <el-button type="primary" size="mini" @click="submitPop">确定</el-button>
        </div>
        <el-select
          v-model="selectItemList"
          default-first-option
          multiple
          filterable
          allow-create
          placeholder="请选择">
          <el-option
            v-for="item in selectableList"
            :key="item.name"
            :value="item.name">
          </el-option>
        </el-select>
      </el-popover>
      <el-tag style="margin-right: 10px" v-for="(item, index) in spec.value" :key="index" :closable="true" type="gray" @close="removeItem(index)">
      {{item}}
      </el-tag>
      <el-button size="mini" type="text" v-popover:pop>+新增</el-button>
  </div>
</template>
<script>
  import _ from 'underscore'
  import {Select, Button, Popover, Tag} from 'element-ui'
  export default{
    components: {
      ElSelect: Select,
      ElButton: Button,
      ElPopover: Popover,
      ElTag: Tag
    },
    props: {
      spec: {
        type: Object,
        default: {}
      },
      // 可供选择的规格
      optionList: {
        type: Array,
        default: []
      }
    },
    computed: {
      // 可供选择的规则子选项
      selectableList () {
        var res = []
        var self = this
        this.optionList.forEach(function (item) {
          if (item.name === self.spec.name) {
            res = item.value
          }
        })
        return res
      }
    },
    data () {
      return {
        visible: false,
        // pop中已选择的规格子类
        selectItemList: []
      }
    },
    methods: {
      cancelPop () {
        this.visible = false
        this.selectItemList = []
      },
      submitPop () {
        var self = this
        // 过滤掉重复的规格
        this.selectItemList = this.selectItemList.filter(function(item){
          return self.spec.value.indexOf(item) === -1
        })
        this.visible = false
        this.spec.value = this.spec.value.concat(this.selectItemList)
        this.selectItemList = []
        this.$emit('updateSpec', this.spec)
      },
      removeItem (index) {
        this.spec.value.splice(index, 1)
        this.$emit('updateSpec', this.spec)
      }
    }
  }
</script>