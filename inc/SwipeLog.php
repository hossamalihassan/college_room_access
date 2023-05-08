<?php

    class SwipeLog {
        public $log_date, $user_name, $user_id, $user_role, $building_code, $room_floor_number, $did_access;

        public function __construct($log_date, $user_name, $user_id, $user_role, $building_code, $room_floor_number, $did_access) {
            $this->log_date = $log_date;
            $this->user_name = $user_name;
            $this->user_id = $user_id;
            $this->user_role = $user_role;
            $this->building_code = $building_code;
            $this->room_floor_number = $room_floor_number;
            $this->did_access = $did_access;
        }
    }

?>