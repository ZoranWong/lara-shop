/*
 * mengyuan 2017
 * Version: 0.0.1
 *
 */

 ;(function($,window,document,undefined){
      /*****定义Banner的构造函数******/
      //将变量定义到对象的属性上，函数变成对象的方法，使用时通过对象获取
      var InputList = function(ele,opt){
          this.$element = ele,           //获取到的jQuery对象console.log(this);
          this.index = 1;
          //设置默认参数
          this.defaults = { 
              'type': 'input',
              'data': {},
              'label': 'i'
          },
          this.options = $.extend({}, this.defaults, opt);
          //////定义全局变量
          var _ = this,
              $html = this.$element.html();
          ///////定义方法

          this.rander = function () {
             var group = this.createAddbtn();
             this.$element.append(group);
          }

          this.createAddbtn = function () {
            var group = $('<div></div>').addClass('form-group');
            var input = $('<div class="col-md-offset-2 col-md-5"></div>').append($('<div class="btn btn-default btn-block" id="add">增加</div>'));
            return group.append(input);
          }

          this.createInput = function (value) {
            var group = $('<div></div>').addClass('form-group');
            var label = $('<label class="col-sm-2 control-label">' + this.options.label.replace('i',this.index) + '</label>')
            var input = $('<div class="col-md-5"></div>');
            if($html){
              input.append($($html).val(value));
            }else{
              input.append($('<input class="form-control" />').val(value));
            }
            var btn = $('<div class="col-md-2"></div>').append($('<div class="btn btn-default del"><span aria-hidden="true">&times;</span></div>'));
            return group.append(label).append(input).append(btn);
          }

          this.addItem = function (element, value) {
            value = value || ''
            var group = this.createInput(value);
            $(element).parent().parent().before(group);
            this.index++;
            if(this.options.type == 'select'){
              $('.select2').select2();
            }
          }

          this.fillData = function () {
            var data = this.options.data,
                temp = {},
                $add = $('#add');

            if(data instanceof Array){
              data.forEach(function(item,index){
                temp[index] = item;
              })
              data = temp;
            }
            if(Object.keys(data).length > 0){
              for (item in data) {
                this.addItem($add, data[item]);
              }
            }else{
              this.addItem($add);
            }
          }

          this.randerLabel = function () {
            var _ = this
            this.$element.find('.control-label').each(function (index) {
              $(this).html(_.options.label.replace('i',index + 1));
            })
            this.index = this.$element.find('.control-label').length + 1
          }

     }

     /// 定义InputList的方法
     InputList.prototype = {
         init: function () {
             var _ = this;
             _.$element.html('');
             // 渲染初始列表;
             _.rander();

             //删除按钮
             this.$element.delegate('.del','click',function() {
                $(this).parent().parent().remove();
                _.randerLabel();
             })
             // 新增列表
             $('#add').click(function () {
                _.addItem(this);
             })
             _.fillData();

         },
         getListVal: function () {
            var _ = this,
                obj = {};
            this.$element.find(_.options.type).each(function (index, element) {
              // obj[String.fromCharCode((65 + index))] = element.value
              if( element.value ){
                obj[index] = element.value
              }
            });
            return obj;
         }
     }
     /******插件的调用******/
     //在插件中使用InputList对象
     $.fn.inputlist = function(options){
         //创建InputList的实体
         inputlist = new InputList(this,options);
         //调用其方法
         return inputlist;
     }
 })(jQuery,window,document);