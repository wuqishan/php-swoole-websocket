layui.define(['jquery'], function(exports){
    var $ = layui.jquery;
    var tool = {};
    var msgMaxCount = 80;   // 当信息条数大于80的时候则删除30条数据(客户端检测)
    var delMsgCount = 30;
    var msgBox = $("#message-list");
    var userBox = $("#user-list");
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
    var userTemplate = '<li class="per-user" id="user-%key%">%value%</li>';
    var userTemplateAsMe = '<li class="per-user user-as-me" id="user-%key%">%value%</li>';

    // 通知新用户进入聊天室
    tool.entry = function(e) {
        var data = {};
        data.from = e.dataObj.from.value;

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

    // 初始化user list
    tool.initUserList = function (users, from) {
        users = users || {};
        for (var i in users) {
            var user = {};
            user.key = i;
            user.value = users[i];
            if (from.key === i) {
                userBox.append(tool.sprintf(userTemplateAsMe, user));
            } else {
                userBox.append(tool.sprintf(userTemplate, user));
            }
        }
    }

    // 添加新进来的用户
    tool.addUserList = function (user) {
        var hasUser = false;
        userBox.find('.per-user').each(function(index) {
            if ($(this).attr('id') === 'user-' + user.key) {
                hasUser = true;
                return;
            }
        });
        if (! hasUser) {
            userBox.append(tool.sprintf(userTemplate, user));
        }
    }

    // 删除离开的用户
    tool.removeUserList = function (user) {
        userBox.find('.per-user').each(function(index) {
            if ($(this).attr('id') === 'user-' + user.key) {
                $(this).remove();
            }
        });
    }

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