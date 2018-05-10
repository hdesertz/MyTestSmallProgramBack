/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1_3306
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : wxa_blog

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-05-09 00:23:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wb_post
-- ----------------------------
DROP TABLE IF EXISTS `wb_post`;
CREATE TABLE `wb_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(90) NOT NULL COMMENT '标题',
  `summary` varchar(1000) DEFAULT NULL COMMENT '文章摘要',
  `content` text,
  `content_html` text COMMENT 'markdown解析后的文本',
  `author_id` int(11) NOT NULL,
  `author_name` varchar(50) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `category` varchar(30) NOT NULL COMMENT 'category.en_name',
  `is_top` tinyint(1) unsigned DEFAULT '0' COMMENT '是否置顶 0否 1是',
  `is_good` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为精华',
  `reply_count` int(10) unsigned DEFAULT '0',
  `visit_count` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of wb_post
-- ----------------------------

-- ----------------------------
-- Table structure for wb_post_category
-- ----------------------------
DROP TABLE IF EXISTS `wb_post_category`;
CREATE TABLE `wb_post_category` (
  `name` varchar(30) NOT NULL COMMENT '中文分类名',
  `en_name` varchar(40) NOT NULL COMMENT '英文分类名',
  `description` varchar(2000) DEFAULT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`en_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of wb_post_category
-- ----------------------------
INSERT INTO `wb_post_category` VALUES ('问答', 'ask', '问答', '10');
INSERT INTO `wb_post_category` VALUES ('招聘', 'employ', '招聘求职', '6');
INSERT INTO `wb_post_category` VALUES ('分享', 'share', '资源分享', '8');
INSERT INTO `wb_post_category` VALUES ('未分类', 'uncategorized', '未分类', '0');

-- ----------------------------
-- Table structure for wb_user
-- ----------------------------
DROP TABLE IF EXISTS `wb_user`;
CREATE TABLE `wb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未知 1男 2女',
  `avatar_url` varchar(300) DEFAULT NULL COMMENT '头像url',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `banned_at` datetime DEFAULT NULL COMMENT '账号禁用时间',
  `account` varchar(100) DEFAULT NULL,
  `hashed_password` varchar(100) DEFAULT NULL COMMENT 'hash后的密码',
  `salt` varchar(32) DEFAULT NULL COMMENT '密码盐',
  `wx_user_info` varchar(2000) DEFAULT NULL COMMENT '来自微信小程序的用户信息',
  `openid` varchar(100) NOT NULL,
  `session_key` varchar(100) NOT NULL,
  `unionid` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL COMMENT '纯手机号码',
  `country_code` varchar(10) DEFAULT NULL COMMENT '国家代码 跟mobile结合使用',
  `email` varchar(200) DEFAULT NULL,
  `credit` int(10) unsigned DEFAULT '0' COMMENT '积分',
  `role_name` varchar(100) NOT NULL DEFAULT 'member' COMMENT '角色名称',
  `signature` varchar(500) DEFAULT NULL COMMENT '个性签名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `un_openid` (`openid`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of wb_user
-- ----------------------------

-- ----------------------------
-- Table structure for wb_user_collection
-- ----------------------------
DROP TABLE IF EXISTS `wb_user_collection`;
CREATE TABLE `wb_user_collection` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`post_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户的文章收藏表';

-- ----------------------------
-- Records of wb_user_collection
-- ----------------------------

-- ----------------------------
-- Table structure for wb_user_role
-- ----------------------------
DROP TABLE IF EXISTS `wb_user_role`;
CREATE TABLE `wb_user_role` (
  `name` varchar(100) NOT NULL COMMENT '角色名称',
  `en_name` varchar(100) NOT NULL DEFAULT '' COMMENT '英文名',
  `description` text COMMENT '角色描述',
  PRIMARY KEY (`en_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of wb_user_role
-- ----------------------------
INSERT INTO `wb_user_role` VALUES ('管理员', 'admin', '');
INSERT INTO `wb_user_role` VALUES ('会员', 'member', '');
