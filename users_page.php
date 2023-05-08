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

    // get db connection
    include("config/database_connection.php");

    // to add a user to db
    if(isset($_GET["addUser"])){
        $user_name = $_GET["user_name"];
        $user_role = $_GET["userRole"];

        $new_user = getUser($user_role, $user_name);

        // add user to db
        $addUser = "INSERT INTO users
                    (user_name, user_role) 
                    VALUES
                    ('" . $new_user->user_name . "', '". $new_user->user_role ."');";

        if(mysqli_query($conn, $addUser)){
            header("location: users_page.php");
        } else {
            echo mysqli_error($conn);
        }
    }

    // get all users from db
    $all_users = "SELECT * FROM users ORDER BY user_name";                     
    $all_users_result = mysqli_query($conn, $all_users);
    $all_users_returned = mysqli_fetch_all($all_users_result, MYSQLI_ASSOC);

    // update a user
    if(isset($_GET["updateUser"])){
        $user_id = $_GET["user_id"];
        $user_name = $_GET["change_user_name"];
        $user_role = $_GET["change_userRole"];

        $updated_user = getUser($user_role, $user_name);

        // update the user
        $update_user = "UPDATE users SET user_name = '$updated_user->user_name', user_role = '$updated_user->user_role' WHERE user_id = $user_id;";

        if(mysqli_query($conn, $update_user)){
            header("location: users_page.php");
        } else {
            echo mysqli_error($conn);
        }
    }

?>

<div class="add_user">
    <form>
        <h1>Add user</h1>
        <label>User Name</label>
        <input type="text" name="user_name" required>
        <label>User Role</label>
        <select name="userRole">
            <option>Staff Member</option>
            <option>Student</option>
            <option>Guest</option>
            <option>Contract Cleaner</option>
            <option>Manger</option>
            <option>Security</option>
            <option>Emergency Responder</option>
        </select>
        <input type="submit" value="Add User" name="addUser">
    </form>
</div>

<div class="view_all_users">
    <h1>All Users</h1>
    <table>
        <tr>
            <th>User id</th>
            <th>User Name</th>
            <th>User Role</th>
        </tr>
        <?php if(!empty($all_users_result)): ?>
            <?php foreach($all_users_result as $user): ?>
                <!-- check if user in change mode -->
                <?php if(!isset($_GET["change"]) || (isset($_GET["change"]) && $_GET["change"] !== $user["user_id"])): ?>
                    <tr>
                        <td><?php echo $user["user_id"] ?></td>
                        <td><?php echo $user["user_name"] ?></td>
                        <td><?php echo $user["user_role"] ?></td>
                        <td><a href="users_page.php?change=<?php echo $user["user_id"] ?>">Change</a></td>
                        <td><a href="inc/remove_user.php?user_id=<?php echo $user["user_id"] ?>">Delete</a></td>
                    </tr>
                <?php else: ?>
                    <tr>
                    <form>
                        <td><input value="<?php echo $user["user_id"] ?>" name="user_id" readonly="readonly"></td>
                        <td><input type="text" name="change_user_name" value="<?php echo $user["user_name"] ?>"></td>
                        <td>
                            <select name="change_userRole">
                                <option <?php echo $user["user_role"] == "Staff Member" ? "selected" : "" ?>>Staff Member</option>
                                <option <?php echo $user["user_role"] == "Student" ? "selected" : "" ?>>Student</option>
                                <option <?php echo $user["user_role"] == "Guest" ? "selected" : ""  ?>>Guest</option>
                                <option <?php echo $user["user_role"] == "Contract Cleaner" ? "selected" : "" ?>>Contract Cleaner</option>
                                <option <?php echo $user["user_role"] == "Manger" ? "selected" : "" ?>>Manger</option>
                                <option <?php echo $user["user_role"] == "Security" ? "selected" : "" ?>>Security</option>
                                <option <?php echo $user["user_role"] == "Emergency Responder" ? "selected" : "" ?>>Emergency Responder</option>
                            </select>
                        </td>
                        <td><input type="submit" name="updateUser" value="Save"></td>
                        <td><a href="inc/remove_user.php?user_id=<?php echo $user["user_id"] ?>">Delete</a></td>
                    </form>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>