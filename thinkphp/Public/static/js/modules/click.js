/**
 * Created by wanghui on 16/6/5.
 */
define(['jquery'],function ($) {
    function Click(id){
        var dom = $(id);
        var callbackMap = {};
        dom.unbind('click').on('click',function (event) {
            var it = event.target;
            var callback = callbackMap[it.className];
            callback && callback();
        });
        this.click = function(map){
            callbackMap = map;
        }
    }
    return Click;
});