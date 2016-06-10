/**
 * Created by wanghui on 16/6/6.
 */
define(['jquery'],function($){
    function initState(state,callback){
        if(state=="login"){
            $('.wrapper-login').show();
            $('.wrapper-login .loginBtn').one('click',function(event){
                callback && callback();
                $('.wrapper-login').hide();
            });
        }
    }
    return {
        init:initState
    }
});