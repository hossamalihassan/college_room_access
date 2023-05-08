<?php

    // to return room object based on its state
    include("inc/Room.php");
    function getRoom($roomState, $room_floor, $building_code){
        $new_room = null;
        switch($roomState) {
            case "Lecture Hall":
                $new_room = new LectureHall($room_floor, $building_code);
                break;
            case "Teaching Room":
                $new_room = new TeachingRoom($room_floor, $building_code);
                break;
            case "Secure Room":
                $new_room = new SecureRoom($room_floor, $building_code);
                break;
            case "Staff Room":
                $new_room = new StaffRoom($room_floor, $building_code);
                break;
        }

        return $new_room->getRoom();
    }

    // get db connction
    include("config/database_connection.php");

    // to add a room to db
    if(isset($_GET["addRoom"])){
        $building_code = $_GET["building_code"];
        $room_floor = $_GET["floor"];
        $roomState = $_GET["roomState"];

        $new_room = getRoom($roomState, $room_floor, $building_code);

        // add room to db
        $addRoom = "INSERT INTO rooms
                    (building_code, room_floor, room_state) 
                    VALUES
                    ('" . $new_room->building_code . "', '". $new_room->room_floor ."','" . $new_room->room_state . "');";

        if(mysqli_query($conn, $addRoom)){
            header("location: rooms_page.php");
        } else {
            echo mysqli_error($conn);
        }
    }

    // get all rooms from db
    $all_rooms = "SELECT * FROM rooms";         
    $all_rooms_result = mysqli_query($conn, $all_rooms);
    $all_rooms_returned = mysqli_fetch_all($all_rooms_result, MYSQLI_ASSOC);

    // update a room
    if(isset($_GET["updateRoom"])){
        $room_id = $_GET["room_id"];
        $building_code = $_GET["change_building_code"];
        $room_floor = $_GET["change_floor"];
        $roomState = $_GET["change_roomState"];

        $updated_room = getRoom($roomState, $room_floor, $building_code);

        // update the room
        $update_room = "UPDATE rooms SET building_code = '$updated_room->building_code', room_floor = $updated_room->room_floor, room_state = '$updated_room->room_state' WHERE room_id = $room_id;";

        if(mysqli_query($conn, $update_room)){
            header("location: rooms_page.php");
        } else {
            echo mysqli_error($conn);
        }
    }

?>

<div class="add_room">
    <form>
        <h1>Add room</h1>
        <label>Building Code</label>
        <input type="text" name="building_code" required>
        <label>Room Floor</label>
        <input type="number" name="floor" required>
        <label>Room State</label>
        <select name="roomState">
            <option>Lecture Hall</option>
            <option>Teaching Room</option>
            <option>Staff Room</option>
            <option>Secure Room</option>
        </select>
        <input type="submit" value="Add Room" name="addRoom">
    </form>
</div>

<div class="view_all_rooms">
    <h1>All Rooms</h1>
    <table>
        <tr>
            <th>Room id</th>
            <th>Building Code</th>
            <th>Room Floor</th>
            <th>Room State</th>
        </tr>
        <?php if(!empty($all_rooms_result)): ?>
            <?php foreach($all_rooms_result as $room): ?>
                <!-- check if this room in change mode -->
                <?php if(!isset($_GET["change"]) || (isset($_GET["change"]) && $_GET["change"] !== $room["room_id"])): ?>
                    <tr>
                        <td><?php echo $room["room_id"] ?></td>
                        <td><?php echo $room["building_code"] ?></td>
                        <td><?php echo $room["room_floor"] ?></td>
                        <td><?php echo $room["room_state"] ?></td>
                        <td><a href="rooms_page.php?change=<?php echo $room["room_id"] ?>">Change</a></td>
                        <td><a href="inc/remove_room.php?room_id=<?php echo $room["room_id"] ?>">Delete</a></td>
                    </tr>
                    
                <?php else: ?>
                    <tr>
                    <form>
                        <td><input value="<?php echo $room["room_id"] ?>" name="room_id" readonly="readonly"></td>
                        <td><input type="text" name="change_building_code" value="<?php echo $room["building_code"] ?>"></td>
                        <td><input type="number" name="change_floor" value="<?php echo $room["room_floor"] ?>"></td>
                        <td>
                            <select name="change_roomState">
                                <option <?php echo $room["room_state"] == "Lecture Hall" ? "selected" : "" ?>>Lecture Hall</option>
                                <option <?php echo $room["room_state"] == "Teaching Room" ? "selected" : "" ?>>Teaching Room</option>
                                <option <?php echo $room["room_state"] == "Staff Room" ? "selected" : ""  ?>>Staff Room</option>
                                <option <?php echo $room["room_state"] == "Secure Room" ? "selected" : "" ?>>Secure Room</option>
                            </select>
                        </td>
                        <td><input type="submit" name="updateRoom" value="Save"></td>
                        <td><a href="inc/remove_room.php?room_id=<?php echo $room["room_id"] ?>">Delete</a></td>
                    </form>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>