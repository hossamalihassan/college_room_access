<?php

    class Room {
        public $room_state;
        public $room_puropse;
        public $building_code;
        public $room_floor;

        public function getRoom(){
            return $this;
        }
    }

    class LectureHall extends Room {
        public function __construct($room_floor, $building_code) {
            $this->room_state = "Lecture Hall";
            $this->building_code = $building_code;
            $this->room_floor = $room_floor;
            $this->room_puropse = "This type of room is used to deliver lectures and talks to many students.";
        }
    }

    class TeachingRoom extends Room {
        public function __construct($room_floor, $building_code) {
            $this->room_state = "Teaching Room";
            $this->building_code = $building_code;
            $this->room_floor = $room_floor;
            $this->room_puropse = "This type of room is used to deliver lectures and practical sessions to students";
        }
    }

    class StaffRoom extends Room {
        public function __construct($room_floor, $building_code) {
            $this->room_state = "Staff Room";
            $this->building_code = $building_code;
            $this->room_floor = $room_floor;
            $this->room_puropse = "These are the lecturer's offices and college administration rooms.";
        }
    }

    class SecureRoom extends Room {
        public function __construct($room_floor, $building_code) {
            $this->room_state = "Secure Room";
            $this->building_code = $building_code;
            $this->room_floor = $room_floor;
            $this->room_puropse = "These rooms hold sensitive or dangerous equipment or chemicals.";
        }
    }

?>