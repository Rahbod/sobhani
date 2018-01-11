/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : sobhani

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2018-01-11 17:49:28
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
) ENGINE=InnoDB AUTO_INCREMENT=1014 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_admin_role_permissions
-- ----------------------------
INSERT INTO `ym_admin_role_permissions` VALUES ('982', '2', 'base', 'BookCategoriesController', 'create,update,admin,delete,upload,deleteUpload,uploadIcon,deleteUploadIcon');
INSERT INTO `ym_admin_role_permissions` VALUES ('983', '2', 'base', 'BookController', 'reportSales,reportIncome,reportBookSales');
INSERT INTO `ym_admin_role_permissions` VALUES ('984', '2', 'base', 'BookPersonsController', 'create,update,admin,delete,list');
INSERT INTO `ym_admin_role_permissions` VALUES ('985', '2', 'base', 'SiteController', 'transactions');
INSERT INTO `ym_admin_role_permissions` VALUES ('986', '2', 'base', 'TagsController', 'index,create,update,admin,delete,list');
INSERT INTO `ym_admin_role_permissions` VALUES ('987', '2', 'admins', 'AdminsDashboardController', 'index');
INSERT INTO `ym_admin_role_permissions` VALUES ('988', '2', 'admins', 'AdminsManageController', 'index,views,create,update,admin,sessions,removeSession,changePass,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('989', '2', 'admins', 'AdminsRolesController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('990', '2', 'advertises', 'AdvertisesManageController', 'create,update,admin,delete,upload,deleteUpload');
INSERT INTO `ym_admin_role_permissions` VALUES ('991', '2', 'comments', 'CommentsCommentController', 'adminBooks,delete,approve');
INSERT INTO `ym_admin_role_permissions` VALUES ('992', '2', 'discountCodes', 'DiscountCodesManageController', 'admin,create,update,delete,codeGenerator,report');
INSERT INTO `ym_admin_role_permissions` VALUES ('993', '2', 'festivals', 'FestivalsManageController', 'admin,create,update,delete,report');
INSERT INTO `ym_admin_role_permissions` VALUES ('994', '2', 'manageBooks', 'ManageBooksBaseManageController', 'view,create,update,admin,delete,upload,deleteUpload,changeConfirm,deletePackage,savePackage,images,download,updatePackage,downloadPackage,discount,createDiscount,groupDiscount,updateDiscount,deleteDiscount,deleteSelectedDiscount,uploadPreview,deleteUploadedPreview,deletePdfFile,deleteEpubFile,changePublisherCommission,uploadFile,deleteUploadedFile');
INSERT INTO `ym_admin_role_permissions` VALUES ('995', '2', 'manageBooks', 'ManageBooksImagesManageController', 'upload,deleteUploaded');
INSERT INTO `ym_admin_role_permissions` VALUES ('996', '2', 'news', 'NewsCategoriesManageController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('997', '2', 'news', 'NewsManageController', 'create,update,admin,delete,upload,deleteUpload,order');
INSERT INTO `ym_admin_role_permissions` VALUES ('998', '2', 'pages', 'PagesManageController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('999', '2', 'places', 'PlacesCitiesController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1000', '2', 'places', 'PlacesTownsController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1001', '2', 'publishers', 'PublishersPanelController', 'manageSettlement,uploadNationalCardImage,uploadRegistrationCertificateImage,update,create,excel');
INSERT INTO `ym_admin_role_permissions` VALUES ('1002', '2', 'rows', 'RowsManageController', 'admin,const,delete,create,update,updateConst,add,remove,order');
INSERT INTO `ym_admin_role_permissions` VALUES ('1003', '2', 'setting', 'SettingManageController', 'changeSetting,socialLinks');
INSERT INTO `ym_admin_role_permissions` VALUES ('1004', '2', 'shop', 'ShopOrderController', 'admin,view,delete,changeStatus,exportCode,report');
INSERT INTO `ym_admin_role_permissions` VALUES ('1005', '2', 'shop', 'ShopPaymentController', 'admin,view,delete,update,changeStatus,order');
INSERT INTO `ym_admin_role_permissions` VALUES ('1006', '2', 'shop', 'ShopShippingController', 'admin,view,delete,create,update,changeStatus,order');
INSERT INTO `ym_admin_role_permissions` VALUES ('1007', '2', 'tickets', 'TicketsDepartmentsController', 'admin,create,update,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('1008', '2', 'tickets', 'TicketsManageController', 'delete,pendingTicket,openTicket,admin,index,view,create,update,closeTicket,upload,deleteUploaded,send');
INSERT INTO `ym_admin_role_permissions` VALUES ('1009', '2', 'tickets', 'TicketsMessagesController', 'delete,create');
INSERT INTO `ym_admin_role_permissions` VALUES ('1010', '2', 'users', 'UsersBonController', 'create,update,admin,delete,index,view,generateCode');
INSERT INTO `ym_admin_role_permissions` VALUES ('1011', '2', 'users', 'UsersCreditController', 'reportCreditBuys,reportBonBuys');
INSERT INTO `ym_admin_role_permissions` VALUES ('1012', '2', 'users', 'UsersManageController', 'index,view,sessions,removeSession,create,update,admin,adminPublishers,delete,userLibrary,userTransactions,changeCredit,changeFinanceStatus,confirmDevID,deleteDevID,confirmPublisher,refusePublisher');
INSERT INTO `ym_admin_role_permissions` VALUES ('1013', '2', 'users', 'UsersRolesController', 'create,update,admin,delete');

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
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_comments
-- ----------------------------

-- ----------------------------
-- Table structure for ym_items
-- ----------------------------
DROP TABLE IF EXISTS `ym_items`;
CREATE TABLE `ym_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `image` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تصویر',
  `status` decimal(1,0) unsigned DEFAULT '0' COMMENT 'وضعیت',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

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
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `seen` int(10) unsigned DEFAULT NULL,
  `status` decimal(1,0) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ym_lists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_lists_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_list_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

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
  PRIMARY KEY (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('1', 'درباره ما', 'متن صفحه درباره ما', '1');
INSERT INTO `ym_pages` VALUES ('2', 'درباره ما - بخش فوتر', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چـاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآن چـنان کـه لازم اسـت و بـرای شرایط فعلی تکنولوژی مورد نیاز و کاربـردهای متـنوع با هـدف بهـبود ابـزارهـای کاربردی می باشد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.', '1');
INSERT INTO `ym_pages` VALUES ('3', 'درباره ما - بخش نمایش کتاب', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چـاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآن چـنان کـه لازم اسـت و بـرای شرایط فعلی تکنولوژی مورد نیاز و کاربـردهای متـنوع با هـدف بهـبود ابـزارهـای کاربردی می باشد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.', '1');
INSERT INTO `ym_pages` VALUES ('6', 'راهنما', 'متن راهنما', '1');
INSERT INTO `ym_pages` VALUES ('7', 'قرارداد ناشران', 'متن قرارداد', '1');
INSERT INTO `ym_pages` VALUES ('8', 'تماس با ما', 'متن تماس با ما', '1');
INSERT INTO `ym_pages` VALUES ('9', 'ناشران', 'متن ناشران', '1');
INSERT INTO `ym_pages` VALUES ('10', 'درباره ما - موبایل', 'متن درباره ما - موبایل', '1');
INSERT INTO `ym_pages` VALUES ('11', 'راهنما - موبایل', 'متن راهنما - موبایل', '1');
INSERT INTO `ym_pages` VALUES ('12', 'تماس با ما - موبایل', 'متن تماس با ما - موبایل', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('43', '', '$2a$12$s8yAVo/JZ3Z86w5iFQV/7OIOGEwhyBCWj1Jw5DrlIqHERUF2otno2', 'gharagozlu.masoud@gmail.com', '1', '1460634664', 'active', '78ae2cf7ae4f9e824de3d590c9c0442a', '2', 'site');
INSERT INTO `ym_users` VALUES ('45', '', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'yusef.mobasheri@gmail.com', '2', '1469083948', 'active', '72ca2204ef7d713a27204d6dfeb615a4', '1', 'site');
INSERT INTO `ym_users` VALUES ('46', 'k.rahebi@gmail.com', '$2a$12$NSBVAHtMkDLy65.hD5/i5e2WR3kUoeScIqwEC2u2EcrEpAghglYlK', 'k.rahebi@gmail.com', '1', '1469083948', 'active', null, '0', 'site');
INSERT INTO `ym_users` VALUES ('51', '', '$2a$12$gvyjmX5ttqTkrzj5JBy7rukf.8NMati8EMybX8XZa1TnUDfRXUrre', 'yast6r@gmail.com', '1', '1478345220', 'pending', '018d909b5d2e14e87bad349e23705455', '0', 'site');
INSERT INTO `ym_users` VALUES ('56', '', '$2a$12$z.4Wf48k9Fc2m6u1zVMNgeg4jhxF5znCG.lpR3V4kjRLOotG8A4Dq', 'Dr.D347h@gmail.com', '1', '1478352314', 'active', null, '0', 'site');
INSERT INTO `ym_users` VALUES ('57', '', '$2a$12$qomUr6PNpq8bZYtfjxOzp.iIODRKDWrEOxxHbI4ynhkslrkT.enPa', 'ketabic.ir@gmail.com', '1', '1478352672', 'active', null, '0', 'google');
INSERT INTO `ym_users` VALUES ('58', '', '$2a$12$c04VvE0TP/2i47zMcxfgXuBqV0nNznTsEb1ZXAcY7cOSTrDImiNym', 'yast6r@yahoo.com', '1', '1478364134', 'pending', '27809b661848b43d3737f9e62c517bb2', '0', 'site');
INSERT INTO `ym_users` VALUES ('59', '', '$2a$12$n8jCCVKNv4A56EQXsZ19oe8B5k.jiXHcMGkvckQod1Ez.bLapr1YK', 'soltan.e.eshgh2008@gmail.com', '1', '1478383869', 'active', null, '0', 'google');
INSERT INTO `ym_users` VALUES ('60', '', '$2a$12$dZ1lP57P3KkBSlkcHthD9uyItCj3IbLsW7ZuueoFIG6VHDXPfsAX6', 'ya.st6r@gmail.com', '1', '1479449931', 'pending', '0a129a28e5205a2c67359dfad6c489b3', '0', 'site');
INSERT INTO `ym_users` VALUES ('61', '', '$2a$12$ZgBCcDwpc3KE02bx0v4gUugo8p45zU6Vjf3n0/sLl83t9eOLT9kaG', 'ketabest.com@gmail.com', '1', '1480058655', 'active', null, '0', 'google');
INSERT INTO `ym_users` VALUES ('63', '', '$2a$12$wcAodp2SRgLefp/0jgSDxeLejIvjXS/qHYLBUqS04j2VLJwjmpeWS', 'mr.m.gharagozlu@gmail.com', '1', '1480580350', 'pending', '7a29afa4b686cac24478dbef1566af3f', '0', 'site');
INSERT INTO `ym_users` VALUES ('64', '', '$2a$12$AXoomX.gySmbTQNj3fE6dO5ZkgLDW/WikWe490wH1wnKRw6nCLDH2', 'fight542@hotmail.com', '1', '1481312702', 'pending', '45668f64926685af0b73758c7a355bd5', '0', 'site');
INSERT INTO `ym_users` VALUES ('65', '', '$2a$12$XsI2VEKl2hYUZPIpwsQPWuq4xhRnBoYNk6fs95bS77IATjcmtYP6y', 'fight541@hotmail.com', '1', '1481367654', 'pending', '6e4841ff0e61b595fa35bb376897b2c4', '0', 'site');
INSERT INTO `ym_users` VALUES ('66', '', '$2a$12$k6pRZUAGOu0KWafFVMHN5OQ3eeh8kBbjdVUTV8YDx5b136wFEnI/u', 'timhd16@delta.gamma.coayako.top', '1', '1481473008', 'pending', 'b0bef10ff9e89311dcc552c7ecb6cafe', '0', 'site');
INSERT INTO `ym_users` VALUES ('67', '', '$2a$12$3JgT925i920JdZGAnLxVpOwSVTM64ABCvEjuj6zdPGqoD6/K87dBy', 'paulinelb4@upsilon.lambda.ezbunko.top', '1', '1481473013', 'pending', '9c1c803a478485d5547db9d694b1a7dd', '0', 'site');
INSERT INTO `ym_users` VALUES ('68', '', '$2a$12$SLzFe2.Rqy5DWuV7xyny9.hKUgY/19hlmnz1pWeLI3eGjJ.iiVjdO', 'heatherbessette@outlook.com', '1', '1481695811', 'pending', '610c7d65d48024e965fada57ccff935c', '0', 'site');
INSERT INTO `ym_users` VALUES ('69', '', '$2a$12$Nalrp9O0md1iBiT6JZkDW.SDkozEszHX.GMTxXY/MmoL.qjGVBFC2', 'K.rahe.bi@gmail.com', '2', '1482158441', 'active', null, '0', 'site');
INSERT INTO `ym_users` VALUES ('70', '', '$2a$12$lbL0EkxR0GRISjTNh2coC.4lvDUKjoou8.k3rfiGq8KEnLlUaLOwm', 'yast6.r@gmail.com', '1', '1482327945', 'active', '23624cb9cc5e1c1a08e119fd82a64419', '0', 'site');
INSERT INTO `ym_users` VALUES ('71', '', '$2a$12$UPxq6rbOQW3Xa8bfwqRjnORwumX7aUJpQBwDu0MHQGiTrKuUAk9s6', 'soltan.e.eshgh20089@gmail.com', '1', '1482328653', 'active', '5b1ceb4792ab937789c47fc6d5c135e7', '0', 'site');
INSERT INTO `ym_users` VALUES ('76', '', '$2a$12$okfYUTyMz9zGMXfNqZoVlehV/YIsbFijHCbMLImkGubUD/0BkDPOe', 'khodagholi.rahebi@gmail.com', '2', '1483363269', 'active', null, '0', 'site');
INSERT INTO `ym_users` VALUES ('77', '', '$2a$12$9NwGAbz.Vw4Nyo78n65hOOaH9t1DIGXzrzyJYM0j9koFYR7oC5kq2', 'kraheb.i@gmail.com', '1', '1483366165', 'active', 'ca672d5af2fbbddcbbbcf3efe8351476', '0', 'site');
INSERT INTO `ym_users` VALUES ('78', '', '$2a$12$P8jSxWjRtq/4YnDd76ANR.JEyR6NyU6Ggj0EcI8HNZ50D3qKUq3A2', 'ymofidk@gmail.com', '1', '1483369292', 'active', null, '0', 'google');
INSERT INTO `ym_users` VALUES ('79', '', '$2a$12$my.2.5cWgStXcDwILwesouW/ju8dt4/octNqVPhEL/3g8SoolADY6', 'yastar@ymail.com', '2', '1483372711', 'active', null, '0', 'site');
INSERT INTO `ym_users` VALUES ('80', '', '$2a$12$qzMa4pNlMfKHsXtQg5dWjuSB1ylN0bx5azXn03lqDGB33s5k.NTbC', 'zahed.godaneh@gmail.com', '1', '1483446199', 'active', 'f3d783675d50f95ec55b45c73f1ae7f8', '0', 'site');
INSERT INTO `ym_users` VALUES ('81', '', '$2a$12$80wbWIkzTN26weZJpVEVreGVXwE58f28ZY7WVECUJQPjI2F2c7pTW', 'zahed.ggf@gmail.com', '1', '1483446626', 'active', '4228345ce04a223eadd91fdb8fde5b26', '0', 'site');
INSERT INTO `ym_users` VALUES ('82', '', '$2a$12$g/Zhfays5DcWfJ8MW.Ijfu8JewaDTNv5xcb0HRjRPwUfU4MnyTBda', 'drd347h@gmail.com', '1', '1483464071', 'active', 'eb2f55240216cf227130eaf94a31c925', '0', 'site');
INSERT INTO `ym_users` VALUES ('83', '', '$2a$12$5k.A0TeFujI5grf06mrvc.Xsjq29Yt6LJpPwpAwzCTLBPTtIzbnk2', 'pouya.rahebi@gmail.com', '1', '1483465611', 'pending', '237146bde8296ee857bd8f524cbd9d44', '0', 'site');
INSERT INTO `ym_users` VALUES ('84', '', '$2a$12$XkmUgV8jcta5X3E.4w8YKu5NnxEkyp6UhvkbYMmi.XypSAtm5cGh6', 'atashbar290@gmail.com', '1', '1485189979', 'active', '1433af0d5cafce276a475b1ddaa866dc', '0', 'site');
INSERT INTO `ym_users` VALUES ('86', '', '$2a$12$GFLsp8Pf6UqxJXk5id8NRuImTFg4DNT9Y5bm7nYzVI8SQsBJSEaMG', 'e@s.s', '1', '1487399304', 'pending', '82997f3e082800eb14e38b32478988dd', '0', 'site');
INSERT INTO `ym_users` VALUES ('87', '', '$2a$12$XEKLMAgXvWiE4TxlEEfzg.9/b2jHhy2Qxho2Vy16JjihLLE9eNlnm', '7mohamad7@gmail.com', '1', '1487517691', 'active', null, '0', 'google');

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
  CONSTRAINT `ym_user_bookmarks_ibfk_2` FOREIGN KEY (`list_id`) REFERENCES `ym_lists` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_user_bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
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
  `fa_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام فارسی',
  `en_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام انگلیسی',
  `fa_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت فارسی',
  `en_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت انگلیسی',
  `national_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد ملی',
  `national_card_image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تصویر کارت ملی',
  `phone` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تلفن',
  `zip_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد پستی',
  `address` varchar(1000) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نشانی دقیق پستی',
  `credit` double DEFAULT NULL COMMENT 'اعتبار',
  `publisher_id` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه توسعه دهنده',
  `details_status` enum('refused','pending','accepted') CHARACTER SET utf8 DEFAULT 'pending' COMMENT 'وضعیت اطلاعات کاربر',
  `monthly_settlement` tinyint(4) DEFAULT '0' COMMENT 'تسویه حساب ماهانه',
  `iban` varchar(24) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شماره شبا',
  `nickname` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام نمایشی',
  `type` enum('real','legal') CHARACTER SET utf8 DEFAULT 'real' COMMENT 'نوع حساب',
  `post` enum('ceo','board') CHARACTER SET utf8 DEFAULT NULL COMMENT 'سمت',
  `company_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام شرکت',
  `registration_number` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شماره ثبت',
  `registration_certificate_image` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تصویر گواهی ثبت شرکت',
  `score` int(10) unsigned DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'آواتار',
  `publication_name` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `account_owner_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `account_owner_family` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `account_type` enum('real','legal') CHARACTER SET latin1 DEFAULT 'real' COMMENT 'نوع حساب بانکی',
  `account_number` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `bank_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `financial_info_status` enum('pending','accepted','refused') COLLATE utf8_persian_ci DEFAULT 'pending' COMMENT 'وضعیت اطلاعات مالی',
  `commission` decimal(3,0) unsigned DEFAULT NULL COMMENT 'کمیسیون ناشر',
  `tax_exempt` decimal(1,0) unsigned DEFAULT '0' COMMENT 'معاف از مالیات',
  `earning` decimal(10,0) unsigned DEFAULT '0' COMMENT 'درآمد',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('43', 'مسعود قراگوزلو', 'masoud', '', '', '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '128000', 'Masoud', 'accepted', '1', '123456789123456789123456', 'Masoud', 'real', null, null, null, null, '5', null, '', 'مسعود', 'قراگوزلو', 'real', '123456', 'انصار', 'accepted', null, '0', '2730');
INSERT INTO `ym_user_details` VALUES ('45', 'یوسف مبشری', 'yusef', null, null, '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '100', 'Yusef', 'accepted', '1', '123456789123456987465321', null, 'real', null, null, null, null, '32', null, 'انتشارات نصر', 'یوسف', 'مبشری', 'real', '026563651653135', 'بانک ملی', 'accepted', null, '0', '1638');
INSERT INTO `ym_user_details` VALUES ('46', null, null, null, null, null, null, null, null, null, '85000', null, 'accepted', '0', null, null, 'real', null, null, null, null, '7', null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('51', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('56', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('57', null, null, null, null, null, null, null, null, null, '8400', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('58', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('59', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('60', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('61', ' ', null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=200', '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('63', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('64', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('65', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('66', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('67', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('68', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('69', null, null, null, null, null, null, null, null, null, '0', null, 'accepted', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('70', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('71', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, '', '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('76', 'خداقلی راهبی', null, '', null, '2020202020', '3vA591483363746.jpg', '01733284850', '4971695633', 'معنغتیلییام', '0', 'Rahebi', 'accepted', '0', '1234558901234ثقفغعغابلیب', 'راهبی', 'real', null, null, null, null, null, null, 'انتشارات راهبی', 'خداقلی', 'راهبی', 'real', '3502', 'پاسارگاد', 'accepted', null, '1', '4250');
INSERT INTO `ym_user_details` VALUES ('77', null, null, null, null, null, null, null, null, null, '90000', null, 'pending', '0', null, null, 'real', null, null, null, null, '2', null, null, '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('78', ' ', null, null, null, null, null, null, null, null, '4500', null, 'pending', '0', null, null, 'real', null, null, null, null, '1', 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=200', null, '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('79', 'یاسر مفید', null, '', null, '2020210754', 'bR5JG1492961358.png', '09355549224', '4971936741', 'گنبددد تالتل الابالبلا- نتاتا-تاال', '1000', 'yast_6r', 'accepted', '0', 'asdfgkhsdfgdfgsdfsdfasdf', 'یاستار', 'real', null, null, null, null, null, null, 'یاستا', '', '', 'real', '', '', 'refused', null, '0', '1025');
INSERT INTO `ym_user_details` VALUES ('80', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, null, '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('81', null, null, null, null, null, null, null, null, null, '100', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, null, '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('82', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, null, '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('83', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, null, '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('84', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, null, '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('85', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, null, '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('86', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null, null, '', '', 'real', '', '', 'pending', null, '0', '0');
INSERT INTO `ym_user_details` VALUES ('87', 'Mohamad Delavari', null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=200', null, '', '', 'real', '', '', 'pending', null, '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_notifications
-- ----------------------------

-- ----------------------------
-- Table structure for ym_user_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_roles`;
CREATE TABLE `ym_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_roles
-- ----------------------------
INSERT INTO `ym_user_roles` VALUES ('1', 'کاربر معمولی', 'user');
INSERT INTO `ym_user_roles` VALUES ('2', 'ناشر', 'publisher');

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
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

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
INSERT INTO `ym_user_role_permissions` VALUES ('208', '1', 'base', 'BookController', 'buy,bookmark,rate,verify,updateVersion');
INSERT INTO `ym_user_role_permissions` VALUES ('209', '1', 'publishers', 'PublishersPanelController', 'uploadNationalCardImage,uploadRegistrationCertificateImage,signup');
INSERT INTO `ym_user_role_permissions` VALUES ('210', '1', 'shop', 'ShopAddressesController', 'add,remove,update');
INSERT INTO `ym_user_role_permissions` VALUES ('211', '1', 'shop', 'ShopOrderController', 'getInfo,history');
INSERT INTO `ym_user_role_permissions` VALUES ('212', '1', 'tickets', 'TicketsDepartmentsController', 'create,update');
INSERT INTO `ym_user_role_permissions` VALUES ('213', '1', 'tickets', 'TicketsManageController', 'index,view,create,update,closeTicket,upload,deleteUploaded,send');
INSERT INTO `ym_user_role_permissions` VALUES ('214', '1', 'tickets', 'TicketsMessagesController', 'delete,create');
INSERT INTO `ym_user_role_permissions` VALUES ('215', '1', 'users', 'UsersCreditController', 'buy,bill,captcha,verify');
INSERT INTO `ym_user_role_permissions` VALUES ('216', '1', 'users', 'UsersPublicController', 'dashboard,logout,setting,notifications,changePassword,bookmarked,downloaded,transactions,library,sessions,removeSession');

-- ----------------------------
-- Table structure for ym_votes
-- ----------------------------
DROP TABLE IF EXISTS `ym_votes`;
CREATE TABLE `ym_votes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `list_item_rel_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `list_item_rel_id` (`list_item_rel_id`),
  CONSTRAINT `ym_votes_ibfk_2` FOREIGN KEY (`list_item_rel_id`) REFERENCES `ym_list_item_rel` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_votes
-- ----------------------------
