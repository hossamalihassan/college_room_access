# College room access app
I implemented a web app for system for controlling access to rooms on the college site. Access to each room on each floor of each building is controlled by via a swipe card. All staff and students are permanently issued swipe cards appropriate to their role at the college while visitors are issued with a visitor card upon arrival at reception. Each room can be configured to admit a user based on the roles assigned to their swipe card, the type of room the user is trying to access, and the mode set for that room (i.e. NORMAL or EMERGENCY). In addition, certain roles may only allow access to a room at certain times. In addition to the swipe card systems normal operations, and to support health and safety requirements, it should be possible to place a room (and therein the building) into an “emergency mode”. The college reception has a supply of ‘emergency responder’ cards that can be accessed by fire, police and medical personnel. In “normal mode” these cards cannot be used to access any room. However, whenever any room is in “emergency mode”, these cards should allow access to ANY room.