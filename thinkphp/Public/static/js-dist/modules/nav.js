define(["jquery"],function(i){function e(i,e,a,n){if(i.removeClass(a),i.eq(e).addClass(a),n){var t=i.eq(e).attr("id"),s=n[t];s&&s()}}function a(a){n=i.extend(n,a);var t=i(n.tabClass),s=i(n.viewClass),c=n.activeClass,l=n.initModule;t.unbind("click").on("click",function(a){var n=i(a.currentTarget),r=t.index(n);e(t,r,c),e(s,r,c,l)}),this.index=function(i){e(t,i,c),e(s,i,c,l)}}var n={tabClass:".tab",viewClass:".view",activeClass:"active",initModule:{}};return a});