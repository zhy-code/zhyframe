/*
Navicat MySQL Data Transfer

Source Server         : 本地数据库
Source Server Version : 50715
Source Host           : localhost:3306
Source Database       : zhyframe

Target Server Type    : MYSQL
Target Server Version : 50715
File Encoding         : 65001

Date: 2016-10-24 21:29:02
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '后台菜单自增Id',
  `menu_parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '后台菜单父类Id',
  `menu_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '后台菜单名称',
  `menu_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '后台菜单状态 0不显示，1显示',
  `menu_module` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '后台菜单模块',
  `menu_controller` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '后台菜单控制器',
  `menu_action` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '后台菜单方法',
  `menu_parameter` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '后台菜单方法',
  `menu_icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '后台菜单标识符',
  `menu_remark` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '后台菜单备注',
  `menu_sort` smallint(6) NOT NULL COMMENT '后台菜单排序',
  `menu_add_time` int(11) NOT NULL COMMENT '后台菜单添加时间',
  `menu_add_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '后台菜单添加IP',
  `menu_creator` int(10) unsigned NOT NULL COMMENT '后台菜单添加者id',
  PRIMARY KEY (`menu_id`),
  UNIQUE KEY `admin_menu_menu_name_unique` (`menu_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO admin_menu VALUES ('1', '0', '菜单管理', '1', '', '', '', '', 'bars', '', '1', '1477112574', '127.0.0.1', '1');
INSERT INTO admin_menu VALUES ('2', '1', '菜单列表', '1', 'Admin', 'Menu', 'menuList', '', '', '', '1', '1477112585', '127.0.0.1', '1');
INSERT INTO admin_menu VALUES ('3', '0', '后台管理员', '1', '', '', '', '', 'user', '', '2', '1477112574', '127.0.0.1', '1');
INSERT INTO admin_menu VALUES ('4', '3', '管理员列表', '1', 'Admin', 'User', 'userList', '', '', '', '1', '1477112574', '127.0.0.1', '1');

-- ----------------------------
-- Table structure for `admin_task`
-- ----------------------------
DROP TABLE IF EXISTS `admin_task`;
CREATE TABLE `admin_task` (
  `task_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '任务自增Id',
  `task_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '任务标题',
  `task_content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '任务内容',
  `task_creator` int(11) NOT NULL COMMENT '任务发布人Id',
  `task_finisher` int(11) NOT NULL COMMENT '任务完成人Id',
  `task_datetime` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '任务预定开展时间',
  `task_weekday` tinyint(4) NOT NULL COMMENT '任务预定开展的星期数',
  `task_add_time` int(11) NOT NULL COMMENT '任务添加的时间',
  `task_add_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '任务添加的IP',
  `task_edit_time` int(11) NOT NULL COMMENT '任务最后编辑的时间',
  `task_eidt_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '任务最后编辑的IP',
  `task_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '任务状态 0未做，1已完成，-1已过期',
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_task
-- ----------------------------

-- ----------------------------
-- Table structure for `admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '后台管理员自增Id',
  `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '后台管理员名/账号',
  `user_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '后台管理员密码',
  `user_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '后台管理员状态 0正常，1禁用',
  `user_remark` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '后台管理员备注',
  `user_last_login_time` int(11) NOT NULL COMMENT '最后登录时间',
  `user_last_login_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '最后登录IP',
  `user_true_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '后台管理员姓名',
  `user_add_time` int(11) NOT NULL COMMENT '后台管理员添加时间',
  `user_add_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '后台管理员添加IP',
  `user_edit_time` int(11) NOT NULL COMMENT '后台管理员最后编辑的时间',
  `user_eidt_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '后台管理员最后编辑的IP',
  `user_login_rnd` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '后台管理员登陆标识符，随机数',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `admin_user_user_name_unique` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO admin_user VALUES ('1', 'admin', '10470c3b4b1fed12c3baac014be15fac67c6e815', '1', '测试管理员', '1477314796', '127.0.0.1', '郑焰', '1477103046', '127.0.0.1', '1477103046', '127.0.0.1', 'zzz');

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO migrations VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO migrations VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO migrations VALUES ('3', '2016_10_17_090226_create_adminTask_table', '1');
INSERT INTO migrations VALUES ('4', '2016_10_17_090444_create_adminUser_table', '1');
INSERT INTO migrations VALUES ('5', '2016_10_22_004229_create_adminMenu_table', '1');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
