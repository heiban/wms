/**
 * Created by wanghui on 16/6/5.
 */
define(['jquery','underscore'],function($,_){

    function Table(tableId,tableColNames,tableActiveClass){
        var tableData=[],opCallback=null,tableActiveClass=tableActiveClass?tableActiveClass:'active';
        var tableLineId = tableId+" tr[data-index]";
        var tableSelectLineId = tableId+" tr[class='"+tableActiveClass+"']";
        var tableItemId = tableId+" span[data-index]";

        var me=this;
        var onLineClickedCallback=null;
        function initEvent(){
            var $lines = $(tableLineId);
            $lines.unbind('click').on('click',function(event){
                var $line = $(event.currentTarget);
                var index = $line.attr("data-index");
                $lines.removeClass(tableActiveClass);
                $line.addClass(tableActiveClass);
                if(onLineClickedCallback){
                    onLineClickedCallback(tableData[index]);
                }
            });
            if(opCallback) {
                $(tableItemId).one("click", function (event) {
                    var $line = $(event.currentTarget);
                    var index = $line.attr("data-index");
                    var type = $line.attr("data-type");
                    opCallback && opCallback(index, type);
                });
            }

        }
        this.selectedIndex=function(){
            var $line = $(tableSelectLineId);
            if($line.length==1){
                return $line.attr("data-index");
            }else{
                return -1;
            }
        };
        this.selectedItem = function(){
            var index = me.selectedIndex();
            if(index>-1){
                return tableData[index];
            }else{
                return null;
            }
        };
        this.deleteItem = function(index){
            if(index==-1)return;
            var tlineId = tableId+" tr[data-index="+index+"]";
            var $line = $(tlineId);
            $line.animate({opacity:0},600,function(){
                tableData.splice(index,1);
                me.render(tableData);
            });

        };
        this.addItem = function(item){
            tableData.push(item);
            me.render(tableData);
        };
        this.data = function(){
            return tableData;
        };
        this.click=function(callback){
            onLineClickedCallback=callback;
        };

        this.render=function(data){
            if(data)
                tableData = data;
            var colTpl='<tr><% _.each(colNames,function(item){%><th><%=item.name%></th><%});%></tr>';
            var rowTpl='<tr data-index="<%=itemIndex%>">' +
                '<% _.each(colNames,function(item){' +
                'if(item.param.indexOf("op-")>-1){' +
                    '%><td><span data-index="<%=itemIndex%>" data-type="<%=item.param%>"><%=itemData[item.param]%></span></td><%' +
                '}else{' +
                    '%><td><%=itemData[item.param]%></td><%}' +
                '});%>' +
                '</tr>';
            $(tableId).html('');
            $(tableId).append(_.template(colTpl)({colNames:tableColNames}));
            $(tableData).each(function(index,item){
                $(tableId).append(_.template(rowTpl)({colNames:tableColNames,itemData:item,itemIndex:index}));
            });
            initEvent();
        };
        this.reset=function(){
            $(tableLineId).removeClass("active");
        };
        this.clear=function(){
            $(tableId).html('');
        }
        this.setOpCallback=function(callback){
            opCallback=callback;
            me.render();
            //initEvent();
        };

    }
    return Table;
});