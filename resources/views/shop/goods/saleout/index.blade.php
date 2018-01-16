<div id="toolbar2" style="width:100%">
    <form class="form-horizontal" id="form-saleout">
        <div class="form-group col-md-4">
            <div class="input-group col-md-12">
             <div class="input-group-addon">商品分组</div>
              <select class="select form-control" id="chose-cate-saleout">
                  <option value="">所有分组</option>
                  <option value="0">未分组</option>
              </select>
            </div>
        </div>

        <div class="form-group col-md-4">
            <div class="input-group  col-md-12">
            <div class="input-group-addon">商品名称</div>
              <input type="text" class="form-control input" name="search" placeholder="商品名称" maxlength="11">
            </div>
        </div>

        <div class="form-group col-md-3">
            <button type="submit" class="btn btn-primary">查询</button>
            <button type="reset" class="btn btn-info">重置</button>
        </div>
    </form>
    <div class="form-group col-md-3">
	    <a href="{{ url('shop/goods/add') }}" class="btn btn-primary">
	        <i class="glyphicon glyphicon-plus"></i>发布商品
	    </a>
    </div>
</div>
<div class="box-body2" id="box-body2">
    <table id="table_saleout"
        data-toolbar="#toolbar2"
        data-striped="true"
        data-pagination="true"
        data-id-field="id"
        data-page-size="10"
        data-page-list="[10,15,20]"
        data-show-footer="false"
        data-side-pagination="server"
        data-url="/ajax/shop/goods/list"
        data-response-handler="responseHandler">
    </table>
</div>

@push('js')
<script type="text/javascript" src="{{ asset('js/zclip/jquery.zclip.js') }}"></script>
<script>
	$(document).ready(function () {
		var $table = $('#table_saleout'),
		$remove = $('#remove_saleout'),
		$close = $('#close_saleout'),
		status = 2,
		condition = true,
		selections = [];
		var pagHtml = '<div class="pull-left pagination-detail delete-cancel">'
		          +'<a id="close_saleout" href="javascript:void(0)" name="dc" class="btn btn-primary dc">'
		          +'<i class="glyphicon glyphicon-eye-close"></i>下架'
		          +'</a>'
		          +'<a id="remove_saleout" href="javascript:void(0)" name="dc" class="btn btn-danger dc">'
		          +'<i class="glyphicon glyphicon-remove"></i>删除'
		          +'</a>'
		          +'</div>';
		var isfresh = false;
		function initTable() {
		    $table.bootstrapTable({
				height: getHeight2(),
				pagination: true,/*是否分页显示*/
	            sidePagination: "server", /*分页方式：client客户端分页，server服务端分页*/
	            smartDisplay: false,/*隐藏分页*/
				queryParams:queryParams,
				pagination: true,/*是否分页显示*/
				pageNumber: 1,
				pageSize: 10,
		      	columns: [
		        [
		          {
		            field: 'state',
		            checkbox: true,
		            align: 'center',
		            valign: 'middle'
		          },{
		            title: '商品信息',
		            field: 'sell_price',
		            align: 'center',
		            valign: 'middle',
		            sortable: false,
		            formatter:goodsInfoFormatter
		          },{
		            title: '库存',
		            field: 'stock_num',
		            align: 'center',
		            sortable: true,
		            valign: 'middle'
		          },{
		            title: '总销量',
		            field: 'sell_num',
		            align: 'center',
		            sortable: true,
		            valign: 'middle'
		          },{
		            title: '创建时间',
		            field: 'created_at',
		            align: 'center',
		            sortable: true,
		            valign: 'middle'
		          },{
		            title: '序号',
		            field: 'sort',
		            align: 'center',
		            valign: 'middle',
		            sortable: true,
		            events: sortEventsSaleout,
		            formatter:sortFormatter
		          },{
		            title: '操作',
		            field: 'operate',
		            align: 'center',
		            valign: 'middle',
		            events: saleoutOperateEvents,
		            formatter: saleoutOperateFormatter
		          }
		        ]
		      	],
		      	responseHandler: function (res) {
		        	return res.data;
		      	}
		    });
		    setTimeout(function () {
		      	$table.bootstrapTable('resetView');
		    }, 200);

		    $(window).resize(function () {
		        $table.bootstrapTable('resetView', {
		          height: getHeight2()
		        });
		    });

		    //push分组进入toolbar
		    $.get('/ajax/shop/category/list', {}, function (json) {
		        if (json.code == 200) {
		          var data = json.data;
		          var str = '';
		          for(var i in data){
		            str += '<option value="'+data[i].id+'">'+data[i].name+"</option>"
		          }
		          $('#chose-cate-saleout').append(str);
		        } else if (json.code == 401) {
		          location.pathname = '/login';
		        }
		    }, 'json')
		    $table.on('load-success.bs.table',function(data){
		        //pushanniu
		        if($('#box-body2 .delete-cancel').length == 0){
		          $('#box-body2 .fixed-table-pagination').prepend(pagHtml);
		        }
		    });

		    //push 按钮进入分页
		    $table.on('check.bs.table uncheck.bs.table ' +
		    'check-all.bs.table uncheck-all.bs.table', function () {
		      $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
		      selections = getIdSelections();
		    });

		    $(".box-body2").bind('click','.dc',function(e){
		      	if(e.target.id == 'close_saleout'){
					var ids = getIdSelections();
					if(ids.length == 0){
						$.notify({
						  	message: "请选择商品"
			            },{
							type: 'success',
							placement: {
								from: "top",
								align: "center"
							},
			            })
			            return;
			        }
			        bootbox.confirm({
			            size: "small",
			            title: "警告",
			            message: '确定要下架这些商品吗',
			            buttons: {
							confirm: {
								label: '确定',
								className: 'btn-danger'
							},
							cancel: {
								label: '取消'
							}
			            },
			            callback: function (result) {
							if(result){
								closeGoods(ids);
							}
			            }
			        })
			    }
				if(e.target.id == 'remove_saleout'){
				  	var ids = getIdSelections();
				  	if(ids.length == 0){
						$.notify({
							message: "请选择商品"
						},{
							type: 'success',
							placement: {
						  		from: "top",
						  		align: "center"
							},
						})
				      return;
				  }
				  bootbox.confirm({
				      size: "small",
				      title: "警告",
				      message: '确定要删除这些商品吗？',
				      buttons: {
				          confirm: {
				            label: '确定',
				            className: 'btn-danger'
				          },
				          cancel: {
				            label: '取消'
				          }
				      },
				      callback: function (result) {
				          if (result) {
				            deleteGoods(ids);
				          }
				      }
				  })
				}
		    })
		}
	  	function queryParams(params){
	  		if(params.sort == undefined) {
	  			params.sort = 'created_at';
	  			params.order = 'desc';
	  		}
	  		if(condition) {
	  			params.order = 'desc';
	  			condition = false;
	  		}
	  		params.status = status;
	  		params.category_id = $("#chose-cate-saleout").val();
	  		params.search = $("#form-saleout input[name=search]").val();
			return params;
	  	}

	  // 	$(".box-body2").bind('change','#chose-cate-saleout',function(e){
			// if(e.target.id != 'chose-cate-saleout')return;
			// $table.bootstrapTable('refresh',{query:{'order':'desc','sort':'created_at'
			// }});
	  // 	})

	  	window.sortEventsSaleout = {
		    'dblclick .edit-a-sort': function (e, value, row, index) {
		        $(this).hide();
		        $(this).siblings('div').show();
		    },
		    'click .sort-edit-fail': function (e, value, row, index) {
		        $('#edit-sort-'+row.id).hide();
		        $('#edit-a-sort-'+row.id).show();
		    },
	      	'click .sort-edit-success': function (e, value, row, index) {
		        var sort = $("#sort-"+row.id).val();
		        var $self = $(this);
		        var alertLog = '';
		        if(isNaN(sort)){
		          	alertLog = '排序参数必须为数字';
		        }
		        if(sort < 0){
		          	alertLog = '排序参数不能为负数';
		        }
		        if(alertLog.length > 0){
		          	bootbox.alert({
			            title: '<span class="text-danger">提示</span>',
			            message: alertLog,
		          	});
			        return false;
		        }
		        $self.attr('disabled', 'disabled');
		        $.post('/ajax/shop/goods/sort/'+row.id, {sort:sort}, function (json) {
			        if (json.code == 200) {
			            $table.bootstrapTable('refresh', {query:{'order':'desc','sort':'created_at'
					}});
			        } else if (json.code == 401) {
			            location.pathname = '/login';
			        } else {
			            bootbox.alert({
			              title: '<span class="text-danger">错误</span>',
			              message: '编辑失败',
			            });
			            $self.removeAttr('disabled');
			            return false;
			        }
		        }, 'json')
	      	},
	  	}

		function sortFormatter(value,row,index){
			var label = '<a href="javascript:void(0);" class="edit-a-sort" id="edit-a-sort-'+row.id+'">'+value+'</a>';
			label += '<div class="edit-sort" id="edit-sort-'+row.id+'"><input type="number" value="'+value+'" min="0" max="'+row.stock_num+'" id="sort-'+row.id+'" style="border:1px solid #006DC9;border-radius:2px;width:60px;height:30px;">';
			label += '<button type="button" class="btn btn-primary btn-margin sort-edit-success"><i class="fa fa-fw fa-check"></i></button>';
			label += '<button type="button" class="btn btn-info btn-margin sort-edit-fail"><i class="fa fa-fw fa-close"></i></button></div>';
			return label;
		}

		function goodsInfoFormatter(value, row, index){
			var label = '<div class="goods-info-float"><img src="'+row.image_url+'" style="height:50px;width:80px"></div>'
				+ '<div class="goods-info-float">' + row.name + '<br>￥' + row.sell_price/100 + '</div>';
			return label;
		}

		function saleoutOperateFormatter(value, row, index) {
			var label = '<a href="javascript:void(0);" class="goods-edit">编辑</a>';
				label += '<span style="margin-left:8px;"><a href="javascript:void(0);" class="goods-spread">推广</a></span>';
			return label;
		}

	 	window.saleoutOperateEvents = {
	      	'click .goods-edit': function (e, value, row, index) {
	        	location.pathname = "/shop/goods/edit/" + row.id;
	      	},
	      	'click .goods-spread': function (e, value, row, index) {
	      		goodsId = row.id;
		        $.post('/ajax/shop/goods/weapp/goods/spread', {'goods_id' : row.id}, function (json) {
		        	res = json.data;
       			 	var text = $('#spread').text();
		            bootbox.dialog({
		                'title':'推广',
		                'message': text,
		                buttons: {
		                    Cancel: {
		                        label: "关闭",
		                        className: "btn-default",
		                        callback: function () {
		                            
		                        }
		                    }
		                }
		            });
		        }, 'json');
	      	},
	  	};

	  	function getIdSelections() {
	      	return $.map($table.bootstrapTable('getSelections'), function (row) {
	        	return row.id;
	      	});
	  	}

	    function getHeight2() {
	      	return $(window).height() - $('#box-body2').offset().top - 32;
	  	}

	  	$('#form-saleout').validator().on('submit', function (e) {
	        if(!e.isDefaultPrevented()){
	            e.preventDefault();
	        }

	        $table.bootstrapTable('selectPage', 1)
	    });


		function deleteGoods(ids){
			$.post('/ajax/shop/goods/delete', {id: ids}, function (json) {
				if (json.code == 200) {
					$.notify({
						message: "删除商品成功"
					},{
						type: 'success',
						placement: {
							from: "top",
							align: "center"
						},
					})
					$table.bootstrapTable('remove', {
						field: 'id',
						values: ids
					});
					$('#box-body2 .fixed-table-pagination').prepend(pagHtml);
				} else if (json.code == 401) {
					location.pathname = '/login';
				} else {
					alert( json.error);
				}
			}, 'json')
		}

	  	function closeGoods(ids){
	      	$.post('/ajax/shop/goods/close', {id:ids}, function (json) {
	          	if (json.code == 200) {
	              	$.notify({
		                message: "下架商品成功"
		            },{
		                type: 'success',
		                placement: {
							from: "top",
							align: "center"
		            	},
					})
					$table.bootstrapTable('remove', {
						field: 'id',
						values: ids
					});
 					$('#table').bootstrapTable('refresh',{query:{'order':'desc','sort':'created_at'
					}}); 
					$('#table_stock').bootstrapTable('refresh',{query:{'order':'desc','sort':'created_at'
					}});
					$('#box-body2 .fixed-table-pagination').prepend(pagHtml);
	          	} else if (json.code == 401) {
					location.pathname = '/login';
	          	} else {
					bootbox.alert({
						title: '<span class="text-danger">错误</span>',
						message: json.error,
					});
	          	}
	      	}, 'json')
	  	}
	  	$(function () {
			initTable();
	  	});
	});

</script>
<script type="text/template" id="spread">
      <!-- /*查看某商品独立佣金详情 */ -->
      <div class="form-group" style="height:320px;"> 
          <div class="col-sm-2" style="padding-top: 120px;"> 小程序码</div>
          <div class="col-sm-10" >
            <div style="margin-left: 80px;">微信“扫一扫”小程序访问</div>

            <img src="" id="mini_code" width="300px;"/>
            <div style="margin-left: 100px;margin-bottom: 10px;margin-top: -10px;"><a href="" id="weapp_code_download_saleout">下载小程序码</a></div>
          </div>

      </div>
      <div class="col-sm-2">
          小程序路径
      </div>
      <div class="col-sm-10 input-group form-group" style="line-height:21px;">
          <input type="text" 
                 class="form-control"
                 name="path" id="path" disabled><span id="copy_word" style="font-size:12px; color:#ab9a9a;" class="input-group-addon">复制</span>
      </div>
   
      <script type="text/javascript">
          $('#mini_code').attr('src',res.mini_code);
          $('#path').val(res.path);
          $('#copy_word').click(function(){
            $(this).zclip({
              path: "{{asset('js/zclip/ZeroClipboard.swf')}}",
              copy: function(){
                  return res.path;
              },
              beforeCopy:function(){/* 按住鼠标时的操作 */
                  $(this).css("color","orange");
              },
              afterCopy:function(){/* 复制成功后的操作 */
                  $(this).css("color","green");
                  $(this).text('复制成功');
              }
            });
          
          });
          $('#weapp_code_download_saleout').click(function(){
              $(this).attr('href', '/ajax/shop/goods/downloadImage?mini_code=' + res.mini_code + '&type=goods&id=' + goodsId);
          });
         
      </script>
</script>
@endpush