<?php

    // to return a user object based on his role
    include("inc/User.php");
    function getUser($user_role, $user_name){
        $new_user = null;
        switch($user_role) {
            case "Staff Member":
                $new_user = new StaffMember($user_name);
                break;
            case "Student":
                $new_user = new Student($user_name);
                break;
            case "Guest":
                $new_user = new Guest($user_name);
                break;
            case "Visitor / Guest":
                $new_user = new Guest($user_name);
                break;
            case "Contract Cleaner":
                $new_user = new ContractCleaner($user_name);
                break;
            case "Manger":
                $new_user = new Manger($user_name);
                break;
            case "Security":
                $new_user = new Security($user_name);
                break;
            case "Emergency Responder":
                $new_user = new EmergencyResponder($user_name);
                break;
        }

        return $new_user;
    }

    // to return room object based on its state
    include("inc/Room.php");
    function getRoom($roomState, $room_floor, $building_code){
        $new_room = null;
        switch($roomState) {
            case "LectureHall":
                $new_room = new LectureHall($room_floor, $building_code);
                break;
            case "TeachingRoom":
                $new_room = new TeachingRoom($room_floor, $building_code);
                break;
            case "SecureRoom":
                $new_room = new SecureRoom($room_floor, $building_code);
                break;
            case "StaffRoom":
                $new_room = new StaffRoom($room_floor, $building_code);
                break;
        }

        return $new_room->getRoom();
    }

    // get db connection
    include("config/database_connection.php");

    // get all users from db
    $all_users = "SELECT * FROM users ORDER BY user_name";                    
    $all_users_result = mysqli_query($conn, $all_users);
    $all_users_returned = mysqli_fetch_all($all_users_result, MYSQLI_ASSOC);

    // get all rooms from db
    $all_rooms = "SELECT * FROM rooms";                
    $all_rooms_result = mysqli_query($conn, $all_rooms);
    $all_rooms_returned = mysqli_fetch_all($all_rooms_result, MYSQLI_ASSOC);

?>


<div class="simulation">
    <form>
        <h1>Simulation</h1>
        <label>Choose a user</label>
        <select name="user_name">
            <!-- print all users -->
            <?php foreach($all_users_returned as $user): ?>
                <option><?php echo $user["user_name"] ?></option> 
            <?php endforeach; ?>
        </select>
        <label>Choose a room</label>
        <select name="roomState">
            <!-- print all rooms -->
            <?php foreach($all_rooms_returned as $room): ?>
                <option><?php echo str_replace(' ', '', $room["room_state"]) . " " . str_replace(' ', '', $room["building_code"]) . " " . str_replace(' ', '', $room["room_floor"]) ?></option> 
            <?php endforeach; ?>
        </select>
        <input type="radio" name="mode" id="norm" value="Normal" checked>
        <label for="norm">Normal Mode</label>
        <input type="radio" name="mode" id="emerg" value="Emergency">
        <label for="emerg">Emergency Mode</label>
        <input type="submit" value="Simulate" name="simulate">
    </form>
</div>

<div class="simulation-result">

<?php

    if(isset($_GET["simulate"])){
        $mode = $_GET["mode"];
        $user_name = $_GET["user_name"];
        $room_state = $_GET["roomState"];
        $room_info_arr = explode(" ", $room_state);

        // get user's role from db
        $get_user = "SELECT * FROM users WHERE user_name = '$user_name';";   
        $user_result = mysqli_query($conn, $get_user);
        $user_returned = mysqli_fetch_assoc($user_result);
        $user_role = $user_returned["user_role"];
        $user_id = $user_returned["user_id"];

        // create room and user objects to simulate
        $test_user = getUser($user_role, $user_name);
        $test_room = getRoom($room_info_arr[0], $room_info_arr[2], $room_info_arr[1]);

        // to check for swipe card
        $allowed_mode = false;
        $allowed_time = false;
        $allowed_room = false;
        $allow_swipe = "NO";

        // check for time
        $now = date("H:i:s");
        $user_allowed_time = $test_user->time_allowed_to_swipe_in;
        for($i=0; $i < count($user_allowed_time); $i++){
            $start_time = $user_allowed_time[$i][0];
            $end_time = $user_allowed_time[$i][1];
            if($now >= $start_time && $now <= $end_time){
                $allowed_time = true;
            }
        }

        // check for mode
        if($mode == "Emergency" && $test_user->access_in_emergency_mode){
            $allowed_mode = true;
        } else if($mode == "Normal" && $test_user->access_in_normal_mode){
            $allowed_mode = true;
        }

        // check for room
        $user_allowed_rooms = $test_user->allowed_rooms;
        for($i=0; $i < count($user_allowed_rooms); $i++){
            if($user_allowed_rooms[$i] == $test_room->room_state){
                $allowed_room = true;
            }
        } 

        // check if allowed
        if($allowed_mode && $allowed_time && $allowed_room){
            $allow_swipe = "YES";
        }
        
        // create log class and print the log
        include("inc/SwipeLog.php");
        $log = new SwipeLog(date("H:i:s"), $user_name, $user_id, $user_role, $room_info_arr[1], $room_info_arr[2], $allow_swipe);
        echo "<h3>Swipe Log</h3>";
        echo "Date: $log->log_date<br>";
        echo "User Name: $log->user_name<br>";
        echo "User ID: $log->user_id<br>";
        echo "User Role: $log->user_role<br>";
        echo "Building Code: $log->building_code<br>";
        echo "Room Floor: $log->room_floor_number<br>";
        echo "Access was granted ? $log->did_access";

        // write to logs file
        $today = date("Y-m-d");
        $content = "Date: $log->log_date, User Name: $log->user_name, User ID: $log->user_id, User Role: $log->user_role, Building Code: $log->building_code, Room Floor: $log->room_floor_number, Access was granted ? $log->did_access\n";
        $mode;
        if(file_exists("logs/room_access_log_$today.txt")){   
            $mode = "a";
        } else {     
            $mode = "w";
        }
        $fp = fopen("logs/room_access_log_$today.txt", $mode);
        fwrite($fp,$content);
        fclose($fp);
    }
    

?>

</div>