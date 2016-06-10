/**
 * Created by wanghui on 16/6/2.
 */
define(function(){
    function Popup(config) {
        var id = config["id"];
        var popup = $(id + ".popup");
        var sureCallback = config["onSure"];
        var initCallback = config["onInit"];
        var cancelCallback = config["onCancel"];

        var me=this;
        var innerParam=null;
        config["cancelTitle"] && $(id + ".popup .cancel").html(config["cancelTitle"]);
        config["sureTitle"] && $(id + ".popup .sure").html(config["sureTitle"]);
        config["title"] && $(id + ".popup .title").html(config["title"]);
        config["width"] && $(id + ".popup .container").css("width", config["width"] + "px");

        popup.unbind('click').on("click", function (event) {
            var className = event.target.className;
            switch (className) {
                case "close":
                    me.hide();
                    break;
                case "sure":
                    if (sureCallback(innerParam)) me.hide();
                    break;
                case "cancel":
                    if(cancelCallback())me.hide();
                    break;
                default:
                    break;
            }
        });
        this.hide = function () {
            $popup=$(id + ".popup");
            $popup.hide();
            $popup.css('opacity','0');

        }
        this.show = function (param) {
            innerParam = param;
            if(initCallback(innerParam)){
                $(id + ".popup .container").css("margin-top", $(document).height() / 15 + "px");
                $popup=$(id + ".popup");
                $popup.css('opacity','0');
                $popup.show();
                $popup.animate({opacity:'1'},300,function(){

                });
            };
        }
    }
    return Popup;
})