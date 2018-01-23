<template id = "merchandise-edit" name = "merchandise">
    <div class = "col-md-12 merchandise-info">
        <el-row class="tab" :gutter="20">
            <el-col class="tab-item" :class="{active: type === 1}" :span="12">
                <div  @click="setStep(1)">编辑基本信息</div>
            </el-col>
            <el-col class="tab-item" :class="{active: type === 2}" :span="12">
                <div  @click="setStep(2)">编辑商品详情</div>
            </el-col>
        </el-row>
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="200px" v-show="step === 1" class="form">
            <div class="form-group">
                <h4><span>分组</span></h4>
                <el-form-item label="商品状态" prop="status">
                    <el-switch
                            v-model="ruleForm.status"
                            on-text="上架"
                            off-text="下架"
                            on-color="#13ce66"
                            off-color="#ff4949"
                            :on-value="status[1]"
                            :off-value="status[0]">
                    </el-switch>
                </el-form-item>

                <el-form-item label="商品分组" prop="category_id">
                    <el-select v-model="ruleForm.category_id"  filterable>
                        <el-option
                                v-for="item in categoryList"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </div>
            <div class = "form-group">
                <h4><span>库存/规格</span></h4>
                <el-form-item label="规格" prop="sku">
                    <sku
                            v-on:updateSku="updateSku"
                            :goods-id="goodsId">
                    </sku>
                    <sku-table
                            v-if="tableData.length > 0"
                            v-on:updateTableData="updateTableData"
                            :skuTree="skuTree"
                            :tableData="tableData">
                    </sku-table>
                </el-form-item>
                <el-form-item label="总库存" prop="num">
                    <el-input v-model="ruleForm.stock_num" :disabled="tableData.length > 0" type="number" min="0"></el-input>
                    <p style="color: #99A9BF">总库存为 0 时，会上架到『已售罄的商品』列表里发布后商品同步更新，以库存数字为准</p>
                </el-form-item>
            </div>
            <div class = "form-group">
                <h4><span>商品信息</span></h4>
                <el-form-item label="商品名称" prop="name">
                    <el-input v-model="ruleForm.name"></el-input>
                </el-form-item>
                <el-row>
                    <el-col :span="12">
                        <el-form-item label="价格" prop="sell_price">
                            <el-input v-model="ruleForm.sell_price" :disabled="tableData.length > 0" type="number" min="0.00" step="0.01"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="原价" prop="market_price">
                            <el-input v-model="ruleForm.market_price" type="number" min="0.00" step="0.01"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item label="图片" prop="images">
                    <el-upload
                            action="/upload/image_image"
                            name="image"
                            list-type="picture-card"
                            :file-list="ruleForm.images"
                            :on-success="handleSuccessUpload"
                            :before-upload="handleBeforeUpload"
                            :on-preview="handlePictureCardPreview"
                            :on-remove="handleRemove">
                        <i class="el-icon-plus"></i>
                    </el-upload>
                    <el-dialog v-model="dialogVisible" size="tiny">
                        <img width="100%" :src="dialogImageUrl" alt="">
                    </el-dialog>
                    <p style="color: #99A9BF">建议尺寸：640 x 640 像素。最多可设置5张图片。</p>
                </el-form-item>
            </div>
            <div class = "form-group">
                <el-form-item >
                    <el-button type="success" @click="setStep(2)">下一步</el-button>
                </el-form-item>
            </div>
        </el-form>
    </div>
</template>
<script>
    import SKU from './SKU.vue';
    import SkuTable from './SkuTable'
    let STATUS = [
        'TAKEN_OFF',
        'ON_SHELVES'
    ];
    export default {
        components: {
            'sku': SKU,
            'sku-tabke': SkuTable
        },
        props: {
            goodsId: 0,
            categoryList: [],       // 商品分类列表
            skuTree: [],            // sku组件传出的规格结构，用于构建列表的表头
            tableData: [],          // 列表数据
            dialogImageUrl: '',     // 图片预览url
            dialogVisible: false,   // 图片预览开关
            ruleForm: {
                type: Object,
                default: {
                    status: STATUS[0],
                    name: '',
                    category_id: null,
                    sell_price: 0,
                    market_price: 0,
                    post_fee: 0,
                    stock_num: 0,
                    images: [],
                    products: [],
                    brief_introduction: null,
                    content: null
                }
            },
        },
        data: {
            editor: null,
            step: 1, // 表单类型切换，区分基本信息和商品详情
            status: STATUS,
            skuTree: [],            // sku组件传出的规格结构，用于构建列表的表头
            tableData: [],          // 列表数据
            dialogImageUrl: '',     // 图片预览url
            dialogVisible: false,   // 图片预览开关
            rules: {
                name: [
                    { required: true, message: '请输入商品名称', trigger: 'blur' }
                ],
                sell_price: [
                    { required: true, message: '请输入商品价格', trigger: 'blur' }
                ],
                images: [
                    { type:'array', required: true, message: '请选择商品图像', trigger: 'blur' }
                ]
            }
        },
        create: function () {
            let self = this;
            this.editor = UE.getEditor('container');
            this.editor.ready(function() {
                self.editor.execCommand('serverparam', '_token', '{{ csrf_token() }}');
            })
        },
        methods: {
            // 处理删除图片事件
            handleRemove(file, fileList) {
                this.ruleForm.images = fileList.map(function(item){
                    let url = item.response ? item.response.data : item.url;
                    return {url: url};
                });
            },
            // 处理图片预览事件
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            handleBeforeUpload(file){
                if (this.ruleForm.images.length > 4) {
                    alert("图片最多5张");
                    return false;
                }
            },
            // 处理成功上传事件
            handleSuccessUpload(response, file, fileList) {
                this.ruleForm.images.push({url: response.data});
            },
            // 响应sku列表数据更新事件
            updateTableData(skuRes){
                let arr = [];
                let num = 0;
                let price = [];
                for (let i = 0; i < skuRes.length; i++) {
                    if (_.compact(_.keys(skuRes[i].spec_array)).length > 0) {
                        arr.push(skuRes[i]);
                    }
                    price.push(skuRes[i].sell_price);
                    num += parseInt(skuRes[i].stock_num);
                }
                this.ruleForm.sell_price = Math.min.apply(null, price).toString();
                this.ruleForm.stock_num = num;
                this.ruleForm.products = JSON.stringify(arr);
                this.skuList = arr;
            },
            // 响应sku更新事件
            updateSku (data) {
                this.tableData = data[0];
                this.skuTree = data[1];
            },
            // 切换表单
            setStep(step){
                let self = this;
                if (step === 2) {
                    this.validateData('ruleForm', function(){
                        self.step = 2;
                    });
                } else {
                    this.step = 1;
                }
            },
            // 格式化提交数据
            formatPostData(){
                let data = {
                    name: this.ruleForm.name,
                    status: this.ruleForm.status,
                    category_id: this.ruleForm.category_id,
                    sell_price: this.ruleForm.sell_price,
                    market_price: this.ruleForm.market_price,
                    stock_num: this.ruleForm.stock_num,
                    main_image_url: this.ruleForm.images[0].url,
                    images: this.ruleForm.images.map(function(item){
                        return item.url
                    }),
                    products: this.ruleForm.products,
                    content: $('[name="content"]').val(),
                };

                if (this.ruleForm.brief_introduction) {
                    data.brief_introduction = this.ruleForm.brief_introduction;
                }
                return data;
            },
            // 提示消息
            showMessage (setStep, info) {
                this.$alert(info, setStep ? '成功': '失败', {
                    type: type ? 'success': 'error',
                    confirmButtonText: '确定',
                    callback: function (action) {
                        location.pathname = this.listPath;
                    }
                })
            },
            // 提交表单
            saveMerchandise(){
                let postData = this.formatPostData();
                this.$http[this.method](this.url, postData)
                    .then(function(res){
                        if (res.data.hasError) {
                            this.showMessage(false, res.data.error);
                        } else {
                            this.showMessage(true, this.goodsId ? '更新商品成功' : '添加商品成功');
                        }
                    })
            },
            // 校验sku数据
            validateSku(){
                if (this.ruleForm.products) {
                    let emptyPrice = this.tableData.some(function(item){
                        return item.sell_price <= 0;
                    });
                    if (emptyPrice) {
                        this.$message.error('请填写商品不同SKU的价格');
                        return false;
                    }
                }
                return true;
            },
            // 数据校验
            validateData(formName, callback){
                let self = this;
                this.$refs[formName].validate(function (valid){
                    if (valid && self.validateSku() ) {
                        callback();
                    } else {
                        return false;
                    }
                });
            },
        }
    }
</script>