<!-- index.html -->
<?php 
session_start();
if(!isset($_SESSION["userdata"]) && empty($_SESSION["userdata"]["id"])) header("Location:login.php");
$userdata = $_SESSION["userdata"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Chat</title>
</head>
<body>
    <div id="chat"></div>
    <input type="text" id="uid" placeholder="Type your ID" value="<?=$userdata["id"]?>">
    <input type="text" id="uidto" placeholder="Type your ID of receiver">
    <input type="text" id="message" placeholder="Type your message">
    <button id="send">Send</button>
    <br><br><br>
    <a href="logout.php">logout</a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var ws = new WebSocket('ws://localhost:8080?token=?<?=$userdata["u_token"]?>');

            ws.onopen = function() {
                console.log('Connected to WebSocket server');
            };

            ws.onmessage = function(event) {
                $('#chat').append('<p>' + event.data + '</p>');
            };

            $('#send').click(function() {
                var message = $('#message').val();
                var uid = $('#uid').val();
                var uidto = $('#uidto').val();

                // Create a JavaScript object to hold both message and uid
                var data = {
                    message: message,
                    uid: uid,
                    uidto: uidto
                };
                // Convert the object to JSON format
                var jsonData = JSON.stringify(data);
                // Send the JSON data to the WebSocket server
                ws.send(jsonData);
                // Clear the message input field
                $('#message').val('');
            });

        });
    </script>
</body>
</html>
