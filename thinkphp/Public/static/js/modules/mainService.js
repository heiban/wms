/**
 * Created by wanghui on 16/6/6.
 */
define(['jquery','nav','receipt','net'],function($,Nav,receipt,net){
    function initState(state,callback){
        if(state=="main"){
            var menuNav = new Nav({
                tabClass:'.list-menu .item-menu',viewClass:'.list-content .item-content',activeClass:'active',
                initModule:{
                    "receiptModule":function(){
                        receipt.initModule();
                    },
                    "invoiceModule":function(){console.log("invoiceModule")}
                }
            });
            menuNav.index(0);
            $('.wrapper-service .header-wrapper .logoutBtn').unbind('click').on('click',function(){
                net.req(net.ApiClientPassportLogout,{},
                    function(error,rest){
                        if( error == 0 && rest.result ){
                            callback && callback();
                        }
                    }
                );
            });
            $('.wrapper-service').show();
        }else{
            $('.wrapper-service').hide();
        }
    }
    return {
        init:initState
    }
});