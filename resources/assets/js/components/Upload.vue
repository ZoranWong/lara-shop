<template>
  <div>
    <div v-if="type === 'image'" class="img-wrap">
      <div class="img-box" v-on:click="upload()">
        <i v-if="fthumb == ''" class="icon_thumb"></i>
        <img v-else v-bind:src="fthumb">
      </div>
      <input type="text" style="display: none;" :name="name" v-model="fthumb">
    </div>
    <div v-else class="showInput">
      <input type="text" v-model="fthumb" :name="name" v-on:click="upload()">
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      thumb: ''
    }
  },
  props: {
    url: {
      required: true
    },
    name: {
      default: 'thumb'
    },
    xthumb: {
      default: false
    },
    type: {
      default: 'image'
    }
  },
  mounted() {
    window.upload = window.upload || {};
    window.upload[this.name] = this;
  },
  computed: {
    fthumb () {
        return this.xthumb === false ? this.thumb : this.xthumb;
    }
  },
  methods: {
    upload() {
      var that = this;
      bootbox.dialog({
        title: '上传文件',
        message: '<div class="dropzone" id="myDrop"></div>'
      });
      var myDrop = new Dropzone('#myDrop',{
        url: that.url,
        paramName: that.type,
        dictDefaultMessage: '点击上传文件<br />或将文件拖到这里',
        maxFiles: 1,
        addRemoveLinks: true,
        dictResponseError: '错误'
      });
      myDrop.on('success',function(file,info){
        that.thumb = info.data;
        that.xthumb = false;
        bootbox.hideAll();
        that.$emit('upload',that.thumb);
      });
    }
  },
};
</script>

<style scoped>
  .icon_thumb{
    width: 44px;
    height: 34px;
    vertical-align: middle;
    display: inline-block;
    line-height: 300px;
    overflow: hidden;
    background: url(/images/wechat_media.png) 0 -88px no-repeat;
  }
  .img-box{
      width: 120px;
      background-color: #ececec;
      font-size: 14px;
      line-height: 120px;
      text-align: center;
      cursor: pointer;
    }
  .img-box img{
    width: 120px;
    height: 120px;
  }
  .img-wrap{
    border: 1px solid #e0e0eb;
    padding: 5px;
    width: 132px;
  }
  .showInput input{
    width: 100%;
  }
</style>