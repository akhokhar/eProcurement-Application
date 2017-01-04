/*
SQLyog Ultimate v8.55 
MySQL - 5.5.24-log : Database - eprocurement
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`eprocurement` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `eprocurement`;

/*Table structure for table `budget_head` */

DROP TABLE IF EXISTS `budget_head`;

CREATE TABLE `budget_head` (
  `budget_head_id` int(11) NOT NULL AUTO_INCREMENT,
  `budget_head` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`budget_head_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `budget_head` */

/*Table structure for table `donor` */

DROP TABLE IF EXISTS `donor`;

CREATE TABLE `donor` (
  `donor_id` int(11) NOT NULL AUTO_INCREMENT,
  `donor_name` varchar(50) DEFAULT NULL,
  `donor_logo` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`donor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `donor` */

/*Table structure for table `location` */

DROP TABLE IF EXISTS `location`;

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `location` */

/*Table structure for table `project` */

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) DEFAULT NULL,
  `project_desc` varchar(200) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `project` */

/*Table structure for table `project_budget_head` */

DROP TABLE IF EXISTS `project_budget_head`;

CREATE TABLE `project_budget_head` (
  `project_id` int(11) NOT NULL,
  `budget_head_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`project_id`,`budget_head_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `project_budget_head` */

/*Table structure for table `project_donor` */

DROP TABLE IF EXISTS `project_donor`;

CREATE TABLE `project_donor` (
  `project_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`project_id`,`donor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `project_donor` */

/*Table structure for table `project_location` */

DROP TABLE IF EXISTS `project_location`;

CREATE TABLE `project_location` (
  `project_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`project_id`,`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `project_location` */

/*Table structure for table `requisition` */

DROP TABLE IF EXISTS `requisition`;

CREATE TABLE `requisition` (
  `requisition_id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition_num` varchar(15) DEFAULT NULL,
  `date_req` datetime DEFAULT NULL,
  `date_req_until` datetime DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `budget_head_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `donor_id` int(11) DEFAULT NULL,
  `approved_rejected_by` int(11) DEFAULT NULL,
  `is_approved` int(11) DEFAULT NULL,
  `is_tendered` tinyint(1) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`requisition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `requisition` */

/*Table structure for table `requisition_item` */

DROP TABLE IF EXISTS `requisition_item`;

CREATE TABLE `requisition_item` (
  `requisition_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(50) DEFAULT NULL,
  `item_desc` varchar(200) DEFAULT NULL,
  `cost_center` int(11) DEFAULT NULL,
  `unit` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  `requisition_id` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`requisition_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `requisition_item` */

/*Table structure for table `setting` */

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(50) DEFAULT NULL,
  `setting` text,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `setting` */

insert  into `setting`(`setting_id`,`setting_name`,`setting`) values (1,'tender','{\'tender_limit\': \'100000\'}');

/*Table structure for table `tender` */

DROP TABLE IF EXISTS `tender`;

CREATE TABLE `tender` (
  `tender_id` int(11) NOT NULL AUTO_INCREMENT,
  `tender_name` varchar(50) DEFAULT NULL,
  `tender_desc` text,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tender` */

/*Table structure for table `tender_committe` */

DROP TABLE IF EXISTS `tender_committe`;

CREATE TABLE `tender_committe` (
  `tender_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modifed` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tender_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tender_committe` */

/*Table structure for table `tender_document` */

DROP TABLE IF EXISTS `tender_document`;

CREATE TABLE `tender_document` (
  `tender_doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tender_doc_name` varchar(50) DEFAULT NULL,
  `tender_file` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_mdofied` datetime DEFAULT NULL,
  `tender_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tender_doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tender_document` */

/*Table structure for table `vendor` */

DROP TABLE IF EXISTS `vendor`;

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(50) DEFAULT NULL,
  `vendor_address` varchar(200) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vendor` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
