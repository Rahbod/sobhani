/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : sobhani

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2018-01-27 18:17:58
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
INSERT INTO `ym_admins` VALUES ('1', 'rahbod', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'gharagozlu.masoud@gmial.com', '2');
INSERT INTO `ym_admins` VALUES ('28', 'mrketabic', '$2a$12$y.e4VsL6rSQ9hiItn96GM..bYIFel/FToEX1tzO.7VuVuE4pEiDEu', 'k.rahebi@gmail.com', '2');

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
) ENGINE=InnoDB AUTO_INCREMENT=1081 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_admin_role_permissions
-- ----------------------------
INSERT INTO `ym_admin_role_permissions` VALUES ('1069', '2', 'base', 'TagsController', 'index,create,update,admin,delete,list');
INSERT INTO `ym_admin_role_permissions` VALUES ('1070', '2', 'admins', 'AdminsDashboardController', 'index');
INSERT INTO `ym_admin_role_permissions` VALUES ('1071', '2', 'admins', 'AdminsManageController', 'index,views,create,update,admin,sessions,removeSession,changePass,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1072', '2', 'admins', 'AdminsRolesController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1073', '2', 'lists', 'ListsCategoryController', 'index,create,update,admin,delete,view');
INSERT INTO `ym_admin_role_permissions` VALUES ('1074', '2', 'lists', 'ListsManageController', 'index,create,update,admin,delete,upload,deleteUpload,uploadItem,deleteUploadItem,changeStatus');
INSERT INTO `ym_admin_role_permissions` VALUES ('1075', '2', 'pages', 'PageCategoriesManageController', 'index,view,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1076', '2', 'pages', 'PagesManageController', 'index,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1077', '2', 'setting', 'SettingManageController', 'gatewaySetting,changeSetting,socialLinks');
INSERT INTO `ym_admin_role_permissions` VALUES ('1078', '2', 'users', 'UsersManageController', 'index,view,create,update,admin,delete,userTransactions,transactions,dealerships,createDealership,updateDealership,upload,deleteUpload,dealershipRequests,dealershipRequest,deleteDealershipRequest');
INSERT INTO `ym_admin_role_permissions` VALUES ('1079', '2', 'users', 'UsersRolesController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1080', '2', 'comments', 'CommentsCommentController', 'adminBooks,delete,approve');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_comments
-- ----------------------------

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
INSERT INTO `ym_counter_save` VALUES ('counter', '9');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2458146');
INSERT INTO `ym_counter_save` VALUES ('max_count', '2');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1516005000');
INSERT INTO `ym_counter_save` VALUES ('yesterday', '0');

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
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1517059803');

-- ----------------------------
-- Table structure for ym_items
-- ----------------------------
DROP TABLE IF EXISTS `ym_items`;
CREATE TABLE `ym_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `status` decimal(1,0) unsigned DEFAULT '0' COMMENT 'وضعیت',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_items
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_lists
-- ----------------------------

-- ----------------------------
-- Table structure for ym_list_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_list_categories`;
CREATE TABLE `ym_list_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_list_categories
-- ----------------------------

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
  UNIQUE KEY `list_id` (`list_id`,`item_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `ym_list_item_rel_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `ym_lists` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_list_item_rel_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `ym_items` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_list_item_rel
-- ----------------------------

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
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'مرجع خرید و فروش کتاب آنلاین');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', 'کتابیک');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', '');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', '');
INSERT INTO `ym_site_setting` VALUES ('5', 'buy_credit_options', 'گزینه های خرید اعتبار', '[\"5000\",\"10000\",\"20000\",\"30000\",\"100\"]');
INSERT INTO `ym_site_setting` VALUES ('6', 'min_credit', 'حداقل درآمد برای تسویه حساب', '500');
INSERT INTO `ym_site_setting` VALUES ('7', 'tax', 'میزان مالیات (درصد)', '9');
INSERT INTO `ym_site_setting` VALUES ('8', 'commission', 'کمیسیون ناشر (درصد)', '15');
INSERT INTO `ym_site_setting` VALUES ('9', 'social_links', 'شبکه های اجتماعی', '{\"facebook\":\"http:\\/\\/facebook.com\",\"twitter\":\"http:\\/\\/twitter.com\"}');
INSERT INTO `ym_site_setting` VALUES ('10', 'android_app_url', 'آدرس دانلود نرم افزار اندروید سایت', 'http://');
INSERT INTO `ym_site_setting` VALUES ('11', 'windows_app_url', 'آدرس دانلود نرم افزار ویندوز سایت', 'http://');

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
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('43', '', '$2a$12$ZOt1EYXAP6Jm/S9pVLP3o.T8ff256Cl53dpOh6afEdO.hkLUD0QTS', 'gharagozlu.masoud@gmail.com', '1', '1460634664', 'active', null, '0', 'site');
INSERT INTO `ym_users` VALUES ('45', '', '$2a$12$7Kfxd0zJjNpi.tHsxHm/n.1OYATncA9n86jjyAsIDNsE7k/FUyMrK', 'yusef.mobasheri@gmail.com', '1', '1469083948', 'active', '72ca2204ef7d713a27204d6dfeb615a4', '1', 'site');
INSERT INTO `ym_users` VALUES ('89', '', '$2a$12$2oNQNNU9korJrUET4i0HtO0VZyKCmVh714PwKIlcdBWDnpD.ENSlK', 'admin@crm-yii.com', '1', '1516202084', 'pending', '1510aeb352411aae87e940bc98dfa3c9', '0', 'site');

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
INSERT INTO `ym_user_details` VALUES ('43', 'مسعود', 'قراگوزلو', '09373252746', '3718895691', 'بلوار سوم خرداد', 'amKd41493797323.jpg', '09123456789', null);
INSERT INTO `ym_user_details` VALUES ('45', 'یوسف', 'مبشری', '09373252746', '3715146164', 'بلوار سوم خرداد', 'cZxnn1516286876.jpg', '09358389265', null);
INSERT INTO `ym_user_details` VALUES ('89', null, null, null, null, null, null, null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_notifications
-- ----------------------------
INSERT INTO `ym_user_notifications` VALUES ('1', '45', 'برنامه دعای روزانه ماه رمضان+صوت تایید شده است.', '1', '1471688555');
INSERT INTO `ym_user_notifications` VALUES ('42', '45', 'برنامه دعای روزانه ماه رمضان+صوت تایید شده است.', '1', '1471688555');
INSERT INTO `ym_user_notifications` VALUES ('43', '45', 'بسته ir.hyperads.shabake توسط مدیر سیستم تایید شد.', '1', '1471688567');
INSERT INTO `ym_user_notifications` VALUES ('44', '45', 'برنامه ترفند و راز رمز های تلگرام،واتس آپ ،وایبر و ... تایید شده است.', '1', '1471688672');
INSERT INTO `ym_user_notifications` VALUES ('45', '45', 'بسته com.apusapps.tools.flashtorch توسط مدیر سیستم حذف شد.', '1', '1472913143');
INSERT INTO `ym_user_notifications` VALUES ('46', '45', 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', '1', '1472913146');
INSERT INTO `ym_user_notifications` VALUES ('47', '45', 'بسته com.apusapps.tools.flashtorch توسط مدیر سیستم حذف شد.', '1', '1472915999');
INSERT INTO `ym_user_notifications` VALUES ('48', '45', 'بسته com.asadworld.asadworld.flashlightpro توسط مدیر سیستم حذف شد.', '1', '1472916002');
INSERT INTO `ym_user_notifications` VALUES ('49', '45', 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', '1', '1472979885');

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
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

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
INSERT INTO `ym_user_role_permissions` VALUES ('223', '1', 'lists', 'ListsCategoryController', 'index,create,update,admin,delete,view');
INSERT INTO `ym_user_role_permissions` VALUES ('224', '1', 'lists', 'ListsManageController', 'index,create,update,admin,delete,upload,deleteUpload,uploadItem,deleteUploadItem,changeStatus');
INSERT INTO `ym_user_role_permissions` VALUES ('225', '1', 'lists', 'ListsPublicController', 'view,new,update,upload,uploadItem,deleteUpload,deleteUploadItem,rows,json,authJson');
INSERT INTO `ym_user_role_permissions` VALUES ('226', '1', 'users', 'UsersManageController', 'index,view,create,update,admin,delete,userTransactions,transactions,dealerships,createDealership,updateDealership,upload,deleteUpload,dealershipRequests,dealershipRequest,deleteDealershipRequest');
INSERT INTO `ym_user_role_permissions` VALUES ('227', '1', 'users', 'UsersRolesController', 'create,update,admin,delete');
INSERT INTO `ym_user_role_permissions` VALUES ('228', '1', 'users', 'UsersPublicController', 'dashboard,logout,changePassword,verify,forgetPassword,recoverPassword,authCallback,transactions,index,ResendVerification,profile,upload,deleteUpload,viewProfile,login,captcha');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_votes
-- ----------------------------
