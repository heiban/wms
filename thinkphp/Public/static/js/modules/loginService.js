/**
 * Created by wanghui on 16/6/6.
 */
define(['jquery','net'],function($,net){
    var settimeoutHandler;
    function showTip(msg){
        var tip = $('.wrapper-login .tip');
        clearTimeout(settimeoutHandler);
        tip.html(msg);
        tip.show();
        settimeoutHandler= setTimeout(function(){
            tip.hide();
            tip.html("");
        },5000);
    }
    function initLogin(state,callback){
        if(state=="login"){
            $('.wrapper-login .loginBtn').unbind('click').on('click',function(event){
                var username = $('.loginName').val();
                var userpwd = $('.loginPwd').val();
                //等待验证
                net.req(net.ApiClientPassportLogin,
                    {'user_name':username,'user_pwd':userpwd},
                    function(error,rest){
                        if(error == 0 && rest.result ){
                            callback && setTimeout(callback,600);
                        }else if(error == 0 && rest.result == 0){
                            showTip(rest.message);
                        }else{
                            showTip("系统错误");
                        }
                    }
                );
            });
            $('.wrapper-login .loginPwd').unbind('keydown').on('keydown',function(event){
                if(event.keyCode == 13){
                    $('.wrapper-login .loginBtn').click();
                }
            });
            $('.wrapper-login').show();
        }else{
            $('.wrapper-login').hide();
        }
    }
    return {
        init:initLogin
    }
});