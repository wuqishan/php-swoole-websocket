<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/index.css" media="screen">
    <link rel="stylesheet" type="text/css" href="js/lib/layui/css/layui.css" media="screen">
</head>
<body>
<div class="layui-container layui-bg-orange" id="box">
    <div class="layui-row" >
        <div class="layui-col-md8" id="message-form">
            <div class="layui-row">
                <div class="layui-col-md12" id="message-list">
                    <blockquote class="layui-elem-quote per-msg">
                        <div class="message-info"><span>一剪梅</span><span class="fr">2015-12-04 12:34:02</span></div>
                        <div class="message-data">大家好</div>
                    </blockquote>
                    <blockquote class="layui-elem-quote per-msg">
                        <div class="message-info"><span>一剪梅</span><span class="fr">2015-12-04 12:34:02</span></div>
                        <div class="message-data">大家好</div>
                    </blockquote>
                    <blockquote class="layui-elem-quote per-msg">
                        <div class="message-data user-entry">欢迎用户《一线天》加入聊天室</div>
                    </blockquote>

                    <blockquote class="layui-elem-quote per-msg">
                        <div class="message-data user-leave">用户《一线天》离开聊天室</div>
                    </blockquote>
                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-md12">
                    <form class="layui-form layui-form-pane">
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">文本域</label>
                            <div class="layui-input-block">
                                <textarea placeholder="请输入内容" id="message" class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <a class="layui-btn" id="send"><i class="layui-icon">&#xe609;</i> 发 送</a>
                            <a class="layui-btn layui-btn-normal fr" id="entry"><i class="layui-icon">&#xe654;</i>参与聊天</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="layui-col-md4">
            <ul id="user-list">
                <li>22222</li>
            </ul>
        </div>
    </div>
</div>

<script src="js/lib/layui/layui.js"></script>
<script type="text/javascript">
    layui.config({
        base: '/js/modules/'
    }).use(['jquery', 'index'], function () {
        var $ = layui.jquery;
        var index = layui.index;

        $('#entry').click(function() {
            index.switchUserStatus();
        });

        $('#send').click(function () {
            index.sendMessage($('#message').val());
        });
    });
</script>
</body>
</html>