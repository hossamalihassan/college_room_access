<?php

    include("../config/database_connection.php");
    $user_id = $_GET["user_id"];
    $remove_user = "DELETE FROM users WHERE user_id = $user_id";

    if(mysqli_query($conn, $remove_user)){
        header("location: ../users_page.php");
    } else {
        echo mysqli_error($conn);
    }

?>