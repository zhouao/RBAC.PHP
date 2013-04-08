/*
SQLyog v10.2 
MySQL - 5.1.67-log : Database - ws51rbac
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `rbac_objects` */

DROP TABLE IF EXISTS `rbac_objects`;

CREATE TABLE `rbac_objects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mode` enum('None','MCAD','NTier') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NTier' COMMENT '0:None 1:MCAD  2:N-Tier Control',
  `type` enum('None','Object','Rights','Data') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Object' COMMENT '0:None 1:Object 2:Rights 3:Resource/Data',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:ROOT MCAD=[1:Module 2:Class 3:Action 4:Data]',
  `tier` tinyint(4) NOT NULL DEFAULT '1',
  `key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `parents_path` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=280 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rbac_objects` */

insert  into `rbac_objects`(`id`,`name`,`mode`,`type`,`level`,`tier`,`key`,`parent_id`,`parents_path`) values (1,'根系统','NTier','Object',1,1,NULL,0,NULL),(234,'万事无忧招聘','NTier','Object',1,1,NULL,1,'1'),(235,'管理后台','NTier','Object',1,1,NULL,234,'1,234'),(236,'公共前台','NTier','Object',1,1,NULL,234,'1,234'),(237,'首页','NTier','Object',1,1,'default.index.init',236,'1,234,236'),(238,'会员中心','NTier','Object',1,1,NULL,234,'1,234'),(239,'会员管理','NTier','Object',1,1,NULL,235,'1,234,235'),(240,'会员认证','NTier','Object',1,1,NULL,239,'1,234,235,239'),(241,'会员相关','NTier','Object',1,1,NULL,239,'1,234,235,239'),(242,'个人会员','NTier','Object',1,1,NULL,240,'1,234,235,239,240'),(243,'企业会员','NTier','Object',1,1,NULL,240,'1,234,235,239,240'),(244,'万事无忧威客','NTier','Object',1,1,NULL,1,'1'),(245,'个人会员中心','NTier','Object',1,1,'personal',244,'1,244'),(246,'XXOO项目','NTier','Object',1,1,NULL,1,'1'),(247,'首页','NTier','Object',1,1,'personal.index.init',238,'1,234,238'),(249,'我的帐户','NTier','Object',1,1,'personal.basic',238,'1,234,238'),(250,'简历管理','NTier','Object',1,1,NULL,238,'1,234,238'),(251,'应聘管理','NTier','Object',1,1,NULL,238,'1,234,238'),(252,'职位搜索','NTier','Object',1,1,NULL,238,'1,234,238'),(253,'消息管理','NTier','Object',1,1,NULL,238,'1,234,238'),(254,'积分管理','NTier','Object',1,1,NULL,238,'1,234,238'),(255,'圈子管理','NTier','Object',1,1,NULL,238,'1,234,238'),(256,'个人档案','NTier','Object',1,1,'personal.basic.myaccount',249,'1,234,238,249'),(257,'账户设置','NTier','Object',1,1,NULL,249,'1,234,238,249'),(258,'导入简历','NTier','Object',1,1,NULL,250,'1,234,238,250'),(259,'普工简历','NTier','Object',1,1,NULL,250,'1,234,238,250'),(260,'人才简历','NTier','Object',1,1,NULL,250,'1,234,238,250'),(261,'求职信','NTier','Object',1,1,NULL,250,'1,234,238,250'),(262,'外发简历','NTier','Object',1,1,NULL,250,'1,234,238,250'),(263,'隐私设置','NTier','Object',1,1,NULL,250,'1,234,238,250'),(264,'屏蔽公司','NTier','Object',1,1,NULL,250,'1,234,238,250'),(266,'应聘记录','NTier','Object',1,1,NULL,251,'1,234,238,251'),(267,'面试邀请','NTier','Object',1,1,NULL,251,'1,234,238,251'),(268,'谁看过我','NTier','Object',1,1,NULL,251,'1,234,238,251'),(269,'我看过谁','NTier','Object',1,1,NULL,251,'1,234,238,251'),(270,'收藏职位','NTier','Object',1,1,NULL,251,'1,234,238,251'),(271,'特别关注','NTier','Object',1,1,NULL,251,'1,234,238,251'),(272,'高级搜索','NTier','Object',1,1,NULL,252,'1,234,238,252'),(273,'搜索器','NTier','Object',1,1,NULL,252,'1,234,238,252'),(274,'我的消息','NTier','Object',1,1,NULL,253,'1,234,238,253'),(275,'发送记录','NTier','Object',1,1,NULL,253,'1,234,238,253'),(276,'我的积分','NTier','Object',1,1,NULL,254,'1,234,238,254'),(277,'积分明细','NTier','Object',1,1,NULL,254,'1,234,238,254'),(278,'我的圈子','NTier','Object',1,1,NULL,255,'1,234,238,255'),(279,'圈子搜索','NTier','Object',1,1,NULL,255,'1,234,238,255');

/*Table structure for table `rbac_oo_mappings` */

DROP TABLE IF EXISTS `rbac_oo_mappings`;

CREATE TABLE `rbac_oo_mappings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL DEFAULT '0',
  `operation_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '支持{0}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rbac_oo_mappings` */

insert  into `rbac_oo_mappings`(`id`,`object_id`,`operation_id`,`name`) values (56,243,3,'删除'),(57,243,6,'编辑'),(58,242,6,'编辑'),(59,242,7,'浏览');

/*Table structure for table `rbac_operations` */

DROP TABLE IF EXISTS `rbac_operations`;

CREATE TABLE `rbac_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('public','private') COLLATE utf8_unicode_ci DEFAULT 'public' COMMENT '0:公共  1:私有',
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rbac_operations` */

insert  into `rbac_operations`(`id`,`type`,`name`,`parent_id`) values (1,'public','常规操作',0),(2,'public','增加',1),(3,'public','删除',1),(4,'public','修改',1),(5,'public','查看',1),(6,'public','编辑',4),(7,'public','浏览',5),(8,'public','搜索',5),(9,'public','查看明细',5);

/*Table structure for table `rbac_permission_scopes` */

DROP TABLE IF EXISTS `rbac_permission_scopes`;

CREATE TABLE `rbac_permission_scopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `owner_type` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `begin` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `items` tinytext COLLATE utf8_unicode_ci,
  `expression` tinytext COLLATE utf8_unicode_ci,
  `is_denied` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rbac_permission_scopes` */

insert  into `rbac_permission_scopes`(`id`,`owner_id`,`owner_type`,`permission_id`,`begin`,`end`,`items`,`expression`,`is_denied`) values (1,0,0,1,'1000','2000',NULL,NULL,'\0'),(2,0,0,2,NULL,NULL,'5,6,7,8,9,10',NULL,'');

/*Table structure for table `rbac_permissions` */

DROP TABLE IF EXISTS `rbac_permissions`;

CREATE TABLE `rbac_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner_type` tinyint(4) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `is_forcedown` tinyint(1) NOT NULL DEFAULT '0',
  `is_denied` tinyint(1) NOT NULL DEFAULT '1',
  `begin_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rbac_permissions` */

insert  into `rbac_permissions`(`id`,`name`,`owner_type`,`owner_id`,`object_id`,`operation_id`,`is_forcedown`,`is_denied`,`begin_time`,`end_time`) values (1,NULL,1,14,1,1,1,0,NULL,NULL),(2,NULL,1,14,1,2,1,0,NULL,NULL),(3,NULL,1,10,247,0,1,0,NULL,NULL),(4,NULL,1,10,237,0,1,0,NULL,NULL),(5,NULL,1,10,256,0,1,0,NULL,NULL),(6,NULL,0,0,0,0,0,1,NULL,NULL);

/*Table structure for table `rbac_role_inherit_mappings` */

DROP TABLE IF EXISTS `rbac_role_inherit_mappings`;

CREATE TABLE `rbac_role_inherit_mappings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `derived_role_id` tinyint(1) NOT NULL,
  `parent_role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rbac_role_inherit_mappings` */

/*Table structure for table `rbac_roles` */

DROP TABLE IF EXISTS `rbac_roles`;

CREATE TABLE `rbac_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `parents_path` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rbac_roles` */

insert  into `rbac_roles`(`id`,`name`,`parent_id`,`parents_path`) values (1,'Everyone',0,''),(2,'Users',1,'1'),(3,'Manager',1,'1'),(4,'Member',2,'1,2'),(5,'VIP1',4,'1,2,4'),(6,'VIP2',4,'1,2,4'),(7,'VIP3',4,'1,2,4'),(8,'VIP4',4,'1,2,4'),(9,'VIP5',4,'1,2,4');

/*Table structure for table `rbac_user_role_mappings` */

DROP TABLE IF EXISTS `rbac_user_role_mappings`;

CREATE TABLE `rbac_user_role_mappings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rbac_user_role_mappings` */

/*Table structure for table `rbac_users` */

DROP TABLE IF EXISTS `rbac_users`;

CREATE TABLE `rbac_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rbac_users` */

insert  into `rbac_users`(`id`,`name`,`password`,`add_time`) values (2,'zhouao','123123',NULL),(3,'aaaa','cccc',NULL);

/*Table structure for table `sys_tempstorage` */

DROP TABLE IF EXISTS `sys_tempstorage`;

CREATE TABLE `sys_tempstorage` (
  `id` int(11) NOT NULL,
  `key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `tiny_int_value` int(11) DEFAULT NULL,
  `int_value` mediumint(9) DEFAULT NULL,
  `big_int_value` bigint(20) DEFAULT NULL,
  `tiny_mixed_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_mixed_value` tinytext COLLATE utf8_unicode_ci,
  `big_mixed_value` text COLLATE utf8_unicode_ci,
  `tiny_string_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_string_value` tinytext COLLATE utf8_unicode_ci,
  `big_string_value` text COLLATE utf8_unicode_ci,
  `expire` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sys_tempstorage` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
