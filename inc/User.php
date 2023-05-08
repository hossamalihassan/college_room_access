<?php

    class User {
        public $user_name;
        public $user_role;
        public $access_in_normal_mode;
        public $access_in_emergency_mode;
        public $allowed_rooms;
        public $time_allowed_to_swipe_in;
        
        public function getUser(){
            return $this;
        }
    }

    class StaffMember extends User {
        public function __construct($user_name) {
            $this->user_name = $user_name;
            $this->user_role = "Staff Member";
            $this->access_in_normal_mode = true;
            $this->access_in_emergency_mode = false;
            $this->allowed_rooms = ["Lecture Hall", "Student Lab", "Research Lab", "Staff Room"];
            $this->time_allowed_to_swipe_in = [date("H:i:s", mktime(5, 30)), date("H:i:s", mktime(23, 59, 59))];
        }
    }

    class Student extends User {
        public function __construct($user_name) {
            $this->user_name = $user_name;
            $this->user_role = "Student";
            $this->access_in_normal_mode = true;
            $this->access_in_emergency_mode = false;
            $this->allowed_rooms = ["Lecture Hall", "Teaching Room"];
            $this->time_allowed_to_swipe_in = [date("H:i:s", mktime(8, 30)), date("H:i:s", mktime(22, 0))];
        }
    }

    class Guest extends User {
        public function __construct($user_name) {
            $this->user_name = $user_name;
            $this->user_role = "Visitor / Guest";
            $this->access_in_normal_mode = true;
            $this->access_in_emergency_mode = false;
            $this->allowed_rooms = ["Lecture Hall"];
            $this->time_allowed_to_swipe_in = [[date("H:i:s", mktime(8, 30)), date("H:i:s", mktime(22, 0))]];
        }
    }

    class ContractCleaner extends User {
        public function __construct($user_name) {
            $this->user_name = $user_name;
            $this->user_role = "Contract Cleaner";
            $this->access_in_normal_mode = true;
            $this->access_in_emergency_mode = false;
            $this->allowed_rooms = ["Lecture Hall", "Teaching Room", "Research Lab", "Staff Room"];
            $this->time_allowed_to_swipe_in = [[date("H:i:s", mktime(5, 30)), date("H:i:s", mktime(10, 30))], [date("H:i:s", mktime(17, 30)), date("H:i:s", mktime(22, 30))]];
        }
    }

    class Manger extends User {
        public function __construct($user_name) {
            $this->user_name = $user_name;
            $this->user_role = "Contract Cleaner";
            $this->access_in_normal_mode = true;
            $this->access_in_emergency_mode = false;
            $this->allowed_rooms = ["Lecture Hall", "Teaching Room", "Research Lab", "Staff Room", "Secure Room"];
            $this->time_allowed_to_swipe_in = [[date("H:i:s", mktime(0, 0)), date("H:i:s", mktime(23, 59))]];
        }
    }

    class Security extends User {
        public function __construct($user_name) {
            $this->user_name = $user_name;
            $this->user_role = "Security";
            $this->access_in_normal_mode = true;
            $this->access_in_emergency_mode = true;
            $this->allowed_rooms = ["Lecture Hall", "Teaching Room", "Research Lab", "Staff Room", "Secure Room"];
            $this->time_allowed_to_swipe_in = [[date("H:i:s", mktime(0, 0)), date("H:i:s", mktime(23, 59))]];
        }
    }
    
    class EmergencyResponder extends User {
        public function __construct($user_name) {
            $this->user_name = $user_name;
            $this->user_role = "Emergency Responder";
            $this->access_in_normal_mode = false;
            $this->access_in_emergency_mode = true;
            $this->allowed_rooms = ["Lecture Hall", "Teaching Room", "Research Lab", "Staff Room", "Secure Room"];
            $this->time_allowed_to_swipe_in = [[date("H:i:s", mktime(0, 0)), date("H:i:s", mktime(23, 59))]];
        }
    }

?>