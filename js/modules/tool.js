layui.define(['jquery'], function(exports){
    var $ = layui.jquery;
    var tool = {};
    var msgMaxCount = 80;   // 当信息条数大于80的时候则删除30条数据(客户端检测)
    var delMsgCount = 30;
    var msgBox = $("#message-list");
    var entryTemplate = '<blockquote class="layui-elem-quote per-msg">' +
                            '<div class="message-data user-entry">欢迎用户《%from%》加入聊天室！</div>' +
                        '</blockquote>'
    var leaveTemplate = '<blockquote class="layui-elem-quote per-msg">' +
                            '<div class="message-data user-leave">用户《%from%》离开聊天室！</div>' +
                        '</blockquote>';
    var chatTemplate = '<blockquote class="layui-elem-quote per-msg">' +
                            '<div class="message-info">' +
                                '<span>%from%</span>' +
                                '<span class="fr">%datetime%</span>' +
                            '</div>' +
                            '<div class="message-data">%message%</div>' +
                        '</blockquote>';

    // 通知新用户进入聊天室
    tool.entry = function(e) {
        var data = {};
        data.from = e.dataObj.from;

        msgBox.append(tool.sprintf(entryTemplate, data));
    };

    // 通知用户离开聊天室
    tool.leave = function (e) {
        var data = {};
        data.from = e.dataObj.from;

        msgBox.append(tool.sprintf(leaveTemplate, data));
    };

    // 通知用户聊天数据
    tool.chat = function (e) {
        var data = {};
        data.from = e.dataObj.from;
        data.datetime = e.dataObj.datetime;
        data.message = e.dataObj.message;

        msgBox.append(tool.sprintf(chatTemplate, data));
    };

    // 聊天数据滚到底部及数据删除
    tool.scrollBottom = function () {
        var msgCount = $('.per-msg').length;
        if (msgCount > msgMaxCount) {
            for (var i = 0; i < delMsgCount; i++) {
                $('.per-msg').eq(i).remove();
            }
        }

        msgBox.animate({scrollTop:msgBox[0].scrollHeight}, 100);
    };

    // 格式化显示的信息数据
    tool.sprintf = function(template, data) {
        for (var i in data) {
            if (template.indexOf('%'+i+'%') >= 0) {
                template = template.split('%'+i+'%').join(data[i]);
            }
        }

        return template;
    };

    exports('tool', tool);
});