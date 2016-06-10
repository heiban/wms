/**
 * Created by wanghui on 16/6/2.
 */
(function (win) {
    win.console=!win.console?{log:function(s){}}:win.console;
    var baseUrl = document.getElementById('main').getAttribute('data-baseurl');
    var config = {
        baseUrl: baseUrl,           //依赖相对路径
        paths: {                    //如果某个前缀的依赖不是按照baseUrl拼接这么简单，就需要在这里指出
            jquery: '../libs/jquery.min',
            underscore: '../libs/underscore-min',
            backbone: '../libs/backbone-min',
            autosuggest: '../libs/jquery.autocomplete.min'
        },
        shim: {                     //引入没有使用requirejs模块写法的类库。backbone依赖underscore
            'jquery': {
                exports: '$'
            },
            'underscore': {
                exports: '_'
            },
            'backbone': {
                deps: ['underscore','jquery'],
                exports: 'Backbone'
            },
            'autosuggest': {
                deps: ['jquery'],
                exports: 'Autosuggest'
            }
        }
    };
    require.config(config);

    require(['wms'],function (wms) {
        wms.init();
    });

})(window);
