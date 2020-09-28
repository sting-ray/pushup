CREATE TABLE `MAP` (
  `X` int(11) NOT NULL,
  `Y` int(11) NOT NULL,
  `STATUS` tinyint(1) UNSIGNED DEFAULT '0',
  `IMAGE` varchar(255) DEFAULT NULL,
  `TOLEAVE` int(11) NOT NULL DEFAULT '0',
  `TOARRIVE` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Modify the values here for your own map*/
INSERT INTO `MAP` (`X`, `Y`, `STATUS`, `IMAGE`, `TOLEAVE`, `TOARRIVE`) VALUES
(1, 0, 1, 'blocked.png', 0, 0),
(2, 0, 1, 'blocked.png', 0, 0),
(3, 0, 4, 'finish.png', 0, 0),
(4, 0, 1, 'blocked.png', 0, 0),
(5, 0, 1, 'blocked.png', 0, 0),
(1, 1, 1, 'blocked.png', 0, 0),
(2, 1, 0, 'empty.png', 1000, 0),
(3, 1, 0, 'footpath_straight.png', 980, 0),
(4, 1, 0, 'empty.png', 1000, 0),
(5, 1, 1, 'blocked.png', 0, 0),
(1, 2, 0, 'swamp.png', 920, 0),
(2, 2, 0, 'empty.png', 900, 0),
(3, 2, 0, 'footpath_y_down.png', 880, 0),
(4, 2, 0, 'empty.png', 900, 0),
(5, 2, 0, 'swamp.png', 920, 0),
(1, 3, 0, 'empty.png', 800, 0),
(2, 3, 0, 'footpath_topleft.png', 780, 0),
(3, 3, 0, 'empty.png', 800, 0),
(4, 3, 0, 'footpath_topright.png', 780, 0),
(5, 3, 0, 'empty.png', 800, 0),
(1, 4, 1, 'river.png', 0, 0),
(2, 4, 0, 'bridge.png', 680, 0),
(3, 4, 1, 'river.png', 0, 0),
(4, 4, 0, 'bridge.png', 680, 0),
(5, 4, 1, 'river.png', 0, 0),
(1, 5, 0, 'empty.png', 600, 0),
(2, 5, 0, 'footpath_straight.png', 480, 0),
(3, 5, 0, 'empty.png', 600, 0),
(4, 5, 0, 'footpath_straight.png', 580, 0),
(5, 5, 0, 'empty.png', 600, 0),
(1, 6, 0, 'swamp.png', 520, 0),
(2, 6, 0, 'footpath_straight.png', 480, 0),
(3, 6, 0, 'empty.png', 500, 0),
(4, 6, 0, 'footpath_straight.png', 480, 0),
(5, 6, 0, 'swamp.png', 520, 0),
(1, 7, 0, 'empty.png', 400, 0),
(2, 7, 0, 'footpath_bottomleft.png', 380, 0),
(3, 7, 0, 'swamp.png', 420, 0),
(4, 7, 0, 'footpath_bottomright.png', 380, 0),
(5, 7, 0, 'empty.png', 400, 0),
(1, 8, 1, 'blocked.png', 0, 0),
(2, 8, 0, 'empty.png', 300, 0),
(3, 8, 0, 'footpath_y_up.png', 280, 0),
(4, 8, 0, 'empty.png', 300, 0),
(5, 8, 1, 'blocked.png', 0, 0),
(1, 9, 1, 'blocked.png', 0, 0),
(2, 9, 1, 'blocked.png', 0, 0),
(3, 9, 3, 'start.png', 200, 0),
(4, 9, 1, 'blocked.png', 0, 0),
(5, 9, 1, 'blocked.png', 0, 0);

CREATE TABLE `PUSHUP` (
  `ID` int(11) UNSIGNED NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `DATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `FULL` int(11) UNSIGNED DEFAULT NULL,
  `KNEE` int(11) UNSIGNED DEFAULT NULL,
  `WALL` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*set a single entry for competition start date/time*/
CREATE TABLE `SETTINGS` (
  `START` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `TEAM` (
  `ID` int(11) UNSIGNED NOT NULL,
  `NAME` text,
  `CAPTAIN` int(11) DEFAULT NULL,
  `FLAG` text,
  `START_X` int(11) NOT NULL,
  `START_Y` int(11) NOT NULL,
  `POINTS` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Default teams, only need 2 teams to work.*/
/*Set captain as a user_id for each team*/
INSERT INTO `TEAM` (`ID`, `NAME`, `CAPTAIN`, `FLAG`, `START_X`, `START_Y`, `POINTS`) VALUES
(1, 'Rabbit', 0, 'rabbit.png', 3, 9, 0),
(2, 'kangaroo', 0, 'kangaroo.png', 3, 9, 0),
(3, 'Bear', 0, 'bear.png', 3, 9, 0),
(4, 'Penguin', 0, 'penguin.png', 3, 9, 0),
(5, 'Turtle', 0, 'turtle.png', 3, 9, 0);

CREATE TABLE `TEAM_MOVE` (
  `ID` int(10) UNSIGNED NOT NULL,
  `TEAM_ID` int(10) UNSIGNED NOT NULL,
  `USER_ID` int(10) UNSIGNED NOT NULL,
  `X` int(11) NOT NULL,
  `Y` int(11) NOT NULL,
  `DATETIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Entries will be created on user sign up.  Need to chagne TEAM_ID to have a user put into a team*/
CREATE TABLE `USER` (
  `ID` int(11) UNSIGNED NOT NULL,
  `NAME` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `TEAM_ID` int(11) UNSIGNED DEFAULT NULL,
  `SPONSER` varchar(255) DEFAULT NULL,
  `PRIVACY` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `PUSHUP`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `TEAM`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `TEAM_MOVE`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `USER`
  ADD PRIMARY KEY (`ID`);