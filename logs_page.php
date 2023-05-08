<?php
    
    $today = date("Y-m-d");
    // read all logs for today
    $today_logs = file("logs/room_access_log_$today.txt", FILE_IGNORE_NEW_LINES);


?>

<div class="view_all_logs">
    <h1>Today's logs (<?php echo $today; ?>)</h1>
    <table>
        <tr>
            <th>Log id</th>
            <th>Log Content</th>
        </tr>
        <?php if(!empty($today_logs)): ?>
            <?php for($i=0; $i < count($today_logs); $i++): ?>
                <tr>
                    <td><?php echo $i+1 ?></td>
                    <td><?php echo $today_logs[$i] ?></td>
                </tr>
            <?php endfor; ?>
        <?php endif; ?>
    </table>
</div>