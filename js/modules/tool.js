layui.define(['jquery'], function(exports){
    var $ = layui.jquery;
    var tool = {};

    tool.test = function () {
        alert(3333);
    }

    exports('tool', tool);
});