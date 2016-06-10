/**
 * Created by wanghui on 16/6/5.
 */
define(['jquery','click','table','popup','nav','net','autosuggest'],function($,Click,Table,Popup,Nav,net){
    var receiptNav = new Nav({tabClass:'.list-tab .item-tab',viewClass:'.list-view .item-view',activeClass:'active',
        initModule:{
            "receiptDraftModule":function(){
                console.log("receiptDraftModule");
                initDraftModule();
            },
            "receiptActiveModule":function(){
                console.log("receiptActiveModule");
                initActiveModule();
            }
        }});
    function initModule(){
        console.log("receiptModule");
        receiptNav.index(0);
    }



    /*initDraftModule*/
    var receiptDraftOper = new Click('#receiptDraftModule .oper-receipt-draft');
    var receiptDraftTable = new Table('#receiptDraftModule .table-receipt-draft .table',[
        {name:"申请单编号",param:"receipt_code"},
        {name:"创建时间",param:"receipt_createdate"},
        {name:"预报物流单号1",param:"receipt_dcode"},
        {name:"预报物流单号2",param:"receipt_dcode2"},
        {name:"申请单状态",param:"receipt_status"}
    ],"lineactive");
    var receiptIngoodTable = new Table('#receiptDialog .detail-receipt .table',[
        {name:"仓内编码",param:"ingoods_code"},
        {name:"商品名称",param:"sku_name"},
        {name:"商品条码",param:"sku_barcode"},
        {name:"入仓数量",param:"ingoods_num"},
        {name:"操作",param:"op-delete"}
    ],"lineactive");

    function initDraftModule(){
        function refreshReceiptDraftTableState(){
            $('.apply').hide();
            $('.delete').hide();
            $('.modify').hide();
            receiptDraftTable.render();
        }
        net.req(net.ApiClientReceiptSearch,
            {'receipt_type':0},
            function(error,rest){
                if(error == 0 && rest.result.list ){
                    var receiptDraftData=rest.result.list;
                    receiptDraftTable.render(receiptDraftData);
                }
            }
        );
        receiptDraftTable.click(function(item){
            console.log(item);
            if(item){
                $('.delete').show();
                $('.modify').show();
                if(item['receipt_dcode']!='' || item['receipt_dcode2']!=''){
                    $('.apply').show();

                }else{
                    $('.apply').hide();
                }
            }


        });
        receiptDraftOper.click({
            "create":function(){
                refreshReceiptDraftTableState();
                receiptIngoodPopup.show();
            },
            "refresh":function(){
                refreshReceiptDraftTableState();
                net.req(net.ApiClientReceiptSearch,
                    {'receipt_type':0},
                    function(error,rest){
                        if(error == 0 && rest.result.list ){
                            receiptDraftTable.render(rest.result.list);
                        }
                    }
                );
            },
            "modify":function(){
                var index = receiptDraftTable.selectedIndex();
                var data = receiptDraftTable.selectedItem();
                refreshReceiptDraftTableState();
                if(index ==-1){
                    alert("提示:请选择一条纪录来修改");
                    return;
                }
                receiptIngoodPopup.show(data);
            },
            "delete":function(){
                var index= receiptDraftTable.selectedIndex();
                var data = receiptDraftTable.selectedItem();
                refreshReceiptDraftTableState();
                if(data && data['receipt_code'] && confirm("提示:确定要删除吗")){
                    net.req(net.ApiClientReceiptDelete,
                        {'receipt_code':data['receipt_code']},
                        function(error,rest){
                            if(error == 0 && rest.result ){
                                receiptDraftTable.deleteItem(index);
                            }
                        }
                    );
                }

            },
            "apply":function(){
                var index = receiptDraftTable.selectedIndex();
                var data = receiptDraftTable.selectedItem();
                refreshReceiptDraftTableState();
                if(data && data['receipt_code']){
                    if(data['receipt_dcode']=="" && data['receipt_dcode2']==""){
                        alert("提示:请补全物流单信息后提交入仓申请!");
                        return;
                    }
                    if(confirm("提示:确定要提交吗")){
                        net.req(net.ApiClientReceiptApply,
                            {
                                'receipt_code': data['receipt_code'],
                                'receipt_dcode': data['receipt_dcode'],
                                'receipt_dcode2': data['receipt_dcode2']
                            },
                            function(error,rest){
                                if(error == 0 && rest.result ){
                                    receiptDraftTable.deleteItem(index);
                                }
                            }
                        );
                    }
                }

            }
        });
    }

    /*initActiveModule*/
    var receiprActiveTable = new Table('#receiptActiveModule .table-receipt-active .table',[
        {name:"申请单编号",param:"receipt_code"},
        {name:"创建时间",param:"receipt_createdate"},
        {name:"预报物流单号1",param:"receipt_dcode"},
        {name:"预报物流单号2",param:"receipt_dcode2"},
        {name:"申请单状态",param:"receipt_status"}
    ],"lineactive");
    function initActiveModule(){
        net.req(net.ApiClientReceiptSearch,
            {'receipt_type':1,'page':1},
            function(error,rest){
                if(error == 0 && rest.result.list ){
                    var receiptActiveData= rest.result.list;
                    receiprActiveTable.render(receiptActiveData);
                    var pageNum = rest.result.pn;
                    var pageIndex = rest.result.p;
                    setPageSelect(pageIndex,pageNum);
                    console.log(pageNum);
                }
            }
        );
        
        receiprActiveTable.click(function(item){
            console.log(item);
        });
    }
    function setPageSelect(pageIndex,pageNum){
        var pageSelect = $('.oper-receipt-active .pageselect');
        pageSelect.empty();
        for(var i=1;i<=pageNum;i++){
            if(i==pageIndex){
                pageSelect.append("<option value='"+i+"' selected>第"+i+"页</option>");
            }else{
                pageSelect.append("<option value='"+i+"'>第"+i+"页</option>");
            }

        }
        pageSelect.unbind('change').on('change',function(event){
            var pageIndex=$(event.target).val();
            net.req(net.ApiClientReceiptSearch,
                {'receipt_type':1,'page':pageIndex},
                function(error,rest){
                    if(error == 0 && rest.result.list ){
                        var receiptActiveData= rest.result.list;
                        receiprActiveTable.render(receiptActiveData);
                        var pageNum = rest.result.pn;
                        var pageIndex = rest.result.p;
                        setPageSelect(pageIndex,pageNum);
                        console.log(pageNum);
                    }
                }
            );
        });
    }
    var receiptIngoodPopup = new Popup({
        id:"#receiptDialog",
        title:"申请创建入仓单",
        cancelTitle:"放弃申请",
        sureTitle:"保存提交",
        width:"800",
        onCancel:function(){
            $('.receiptName').val('');
            $('.receiptBarcode').val('');
            $('.receiptSize').val('');
            $('.receiptWeight').val('');
            $('.receiptNorms').val('');
            $('.receiptNum').val('');
            $('.receiptImg').attr("src","");
            return 1;
        },
        onSure:function(param){
            var data,ingoodsList;
            if(param && param['receipt_code']){
                data = receiptIngoodTable.data();
                ingoodsList = JSON.stringify(data);
                net.req(net.ApiClientReceiptUpdate,
                    {
                        'receipt_code':param['receipt_code'],
                        'receipt_dcode':$('.receiptDCode').val(),
                        'receipt_dcode2':$('.receiptDCode2').val(),
                        'ingoods_list':encodeURIComponent(ingoodsList)
                    },
                    function(error,rest){
                        if(error == 0 && rest.result){
                            net.req(net.ApiClientReceiptSearch,
                                {'receipt_type':0},
                                function(error,rest){
                                    if(error == 0 && rest.result.list ){
                                        receiptDraftTable.render(rest.result.list);
                                    }
                                }
                            );
                        }
                    }
                );
                receiptIngoodTable.clear();
            }else{
                data = receiptIngoodTable.data();
                ingoodsList = JSON.stringify(data);
                net.req(net.ApiClientReceiptCreate,
                    {
                        'receipt_dcode':$('.receiptDCode').val(),
                        'receipt_dcode2':$('.receiptDCode2').val(),
                        'ingoods_list':encodeURIComponent(ingoodsList)
                    },
                    function(error,rest){
                        if(error == 0 && rest.result){
                            net.req(net.ApiClientReceiptSearch,
                                {'receipt_type':0},
                                function(error,rest){
                                    if(error == 0 && rest.result.list ){
                                        receiptDraftTable.render(rest.result.list);
                                    }
                                }
                            );
                        }
                    }
                );
                receiptIngoodTable.clear();
            }
            return 1;
        },
        onInit:function(param){
            var selectedItemData;
            if(param && param['receipt_code']){
                net.req(net.ApiClientReceiptSearch,
                    {'receipt_code':param['receipt_code']},
                    function(error,rest){
                        if(error == 0 && rest.result['ingoods_list']){
                            var ingoodsListData = rest.result['ingoods_list'];
                            $(ingoodsListData).each(function(index,item){
                                item["op-delete"]="删除";
                            });
                            receiptIngoodTable.render(ingoodsListData);
                        }
                    }
                );
            }
            receiptIngoodTable.setOpCallback(function(index,code){
                if(code =="op-delete") {
                    receiptIngoodTable.deleteItem(index);
                    receiptIngoodTable.render(receiptIngoodTable.data());
                }
            });
            $('.receiptAdd').unbind('click').on('click',function(){
                if(selectedItemData){
                    selectedItemData["ingoods_num"] = parseInt($('.receiptNum').val());
                    receiptIngoodTable.addItem(selectedItemData);
                    selectedItemData = null;
                    $('.receiptName').val('');
                    $('.receiptBarcode').val('');
                    $('.receiptSize').val('');
                    $('.receiptWeight').val('');
                    $('.receiptNorms').val('');
                    $('.receiptNum').val('');
                    $('.receiptImg').attr("src","");
                }
            });
            $('.receiptBarcode').unbind('keyup').on('keyup',function (event) {
                if(event.keyCode==13){
                    var barcode = $('.receiptBarcode').val();
                    net.req(net.ApiDataSkuSearch,
                        {'type':'sku_barcode','word':barcode},
                        function(error,rest){
                            if(error == 0 && rest.result){
                                var data = rest.result[0];
                                selectedItemData=data;
                                $('.receiptName').val(data.sku_name);
                                $('.receiptBarcode').val(data.sku_barcode);
                                $('.receiptSize').val(data.sku_size);
                                $('.receiptWeight').val(data.sku_weight);
                                $('.receiptNorms').val(data.sku_norms);
                                $('.receiptImg').attr("src",data.sku_imgurl);
                                selectedItemData["ingoods_code"]="";
                                selectedItemData["op-delete"]="删除";
                                $('.receiptNum')[0].focus();
                            }
                        },'get'
                    );
                }
            });
            $('.receiptName').autocomplete({
                serviceUrl:"/api/data/sku/search?type=sku_name",
                paramName: 'word',
                transformResult: function(response) {
                    response = $.parseJSON(response);
                    return {
                        suggestions: $.map(response.result, function(dataItem) {
                            return { value: dataItem.sku_name, data: dataItem };
                        })
                    };
                },
                onSelect: function (suggestion) {
                    //alert('You selected: ' + suggestion.value + ', ' + suggestion.data.sku_code);
                    selectedItemData=suggestion.data;
                    $('.receiptName').val(suggestion.data.sku_name);
                    $('.receiptBarcode').val(suggestion.data.sku_barcode);
                    $('.receiptSize').val(suggestion.data.sku_size);
                    $('.receiptWeight').val(suggestion.data.sku_weight);
                    $('.receiptNorms').val(suggestion.data.sku_norms);
                    $('.receiptImg').attr("src",suggestion.data.sku_imgurl);
                    selectedItemData["ingoods_code"]="";
                    selectedItemData["op-delete"]="删除";
                    $('.receiptNum')[0].focus();
                }
            });
            return 1;
        }
    });

    var receiptIngoodPopup0 = new Popup({
        id:"#receiptDialog",
        title:"查看入仓单",
        cancelTitle:"",
        sureTitle:"关闭",
        width:"800",
        onCancel:function(){
            return 1;
        },
        onSure:function(){
            return 1;
        },
        onInit:function(param){
            return 1;
        }
    });


    return {initModule:initModule};
});

/*
 [{
     receipt_code:"R0001020021",
     receipt_createdate:"20140302 12:22:21",
     receipt_dcode:"JJ009111111111",
     receipt_dcode2:"JD1122330092",
     receipt_status:"已创建,未提交"
 }]
*/