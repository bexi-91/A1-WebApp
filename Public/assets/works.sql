CREATE TABLE `works` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `taskname` varchar(30) NOT NULL,
  `duedate` date DEFAULT NULL,
  `taskdetails` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
