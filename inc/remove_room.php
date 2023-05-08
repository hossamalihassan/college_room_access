<?php

    include("../config/database_connection.php");
    $room_id = $_GET["room_id"];
    $remove_room = "DELETE FROM rooms WHERE room_id = $room_id";

    if(mysqli_query($conn, $remove_room)){
        header("location: ../rooms_page.php");
    } else {
        echo mysqli_error($conn);
    }

?>