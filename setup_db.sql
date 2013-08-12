SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `exalted_individual_results`
--

DROP TABLE IF EXISTS `exalted_individual_results`;
CREATE TABLE IF NOT EXISTS `exalted_individual_results` (
  `roll_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `roll_count` int(10) unsigned NOT NULL DEFAULT '0',
  `roll_result` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `exalted_roll_info`
--

DROP TABLE IF EXISTS `exalted_roll_info`;
CREATE TABLE IF NOT EXISTS `exalted_roll_info` (
  `roll_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `character_name` text,
  `character_action` text,
  `pool` smallint(5) unsigned NOT NULL DEFAULT '0',
  `difficulty` tinyint(3) unsigned DEFAULT NULL,
  `target_number` tinyint(3) unsigned DEFAULT NULL,
  `used_wp` tinyint(1) unsigned DEFAULT NULL,
  `initiative` tinyint(1) unsigned DEFAULT NULL,
  `damage_roll` tinyint(1) unsigned DEFAULT NULL,
  `roll_time` datetime DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`roll_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=188547 ;



-- --------------------------------------------------------

--
-- Table structure for table `hits`
--

DROP TABLE IF EXISTS `hits`;
CREATE TABLE IF NOT EXISTS `hits` (
  `roller` varchar(255) NOT NULL DEFAULT '',
  `hits` bigint(20) unsigned NOT NULL DEFAULT '0',
  `begin_date` datetime DEFAULT NULL,
  PRIMARY KEY (`roller`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `sr4_individual_rolls`
--

DROP TABLE IF EXISTS `sr4_individual_rolls`;
CREATE TABLE IF NOT EXISTS `sr4_individual_rolls` (
  `roll_id` int(10) unsigned NOT NULL,
  `die_result` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sr4_roll_info`
--

DROP TABLE IF EXISTS `sr4_roll_info`;
CREATE TABLE IF NOT EXISTS `sr4_roll_info` (
  `roll_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roll_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `pool` smallint(5) unsigned NOT NULL,
  `edge_roll` tinyint(1) unsigned NOT NULL,
  `secret_id` varchar(50) NOT NULL,
  PRIMARY KEY (`roll_id`),
  KEY `roll_time` (`roll_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1276 ;


-- --------------------------------------------------------

--
-- Table structure for table `wod2_individual_results`
--

DROP TABLE IF EXISTS `wod2_individual_results`;
CREATE TABLE IF NOT EXISTS `wod2_individual_results` (
  `roll_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `roll_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `result` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `wod2_roll_info`
--

DROP TABLE IF EXISTS `wod2_roll_info`;
CREATE TABLE IF NOT EXISTS `wod2_roll_info` (
  `roll_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `roll_time` datetime DEFAULT NULL,
  `character_name` text,
  `character_action` text,
  `ip_address` varchar(15) DEFAULT NULL,
  `pool` smallint(6) DEFAULT NULL,
  `initiative` tinyint(4) DEFAULT '0',
  `reroll_floor` tinyint(4) DEFAULT '10',
  `used_wp` tinyint(4) DEFAULT '0',
  `ones_subtract` tinyint(4) DEFAULT '0',
  `chance_roll` tinyint(4) DEFAULT '0',
  `rote_action` tinyint(4) DEFAULT '0',
  `advanced_action` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`roll_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=324911 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
