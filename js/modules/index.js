layui.define(['jquery', 'layer', 'tool'], function(exports){
    var $ = layui.jquery;
    var layer = layui.layer;
    var tool = layui.tool;
    var socket = null;
    var index = {};

    index.init = function (userId) {
        socket = new WebSocket('ws://127.0.0.1:8900');
        socket.onopen = function (event) {
            index.send(userId, 2);
        };
        socket.onmessage = function (event) {
            console.log(event);
        };
        socket.onclose = function (event) {
            console.log(event);
        };
    }

    index.send = function (msg, type) {
        var data = {};
        var type = type || 'chat';
        data.msg = msg;
        data.type = type;
        socket.send(JSON.stringify(data));
    }

    index.switchUserStatus = function () {
        if (socket === null) {
            var entry = layer.prompt({
                title: '请输入使用的用户ID',
                formType: 0
            }, function (userId) {
                if (userId.length > 15) {
                    layer.msg('ID长度不能超过15',{
                        icon: 0,
                        time: 2000
                    })
                } else {
                    layer.close(entry);
                    index.init(userId);
                }
            });
            return 0;
        } else {
            socket.close()
            return 1;
        }

    }

    index.sendMessage = function (message) {
        if (socket !== null) {
            index.send(message, 1);
        } else {
            layer.msg('请先点击"+参与聊天"，填写ID',{
                icon: 0,
                time: 2000
            });
        }
    }

    exports('index', index);
});