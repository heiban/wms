/**
 * Created by wanghui on 16/6/2.
 */
define(['backbone','modules','receipt'], function (Backbone,Modules,Receipt) {
    var Router = Backbone.Router.extend({
        routes: {
            'receipt': 'receiptModule',
            'invoice': 'invoiceModule',
            '*actions': 'defaultAction'
        },

        //路由初始化可以做一些事
        initialize: function () {
            console.log('initialize');
        },
        defaultAction: function () {
            console.log("defaultAction");
            location.hash = 'receipt';
        },
        receiptModule: function() {
            console.log("receiptModule");
            Receipt.init();
        },
        invoiceModule: function() {
            console.log("invoiceModule");
        }
    });

    var router = new Router();
    router.on('route', function (route) {
        Modules.init('.main-content-wrapper',route);
    });
    return router;    //这里必须的，让路由表执行
});