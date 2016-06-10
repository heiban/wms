/**
 * Created by wanghui on 16/6/6.
 */
define(['jquery'],function($){
    var serverUrl="";
    var serverApi={
        /*admin*/
        "ApiAdminPassportStatus":"/api/admin/passport/status",
        "ApiAdminPassportLogin":"/api/admin/passport/login",
        "ApiAdminPassportLogout":"/api/admin/passport/logout",
        /*user*/
        "ApiClientPassportStatus":"/api/client/passport/status",
        "ApiClientPassportLogin":"/api/client/passport/login",
        "ApiClientPassportLogout":"/api/client/passport/logout",
        "ApiClientReceiptApply":"/api/client/receipt/apply",
        "ApiClientReceiptSearch":"/api/client/receipt/search",
        "ApiClientReceiptDelete":"/api/client/receipt/del",
        "ApiClientReceiptCreate":"/api/client/receipt/create",
        "ApiClientReceiptUpdate":"/api/client/receipt/update",
        /*data*/
        "ApiDataSkuSearch":"/api/data/sku/search",
        "ApiDataTraceSearch":"/api/data/trace/search",
        "ApiDataUploadImage":"/api/data/upload/image"
    };
    function request(apiUrl,data,callback,type){
        loadEffect();
        if(!type)type="post";
        $.ajax( {
            url:serverUrl+apiUrl,data:data,type:type,
            cache:false,dataType:'json',
            success:function(rest) {
                callback(0,rest);
            },
            error : function() {
                callback(1,"[NOTICE]NET ERROR!");
            }
        });
    }
    function loadEffect(){
        $progress=$('.globalprogress')
        $progress.css('width','0');
        $progress.css('opacity','1');
        $progress.show();
        $progress.animate({width:"100%",opacity:'0.1'},800,function(){
            $progress.hide();
        });
    }
    return $.extend(serverApi,{req:request});
});