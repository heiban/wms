/**
 * Created by wanghui on 16/6/6.
 */
define(['jquery','net','loginService','mainService'],function($,net,loginService,mainService){
    function initWms(state){

        if(state){
            initWmsState(state);
        }else{
            net.req(net.ApiClientPassportStatus,{},function(error,rest){
                var state = "default";
                if(error==0){
                    if(rest.result){
                        state = 'main';
                        $('.userName').html(rest.result['user_name']);
                    }else if(rest.result==0){
                        state = 'login';
                        $('.userName').html();
                    }
                }
                initWmsState(state);
            });
        }
    }
    function initWmsState(state){
        mainService.init(state,function(state){initWms(state)});
        loginService.init(state,function(state){initWms(state)});
    }
    return {init:initWms};
});