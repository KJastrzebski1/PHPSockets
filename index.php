<!DOCTYPE HTML>
<html>
    <head>
        <title>InterChat</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script
            src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
        <script type="text/javascript">



        </script>
        <link rel="stylesheet" href="public/style.css">
    </head>
    <body>
        <script>
            $(document).ready(function () {
                var ws;
                if ("WebSocket" in window)
                {
                    //alert("WebSocket is supported by your Browser!");

                    // Let us open a web socket
                    
                    
                    ws = new WebSocket("ws://192.168.0.102:8080/server");
                    ws.onopen = function ()
                    {
                        $("#chat").append("<p>Welcome to the chat.</p>");
                        // Web Socket is connected, send data using send()
                        //ws.send("Message to send");
                        //alert("Chat is open");
                    };

                    ws.onmessage = function (evt)
                    {
                        var received_msg = evt.data;
                        $("#chat").append("<p>" + received_msg + "</p>");
                        //alert("Message is received...");
                    };

                    ws.onclose = function ()
                    {
                        // websocket is closed.
                        alert("Connection is closed...");
                    };
                } else
                {
                    // The browser doesn't support WebSocket
                    alert("WebSocket NOT supported by your Browser!");
                }
                //WebSocketTest();
                
                $("#send").click(function () {
                    var text = $("#chat_input").val();
                    //$("#chat").append("<p>" + text + "</p>");
                    if (ws.readyState == 1) {
                        ws.send(text);
                    }
                });
                
            })

        </script>
        <div id="chat">
        </div>
        <input id="chat_input" type="text"><button id="send">Send</button>
        <a href="game.php">Go to Game</a>
    </body>
</html>
