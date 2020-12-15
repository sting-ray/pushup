--
-- Table structure for table `SETTINGS`
--

CREATE TABLE `SETTINGS` (
  `START` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SETTINGS`
--

-- ----------- Set the Competition Start date/time here ----------------------

INSERT INTO `SETTINGS` (`START`) VALUES
('2020-12-07 11:00:00');


--
-- Table structure for table `AUTH_TOKENS`
--

CREATE TABLE `AUTH_TOKENS` (
  `ID` int(11) NOT NULL,
  `SELECTOR` char(12) NOT NULL,
  `VALIDATOR` char(64) NOT NULL,
  `USER_ID` int(10) UNSIGNED NOT NULL,
  `CREATED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EXPIRES` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `EMOTICON`
--

CREATE TABLE `EMOTICON` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `IMAGE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EMOTICON`
--

INSERT INTO `EMOTICON` (`ID`, `NAME`, `IMAGE`) VALUES
(1, 'Smile', 'smile.png'),
(2, 'Shocked', 'shocked.png'),
(3, 'Thumbs Up', 'thumbs_up.png');


--
-- Table structure for table `EMOTICON_JT`
--

CREATE TABLE `EMOTICON_JT` (
  `ID` int(10) UNSIGNED NOT NULL,
  `EMOTICON_ID` int(10) UNSIGNED DEFAULT NULL,
  `PUSHUP_ID` int(10) UNSIGNED DEFAULT NULL,
  `TEAM_MOVE_ID` int(10) UNSIGNED DEFAULT NULL,
  `USER_ID` int(10) UNSIGNED DEFAULT NULL,
  `CREATED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `MAP`
--

CREATE TABLE `MAP` (
  `X` int(11) NOT NULL,
  `Y` int(11) NOT NULL,
  `STATUS` tinyint(1) UNSIGNED DEFAULT '0',
  `IMAGE` varchar(255) DEFAULT NULL,
  `TOLEAVE` int(11) NOT NULL DEFAULT '0',
  `TOARRIVE` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MAP`
--

-- --------------------------Modify for the map that you want----------------

INSERT INTO `MAP` (`X`, `Y`, `STATUS`, `IMAGE`, `TOLEAVE`, `TOARRIVE`) VALUES
(1, 0, 1, '1-0.png', 0, 0),
(2, 0, 1, '2-0.png', 0, 0),
(3, 0, 4, '3-0.png', 0, 0),
(4, 0, 1, '4-0.png', 0, 0),
(5, 0, 1, '5-0.png', 0, 0),
(1, 1, 1, '1-1.png', 0, 0),
(2, 1, 0, '2-1.png', 400, 0),
(3, 1, 0, '3-1.png', 400, 0),
(4, 1, 0, '4-1.png', 400, 0),
(5, 1, 1, '5-1.png', 0, 0),
(1, 2, 0, '1-2.png', 370, 0),
(2, 2, 0, '2-2.png', 350, 0),
(3, 2, 0, '3-2.png', 570, 0),
(4, 2, 0, '4-2.png', 350, 0),
(5, 2, 0, '5-2.png', 370, 0),
(1, 3, 0, '1-3.png', 340, 0),
(2, 3, 0, '2-3.png', 540, 0),
(3, 3, 0, '3-3.png', 320, 0),
(4, 3, 0, '4-3.png', 540, 0),
(5, 3, 0, '5-3.png', 340, 0),
(1, 4, 0, '1-4.png', 310, 0),
(2, 4, 0, '2-4.png', 290, 0),
(3, 4, 0, '3-4.png', 510, 0),
(4, 4, 0, '4-4.png', 290, 0),
(5, 4, 0, '5-4.png', 310, 0),
(1, 5, 1, '1-5.png', 0, 0),
(2, 5, 0, '2-5.png', 260, 0),
(3, 5, 1, '3-5.png', 0, 0),
(4, 5, 0, '4-5.png', 260, 0),
(5, 5, 1, '5-5.png', 0, 0),
(1, 6, 0, '1-6.png', 250, 0),
(2, 6, 0, '2-6.png', 230, 0),
(3, 6, 0, '3-6.png', 450, 0),
(4, 6, 0, '4-6.png', 230, 0),
(5, 6, 0, '5-6.png', 250, 0),
(1, 7, 0, '1-7.png', 220, 0),
(2, 7, 0, '2-7.png', 420, 0),
(3, 7, 0, '3-7.png', 200, 0),
(4, 7, 0, '4-7.png', 420, 0),
(5, 7, 0, '5-7.png', 220, 0),
(1, 8, 0, '1-8.png', 190, 0),
(2, 8, 0, '2-8.png', 170, 0),
(3, 8, 0, '3-8.png', 390, 0),
(4, 8, 0, '4-8.png', 170, 0),
(5, 8, 0, '5-8.png', 190, 0),
(1, 9, 1, '1-9.png', 0, 0),
(2, 9, 0, '2-9.png', 160, 0),
(3, 9, 0, '3-9.png', 160, 0),
(4, 9, 0, '4-9.png', 160, 0),
(5, 9, 1, '5-9.png', 0, 0),
(1, 10, 1, '1-10.png', 0, 0),
(2, 10, 1, '2-10.png', 0, 0),
(3, 10, 3, '3-10.png', 130, 0),
(4, 10, 1, '4-10.png', 0, 0),
(5, 10, 1, '5-10.png', 0, 0);


--
-- Table structure for table `PUSHUP`
--

CREATE TABLE `PUSHUP` (
  `ID` int(11) UNSIGNED NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `DATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `FULL` int(11) UNSIGNED DEFAULT NULL,
  `KNEE` int(11) UNSIGNED DEFAULT NULL,
  `WALL` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `TEAM`
--

CREATE TABLE `TEAM` (
  `ID` int(11) UNSIGNED NOT NULL,
  `NAME` text,
  `CAPTAIN` int(11) DEFAULT NULL,
  `FLAG` text,
  `START_X` int(11) NOT NULL,
  `START_Y` int(11) NOT NULL,
  `POINTS` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `TEAM_MOVE`
--

CREATE TABLE `TEAM_MOVE` (
  `ID` int(10) UNSIGNED NOT NULL,
  `TEAM_ID` int(10) UNSIGNED NOT NULL,
  `USER_ID` int(10) UNSIGNED NOT NULL,
  `X` int(11) NOT NULL,
  `Y` int(11) NOT NULL,
  `DATETIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `ID` int(11) UNSIGNED NOT NULL,
  `NAME` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `TEAM_ID` int(11) UNSIGNED DEFAULT NULL,
  `SPONSER` varchar(255) DEFAULT NULL,
  `PRIVACY` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `PUSHUP_ESTIMATE` int(11) DEFAULT NULL,
  `PUSHUP_ESTIMATE_TYPE` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `AUTH_TOKENS`
--
ALTER TABLE `AUTH_TOKENS`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `EMOTICON`
--
ALTER TABLE `EMOTICON`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `EMOTICON_JT`
--
ALTER TABLE `EMOTICON_JT`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `PUSHUP`
--
ALTER TABLE `PUSHUP`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `TEAM`
--
ALTER TABLE `TEAM`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `TEAM_MOVE`
--
ALTER TABLE `TEAM_MOVE`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`ID`);