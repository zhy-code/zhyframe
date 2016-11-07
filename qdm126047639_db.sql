/*
Navicat MySQL Data Transfer

Source Server         : qdm126047639.my3w.com
Source Server Version : 50148
Source Host           : qdm126047639.my3w.com:3306
Source Database       : qdm126047639_db

Target Server Type    : MYSQL
Target Server Version : 50148
File Encoding         : 65001

Date: 2016-11-07 11:04:09
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `admin_users`
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `adminid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `adminname` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `lastip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `sex` varchar(30) NOT NULL DEFAULT '0',
  `desc` text,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`adminid`),
  UNIQUE KEY `adminname` (`adminname`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO admin_users VALUES ('1', 'admin', '983886dc37fbb845ffd20617ebfcb225', '564197281@qq.com', '0', '1467698109', '127.0.0.1', '1', '密码是123456', '1');

-- ----------------------------
-- Table structure for `wxconfigs`
-- ----------------------------
DROP TABLE IF EXISTS `wxconfigs`;
CREATE TABLE `wxconfigs` (
  `configid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(30) NOT NULL DEFAULT '',
  `appsecret` varchar(32) NOT NULL DEFAULT '',
  `token` varchar(50) NOT NULL DEFAULT '',
  `encodingaeskey` varchar(50) NOT NULL DEFAULT '',
  `payappid` varchar(30) DEFAULT NULL,
  `payappsecret` varchar(32) DEFAULT NULL,
  `welcomeword` varchar(255) DEFAULT NULL,
  `modid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`configid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wxconfigs
-- ----------------------------
INSERT INTO wxconfigs VALUES ('1', 'wx8a2ea1394f6b8379', '4b637fa1119a68957a3abdbf58ad1944', 'weixin', 'lWx19XbqHdsoc4AVkEBx6Iv2jdA8HV5eFsMad5lVQ1P', '1279277001', 'AqijuXinXiKeJiYouXianGongSi10086', '欢迎关注微言微焉官方微信号', 'qyeMWz-TBH1y3Re6IKsuM7aMMrxC_hoTpQoV0cgSiYU');

-- ----------------------------
-- Table structure for `wxmenus`
-- ----------------------------
DROP TABLE IF EXISTS `wxmenus`;
CREATE TABLE `wxmenus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `navname` varchar(255) DEFAULT NULL,
  `navlink` varchar(255) NOT NULL,
  `navtype` varchar(255) NOT NULL,
  `navsort` int(10) NOT NULL,
  `navpid` int(10) unsigned DEFAULT NULL,
  `navstr` varchar(255) NOT NULL DEFAULT '',
  `ishaveson` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wxmenus
-- ----------------------------
