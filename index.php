<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="js/open.js"></script>
    <script src="js/message.js"></script>
    <script src="js/close.js"></script>
    <script type="text/javascript">
        var socket = null;

        function send(msg, socket, type) {
            var data = {};
            var type = type || 'chat';
            data.msg = msg;
            data.type = type;
            socket.send(JSON.stringify(data));
        }
        $(function () {
            $('.submit').click(function() {
                socket = new WebSocket('ws://127.0.0.1:8900');
                socket.onopen = function (event) {
                    send($('.name').val(), socket, 2);
                };
                socket.onmessage = function (event) {
                    console.log(event);
                };
                socket.onclose = function(event) {
                    console.log(event);
                };
                // 关闭Socket....
                //socket.close()
            });
            $('.send').click(function () {
                if (socket !== null) {
                    socket.send($('.write').val());
                }
            });
        });


    </script>
    <style type="text/css">
        #box {width: 600px; margin-top: 40px;}
        #box > div {float: left;width: 580px;margin-top: 10px;border: 1px solid #eee;padding: 10px;}
        .info {width: 600px;}
        .info > .user,.info > .message {float: left;overflow-y: scroll; overflow-x: scroll;}
        .user {width: 200px;height: 300px;border-right: 1px solid #eee;}
        .message {width: 370px;height: 300px;}
    </style>
</head>
<body>
<div id="box">
    <div class="join">
        <input type="text" class="name">
        <input type="button" class="submit" value="Join">
    </div>
    <div class="info">
        <div class="user"></div>
        <div class="message"></div>
        <div style="clear: both;border: none;"></div>
    </div>
    <div class="operate">
        <input type="text" class="write">
        <input type="button" class="send" value="Send">
    </div>
    <div style="clear: both;border: none;"></div>
</div>
</body>
</html>