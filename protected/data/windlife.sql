/*
Navicat MySQL Data Transfer

Source Server         : conn
Source Server Version : 50539
Source Host           : localhost:3306
Source Database       : windlife

Target Server Type    : MYSQL
Target Server Version : 50539
File Encoding         : 65001

Date: 2014-11-03 15:14:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wl_admin
-- ----------------------------
DROP TABLE IF EXISTS `wl_admin`;
CREATE TABLE `wl_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_ip` varchar(50) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0' COMMENT '默认系统管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_admin
-- ----------------------------
INSERT INTO `wl_admin` VALUES ('1', 'admin', '$2a$13$W26iGIQ3G/wir0K8.z3a8.Sm9Rm7D1QQA7ZhojhUvix3LKTXQkzF.', 'jsjgjf@126.com', '郭建飞', '2011-06-13 14:34:41', '2014-11-03 14:50:28', '127.0.0.1', '1');
INSERT INTO `wl_admin` VALUES ('6', '技术部', '$2a$13$lwgFzkYTqet8LmGpFwZWUud8ExhX0T9e5rmhx/gp.NdoNo7vLZeLK', 'jsjgjf@qq.com', '郭建飞', '2013-11-26 17:02:26', '2013-11-29 22:03:37', '127.0.0.1', '0');

-- ----------------------------
-- Table structure for wl_admin_panel
-- ----------------------------
DROP TABLE IF EXISTS `wl_admin_panel`;
CREATE TABLE `wl_admin_panel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` char(32) DEFAULT NULL,
  `url` char(255) DEFAULT NULL,
  `datetime` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_admin_panel
-- ----------------------------

-- ----------------------------
-- Table structure for wl_advert
-- ----------------------------
DROP TABLE IF EXISTS `wl_advert`;
CREATE TABLE `wl_advert` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `position_key` char(20) NOT NULL COMMENT '广告位置',
  `ad_key` char(20) NOT NULL COMMENT '广告模板',
  `description` varchar(255) DEFAULT NULL COMMENT '位置描述',
  `width` int(11) DEFAULT NULL COMMENT '广告宽度',
  `height` int(11) DEFAULT NULL COMMENT '广告高度',
  `num` int(11) DEFAULT '0' COMMENT '广告数量',
  `style` varchar(50) DEFAULT NULL COMMENT '附加样式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_advert
-- ----------------------------
INSERT INTO `wl_advert` VALUES ('3', 'header_logo_right', 'banner', '', '220', '90', '1', null);

-- ----------------------------
-- Table structure for wl_advert_item
-- ----------------------------
DROP TABLE IF EXISTS `wl_advert_item`;
CREATE TABLE `wl_advert_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `ad_id` int(11) NOT NULL COMMENT '所属广告位',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `thumb` varchar(100) DEFAULT NULL COMMENT '缩略图',
  `file_url` varchar(100) NOT NULL COMMENT '广告文件',
  `link_url` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `target` char(10) DEFAULT '_blank' COMMENT '打开方式',
  `created` datetime DEFAULT NULL,
  `listorder` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_advert_item
-- ----------------------------
INSERT INTO `wl_advert_item` VALUES ('5', '3', '家庭文化休闲一站式服务平台', '0', '', '/uploadfiles/images/0/20140617/140297513973.jpg', '#', null, '2014-06-17 15:19:32', '0');

-- ----------------------------
-- Table structure for wl_article
-- ----------------------------
DROP TABLE IF EXISTS `wl_article`;
CREATE TABLE `wl_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `column_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目编号',
  `model_id` smallint(6) NOT NULL COMMENT '模型编号',
  `admin_id` smallint(5) NOT NULL COMMENT '发布人编号',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `style` char(100) NOT NULL DEFAULT '' COMMENT '标题样式',
  `thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `keywords` char(40) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` mediumtext NOT NULL COMMENT '摘要',
  `copyfrom` varchar(100) NOT NULL DEFAULT '' COMMENT '来源',
  `content` text NOT NULL COMMENT '内容',
  `url` char(100) NOT NULL COMMENT 'URL',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '转向链接',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击率',
  `inputtime` datetime DEFAULT NULL COMMENT '添加时间',
  `updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`listorder`,`id`),
  KEY `listorder` (`column_id`,`status`,`listorder`,`id`),
  KEY `catid` (`column_id`,`status`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_article
-- ----------------------------
INSERT INTO `wl_article` VALUES ('12', '5', '3', '1', 'asdfas', '', '/uploadfiles/images/0/20140617/140297513973.jpg', '', '', '百度', '<p>dfasdfasdfasdf<br /></p>', '', '0', '1', '0', '0', '2014-07-08 17:35:25', '2014-07-17 10:15:23');

-- ----------------------------
-- Table structure for wl_attachment
-- ----------------------------
DROP TABLE IF EXISTS `wl_attachment`;
CREATE TABLE `wl_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` char(50) NOT NULL,
  `filepath` char(200) NOT NULL,
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` char(10) NOT NULL,
  `filedesn` varchar(50) DEFAULT NULL,
  `isimage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isthumb` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isscrawl` tinyint(1) NOT NULL DEFAULT '0',
  `isremote` tinyint(1) NOT NULL DEFAULT '0',
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uploadtime` int(10) unsigned NOT NULL DEFAULT '0',
  `uploadip` char(15) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `filepath` (`filepath`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_attachment
-- ----------------------------
INSERT INTO `wl_attachment` VALUES ('2', '天天.jpg', './uploadfiles/images/0/20131201/13859044095025.jpg', '124375', '.jpg', '天天', '1', '0', '0', '0', '0', '0', '1385904409', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('3', 'gg1.jpg', './uploadfiles/images/0/20140617/140297513973.jpg', '34969', '.jpg', 'gg1', '1', '0', '0', '0', '0', '0', '1402975139', '127.0.0.1', '1');
INSERT INTO `wl_attachment` VALUES ('4', '二级页面-产品详情.jpg', './uploadfiles/images/0/20140726/14063412116373.jpg', '60231', '.jpg', '二级页面-产品详情', '1', '0', '0', '0', '0', '0', '1406341211', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('5', '二级页面-产品详情2.jpg', './uploadfiles/images/0/20140726/14063412128744.jpg', '61092', '.jpg', '二级页面-产品详情2', '1', '0', '0', '0', '0', '0', '1406341212', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('6', '二级页面-产品详情-下拉置顶.jpg', './uploadfiles/images/0/20140726/14063412127441.jpg', '66152', '.jpg', '二级页面-产品详情-下拉置顶', '1', '0', '0', '0', '0', '0', '1406341212', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('7', '二级页面-产品详情.jpg', './uploadfiles/images/0/20140726/14063576329537.jpg', '60231', '.jpg', 'dfdfdf', '1', '0', '0', '0', '0', '0', '1406357632', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('8', '二级页面-产品详情.jpg', './uploadfiles/images/0/20140726/14063578673230.jpg', '7732', '.jpg', '二级页面-产品详情', '1', '0', '0', '0', '0', '0', '1406357867', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('9', '二级页面-用户评论.jpg', './uploadfiles/images/0/20140726/14063578901963.jpg', '85228', '.jpg', '二级页面-用户评论', '1', '0', '0', '0', '0', '0', '1406357890', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('10', '搜索页面.jpg', './uploadfiles/images/0/20140726/14063582551306.jpg', '101026', '.jpg', '搜索页面', '1', '0', '0', '0', '0', '0', '1406358255', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('11', '搜索页面.jpg', './uploadfiles/images/0/20140726/14063583694851.jpg', '101026', '.jpg', 'sdfsdfsdf', '1', '0', '0', '0', '0', '0', '1406358369', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('12', '搜索页面.jpg', './uploadfiles/images/0/20140726/14063604149540.jpg', '101026', '.jpg', '搜索页面', '1', '0', '0', '0', '0', '0', '1406360414', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('13', '搜索页面.jpg', './uploadfiles/images/0/20140726/1406360921602.jpg', '101026', '.jpg', 'sdfsdf', '1', '0', '0', '0', '0', '0', '1406360921', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('14', '搜索页面.jpg', './uploadfiles/images/0/20140726/14063622061529.jpg', '101026', '.jpg', '搜索页面', '1', '0', '0', '0', '0', '0', '1406362206', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('15', '搜索页面.jpg', './uploadfiles/images/0/20140726/14063622994033.jpg', '101026', '.jpg', '搜索页面', '1', '0', '0', '0', '0', '0', '1406362299', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('16', '二级页面-使用用户名、手机注册成功.jpg', './uploadfiles/images/0/20140726/14063623495558.jpg', '69324', '.jpg', '二级页面-使用用户名、手机注册成功', '1', '0', '0', '0', '0', '0', '1406362349', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('17', '二级页面-使用用户名、手机注册成功-输入提示.jpg', './uploadfiles/images/0/20140726/14063623517832.jpg', '70625', '.jpg', '二级页面-使用用户名、手机注册成功-输入提示', '1', '0', '0', '0', '0', '0', '1406362351', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('18', '二级页面-使用邮箱注册成功.jpg', './uploadfiles/images/0/20140726/14063623523585.jpg', '72960', '.jpg', '二级页面-使用邮箱注册成功', '1', '0', '0', '0', '0', '0', '1406362352', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('19', '二级页面-使用用户名、手机注册成功.jpg', './uploadfiles/images/0/20140726/14063625034240.jpg', '69324', '.jpg', '二级页面-使用用户名、手机注册成功', '1', '0', '0', '0', '0', '0', '1406362503', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('20', '二级页面-使用用户名、手机注册成功-输入提示.jpg', './uploadfiles/images/0/20140726/14063625046608.jpg', '70625', '.jpg', '二级页面-使用用户名、手机注册成功-输入提示', '1', '0', '0', '0', '0', '0', '1406362504', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('21', '二级页面-使用邮箱注册成功.jpg', './uploadfiles/images/0/20140726/14063625057262.jpg', '72960', '.jpg', '二级页面-使用邮箱注册成功', '1', '0', '0', '0', '0', '0', '1406362505', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('22', '二级页面-用户登录.jpg', './uploadfiles/images/0/20140726/14063625074759.jpg', '73855', '.jpg', '二级页面-用户登录', '1', '0', '0', '0', '0', '0', '1406362507', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('23', '二级页面-账户注册修改版.jpg', './uploadfiles/images/0/20140726/1406362508707.jpg', '73103', '.jpg', '二级页面-账户注册修改版', '1', '0', '0', '0', '0', '0', '1406362508', '127.0.0.1', '1');
INSERT INTO `wl_attachment` VALUES ('24', '二级页面-账户注册修改版-输入框状态.jpg', './uploadfiles/images/0/20140726/14063625092105.jpg', '78263', '.jpg', '二级页面-账户注册修改版-输入框状态', '1', '0', '0', '0', '0', '0', '1406362509', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('25', '二级页面-使用用户名、手机注册成功.jpg', './uploadfiles/images/0/20140726/14063625431489.jpg', '69324', '.jpg', '二级页面-使用用户名、手机注册成功', '1', '0', '0', '0', '0', '0', '1406362543', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('26', '二级页面-账户注册修改版-输入框状态.jpg', './uploadfiles/images/0/20140726/14063625453695.jpg', '78263', '.jpg', '二级页面-账户注册修改版-输入框状态', '1', '0', '0', '0', '0', '0', '1406362545', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('27', '二级页面-找回密码.jpg', './uploadfiles/images/0/20140726/14063625467740.jpg', '67002', '.jpg', '二级页面-找回密码', '1', '0', '0', '0', '0', '0', '1406362546', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('28', '二级页面-账户注册修改版-输入框状态.jpg', './uploadfiles/images/0/20140726/14063626743411.jpg', '78263', '.jpg', '二级页面-账户注册修改版-输入框状态', '1', '0', '0', '0', '0', '0', '1406362674', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('29', '二级页面-账户注册修改版-输入框状态.jpg', './uploadfiles/images/0/20140726/14063627708578.jpg', '78263', '.jpg', '二级页面-账户注册修改版-输入框状态', '1', '0', '0', '0', '0', '0', '1406362770', '127.0.0.1', '0');
INSERT INTO `wl_attachment` VALUES ('30', '二级页面-账户注册修改版.jpg', './uploadfiles/images/0/20140726/14063628154738.jpg', '73103', '.jpg', '二级页面-账户注册修改版', '1', '0', '0', '0', '0', '0', '1406362815', '127.0.0.1', '0');

-- ----------------------------
-- Table structure for wl_attachment_item
-- ----------------------------
DROP TABLE IF EXISTS `wl_attachment_item`;
CREATE TABLE `wl_attachment_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `model_name` char(30) NOT NULL COMMENT '模型名称',
  `attachment_id` int(11) NOT NULL COMMENT '附件ID',
  `record_id` int(11) NOT NULL COMMENT '模型记录ID',
  PRIMARY KEY (`id`),
  KEY `attachment_id` (`attachment_id`),
  KEY `model_name&record_id` (`model_name`,`record_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_attachment_item
-- ----------------------------
INSERT INTO `wl_attachment_item` VALUES ('1', 'Article', '3', '12');

-- ----------------------------
-- Table structure for wl_authassignment
-- ----------------------------
DROP TABLE IF EXISTS `wl_authassignment`;
CREATE TABLE `wl_authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `wl_authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `wl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_authassignment
-- ----------------------------
INSERT INTO `wl_authassignment` VALUES ('SuperAdmin', '1', null, null);
INSERT INTO `wl_authassignment` VALUES ('SystemAdmin', '6', null, 'N;');

-- ----------------------------
-- Table structure for wl_authitem
-- ----------------------------
DROP TABLE IF EXISTS `wl_authitem`;
CREATE TABLE `wl_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  `menu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_authitem
-- ----------------------------
INSERT INTO `wl_authitem` VALUES ('admin_access_setting', '1', '权限参数设置', null, 'N;', '76');
INSERT INTO `wl_authitem` VALUES ('admin_advert_add', '0', '广告添加', null, 'N;', '110');
INSERT INTO `wl_authitem` VALUES ('admin_advert_create', '0', '添加版位', null, 'N;', '99');
INSERT INTO `wl_authitem` VALUES ('admin_advert_del', '0', '广告删除', null, 'N;', '112');
INSERT INTO `wl_authitem` VALUES ('admin_advert_edit', '0', '广告修改', null, 'N;', '111');
INSERT INTO `wl_authitem` VALUES ('admin_advert_index', '1', '广告管理', null, 'N;', '20');
INSERT INTO `wl_authitem` VALUES ('admin_advert_list', '0', '广告列表', null, 'N;', '109');
INSERT INTO `wl_authitem` VALUES ('admin_advert_listorder', '0', '广告排序', null, 'N;', '113');
INSERT INTO `wl_authitem` VALUES ('admin_advert_templet', '0', '广告模板', null, 'N;', '100');
INSERT INTO `wl_authitem` VALUES ('admin_article_create', '0', '添加文章', null, 'N;', '86');
INSERT INTO `wl_authitem` VALUES ('admin_article_delete', '0', '删除文章', null, 'N;', '92');
INSERT INTO `wl_authitem` VALUES ('admin_article_deleteAll', '0', '批量删除', null, 'N;', '93');
INSERT INTO `wl_authitem` VALUES ('admin_article_index', '1', '文章管理', null, 'N;', '85');
INSERT INTO `wl_authitem` VALUES ('admin_article_update', '0', '修改文章', null, 'N;', '91');
INSERT INTO `wl_authitem` VALUES ('admin_attachment_delete', '0', '附件删除', null, 'N;', '81');
INSERT INTO `wl_authitem` VALUES ('admin_attachment_deleteAll', '0', '附件批量删除', null, 'N;', '82');
INSERT INTO `wl_authitem` VALUES ('admin_attachment_index', '1', '附件管理', null, 'N;', '45');
INSERT INTO `wl_authitem` VALUES ('admin_badword_create', '0', '敏感词添加', null, 'N;', '70');
INSERT INTO `wl_authitem` VALUES ('admin_badword_index', '1', '敏感词管理', null, 'N;', '38');
INSERT INTO `wl_authitem` VALUES ('admin_column_create', '0', '栏目添加', null, 'N;', '59');
INSERT INTO `wl_authitem` VALUES ('admin_column_custom', '0', '自定栏目添加', null, 'N;', '60');
INSERT INTO `wl_authitem` VALUES ('admin_column_customUpdate', '0', '自定栏目修改', null, 'N;', '63');
INSERT INTO `wl_authitem` VALUES ('admin_column_index', '1', '管理栏目', null, 'N;', '46');
INSERT INTO `wl_authitem` VALUES ('admin_column_link', '0', '链接栏目添加', null, 'N;', '61');
INSERT INTO `wl_authitem` VALUES ('admin_column_linkUpdate', '0', '链接栏目修改', null, 'N;', '64');
INSERT INTO `wl_authitem` VALUES ('admin_column_update', '0', '栏目修改', null, 'N;', '62');
INSERT INTO `wl_authitem` VALUES ('admin_content_findColumn', '0', '搜索栏目', null, 'N;', '47');
INSERT INTO `wl_authitem` VALUES ('admin_content_init', '1', '内容管理', null, 'N;', '44');
INSERT INTO `wl_authitem` VALUES ('admin_copyfrom_create', '0', '来源添加', null, 'N;', '69');
INSERT INTO `wl_authitem` VALUES ('admin_copyfrom_delete', '0', '来源删除', null, 'N;', '95');
INSERT INTO `wl_authitem` VALUES ('admin_copyfrom_index', '1', '来源管理', null, 'N;', '35');
INSERT INTO `wl_authitem` VALUES ('admin_copyfrom_update', '0', '来源修改', null, 'N;', '94');
INSERT INTO `wl_authitem` VALUES ('admin_database_index', '1', '数据库工具', null, 'N;', '37');
INSERT INTO `wl_authitem` VALUES ('admin_default_updateCache', '1', '更新全站缓存', null, 'N;', '34');
INSERT INTO `wl_authitem` VALUES ('admin_gallery_create', '0', '添加图集', null, 'N;', '115');
INSERT INTO `wl_authitem` VALUES ('admin_gallery_delete', '0', '删除图集', null, 'N;', '117');
INSERT INTO `wl_authitem` VALUES ('admin_gallery_deleteAll', '0', '批量删除', null, 'N;', '118');
INSERT INTO `wl_authitem` VALUES ('admin_gallery_index', '1', '图库管理', null, 'N;', '114');
INSERT INTO `wl_authitem` VALUES ('admin_gallery_update', '0', '修改图集', null, 'N;', '116');
INSERT INTO `wl_authitem` VALUES ('admin_log_index', '1', '后台操作日志', null, 'N;', '36');
INSERT INTO `wl_authitem` VALUES ('admin_manage_changepass', '1', '修改密码', null, 'N;', '33');
INSERT INTO `wl_authitem` VALUES ('admin_manage_create', '0', '管理员添加', null, 'N;', '72');
INSERT INTO `wl_authitem` VALUES ('admin_manage_delete', '0', '管理员删除', null, 'N;', '74');
INSERT INTO `wl_authitem` VALUES ('admin_manage_index', '1', '管理员管理', null, 'N;', '71');
INSERT INTO `wl_authitem` VALUES ('admin_manage_profile', '1', '修改个人信息', null, 'N;', '32');
INSERT INTO `wl_authitem` VALUES ('admin_manage_update', '0', '管理员修改', null, 'N;', '73');
INSERT INTO `wl_authitem` VALUES ('admin_menu_create', '0', '菜单添加', null, 'N;', '11');
INSERT INTO `wl_authitem` VALUES ('admin_menu_delete', '0', '菜单删除', null, 'N;', '13');
INSERT INTO `wl_authitem` VALUES ('admin_menu_index', '1', '菜单管理', null, 'N;', '10');
INSERT INTO `wl_authitem` VALUES ('admin_menu_update', '0', '菜单修改', null, 'N;', '12');
INSERT INTO `wl_authitem` VALUES ('admin_model_create', '0', '模型添加', null, 'N;', '54');
INSERT INTO `wl_authitem` VALUES ('admin_model_delete', '0', '模型删除', null, 'N;', '56');
INSERT INTO `wl_authitem` VALUES ('admin_model_index', '1', '模型管理', null, 'N;', '53');
INSERT INTO `wl_authitem` VALUES ('admin_model_update', '0', '模型修改', null, 'N;', '55');
INSERT INTO `wl_authitem` VALUES ('admin_mparam_create', '0', '模型参数添加', null, 'N;', '88');
INSERT INTO `wl_authitem` VALUES ('admin_mparam_delete', '0', '模型参数删除', null, 'N;', '90');
INSERT INTO `wl_authitem` VALUES ('admin_mparam_index', '1', '模型参数管理', null, 'N;', '87');
INSERT INTO `wl_authitem` VALUES ('admin_mparam_update', '0', '模型参数修改', null, 'N;', '89');
INSERT INTO `wl_authitem` VALUES ('admin_page_edit', '1', '单页面管理', null, 'N;', '83');
INSERT INTO `wl_authitem` VALUES ('admin_page_preview', '0', '点击访问', null, 'N;', '84');
INSERT INTO `wl_authitem` VALUES ('admin_position_create', '0', '发布位添加', null, 'N;', '101');
INSERT INTO `wl_authitem` VALUES ('admin_position_delete', '0', '发布位删除', null, 'N;', '102');
INSERT INTO `wl_authitem` VALUES ('admin_position_index', '1', '发布位管理', null, 'N;', '97');
INSERT INTO `wl_authitem` VALUES ('admin_release_cdelete', '0', '内容删除', null, 'N;', '108');
INSERT INTO `wl_authitem` VALUES ('admin_release_create', '0', '内容发布添加', null, 'N;', '103');
INSERT INTO `wl_authitem` VALUES ('admin_release_delete', '0', '内容发布删除', null, 'N;', '105');
INSERT INTO `wl_authitem` VALUES ('admin_release_index', '1', '内容发布', null, 'N;', '98');
INSERT INTO `wl_authitem` VALUES ('admin_release_list', '0', '内容浏览', null, 'N;', '106');
INSERT INTO `wl_authitem` VALUES ('admin_release_listorder', '0', '内容排序', null, 'N;', '107');
INSERT INTO `wl_authitem` VALUES ('admin_release_update', '0', '内容发布修改', null, 'N;', '104');
INSERT INTO `wl_authitem` VALUES ('admin_role_create', '0', '角色添加', null, 'N;', '77');
INSERT INTO `wl_authitem` VALUES ('admin_role_delete', '0', '角色删除', null, 'N;', '79');
INSERT INTO `wl_authitem` VALUES ('admin_role_index', '1', '角色管理', null, 'N;', '75');
INSERT INTO `wl_authitem` VALUES ('admin_role_setaccess', '0', '角色权限设置', null, 'N;', '80');
INSERT INTO `wl_authitem` VALUES ('admin_role_update', '0', '角色修改', null, 'N;', '78');
INSERT INTO `wl_authitem` VALUES ('admin_setting_index_base', '1', '基础设置', null, 'N;', '48');
INSERT INTO `wl_authitem` VALUES ('admin_setting_index_count', '1', '统计代码', null, 'N;', '52');
INSERT INTO `wl_authitem` VALUES ('admin_setting_index_email', '1', '邮件设置', null, 'N;', '50');
INSERT INTO `wl_authitem` VALUES ('admin_setting_index_upload', '1', '上传设置', null, 'N;', '49');
INSERT INTO `wl_authitem` VALUES ('admin_sitemap_index', '1', 'Sitemap生成', null, 'N;', '42');
INSERT INTO `wl_authitem` VALUES ('admin_tags_index', '1', '标签管理', null, 'N;', '119');
INSERT INTO `wl_authitem` VALUES ('admin_urlmanage_create', '0', 'URL规则添加', null, 'N;', '65');
INSERT INTO `wl_authitem` VALUES ('admin_urlmanage_delete', '0', 'URL规则删除', null, 'N;', '67');
INSERT INTO `wl_authitem` VALUES ('admin_urlmanage_index', '1', 'URL管理', null, 'N;', '57');
INSERT INTO `wl_authitem` VALUES ('admin_urlmanage_update', '0', 'URL规则修改', null, 'N;', '66');
INSERT INTO `wl_authitem` VALUES ('SuperAdmin', '2', '超级管理员', '', 's:10:\"is_super=1\";', null);
INSERT INTO `wl_authitem` VALUES ('SystemAdmin', '2', '系统管理员', '', 's:0:\"\";', null);

-- ----------------------------
-- Table structure for wl_authitemchild
-- ----------------------------
DROP TABLE IF EXISTS `wl_authitemchild`;
CREATE TABLE `wl_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `wl_authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `wl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wl_authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `wl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_authitemchild
-- ----------------------------
INSERT INTO `wl_authitemchild` VALUES ('admin_advert_index', 'admin_advert_add');
INSERT INTO `wl_authitemchild` VALUES ('admin_advert_index', 'admin_advert_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_advert_index', 'admin_advert_del');
INSERT INTO `wl_authitemchild` VALUES ('admin_advert_index', 'admin_advert_edit');
INSERT INTO `wl_authitemchild` VALUES ('admin_advert_index', 'admin_advert_list');
INSERT INTO `wl_authitemchild` VALUES ('admin_advert_index', 'admin_advert_listorder');
INSERT INTO `wl_authitemchild` VALUES ('admin_advert_index', 'admin_advert_templet');
INSERT INTO `wl_authitemchild` VALUES ('admin_article_index', 'admin_article_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_article_index', 'admin_article_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_article_index', 'admin_article_deleteAll');
INSERT INTO `wl_authitemchild` VALUES ('admin_article_index', 'admin_article_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_attachment_index', 'admin_attachment_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_attachment_index', 'admin_attachment_deleteAll');
INSERT INTO `wl_authitemchild` VALUES ('admin_badword_index', 'admin_badword_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_column_index', 'admin_column_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_column_index', 'admin_column_custom');
INSERT INTO `wl_authitemchild` VALUES ('admin_column_index', 'admin_column_customUpdate');
INSERT INTO `wl_authitemchild` VALUES ('admin_column_index', 'admin_column_link');
INSERT INTO `wl_authitemchild` VALUES ('admin_column_index', 'admin_column_linkUpdate');
INSERT INTO `wl_authitemchild` VALUES ('admin_column_index', 'admin_column_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_content_init', 'admin_content_findColumn');
INSERT INTO `wl_authitemchild` VALUES ('admin_copyfrom_index', 'admin_copyfrom_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_copyfrom_index', 'admin_copyfrom_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_copyfrom_index', 'admin_copyfrom_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_gallery_index', 'admin_gallery_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_gallery_index', 'admin_gallery_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_gallery_index', 'admin_gallery_deleteAll');
INSERT INTO `wl_authitemchild` VALUES ('admin_gallery_index', 'admin_gallery_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_manage_index', 'admin_manage_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_manage_index', 'admin_manage_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_manage_index', 'admin_manage_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_menu_index', 'admin_menu_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_menu_index', 'admin_menu_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_menu_index', 'admin_menu_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_model_index', 'admin_model_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_model_index', 'admin_model_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_model_index', 'admin_model_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_mparam_index', 'admin_mparam_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_mparam_index', 'admin_mparam_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_mparam_index', 'admin_mparam_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_page_edit', 'admin_page_preview');
INSERT INTO `wl_authitemchild` VALUES ('admin_position_index', 'admin_position_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_position_index', 'admin_position_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_release_index', 'admin_release_cdelete');
INSERT INTO `wl_authitemchild` VALUES ('admin_release_index', 'admin_release_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_release_index', 'admin_release_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_release_index', 'admin_release_list');
INSERT INTO `wl_authitemchild` VALUES ('admin_release_index', 'admin_release_listorder');
INSERT INTO `wl_authitemchild` VALUES ('admin_release_index', 'admin_release_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_role_index', 'admin_role_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_role_index', 'admin_role_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_role_index', 'admin_role_setaccess');
INSERT INTO `wl_authitemchild` VALUES ('admin_role_index', 'admin_role_update');
INSERT INTO `wl_authitemchild` VALUES ('admin_urlmanage_index', 'admin_urlmanage_create');
INSERT INTO `wl_authitemchild` VALUES ('admin_urlmanage_index', 'admin_urlmanage_delete');
INSERT INTO `wl_authitemchild` VALUES ('admin_urlmanage_index', 'admin_urlmanage_update');

-- ----------------------------
-- Table structure for wl_badword
-- ----------------------------
DROP TABLE IF EXISTS `wl_badword`;
CREATE TABLE `wl_badword` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `badword` char(20) NOT NULL COMMENT '敏感词',
  `level` tinyint(5) NOT NULL DEFAULT '1' COMMENT '敏感等级',
  `replaceword` char(20) NOT NULL DEFAULT '' COMMENT '替换词',
  `lastusetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `badword` (`badword`),
  KEY `usetimes` (`replaceword`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_badword
-- ----------------------------

-- ----------------------------
-- Table structure for wl_column
-- ----------------------------
DROP TABLE IF EXISTS `wl_column`;
CREATE TABLE `wl_column` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目编号',
  `module` varchar(15) NOT NULL COMMENT '栏目模块',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '栏目类型',
  `keyparam` char(20) DEFAULT NULL COMMENT '访问参数',
  `modelid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '模型编号',
  `parentid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父栏目',
  `arrparentid` varchar(255) NOT NULL COMMENT '父栏目数组',
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '子栏目',
  `arrchildid` mediumtext NOT NULL COMMENT '子栏目数组',
  `colname` varchar(30) NOT NULL COMMENT '栏目名称',
  `image` varchar(100) DEFAULT NULL COMMENT '栏目图片',
  `description` mediumtext COMMENT '栏目描述',
  `url` varchar(100) NOT NULL COMMENT '访问地址',
  `urlparam` mediumtext COMMENT '访问地址参数',
  `items` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '栏目内容数据量',
  `hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目点击次数',
  `setting` mediumtext NOT NULL COMMENT '栏目配置',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `letter` varchar(30) NOT NULL COMMENT '栏目拼音',
  `target` char(15) NOT NULL DEFAULT '_self' COMMENT '栏目打开方式',
  `dataway` tinyint(1) NOT NULL DEFAULT '1' COMMENT '栏目数据调用方式',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`parentid`,`listorder`,`id`),
  KEY `siteid` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_column
-- ----------------------------
INSERT INTO `wl_column` VALUES ('1', 'content', '1', 'about', '4', '0', '0', '1', '1,2,3', '关于我们', '', '', '/?r=page/edit&keyparam=about', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'guanyuwomen', '_self', '3');
INSERT INTO `wl_column` VALUES ('2', 'content', '1', 'company', '4', '1', '0,1', '0', '2', '公司简介', '', '', '/index.php?r=page/edit&keyparam=company', null, '1', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'gongsijianjie', '_self', '2');
INSERT INTO `wl_column` VALUES ('3', 'content', '1', 'service', '4', '1', '0,1', '0', '3', '业务范围', '', '', '/index.php?r=page/edit&keyparam=service', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'yewufanwei', '_self', '2');
INSERT INTO `wl_column` VALUES ('4', 'content', '1', 'case', '3', '0', '0', '1', '4,5,6,7', '客户案例', '', '', '/index.php?r=article/list&keyparam=case', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'kehuanli', '_self', '1');
INSERT INTO `wl_column` VALUES ('5', 'content', '1', 'vi', '3', '4', '0,4', '0', '5', '平面VI', '', '', '/index.php?r=article/list&keyparam=vi', null, '1', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'pingmian', '_self', '2');
INSERT INTO `wl_column` VALUES ('6', 'content', '1', 'web', '3', '4', '0,4', '0', '6', '网站门户', '', '', '/index.php?r=article/list&keyparam=web', null, '2', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'wangzhanmenhu', '_self', '2');
INSERT INTO `wl_column` VALUES ('7', 'content', '1', 'app', '3', '4', '0,4', '0', '7', '移动应用', '', '', '/index.php?r=article/list&keyparam=app', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'yidongyingyong', '_self', '2');
INSERT INTO `wl_column` VALUES ('8', 'content', '1', 'solution', '4', '0', '0', '1', '8,9,10,11', '解决方案', '', '', '/index.php?r=page/edit&keyparam=solution', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'jiejuefangan', '_self', '3');
INSERT INTO `wl_column` VALUES ('9', 'content', '1', 'enterprise', '4', '8', '0,8', '0', '9', '企业推广方案', '', '', '/index.php?r=page/edit&keyparam=enterprise', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'qiyetuiguangfangan', '_self', '2');
INSERT INTO `wl_column` VALUES ('10', 'content', '1', 'ec', '4', '8', '0,8', '0', '10', '电子商务推广', '', '', '/index.php?r=article/list&keyparam=ec', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'dianzishangwutuiguang', '_self', '2');
INSERT INTO `wl_column` VALUES ('11', 'content', '1', 'portal', '4', '8', '0,8', '0', '11', '门户网站推广', '', '', '/index.php?r=article/list&keyparam=portal', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'menhuwangzhantuiguang', '_self', '2');
INSERT INTO `wl_column` VALUES ('12', 'content', '1', 'news', '3', '0', '0', '1', '12,13,14', '新闻中心', '', '', '/index.php?r=article/list&keyparam=news', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'xinwenzhongxin', '_self', '3');
INSERT INTO `wl_column` VALUES ('13', 'content', '1', 'cnews', '3', '12', '0,12', '0', '13', '公司新闻', '', '', '/index.php?r=article/list&keyparam=cnews', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'gongsixinwen', '_self', '2');
INSERT INTO `wl_column` VALUES ('14', 'content', '1', 'industry', '3', '12', '0,12', '0', '14', '行业动态', '', '', '/index.php?r=article/list&keyparam=industry', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'xingyedongtai', '_self', '2');
INSERT INTO `wl_column` VALUES ('15', 'content', '1', 'knowledge', '3', '0', '0', '1', '15,16,17,18', '知识中心', '', '', '/index.php?r=article/list&keyparam=knowledge', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'zhishizhongxin', '_self', '3');
INSERT INTO `wl_column` VALUES ('16', 'content', '1', 'design', '3', '15', '0,15', '0', '16', '设计制作', '', '', '/index.php?r=article/list&keyparam=design', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'shejizhizuo', '_self', '2');
INSERT INTO `wl_column` VALUES ('17', 'content', '1', 'program', '3', '15', '0,15', '0', '17', 'web开发', '', '', '/index.php?r=article/list&keyparam=program', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'webkaifa', '_self', '2');
INSERT INTO `wl_column` VALUES ('18', 'content', '1', 'android', '3', '15', '0,15', '0', '18', 'App制作', '', '', '/index.php?r=article/list&keyparam=android', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'ppzhizuo', '_self', '2');
INSERT INTO `wl_column` VALUES ('19', 'content', '1', 'contact', '4', '0', '0', '0', '19', '联系我们', '', '', '/?r=page/edit&keyparam=contact', null, '0', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'lianxiwomen', '_self', '2');
INSERT INTO `wl_column` VALUES ('20', 'content', '1', 'photo', '5', '0', '0', '0', '20', '图库', '', '', '/?r=gallery/index&keyparam=photo', null, '16', '0', 'a:3:{s:9:\"metaTitle\";s:0:\"\";s:11:\"metaKeyword\";s:0:\"\";s:15:\"metaDescription\";s:0:\"\";}', '0', '1', 'tuku', '_self', '2');

-- ----------------------------
-- Table structure for wl_column_param
-- ----------------------------
DROP TABLE IF EXISTS `wl_column_param`;
CREATE TABLE `wl_column_param` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `column_id` smallint(5) NOT NULL COMMENT '栏目编号',
  `model_id` smallint(5) NOT NULL COMMENT '模型编号',
  `value` text NOT NULL COMMENT '参数值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_column_param
-- ----------------------------
INSERT INTO `wl_column_param` VALUES ('1', '4', '3', 'a:1:{i:0;a:2:{s:14:\"b_title_length\";s:2:\"80\";s:6:\"b_test\";s:1:\"2\";}}');
INSERT INTO `wl_column_param` VALUES ('2', '1', '4', 'a:1:{i:0;a:1:{s:14:\"b_title_length\";s:2:\"80\";}}');
INSERT INTO `wl_column_param` VALUES ('3', '5', '3', 'a:1:{i:0;a:2:{s:14:\"b_title_length\";s:2:\"80\";s:12:\"b_image_size\";s:7:\"200*200\";}}');
INSERT INTO `wl_column_param` VALUES ('4', '6', '3', 'a:1:{i:0;a:2:{s:14:\"b_title_length\";s:2:\"80\";s:12:\"b_image_size\";s:7:\"200*200\";}}');
INSERT INTO `wl_column_param` VALUES ('5', '2', '4', 'a:1:{i:0;a:1:{s:14:\"b_title_length\";s:2:\"80\";}}');
INSERT INTO `wl_column_param` VALUES ('6', '9', '4', 'a:1:{i:0;a:1:{s:14:\"b_title_length\";s:2:\"80\";}}');
INSERT INTO `wl_column_param` VALUES ('7', '10', '4', 'a:1:{i:0;a:1:{s:14:\"b_title_length\";s:2:\"80\";}}');
INSERT INTO `wl_column_param` VALUES ('8', '11', '4', 'a:1:{i:0;a:1:{s:14:\"b_title_length\";s:2:\"80\";}}');
INSERT INTO `wl_column_param` VALUES ('9', '3', '4', 'a:1:{i:0;a:1:{s:14:\"b_title_length\";s:2:\"80\";}}');
INSERT INTO `wl_column_param` VALUES ('10', '19', '4', 'a:1:{i:0;a:1:{s:14:\"b_title_length\";s:2:\"80\";}}');
INSERT INTO `wl_column_param` VALUES ('11', '20', '5', 'a:1:{i:0;a:2:{s:14:\"b_title_length\";s:2:\"80\";s:12:\"b_image_size\";s:7:\"200*200\";}}');

-- ----------------------------
-- Table structure for wl_copyfrom
-- ----------------------------
DROP TABLE IF EXISTS `wl_copyfrom`;
CREATE TABLE `wl_copyfrom` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `sitename` varchar(30) NOT NULL COMMENT '来源名称',
  `siteurl` varchar(100) NOT NULL COMMENT '来源链接',
  `thumb` varchar(100) NOT NULL COMMENT '来源logo',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认来源',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_copyfrom
-- ----------------------------
INSERT INTO `wl_copyfrom` VALUES ('1', 'Glen的小站', 'http://windlife.net', '', '0', '0');
INSERT INTO `wl_copyfrom` VALUES ('2', '百度', 'http://www.baidu.com', '', '0', '1');

-- ----------------------------
-- Table structure for wl_gallery
-- ----------------------------
DROP TABLE IF EXISTS `wl_gallery`;
CREATE TABLE `wl_gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `column_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目编号',
  `model_id` smallint(6) NOT NULL,
  `admin_id` smallint(5) NOT NULL COMMENT '发布人编号',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `style` char(100) NOT NULL DEFAULT '' COMMENT '标题样式',
  `thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `keywords` char(40) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` mediumtext NOT NULL COMMENT '摘要',
  `content` text NOT NULL COMMENT '内容',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '图集数量',
  `url` char(100) NOT NULL COMMENT 'URL',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '转向链接',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击率',
  `inputtime` datetime DEFAULT NULL COMMENT '添加时间',
  `updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`listorder`,`id`),
  KEY `listorder` (`column_id`,`status`,`listorder`,`id`),
  KEY `catid` (`column_id`,`status`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_gallery
-- ----------------------------

-- ----------------------------
-- Table structure for wl_gallery_img
-- ----------------------------
DROP TABLE IF EXISTS `wl_gallery_img`;
CREATE TABLE `wl_gallery_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `gallery_id` int(255) NOT NULL COMMENT '图集编号',
  `model_name` char(20) NOT NULL COMMENT '模型名称',
  `model_id` smallint(6) DEFAULT NULL COMMENT '模型编号',
  `img_url` varchar(100) NOT NULL COMMENT '图片地址',
  `alt` varchar(100) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`,`gallery_id`),
  KEY `model_name&gallery_id` (`gallery_id`,`model_name`),
  KEY `model_id&gallery_id` (`gallery_id`,`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_gallery_img
-- ----------------------------

-- ----------------------------
-- Table structure for wl_menu
-- ----------------------------
DROP TABLE IF EXISTS `wl_menu`;
CREATE TABLE `wl_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `parent_id` smallint(6) NOT NULL DEFAULT '0',
  `m` char(20) NOT NULL DEFAULT '',
  `c` char(20) NOT NULL DEFAULT '',
  `a` char(20) NOT NULL DEFAULT '',
  `data` char(100) NOT NULL DEFAULT '',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  `display` enum('7','6','5','4','3','2','1','0') NOT NULL DEFAULT '1',
  `size` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`),
  KEY `parentid` (`parent_id`),
  KEY `module` (`m`,`c`,`a`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_menu
-- ----------------------------
INSERT INTO `wl_menu` VALUES ('2', '设置', '0', 'admin', 'setting', 'a', '', '2', '1', '');
INSERT INTO `wl_menu` VALUES ('3', '模块', '0', 'admin', 'module', 'a', '', '3', '1', '');
INSERT INTO `wl_menu` VALUES ('4', '内容', '0', 'admin', 'content', 'a', '', '4', '1', '');
INSERT INTO `wl_menu` VALUES ('35', '来源管理', '31', 'admin', 'copyfrom', 'index', '', '2', '1', '');
INSERT INTO `wl_menu` VALUES ('34', '更新全站缓存', '31', 'admin', 'default', 'updateCache', '', '1', '1', null);
INSERT INTO `wl_menu` VALUES ('8', '扩展', '0', 'admin', 'extend', 'a', '', '8', '1', '');
INSERT INTO `wl_menu` VALUES ('9', '用户', '0', 'admin', 'user', 'a', '', '5', '1', '');
INSERT INTO `wl_menu` VALUES ('10', '菜单管理', '31', 'admin', 'menu', 'index', '', '4', '1', null);
INSERT INTO `wl_menu` VALUES ('11', '菜单添加', '10', 'admin', 'menu', 'create', '', '1', '1', '');
INSERT INTO `wl_menu` VALUES ('12', '菜单修改', '10', 'admin', 'menu', 'update', '', '2', '0', '');
INSERT INTO `wl_menu` VALUES ('13', '菜单删除', '10', 'admin', 'menu', 'delete', '', '3', '0', '');
INSERT INTO `wl_menu` VALUES ('48', '基础设置', '15', 'admin', 'setting', 'index', 'form_type=base', '1', '1', '');
INSERT INTO `wl_menu` VALUES ('15', '相关设置', '2', 'admin', 'setting', 'b', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('103', '内容发布添加', '98', 'admin', 'release', 'create', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('96', '内容发布设置', '4', 'admin', 'content', 'initSetting', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('97', '发布位管理', '96', 'admin', 'position', 'index', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('98', '内容发布', '96', 'admin', 'release', 'index', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('20', '广告管理', '58', 'admin', 'advert', 'index', '', '2', '1', '');
INSERT INTO `wl_menu` VALUES ('22', '个人信息', '1', 'admin', 'manage', 'b', '', '1', '1', '');
INSERT INTO `wl_menu` VALUES ('23', '内容发布管理', '4', 'admin', 'content', 'b', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('29', '分类管理', '7', 'admin', 'category', 'index', '', '0', '1', null);
INSERT INTO `wl_menu` VALUES ('30', '添加分类', '29', 'admin', 'category', 'create', '', '0', '1', null);
INSERT INTO `wl_menu` VALUES ('31', '扩展管理', '8', 'admin', 'extend', 'b', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('32', '修改个人信息', '22', 'admin', 'manage', 'profile', '', '1', '1', '');
INSERT INTO `wl_menu` VALUES ('33', '修改密码', '22', 'admin', 'manage', 'changepass', '', '2', '1', '');
INSERT INTO `wl_menu` VALUES ('36', '后台操作日志', '31', 'admin', 'log', 'index', '', '3', '1', null);
INSERT INTO `wl_menu` VALUES ('37', '数据库工具', '31', 'admin', 'database', 'index', '', '5', '1', null);
INSERT INTO `wl_menu` VALUES ('38', '敏感词管理', '31', 'admin', 'badword', 'index', '', '6', '1', '');
INSERT INTO `wl_menu` VALUES ('42', 'Sitemap生成', '31', 'admin', 'sitemap', 'index', '', '7', '1', null);
INSERT INTO `wl_menu` VALUES ('40', '管理员设置', '9', 'admin', 'manage', 'b', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('41', '用户管理', '9', 'admin', 'user', 'b', '', '1', '0', '');
INSERT INTO `wl_menu` VALUES ('43', '内容相关设置', '4', 'admin', 'content', 'b', '', '2', '1', '');
INSERT INTO `wl_menu` VALUES ('44', '内容管理', '23', 'admin', 'content', 'init', '', '1', '4', '');
INSERT INTO `wl_menu` VALUES ('45', '附件管理', '23', 'admin', 'attachment', 'index', '', '2', '1', '');
INSERT INTO `wl_menu` VALUES ('46', '管理栏目', '43', 'admin', 'column', 'index', '', '1', '1', '');
INSERT INTO `wl_menu` VALUES ('47', '搜索栏目', '44', 'admin', 'content', 'findColumn', '', '1', '0', '');
INSERT INTO `wl_menu` VALUES ('49', '上传设置', '15', 'admin', 'setting', 'index', 'form_type=upload', '2', '1', '');
INSERT INTO `wl_menu` VALUES ('50', '邮件设置', '15', 'admin', 'setting', 'index', 'form_type=email', '3', '1', '');
INSERT INTO `wl_menu` VALUES ('101', '发布位添加', '97', 'admin', 'position', 'create', '', '0', '2', '600*200');
INSERT INTO `wl_menu` VALUES ('52', '统计代码', '15', 'admin', 'setting', 'index', 'form_type=count', '5', '1', '');
INSERT INTO `wl_menu` VALUES ('53', '模型管理', '43', 'admin', 'model', 'index', '', '2', '1', '');
INSERT INTO `wl_menu` VALUES ('54', '模型添加', '53', 'admin', 'model', 'create', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('55', '模型修改', '53', 'admin', 'model', 'update', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('56', '模型删除', '53', 'admin', 'model', 'delete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('57', 'URL管理', '31', 'admin', 'urlmanage', 'index', '', '8', '1', '');
INSERT INTO `wl_menu` VALUES ('58', '模块列表', '3', 'admin', 'module', 'b', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('59', '栏目添加', '46', 'admin', 'column', 'create', '', '1', '1', '');
INSERT INTO `wl_menu` VALUES ('60', '自定栏目添加', '46', 'admin', 'column', 'custom', '', '2', '1', '');
INSERT INTO `wl_menu` VALUES ('61', '链接栏目添加', '46', 'admin', 'column', 'link', '', '3', '1', '');
INSERT INTO `wl_menu` VALUES ('62', '栏目修改', '46', 'admin', 'column', 'update', '', '4', '0', '');
INSERT INTO `wl_menu` VALUES ('63', '自定栏目修改', '46', 'admin', 'column', 'customUpdate', '', '5', '0', '');
INSERT INTO `wl_menu` VALUES ('64', '链接栏目修改', '46', 'admin', 'column', 'linkUpdate', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('65', 'URL规则添加', '57', 'admin', 'urlmanage', 'create', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('66', 'URL规则修改', '57', 'admin', 'urlmanage', 'update', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('67', 'URL规则删除', '57', 'admin', 'urlmanage', 'delete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('69', '来源添加', '35', 'admin', 'copyfrom', 'create', '', '0', '1', '580*240');
INSERT INTO `wl_menu` VALUES ('70', '敏感词添加', '38', 'admin', 'badword', 'create', '', '0', '2', '500*240');
INSERT INTO `wl_menu` VALUES ('71', '管理员管理', '40', 'admin', 'manage', 'index', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('72', '管理员添加', '71', 'admin', 'manage', 'create', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('73', '管理员修改', '71', 'admin', 'manage', 'update', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('74', '管理员删除', '71', 'admin', 'manage', 'delete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('75', '角色管理', '40', 'admin', 'role', 'index', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('76', '权限参数设置', '40', 'admin', 'access', 'setting', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('77', '角色添加', '75', 'admin', 'role', 'create', '', '0', '2', '570*220');
INSERT INTO `wl_menu` VALUES ('78', '角色修改', '75', 'admin', 'role', 'update', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('79', '角色删除', '75', 'admin', 'role', 'delete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('80', '角色权限设置', '75', 'admin', 'role', 'setaccess', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('81', '附件删除', '45', 'admin', 'attachment', 'delete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('82', '附件批量删除', '45', 'admin', 'attachment', 'deleteAll', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('83', '单页面管理', '23', 'admin', 'page', 'edit', 'column_id={$column_id}', '2', '6', '');
INSERT INTO `wl_menu` VALUES ('84', '点击访问', '83', 'admin', 'page', 'preview', 'click_preview', '3', '5', '');
INSERT INTO `wl_menu` VALUES ('85', '文章管理', '23', 'admin', 'article', 'index', 'column_id={$column_id}', '0', '6', '');
INSERT INTO `wl_menu` VALUES ('86', '添加文章', '85', 'admin', 'article', 'create', 'column_id={$column_id}', '0', '3', '');
INSERT INTO `wl_menu` VALUES ('87', '模型参数管理', '43', 'admin', 'mparam', 'index', 'model_id={$model_id}', '3', '7', '');
INSERT INTO `wl_menu` VALUES ('88', '模型参数添加', '87', 'admin', 'mparam', 'create', 'model_id={$model_id}', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('89', '模型参数修改', '87', 'admin', 'mparam', 'update', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('90', '模型参数删除', '87', 'admin', 'mparam', 'delete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('91', '修改文章', '85', 'admin', 'article', 'update', 'column_id={$column_id}', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('92', '删除文章', '85', 'admin', 'article', 'delete', 'column_id={$column_id}', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('93', '批量删除', '85', 'admin', 'article', 'deleteAll', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('94', '来源修改', '35', 'admin', 'copyfrom', 'update', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('95', '来源删除', '35', 'admin', 'copyfrom', 'delete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('99', '添加版位', '20', 'admin', 'advert', 'create', '', '0', '2', '600*300');
INSERT INTO `wl_menu` VALUES ('100', '广告模板', '20', 'admin', 'advert', 'templet', '', '0', '1', '');
INSERT INTO `wl_menu` VALUES ('102', '发布位删除', '97', 'admin', 'position', 'delete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('104', '内容发布修改', '98', 'admin', 'release', 'update', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('105', '内容发布删除', '98', 'admin', 'release', 'delete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('106', '内容浏览', '98', 'admin', 'release', 'list', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('107', '内容排序', '98', 'admin', 'release', 'listorder', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('108', '内容删除', '98', 'admin', 'release', 'cdelete', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('109', '广告列表', '20', 'admin', 'advert', 'list', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('110', '广告添加', '20', 'admin', 'advert', 'add', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('111', '广告修改', '20', 'admin', 'advert', 'edit', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('112', '广告删除', '20', 'admin', 'advert', 'del', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('113', '广告排序', '20', 'admin', 'advert', 'listorder', '', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('114', '图库管理', '23', 'admin', 'gallery', 'index', 'column_id={$column_id}', '0', '6', '');
INSERT INTO `wl_menu` VALUES ('115', '添加图集', '114', 'admin', 'gallery', 'create', 'column_id={$column_id}', '0', '3', '');
INSERT INTO `wl_menu` VALUES ('116', '修改图集', '114', 'admin', 'gallery', 'update', 'column_id={$column_id}', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('117', '删除图集', '114', 'admin', 'gallery', 'delete', 'column_id={$column_id}', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('118', '批量删除', '114', 'admin', 'gallery', 'deleteAll', 'column_id={$column_id}', '0', '0', '');
INSERT INTO `wl_menu` VALUES ('1', '我的面板', '0', 'admin', 'default', 'main', '', '1', '1', '');
INSERT INTO `wl_menu` VALUES ('119', '标签管理', '23', 'admin', 'tags', 'index', '', '3', '1', '');

-- ----------------------------
-- Table structure for wl_model_object
-- ----------------------------
DROP TABLE IF EXISTS `wl_model_object`;
CREATE TABLE `wl_model_object` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(30) NOT NULL COMMENT '模型名称',
  `module` char(20) DEFAULT NULL COMMENT '模块',
  `controller` char(20) NOT NULL COMMENT '控制器',
  `action` char(20) NOT NULL COMMENT '方法',
  `data` varchar(100) DEFAULT NULL COMMENT '参数',
  `object` char(20) NOT NULL COMMENT '模型对象',
  `items` int(11) NOT NULL DEFAULT '0' COMMENT '模型数据量',
  `m_module` char(20) DEFAULT NULL COMMENT '管理地址模块',
  `m_controller` char(20) NOT NULL COMMENT '管理地址控制器',
  `m_action` char(20) NOT NULL COMMENT '管理地址方法',
  `m_data` varchar(100) DEFAULT NULL COMMENT '管理地址参数',
  `data_num` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数据条目',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_model_object
-- ----------------------------
INSERT INTO `wl_model_object` VALUES ('3', '文章模型', '', 'article', 'index', '', 'Article', '3', 'admin', 'article', 'index', '', '1');
INSERT INTO `wl_model_object` VALUES ('4', '单页面', '', 'page', 'index', '', 'Page', '1', 'admin', 'page', 'edit', '', '0');
INSERT INTO `wl_model_object` VALUES ('5', '图库模型', '', 'gallery', 'index', '', 'Gallery', '16', 'admin', 'gallery', 'index', '', '1');

-- ----------------------------
-- Table structure for wl_model_param
-- ----------------------------
DROP TABLE IF EXISTS `wl_model_param`;
CREATE TABLE `wl_model_param` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `model_id` smallint(5) NOT NULL COMMENT '模型编号',
  `name` char(20) NOT NULL COMMENT '参数名称',
  `key` char(30) NOT NULL COMMENT '参数引用key',
  `default_value` varchar(100) NOT NULL COMMENT '默认值',
  `type` char(20) NOT NULL COMMENT '参数类型',
  `value_items` varchar(255) DEFAULT NULL COMMENT '参数值集合',
  `model_field` char(20) DEFAULT NULL COMMENT '对应模型',
  `position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '参数位置(前台/后台)',
  `hint` varchar(255) DEFAULT NULL COMMENT '参数提示',
  `listorder` smallint(5) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_model_param
-- ----------------------------
INSERT INTO `wl_model_param` VALUES ('3', '3', '标题长度限制', 'b_title_length', '80', 'text', '', '', '0', 'adf', '1');
INSERT INTO `wl_model_param` VALUES ('4', '4', '标题长度限制', 'b_title_length', '80', 'text', '', '', '0', null, '0');
INSERT INTO `wl_model_param` VALUES ('5', '3', '缩略图尺寸', 'b_image_size', '200*200', 'text', '', '', '0', null, '2');
INSERT INTO `wl_model_param` VALUES ('6', '5', '标题长度', 'b_title_length', '80', 'text', '', '', '0', null, '0');
INSERT INTO `wl_model_param` VALUES ('7', '5', '缩略图尺寸', 'b_image_size', '200*200', 'text', '', '', '0', null, '0');

-- ----------------------------
-- Table structure for wl_module
-- ----------------------------
DROP TABLE IF EXISTS `wl_module`;
CREATE TABLE `wl_module` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `name` varchar(20) NOT NULL,
  `config` varchar(255) DEFAULT NULL,
  `desn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_module
-- ----------------------------

-- ----------------------------
-- Table structure for wl_page
-- ----------------------------
DROP TABLE IF EXISTS `wl_page`;
CREATE TABLE `wl_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `style` char(100) DEFAULT NULL,
  `content` text COMMENT '内容',
  `keyword` varchar(255) DEFAULT NULL COMMENT '关键词',
  `column_id` int(11) NOT NULL COMMENT '栏目编号',
  `model_id` int(11) NOT NULL COMMENT '模型编号',
  `admin_id` int(11) NOT NULL COMMENT '管理员编号',
  `created` datetime DEFAULT NULL COMMENT '创建时间',
  `updated` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_page
-- ----------------------------
INSERT INTO `wl_page` VALUES ('1', '阿斯蒂芬克拉斯剪短发', 'font-weight:bold', '<p>阿斯顿了看风景阿撒了款到即发阿斯顿了福建<br /></p>', '', '2', '4', '1', '2014-05-31 20:21:25', null);

-- ----------------------------
-- Table structure for wl_position
-- ----------------------------
DROP TABLE IF EXISTS `wl_position`;
CREATE TABLE `wl_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `key_name` char(50) NOT NULL COMMENT '位置引用key',
  `description` varchar(255) NOT NULL COMMENT '位置描述',
  `type` tinyint(255) NOT NULL DEFAULT '0' COMMENT '内容/广告位置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_position
-- ----------------------------
INSERT INTO `wl_position` VALUES ('5', 'header_logo_right', '头部logo右侧小广告条', '1');
INSERT INTO `wl_position` VALUES ('6', 'header_right', '头部最右侧广告条', '1');
INSERT INTO `wl_position` VALUES ('7', 'index_hotnews', '首页焦点图下面热点信息', '0');

-- ----------------------------
-- Table structure for wl_release
-- ----------------------------
DROP TABLE IF EXISTS `wl_release`;
CREATE TABLE `wl_release` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `key_name` char(50) NOT NULL COMMENT '引用词',
  `title` varchar(100) NOT NULL COMMENT '内容块名称',
  `max_num` int(11) NOT NULL DEFAULT '1' COMMENT '最大数量',
  `num` int(11) DEFAULT '0' COMMENT '数据量',
  `model_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '所属模型',
  `first_title_length` int(11) DEFAULT '20' COMMENT '头条标题长度',
  `first_desc_length` int(11) DEFAULT '100' COMMENT '头条描述长途',
  `img_title_length` int(11) DEFAULT '20' COMMENT '图片内容标题长度',
  `img_desc_length` int(11) DEFAULT '100' COMMENT '图片内容描述长度',
  `img_size` char(10) DEFAULT NULL COMMENT '图片大小',
  `other_title_length` int(11) DEFAULT '20' COMMENT '普通标题长途',
  `other_desc_length` int(11) DEFAULT '100' COMMENT '普通描述长途',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_release
-- ----------------------------
INSERT INTO `wl_release` VALUES ('1', 'index_hotnews', '热点新闻', '7', '0', '3', '20', '100', '20', '100', '200*200', '20', '100');

-- ----------------------------
-- Table structure for wl_release_content
-- ----------------------------
DROP TABLE IF EXISTS `wl_release_content`;
CREATE TABLE `wl_release_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `release_id` int(11) NOT NULL COMMENT '所属内容发布',
  `model_id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL COMMENT '所属栏目',
  `data_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `thumb` varchar(100) DEFAULT NULL COMMENT '缩略图',
  `url` varchar(100) NOT NULL COMMENT '地址',
  `listorder` smallint(6) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `ctime` datetime DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_release_content
-- ----------------------------

-- ----------------------------
-- Table structure for wl_setting
-- ----------------------------
DROP TABLE IF EXISTS `wl_setting`;
CREATE TABLE `wl_setting` (
  `key` char(20) NOT NULL COMMENT '设置key',
  `name` varchar(50) DEFAULT NULL COMMENT '设置名称',
  `value` text COMMENT '设置值',
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_setting
-- ----------------------------
INSERT INTO `wl_setting` VALUES ('base', '基本设置', 'a:10:{s:5:\"title\";s:13:\"Glen的小站\";s:8:\"subTitle\";s:66:\"像风一样自由自在的生活，记录生活的点点滴滴。\";s:6:\"domain\";s:23:\"http://www.windlife.net\";s:11:\"metaKeyword\";s:54:\"网站建设,web app开发,大型web系统解决方案\";s:15:\"metaDescription\";s:81:\"本网站注重大型web系统解决方法提供，开发，部署，维护等。\";s:5:\"email\";s:13:\"jsjgjf@qq.com\";s:5:\"phone\";s:11:\"15288973001\";s:3:\"zip\";s:6:\"266000\";s:7:\"address\";s:30:\"青岛市北区同安路715号\";s:3:\"qq1\";s:9:\"402221480\";}');
INSERT INTO `wl_setting` VALUES ('count', '统计代码', 'a:1:{s:4:\"code\";s:17:\"<script></script>\";}');
INSERT INTO `wl_setting` VALUES ('email', '邮件设置', 'a:5:{s:6:\"server\";s:11:\"smtp.qq.com\";s:4:\"port\";s:2:\"25\";s:7:\"address\";s:14:\"admin@test.com\";s:8:\"username\";s:14:\"admin@test.com\";s:8:\"password\";s:6:\"123456\";}');
INSERT INTO `wl_setting` VALUES ('upload', '上传设置', 'a:9:{s:4:\"size\";s:4:\"2000\";s:8:\"fileType\";s:67:\"jpg|jpeg|gif|bmp|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|rar|zip|swf\";s:9:\"waterWith\";s:3:\"300\";s:11:\"waterHeight\";s:3:\"300\";s:9:\"waterName\";s:8:\"mark.png\";s:12:\"waterTouming\";s:3:\"100\";s:12:\"waterQuality\";s:3:\"100\";s:12:\"thumbQuality\";s:3:\"100\";s:13:\"waterPosition\";s:1:\"3\";}');

-- ----------------------------
-- Table structure for wl_tags
-- ----------------------------
DROP TABLE IF EXISTS `wl_tags`;
CREATE TABLE `wl_tags` (
  `id` int(11) NOT NULL COMMENT '自动编号',
  `title` varchar(100) NOT NULL COMMENT '标签名称',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '内容数量',
  `post_id` smallint(6) NOT NULL COMMENT '创建人',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `listorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_tags
-- ----------------------------

-- ----------------------------
-- Table structure for wl_tags_item
-- ----------------------------
DROP TABLE IF EXISTS `wl_tags_item`;
CREATE TABLE `wl_tags_item` (
  `id` int(11) NOT NULL COMMENT '自动编号',
  `tags_id` int(11) DEFAULT NULL COMMENT '标签ID',
  `model_name` char(20) DEFAULT NULL COMMENT '模型名称',
  `content_id` int(11) DEFAULT NULL COMMENT '内容ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_tags_item
-- ----------------------------

-- ----------------------------
-- Table structure for wl_urlrule
-- ----------------------------
DROP TABLE IF EXISTS `wl_urlrule`;
CREATE TABLE `wl_urlrule` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `name` varchar(50) NOT NULL COMMENT '规则名称',
  `module` char(20) NOT NULL COMMENT '所属模块',
  `rule` char(50) NOT NULL COMMENT '规则',
  `rule_url` char(50) NOT NULL COMMENT '规则对应地址',
  `page_rule` char(60) DEFAULT NULL COMMENT '分页规则',
  `page_rule_url` char(60) DEFAULT NULL COMMENT '分页规则对应地址',
  `listorder` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_urlrule
-- ----------------------------
INSERT INTO `wl_urlrule` VALUES ('3', '单页面规则', '无模块', 'page-<keyparam>.html', 'page/index', '', '', '1');
INSERT INTO `wl_urlrule` VALUES ('7', '文章规则', '无模块', 'article-<keyparam>.html', 'article/index', 'article-<keyparam>-<page>.html', 'article/index', '3');
INSERT INTO `wl_urlrule` VALUES ('8', '文章详情规则', '无模块', 'article-view-<id>.html', 'article/view', '', '', '2');
INSERT INTO `wl_urlrule` VALUES ('9', ' 案例详情规则', '无模块', 'cases-view-<id>.html', 'cases/view', '', '', '4');
INSERT INTO `wl_urlrule` VALUES ('10', '案例规则', '无模块', 'cases-<keyparam>.html', 'cases/index', 'cases-<keyparam>-<page>.html', 'cases.html', '5');
INSERT INTO `wl_urlrule` VALUES ('11', '搜索页面', '无模块', 'search.html', 'search/index', '', '', '6');
