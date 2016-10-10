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
        <?php $conf = include("conf.php"); ?>
        
        <script>
            
            $(document).ready(function () {
                var gameServer;
                if ("WebSocket" in window)
                {
                    //alert("WebSocket is supported by your Browser!");

                    // Let us open a web socket

                    gameServer = new WebSocket("ws://<?php echo $conf["IP"];?>:<?php echo $conf["port"] ?>/gameserver");
                    gameServer.onopen = function () {
                        //alert("elo");
                        //console.log(playerStats);
                        //gameServer.send(JSON.stringify(playerStats));
                    }
                    gameServer.onmessage = function (msg) {
                        var player = JSON.parse(msg.data);
                        var time = new Date().getTime();
                        console.log(time);
                        console.log(playerStats.timestamp);
                        var ping = time - playerStats.timestamp;
                        $("#game").html((ping));
                        if($("#player-"+player.id).length){
                            $("#player-"+player.id).css({"top" : player.y-25, "left" : player.x-25});
                            
                        }else{
                            $("body").append("<div id=\"player-"+player.id+"\" class='player'></div>");
                        }
                    }
                    gameServer.onclose = function () {
                        alert("closed");
                    }
                } else
                {
                    // The browser doesn't support WebSocket
                    alert("WebSocket NOT supported by your Browser!");
                }
                //WebSocketTest();


                var playerStats;

                document.onmousemove = handleMouseMove;
                setInterval(getMousePosition, 10); // setInterval repeats every X ms

                function handleMouseMove(event) {
                    var dot, eventDoc, doc, body, pageX, pageY;

                    event = event || window.event; // IE-ism

                    // If pageX/Y aren't available and clientX/Y are,
                    // calculate pageX/Y - logic taken from jQuery.
                    // (This is to support old IE)
                    if (event.pageX == null && event.clientX != null) {
                        eventDoc = (event.target && event.target.ownerDocument) || document;
                        doc = eventDoc.documentElement;
                        body = eventDoc.body;

                        event.pageX = event.clientX +
                                (doc && doc.scrollLeft || body && body.scrollLeft || 0) -
                                (doc && doc.clientLeft || body && body.clientLeft || 0);
                        event.pageY = event.clientY +
                                (doc && doc.scrollTop || body && body.scrollTop || 0) -
                                (doc && doc.clientTop || body && body.clientTop || 0);
                    }

                    playerStats = {
                        x: event.pageX,
                        y: event.pageY
                    };
                }
                function getMousePosition() {
                    var pos = playerStats;
                    if (!pos) {
                        // We haven't seen any movement yet
                    } else {

                        document.Form1.posx.value = pos.x;
                        document.Form1.posy.value = pos.y;
                        gameServer.send(JSON.stringify(playerStats));
                        playerStats.timestamp = new Date().getTime();
                    }
                }

            })

        </script>
        <div id="game">
            
        </div>
        
        <form name="Form1">
           
            POSX: <input type="text" name="posx"><br>
            POSY: <input type="text" name="posy"><br>
        </form>
    </body>
</html>
