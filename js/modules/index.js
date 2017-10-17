/**
 * index js
 */
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
            event.dataObj = JSON.parse(event.data);

            if (event.dataObj.type === 1) {
                tool.chat(event);
            } else if (event.dataObj.type === 2) {
                tool.entry(event);
                if (event.dataObj.users !== undefined) {
                    tool.initUserList(event.dataObj.users, event.dataObj.from);
                } else {
                    tool.addUserList(event.dataObj.from);
                }
            } else if (event.dataObj.type === 3) {
                tool.leave(event);
                tool.removeUserList(event.dataObj.from);
            }

            console.log(event);

            tool.scrollBottom();
        };
        socket.onclose = function (event) {
            layer.msg('已经离开聊天室！',{
                icon: 0,
                time: 2000
            });
            $('#entry').html('<i class="layui-icon">&#xe654;</i>参与聊天');
        };
    };

    index.send = function (msg, type) {
        var data = {};
        var type = type || 'chat';
        data.msg = msg;
        data.type = type;
        socket.send(JSON.stringify(data));
    };

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
                    });
                } else {
                    layer.close(entry);
                    index.init(userId);
                    $('#entry').html('退出聊天');
                }
            });
        } else {
            socket.close();
            socket = null;
            $('#entry').html('<i class="layui-icon">&#xe654;</i>参与聊天');
        }

    };

    index.sendMessage = function (message) {
        if (socket !== null) {

            console.log($.trim(message))

            if ($.trim(message) == '') {
                layer.msg('发送内容不能为空',{
                    icon: 0,
                    time: 2000
                });
            } else {
                index.send(message, 1);
            }
        } else {
            layer.msg('请先点击"+参与聊天"，填写ID',{
                icon: 0,
                time: 2000
            });
        }
    };

    exports('index', index);
});