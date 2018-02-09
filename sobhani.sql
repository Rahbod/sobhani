/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : sobhani

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-02-09 23:04:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_admins
-- ----------------------------
DROP TABLE IF EXISTS `ym_admins`;
CREATE TABLE `ym_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(11) unsigned NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `ym_admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admins
-- ----------------------------
INSERT INTO `ym_admins` VALUES ('1', 'rahbod', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'gharagozlu.masoud@gmial.com', '1');
INSERT INTO `ym_admins` VALUES ('28', 'admin', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'k.rahebi@gmail.com', '2');

-- ----------------------------
-- Table structure for ym_admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_admin_roles`;
CREATE TABLE `ym_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'عنوان نقش',
  `role` varchar(255) NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admin_roles
-- ----------------------------
INSERT INTO `ym_admin_roles` VALUES ('1', 'Super Admin', 'superAdmin');
INSERT INTO `ym_admin_roles` VALUES ('2', 'مدیریت', 'admin');

-- ----------------------------
-- Table structure for ym_admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `ym_admin_role_permissions`;
CREATE TABLE `ym_admin_role_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `role_id` int(10) unsigned DEFAULT NULL COMMENT 'نقش',
  `module_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ماژول',
  `controller_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'کنترلر',
  `actions` text CHARACTER SET utf8 COMMENT 'اکشن ها',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_admin_role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1105 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_admin_role_permissions
-- ----------------------------
INSERT INTO `ym_admin_role_permissions` VALUES ('1093', '2', 'base', 'TagsController', 'index,create,update,admin,delete,list');
INSERT INTO `ym_admin_role_permissions` VALUES ('1094', '2', 'admins', 'AdminsDashboardController', 'index');
INSERT INTO `ym_admin_role_permissions` VALUES ('1095', '2', 'admins', 'AdminsManageController', 'index,views,create,update,admin,sessions,removeSession,changePass,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1096', '2', 'admins', 'AdminsRolesController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1097', '2', 'comments', 'CommentsCommentController', 'delete,approve,admin');
INSERT INTO `ym_admin_role_permissions` VALUES ('1098', '2', 'lists', 'ListsCategoryController', 'view,index,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1099', '2', 'lists', 'ListsManageController', 'index,create,update,admin,delete,upload,deleteUpload,uploadItem,deleteUploadItem,changeStatus');
INSERT INTO `ym_admin_role_permissions` VALUES ('1100', '2', 'pages', 'PageCategoriesManageController', 'index,view,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1101', '2', 'pages', 'PagesManageController', 'index,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1102', '2', 'setting', 'SettingManageController', 'gatewaySetting,changeSetting,socialLinks');
INSERT INTO `ym_admin_role_permissions` VALUES ('1103', '2', 'users', 'UsersManageController', 'index,view,create,update,admin,delete,userTransactions,transactions,dealerships,createDealership,updateDealership,upload,deleteUpload,dealershipRequests,dealershipRequest,deleteDealershipRequest');
INSERT INTO `ym_admin_role_permissions` VALUES ('1104', '2', 'users', 'UsersRolesController', 'create,update,admin,delete');

-- ----------------------------
-- Table structure for ym_comments
-- ----------------------------
DROP TABLE IF EXISTS `ym_comments`;
CREATE TABLE `ym_comments` (
  `owner_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `owner_id` int(12) NOT NULL,
  `comment_id` int(12) NOT NULL AUTO_INCREMENT,
  `parent_comment_id` int(12) DEFAULT NULL,
  `creator_id` int(12) DEFAULT NULL,
  `user_name` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_email` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `comment_text` text COLLATE utf8_persian_ci,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `owner_name` (`owner_name`,`owner_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_comments
-- ----------------------------
INSERT INTO `ym_comments` VALUES ('ListItemRel', '514', '8', null, '43', 'Admin', null, 'سلام تست نظر...', '1518112921', '1518184134', '1');

-- ----------------------------
-- Table structure for ym_counter_save
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_save`;
CREATE TABLE `ym_counter_save` (
  `save_name` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `save_value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`save_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_counter_save
-- ----------------------------
INSERT INTO `ym_counter_save` VALUES ('counter', '142');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2458159');
INSERT INTO `ym_counter_save` VALUES ('max_count', '16');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1516609800');
INSERT INTO `ym_counter_save` VALUES ('yesterday', '6');

-- ----------------------------
-- Table structure for ym_counter_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_users`;
CREATE TABLE `ym_counter_users` (
  `user_ip` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `user_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_counter_users
-- ----------------------------
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1518203420');

-- ----------------------------
-- Table structure for ym_items
-- ----------------------------
DROP TABLE IF EXISTS `ym_items`;
CREATE TABLE `ym_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `status` decimal(1,0) unsigned DEFAULT '0' COMMENT 'وضعیت',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_items
-- ----------------------------
INSERT INTO `ym_items` VALUES ('13', '1', '1');
INSERT INTO `ym_items` VALUES ('14', '2', '1');
INSERT INTO `ym_items` VALUES ('15', '3', '1');
INSERT INTO `ym_items` VALUES ('16', '4', '1');
INSERT INTO `ym_items` VALUES ('17', '5', '1');
INSERT INTO `ym_items` VALUES ('18', '6', '1');
INSERT INTO `ym_items` VALUES ('19', '7', '1');
INSERT INTO `ym_items` VALUES ('20', '8', '1');
INSERT INTO `ym_items` VALUES ('21', '9', '1');
INSERT INTO `ym_items` VALUES ('22', '10', '1');
INSERT INTO `ym_items` VALUES ('23', 'سلام', '1');
INSERT INTO `ym_items` VALUES ('24', 'asdf', '1');
INSERT INTO `ym_items` VALUES ('25', 'sadga', '1');
INSERT INTO `ym_items` VALUES ('26', 'asdg', '1');
INSERT INTO `ym_items` VALUES ('27', 'jn', '1');
INSERT INTO `ym_items` VALUES ('28', 'nkjnj', '1');
INSERT INTO `ym_items` VALUES ('29', 'jnkj', '1');
INSERT INTO `ym_items` VALUES ('30', 'jkn', '1');
INSERT INTO `ym_items` VALUES ('31', 'nk', '1');
INSERT INTO `ym_items` VALUES ('32', 'میثم ابراهیمی', '1');
INSERT INTO `ym_items` VALUES ('33', 'علیرضا تلیسچی', '1');
INSERT INTO `ym_items` VALUES ('34', 'محسن ابراهیم زاده', '1');
INSERT INTO `ym_items` VALUES ('35', 'هیراد', '1');
INSERT INTO `ym_items` VALUES ('36', 'خداوردی', '1');
INSERT INTO `ym_items` VALUES ('37', 'عسگری', '1');
INSERT INTO `ym_items` VALUES ('38', 'احمدوند', '1');
INSERT INTO `ym_items` VALUES ('39', 'مهدی یراحی', '1');
INSERT INTO `ym_items` VALUES ('40', 'ماکان بند', '1');
INSERT INTO `ym_items` VALUES ('41', 'لهراسبی', '1');
INSERT INTO `ym_items` VALUES ('42', 'sgdg', '0');
INSERT INTO `ym_items` VALUES ('43', 'asdfasf', '0');
INSERT INTO `ym_items` VALUES ('44', 'asdfsadf', '0');
INSERT INTO `ym_items` VALUES ('45', 'weew', '0');
INSERT INTO `ym_items` VALUES ('46', '22fsdf', '0');
INSERT INTO `ym_items` VALUES ('47', '2asdf3', '0');
INSERT INTO `ym_items` VALUES ('48', '65dfg', '0');
INSERT INTO `ym_items` VALUES ('49', 'asda', '0');
INSERT INTO `ym_items` VALUES ('50', 'wrwer', '0');
INSERT INTO `ym_items` VALUES ('51', 'asdfsf', '0');

-- ----------------------------
-- Table structure for ym_lists
-- ----------------------------
DROP TABLE IF EXISTS `ym_lists`;
CREATE TABLE `ym_lists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `image` varchar(512) COLLATE utf8_persian_ci NOT NULL,
  `description` text COLLATE utf8_persian_ci,
  `user_type` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `seen` int(10) unsigned DEFAULT '0',
  `status` decimal(1,0) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ym_lists_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_list_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_lists
-- ----------------------------
INSERT INTO `ym_lists` VALUES ('4', 'تست', '8Zk0A1516290315.jpg', 'طرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود.\r\nطرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود.طرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود.', 'admin', '1', '7', '1516033317', '106', '1');
INSERT INTO `ym_lists` VALUES ('6', '۱۰ بهترین خواننده پاپ مجاز ایرانی', 'F4x9A1516564784.jpg', 'بهترین خوانندگان پاپ که در داخل کشور فعال هستند.', 'user', '43', '6', '1516387533', '197', '1');
INSERT INTO `ym_lists` VALUES ('7', 'تست', '', 'wwersfs', 'user', '43', null, '1517071524', '1', '2');
INSERT INTO `ym_lists` VALUES ('8', 'test', '', 'asdf', 'user', '43', null, '1518111508', '5', '0');
INSERT INTO `ym_lists` VALUES ('9', 'www', '', 'rrr', 'user', '43', '6', '1518112073', '1', '0');
INSERT INTO `ym_lists` VALUES ('10', 'draft', '', 'asdfsadfasf', 'user', '43', '6', '1518112130', '9', '2');

-- ----------------------------
-- Table structure for ym_list_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_list_categories`;
CREATE TABLE `ym_list_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `ym_list_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `ym_list_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_list_categories
-- ----------------------------
INSERT INTO `ym_list_categories` VALUES ('6', 'موسیقی', 'در این بخش خوانندگان، ترانه ها، آلبوم های موسیقی و سبکهای مختلف موسیقی دسته بندی میشوند.', null);
INSERT INTO `ym_list_categories` VALUES ('7', 'آموزش', 'بهترین دانشگاهها، موسسات آموزشی، کلاسهای کنکور، اساتید در همه زمینه ها در این بخش قرار میگیرند.\r\n', '6');
INSERT INTO `ym_list_categories` VALUES ('8', 'شرکت ها و محصولات', '', '6');
INSERT INTO `ym_list_categories` VALUES ('9', 'ورزش ها', '', null);
INSERT INTO `ym_list_categories` VALUES ('10', 'فیلم و سینما', 'بهترین ها در صنعت فیلم و سینما اعم از بازیگران، کارگردانان، سریالها و... در این دسته بندی قرار میگیرند.', null);
INSERT INTO `ym_list_categories` VALUES ('11', 'تفریح و سرگرمی', '', null);
INSERT INTO `ym_list_categories` VALUES ('12', 'علم و تکنولوژی', '', null);
INSERT INTO `ym_list_categories` VALUES ('13', 'فرهنگ و هنر ', '', null);
INSERT INTO `ym_list_categories` VALUES ('14', 'سلامتی و تندرستی', 'توضیحات...', null);

-- ----------------------------
-- Table structure for ym_list_item_rel
-- ----------------------------
DROP TABLE IF EXISTS `ym_list_item_rel`;
CREATE TABLE `ym_list_item_rel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `description` text COLLATE utf8_persian_ci,
  `image` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `list_id` (`list_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `ym_list_item_rel_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `ym_lists` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_list_item_rel_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `ym_items` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=543 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_list_item_rel
-- ----------------------------
INSERT INTO `ym_list_item_rel` VALUES ('461', '4', '13', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('462', '4', '14', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('463', '4', '15', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('464', '4', '16', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('465', '4', '17', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('466', '4', '18', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('467', '4', '19', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('468', '4', '20', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('469', '4', '21', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('470', '4', '22', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('511', '7', '42', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('512', '7', '43', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('513', '7', '44', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('524', '8', '45', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('525', '8', '46', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('526', '8', '47', 'sdf', null);
INSERT INTO `ym_list_item_rel` VALUES ('527', '9', '48', 'dfg', null);
INSERT INTO `ym_list_item_rel` VALUES ('528', '9', '49', 'dfgdfg', null);
INSERT INTO `ym_list_item_rel` VALUES ('529', '9', '50', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('530', '10', '51', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('531', '10', '24', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('532', '10', '44', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('533', '6', '32', 'با صدایی بسیار دلنشین و عاشقانه.', null);
INSERT INTO `ym_list_item_rel` VALUES ('534', '6', '33', 'خوب میخونه...', null);
INSERT INTO `ym_list_item_rel` VALUES ('535', '6', '34', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('536', '6', '35', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('537', '6', '36', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('538', '6', '37', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('539', '6', '38', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('540', '6', '39', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('541', '6', '40', '', null);
INSERT INTO `ym_list_item_rel` VALUES ('542', '6', '41', '', null);

-- ----------------------------
-- Table structure for ym_pages
-- ----------------------------
DROP TABLE IF EXISTS `ym_pages`;
CREATE TABLE `ym_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `summary` text COMMENT 'متن',
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('1', 'درباره ما', 'متن صفحه درباره ما', '1');
INSERT INTO `ym_pages` VALUES ('2', 'راهنما', 'متن راهنما', '1');
INSERT INTO `ym_pages` VALUES ('3', 'شرایط', 'متن شرایط', '1');
INSERT INTO `ym_pages` VALUES ('4', 'سوالات متداول', 'متن سوالات و جواب ها', '1');

-- ----------------------------
-- Table structure for ym_page_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_page_categories`;
CREATE TABLE `ym_page_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `slug` varchar(255) DEFAULT NULL COMMENT 'آدرس',
  `multiple` tinyint(1) unsigned DEFAULT '1' COMMENT 'چند صحفه ای',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_page_categories
-- ----------------------------
INSERT INTO `ym_page_categories` VALUES ('1', 'صفحات استاتیک', 'base', '1');

-- ----------------------------
-- Table structure for ym_site_setting
-- ----------------------------
DROP TABLE IF EXISTS `ym_site_setting`;
CREATE TABLE `ym_site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_site_setting
-- ----------------------------
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'فهرستی از بهترین ها');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', '۱۰ بهترین');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', '[\"10 \\u0628\\u0647\\u062a\\u0631\\u06cc\\u0646\",\"\\u0628\\u0647\\u062a\\u0631\\u06cc\\u0646 \\u0622\\u0647\\u0646\\u06af\",\"\\u0628\\u0647\\u062a\\u0631\\u06cc\\u0646 \\u062e\\u0648\\u0627\\u0646\\u0646\\u062f\\u0647\",\"\\u0628\\u0647\\u062a\\u0631\\u06cc\\u0646 \\u0641\\u0648\\u062a\\u0628\\u0627\\u0644\\u06cc\\u0633\\u062a\",\"\\u0628\\u0647\\u062a\\u0631\\u06cc\\u0646 \\u0641\\u06cc\\u0644\\u0645\",\"\\u0628\\u0647\\u062a\\u0631\\u06cc\\u0646 \\u0648\\u0628\\u0633\\u0627\\u06cc\\u062a\",\"\\u0641\\u0647\\u0631\\u0633\\u062a \\u0628\\u0647\\u062a\\u0631\\u06cc\\u0646 \\u0647\\u0627\",\"\\u0628\\u0647\\u062a\\u0631\\u06cc\\u0646 \\u0628\\u0627\\u0632\\u06cc\\u06af\\u0631\",\"10 \\u0628\\u0631\\u062a\\u0631\\u06cc\\u0646\",\"\\u0644\\u06cc\\u0633\\u062a \\u0628\\u0647\\u062a\\u0631\\u06cc\\u0646 \\u0647\\u0627\"]');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', '۱۰ بهترین مرجعی برای یافتن بهترین ها');
INSERT INTO `ym_site_setting` VALUES ('9', 'social_links', 'شبکه های اجتماعی', '{\"facebook\":\"http:\\/\\/facebook.com\",\"telegram\":\"Http:\\/\\/t.me\\/dahbehtarin_com\",\"google\":\"http:\\/\\/google.com\"}');

-- ----------------------------
-- Table structure for ym_tags
-- ----------------------------
DROP TABLE IF EXISTS `ym_tags`;
CREATE TABLE `ym_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=654 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_tags
-- ----------------------------
INSERT INTO `ym_tags` VALUES ('637', 'گایت');
INSERT INTO `ym_tags` VALUES ('638', 'فیزی');
INSERT INTO `ym_tags` VALUES ('639', 'بسبب.س');
INSERT INTO `ym_tags` VALUES ('640', 'سقلرصق');
INSERT INTO `ym_tags` VALUES ('641', 'لرسربی');
INSERT INTO `ym_tags` VALUES ('642', '');
INSERT INTO `ym_tags` VALUES ('643', 'نمایشی');
INSERT INTO `ym_tags` VALUES ('644', 'سئو');
INSERT INTO `ym_tags` VALUES ('645', 'کوبای');
INSERT INTO `ym_tags` VALUES ('646', 'ایمونو');
INSERT INTO `ym_tags` VALUES ('647', 'اطلس');
INSERT INTO `ym_tags` VALUES ('648', 'هماتو');
INSERT INTO `ym_tags` VALUES ('649', 'هماتولوژی');
INSERT INTO `ym_tags` VALUES ('650', 'پزشکی');
INSERT INTO `ym_tags` VALUES ('651', 'علوم پزشکی');
INSERT INTO `ym_tags` VALUES ('652', 'دبی فورد');
INSERT INTO `ym_tags` VALUES ('653', 'کتاب');

-- ----------------------------
-- Table structure for ym_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_users`;
CREATE TABLE `ym_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(10) unsigned DEFAULT NULL,
  `create_date` varchar(20) DEFAULT NULL,
  `status` enum('pending','active','blocked','deleted') DEFAULT 'pending',
  `verification_token` varchar(100) DEFAULT NULL,
  `change_password_request_count` int(1) DEFAULT '0',
  `auth_mode` varchar(50) NOT NULL DEFAULT 'site',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('43', '', '$2a$12$7Kfxd0zJjNpi.tHsxHm/n.1OYATncA9n86jjyAsIDNsE7k/FUyMrK', 'gharagozlu.masoud@gmail.com', '1', '1460634664', 'active', null, '0', 'site');
INSERT INTO `ym_users` VALUES ('45', '', '$2a$12$7Kfxd0zJjNpi.tHsxHm/n.1OYATncA9n86jjyAsIDNsE7k/FUyMrK', 'yusef.mobasheri@gmail.com', '1', '1469083948', 'active', '72ca2204ef7d713a27204d6dfeb615a4', '1', 'site');
INSERT INTO `ym_users` VALUES ('89', '', '$2a$12$2oNQNNU9korJrUET4i0HtO0VZyKCmVh714PwKIlcdBWDnpD.ENSlK', 'admin@crm-yii.com', '1', '1516202084', 'pending', '1510aeb352411aae87e940bc98dfa3c9', '0', 'site');
INSERT INTO `ym_users` VALUES ('90', '', '$2a$12$Uz8JVJkCdMK.4rfM.68.8OXYmL9nSqL4uj.CQ23brbqvbw74rJ7IK', 'mr.m.gharagozlu@gmail.com', '1', '1516374096', 'active', '84dfa248ad483df17179fbdb31019d85', '0', 'site');
INSERT INTO `ym_users` VALUES ('91', '', '$2a$12$gXmETT9J5NekJ6bYoUak6usC3lbe5gw9zhlrKYnkgoBEDrjP.67l2', 'soltan.e.eshgh2008@gmail.com', '1', '1516374371', 'active', '3156dfc857b121004d16c1f26d518b85', '0', 'site');
INSERT INTO `ym_users` VALUES ('92', '', '$2a$12$JzGsOKuCOhvi/.u34fF4De.5G8/b0XPbI7nf1HEgpeftB7/Bf0tF6', 'sobhani2525@gmail.com', '1', '1516386061', 'active', '015100ed69f9b894e45f5a768479970f', '0', 'site');

-- ----------------------------
-- Table structure for ym_user_bookmarks
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_bookmarks`;
CREATE TABLE `ym_user_bookmarks` (
  `user_id` int(10) unsigned NOT NULL,
  `list_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`list_id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `list_id` (`list_id`),
  CONSTRAINT `ym_user_bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_user_bookmarks_ibfk_2` FOREIGN KEY (`list_id`) REFERENCES `ym_lists` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_bookmarks
-- ----------------------------
INSERT INTO `ym_user_bookmarks` VALUES ('43', '6');
INSERT INTO `ym_user_bookmarks` VALUES ('92', '6');

-- ----------------------------
-- Table structure for ym_user_details
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_details`;
CREATE TABLE `ym_user_details` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `first_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام',
  `last_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام خانوادگی',
  `phone` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تلفن',
  `zip_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد پستی',
  `address` varchar(1000) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نشانی دقیق پستی',
  `avatar` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'آواتار',
  `mobile` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'موبایل',
  `dealership_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام نمایشگاه',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('43', 'مسعود', 'قراگوزلو', '02536610669', '3718895691', 'بلوار مدرس', 'Hd0Wy1518106291.jpg', '09373252746', null);
INSERT INTO `ym_user_details` VALUES ('45', null, null, '09373252746', '3715146164', 'بلوار سوم خرداد', 'cZxnn1516286876.jpg', '09358389265', null);
INSERT INTO `ym_user_details` VALUES ('89', null, null, null, null, null, null, null, null);
INSERT INTO `ym_user_details` VALUES ('90', null, null, null, null, null, null, null, null);
INSERT INTO `ym_user_details` VALUES ('91', null, null, null, null, null, '8s2u71516375155.jpg', null, null);
INSERT INTO `ym_user_details` VALUES ('92', 'سعید', 'نکونام', '', '', '', null, '09100309827', null);

-- ----------------------------
-- Table structure for ym_user_notifications
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_notifications`;
CREATE TABLE `ym_user_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `message` varchar(500) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'متن پیام',
  `seen` tinyint(4) NOT NULL COMMENT 'مشاهده شده',
  `date` varchar(30) NOT NULL COMMENT 'زمان',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_notifications
-- ----------------------------
INSERT INTO `ym_user_notifications` VALUES ('1', '43', 'برنامه دعای روزانه ماه رمضان+صوت تایید شده است.', '1', '1471688555');
INSERT INTO `ym_user_notifications` VALUES ('42', '43', 'برنامه دعای روزانه ماه رمضان+صوت تایید شده است.', '1', '1471688555');
INSERT INTO `ym_user_notifications` VALUES ('43', '43', 'بسته ir.hyperads.shabake توسط مدیر سیستم تایید شد.', '1', '1471688567');
INSERT INTO `ym_user_notifications` VALUES ('44', '43', 'برنامه ترفند و راز رمز های تلگرام،واتس آپ ،وایبر و ... تایید شده است.', '1', '1471688672');
INSERT INTO `ym_user_notifications` VALUES ('45', '43', 'بسته com.apusapps.tools.flashtorch توسط مدیر سیستم حذف شد.', '1', '1472913143');
INSERT INTO `ym_user_notifications` VALUES ('46', '43', 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', '1', '1472913146');
INSERT INTO `ym_user_notifications` VALUES ('47', '43', 'بسته com.apusapps.tools.flashtorch توسط مدیر سیستم حذف شد.', '1', '1472915999');
INSERT INTO `ym_user_notifications` VALUES ('48', '43', 'بسته com.asadworld.asadworld.flashlightpro توسط مدیر سیستم حذف شد.', '1', '1472916002');
INSERT INTO `ym_user_notifications` VALUES ('49', '43', 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', '1', '1472979885');
INSERT INTO `ym_user_notifications` VALUES ('50', '43', '\"کاربر مهمان\" در لیست \"۱۰ بهترین خواننده پاپ مجاز ایرانی\" به گزینه \"محسن ابراهیم زاده\" رای داده است.', '1', '1518202630');
INSERT INTO `ym_user_notifications` VALUES ('51', '43', 'لیست \"۱۰ بهترین خواننده پاپ مجاز ایرانی\" توسط مدیر سایت تایید شد.', '1', '1518203413');

-- ----------------------------
-- Table structure for ym_user_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_roles`;
CREATE TABLE `ym_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_roles
-- ----------------------------
INSERT INTO `ym_user_roles` VALUES ('1', 'کاربر معمولی', 'user');

-- ----------------------------
-- Table structure for ym_user_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_role_permissions`;
CREATE TABLE `ym_user_role_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `role_id` int(10) unsigned DEFAULT NULL COMMENT 'نقش',
  `module_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ماژول',
  `controller_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'کنترلر',
  `actions` text CHARACTER SET utf8 COMMENT 'اکشن ها',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_role_permissions
-- ----------------------------
INSERT INTO `ym_user_role_permissions` VALUES ('195', '2', 'base', 'BookController', 'buy,bookmark,rate,verify,updateVersion');
INSERT INTO `ym_user_role_permissions` VALUES ('196', '2', 'base', 'BookPersonsController', 'list');
INSERT INTO `ym_user_role_permissions` VALUES ('197', '2', 'base', 'TagsController', 'list');
INSERT INTO `ym_user_role_permissions` VALUES ('198', '2', 'comments', 'CommentsCommentController', 'admin,adminBooks,delete,approve');
INSERT INTO `ym_user_role_permissions` VALUES ('199', '2', 'publishers', 'PublishersPanelController', 'manageSettlement,uploadNationalCardImage,uploadRegistrationCertificateImage,update,create,excel,account,index,discount,settlement,sales,documents,signup');
INSERT INTO `ym_user_role_permissions` VALUES ('200', '2', 'publishers', 'PublishersBooksController', 'create,update,delete,uploadImage,deleteImage,upload,deleteUpload,deleteFile,images,savePackage,deletePackage,getPackages,updatePackage,uploadPreview,deleteUploadedPreview');
INSERT INTO `ym_user_role_permissions` VALUES ('201', '2', 'shop', 'ShopAddressesController', 'add,remove,update');
INSERT INTO `ym_user_role_permissions` VALUES ('202', '2', 'shop', 'ShopOrderController', 'getInfo,history');
INSERT INTO `ym_user_role_permissions` VALUES ('203', '2', 'tickets', 'TicketsDepartmentsController', 'create,update');
INSERT INTO `ym_user_role_permissions` VALUES ('204', '2', 'tickets', 'TicketsManageController', 'index,view,create,update,closeTicket,upload,deleteUploaded,send');
INSERT INTO `ym_user_role_permissions` VALUES ('205', '2', 'tickets', 'TicketsMessagesController', 'delete,create');
INSERT INTO `ym_user_role_permissions` VALUES ('206', '2', 'users', 'UsersCreditController', 'buy,bill,captcha,verify');
INSERT INTO `ym_user_role_permissions` VALUES ('207', '2', 'users', 'UsersPublicController', 'dashboard,logout,setting,notifications,changePassword,bookmarked,downloaded,transactions,library,sessions,removeSession');
INSERT INTO `ym_user_role_permissions` VALUES ('229', '1', 'lists', 'ListsCategoryController', 'view,index,create,update,admin,delete');
INSERT INTO `ym_user_role_permissions` VALUES ('230', '1', 'lists', 'ListsManageController', 'index,create,update,admin,delete,upload,deleteUpload,uploadItem,deleteUploadItem,changeStatus');
INSERT INTO `ym_user_role_permissions` VALUES ('231', '1', 'lists', 'ListsPublicController', 'rows,view,new,update,upload,uploadItem,deleteUpload,deleteUploadItem,json,authJson');
INSERT INTO `ym_user_role_permissions` VALUES ('232', '1', 'users', 'UsersManageController', 'index,view,create,update,admin,delete,userTransactions,transactions,dealerships,createDealership,updateDealership,upload,deleteUpload,dealershipRequests,dealershipRequest,deleteDealershipRequest');
INSERT INTO `ym_user_role_permissions` VALUES ('233', '1', 'users', 'UsersRolesController', 'create,update,admin,delete');
INSERT INTO `ym_user_role_permissions` VALUES ('234', '1', 'users', 'UsersPublicController', 'dashboard,logout,changePassword,verify,forgetPassword,recoverPassword,authCallback,transactions,index,ResendVerification,profile,upload,deleteUpload,viewProfile,login,captcha,lists');

-- ----------------------------
-- Table structure for ym_votes
-- ----------------------------
DROP TABLE IF EXISTS `ym_votes`;
CREATE TABLE `ym_votes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `list_item_rel_id` (`list_id`) USING BTREE,
  KEY `item_id` (`item_id`),
  CONSTRAINT `ym_votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_votes_ibfk_2` FOREIGN KEY (`list_id`) REFERENCES `ym_lists` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_votes_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `ym_items` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_votes
-- ----------------------------
INSERT INTO `ym_votes` VALUES ('18', '6', '32', null, '188.211.203.243', '1516728746');
INSERT INTO `ym_votes` VALUES ('19', '6', '32', null, '188.211.203.243', '1516728847');
INSERT INTO `ym_votes` VALUES ('20', '6', '32', null, '188.211.203.243', '1516728889');
INSERT INTO `ym_votes` VALUES ('21', '6', '32', null, '159.203.36.53', '1516729703');
INSERT INTO `ym_votes` VALUES ('22', '6', '37', null, '159.203.36.53', '1516731693');
INSERT INTO `ym_votes` VALUES ('23', '6', '32', null, '188.159.226.54', '1516735651');
INSERT INTO `ym_votes` VALUES ('24', '6', '32', null, '188.159.226.54', '1516735837');
INSERT INTO `ym_votes` VALUES ('25', '6', '33', '92', '188.159.226.54', '1516736577');
INSERT INTO `ym_votes` VALUES ('26', '6', '33', null, '89.199.188.70', '1516807125');
INSERT INTO `ym_votes` VALUES ('27', '6', '33', null, '89.199.188.70', '1516807128');
INSERT INTO `ym_votes` VALUES ('28', '6', '33', null, '89.199.188.70', '1516807154');
INSERT INTO `ym_votes` VALUES ('29', '6', '32', '43', '37.46.114.23', '1517037800');
INSERT INTO `ym_votes` VALUES ('44', '6', '34', null, '::1', '1518202629');
