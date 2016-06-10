/**
 * Created by wanghui on 16/6/5.
 */
define(['jquery'],function($){
    var conf={
        tabClass:".tab",
        viewClass:".view",
        activeClass:"active",
        initModule:{}
    };
    function activeOne(list,index,activeClass,initModule){
        list.removeClass(activeClass);
        list.eq(index).addClass(activeClass);
        if(initModule){
            var moduleName = list.eq(index).attr('id');
            var initModuleFunc = initModule[moduleName];
            initModuleFunc && initModuleFunc();
        }
    }
    function Nav(config){
        conf = $.extend(conf,config);
        var tabs = $(conf['tabClass']);
        var views = $(conf['viewClass']);
        var activeClass = conf['activeClass'];
        var initModule = conf['initModule'];
        tabs.unbind('click').on('click',function(event){
            var item = $(event.currentTarget);
            var index = tabs.index(item);
            activeOne(tabs,index,activeClass);
            activeOne(views,index,activeClass,initModule);
        });
        this.index = function(index){
            activeOne(tabs,index,activeClass);
            activeOne(views,index,activeClass,initModule);
        };
    }
    return Nav;
});