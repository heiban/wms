define(["jquery","click","table","popup","nav","net","autosuggest"],function(e,t,i,r,c,a){function n(){console.log("receiptModule"),d.index(0)}function o(){function t(){e(".apply").hide(),e(".delete").hide(),e(".modify").hide(),u.render()}a.req(a.ApiClientReceiptSearch,{receipt_type:0},function(e,t){if(0==e&&t.result.list){var i=t.result.list;u.render(i)}}),u.click(function(t){console.log(t),t&&(e(".delete").show(),e(".modify").show(),""!=t.receipt_dcode||""!=t.receipt_dcode2?e(".apply").show():e(".apply").hide())}),s.click({create:function(){t(),_.show()},refresh:function(){t(),a.req(a.ApiClientReceiptSearch,{receipt_type:0},function(e,t){0==e&&t.result.list&&u.render(t.result.list)})},modify:function(){var e=u.selectedIndex(),i=u.selectedItem();return t(),-1==e?void alert("提示:请选择一条纪录来修改"):void _.show(i)},"delete":function(){var e=u.selectedIndex(),i=u.selectedItem();t(),i&&i.receipt_code&&confirm("提示:确定要删除吗")&&a.req(a.ApiClientReceiptDelete,{receipt_code:i.receipt_code},function(t,i){0==t&&i.result&&u.deleteItem(e)})},apply:function(){var e=u.selectedIndex(),i=u.selectedItem();if(t(),i&&i.receipt_code){if(""==i.receipt_dcode&&""==i.receipt_dcode2)return void alert("提示:请补全物流单信息后提交入仓申请!");confirm("提示:确定要提交吗")&&a.req(a.ApiClientReceiptApply,{receipt_code:i.receipt_code,receipt_dcode:i.receipt_dcode,receipt_dcode2:i.receipt_dcode2},function(t,i){0==t&&i.result&&u.deleteItem(e)})}}})}function p(){a.req(a.ApiClientReceiptSearch,{receipt_type:1,page:1},function(e,t){if(0==e&&t.result.list){var i=t.result.list;v.render(i);var r=t.result.pn,c=t.result.p;l(c,r),console.log(r)}})}function l(t,i){var r=e(".oper-receipt-active .pageselect");r.empty();for(var c=1;i>=c;c++)c==t?r.append("<option value='"+c+"' selected>第"+c+"页</option>"):r.append("<option value='"+c+"'>第"+c+"页</option>");r.unbind("change").on("change",function(t){var i=e(t.target).val();a.req(a.ApiClientReceiptSearch,{receipt_type:1,page:i},function(e,t){if(0==e&&t.result.list){var i=t.result.list;v.render(i);var r=t.result.pn,c=t.result.p;l(c,r),console.log(r)}})})}var d=new c({tabClass:".list-tab .item-tab",viewClass:".list-view .item-view",activeClass:"active",initModule:{receiptDraftModule:function(){console.log("receiptDraftModule"),o()},receiptActiveModule:function(){console.log("receiptActiveModule"),p()}}}),s=new t("#receiptDraftModule .oper-receipt-draft"),u=new i("#receiptDraftModule .table-receipt-draft .table",[{name:"申请单编号",param:"receipt_code"},{name:"创建时间",param:"receipt_createdate"},{name:"预报物流单号1",param:"receipt_dcode"},{name:"预报物流单号2",param:"receipt_dcode2"},{name:"申请单状态",param:"receipt_status"}],"lineactive"),m=new i("#receiptDialog .detail-receipt .table",[{name:"仓内编码",param:"ingoods_code"},{name:"商品名称",param:"sku_name"},{name:"商品条码",param:"sku_barcode"},{name:"入仓数量",param:"ingoods_num"},{name:"操作",param:"op-delete"}],"lineactive"),v=new i("#receiptActiveModule .table-receipt-active .table",[{name:"申请单编号",param:"receipt_code"},{name:"创建时间",param:"receipt_createdate"},{name:"预报物流单号1",param:"receipt_dcode"},{name:"预报物流单号2",param:"receipt_dcode2"},{name:"申请单状态",param:"receipt_status"}],"lineactive"),_=new r({id:"#receiptDialog",title:"申请创建入仓单",cancelTitle:"放弃申请",sureTitle:"保存提交",width:"800",onCancel:function(){return e(".receiptName").val(""),e(".receiptBarcode").val(""),e(".receiptSize").val(""),e(".receiptWeight").val(""),e(".receiptNorms").val(""),e(".receiptNum").val(""),e(".receiptImg").attr("src",""),1},onSure:function(t){var i,r;return t&&t.receipt_code?(i=m.data(),r=JSON.stringify(i),a.req(a.ApiClientReceiptUpdate,{receipt_code:t.receipt_code,receipt_dcode:e(".receiptDCode").val(),receipt_dcode2:e(".receiptDCode2").val(),ingoods_list:encodeURIComponent(r)},function(e,t){0==e&&t.result&&a.req(a.ApiClientReceiptSearch,{receipt_type:0},function(e,t){0==e&&t.result.list&&u.render(t.result.list)})}),m.clear()):(i=m.data(),r=JSON.stringify(i),a.req(a.ApiClientReceiptCreate,{receipt_dcode:e(".receiptDCode").val(),receipt_dcode2:e(".receiptDCode2").val(),ingoods_list:encodeURIComponent(r)},function(e,t){0==e&&t.result&&a.req(a.ApiClientReceiptSearch,{receipt_type:0},function(e,t){0==e&&t.result.list&&u.render(t.result.list)})}),m.clear()),1},onInit:function(t){var i;return t&&t.receipt_code&&a.req(a.ApiClientReceiptSearch,{receipt_code:t.receipt_code},function(t,i){if(0==t&&i.result.ingoods_list){var r=i.result.ingoods_list;e(r).each(function(e,t){t["op-delete"]="删除"}),m.render(r)}}),m.setOpCallback(function(e,t){"op-delete"==t&&(m.deleteItem(e),m.render(m.data()))}),e(".receiptAdd").unbind("click").on("click",function(){i&&(i.ingoods_num=parseInt(e(".receiptNum").val()),m.addItem(i),i=null,e(".receiptName").val(""),e(".receiptBarcode").val(""),e(".receiptSize").val(""),e(".receiptWeight").val(""),e(".receiptNorms").val(""),e(".receiptNum").val(""),e(".receiptImg").attr("src",""))}),e(".receiptBarcode").unbind("keyup").on("keyup",function(t){if(13==t.keyCode){var r=e(".receiptBarcode").val();a.req(a.ApiDataSkuSearch,{type:"sku_barcode",word:r},function(t,r){if(console.log(r),0==t&&r.result){var c=r.result[0];i=c,e(".receiptName").val(c.sku_name),e(".receiptBarcode").val(c.sku_barcode),e(".receiptSize").val(c.sku_size),e(".receiptWeight").val(c.sku_weight),e(".receiptNorms").val(c.sku_norms),e(".receiptImg").attr("src",c.sku_imgurl),i.ingoods_code="",i["op-delete"]="删除"}},"get")}}),e(".receiptName").autocomplete({serviceUrl:"/api/data/sku/search?type=sku_name",paramName:"word",transformResult:function(t){return t=e.parseJSON(t),{suggestions:e.map(t.result,function(e){return{value:e.sku_name,data:e}})}},onSelect:function(t){i=t.data,e(".receiptName").val(t.data.sku_name),e(".receiptBarcode").val(t.data.sku_barcode),e(".receiptSize").val(t.data.sku_size),e(".receiptWeight").val(t.data.sku_weight),e(".receiptNorms").val(t.data.sku_norms),e(".receiptImg").attr("src",t.data.sku_imgurl),i.ingoods_code="",i["op-delete"]="删除"}}),1}});return{initModule:n}});