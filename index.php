<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/index.css" media="screen">
    <link rel="stylesheet" type="text/css" href="js/lib/layui/css/layui.css" media="screen">

    <script type="text/javascript" charset="utf-8" src="js/lib/ueditor-utf8-php/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/lib/ueditor-utf8-php/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="js/lib/ueditor-utf8-php/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<div class="layui-container" id="box">
    <div class="layui-row" >
        <div class="layui-col-md8" id="message-form">
            <div class="layui-row">
                <div class="layui-col-md12" id="message-list">
                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-md12">
                    <form class="layui-form layui-form-pane">
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">文本域</label>
                            <div class="layui-input-block">
                                <script id="editor" type="text/plain"></script>
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
                <li class="current-user-list">当前用户列表:</li>
            </ul>
        </div>
    </div>
</div>

<script src="js/lib/layui/layui.js"></script>
<script type="text/javascript">
    var ue = UE.getEditor('editor');

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
            $("#message").val('');
        });
    });
</script>
</body>
</html>