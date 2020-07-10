/*
Navicat MySQL Data Transfer

Source Server         : 本地mariadb
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ant_db

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-07-10 17:42:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ant_admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `ant_admin_user`;
CREATE TABLE `ant_admin_user` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `user_name` varchar(55) NOT NULL COMMENT '管理员名字',
  `password` varchar(64) NOT NULL COMMENT '管理员密码',
  `role_id` int(11) DEFAULT NULL COMMENT '所属角色',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 禁用 1 启用',
  `create_time` datetime NOT NULL COMMENT '添加时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `remarks` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`aid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员';

-- ----------------------------
-- Records of ant_admin_user
-- ----------------------------
INSERT INTO `ant_admin_user` VALUES ('1', 'admin_ant', 'b61ee0b37bff4a4b73b2678074d7af97763da3c1', '1', '1', '2020-07-03 13:31:20', '2020-07-10 16:10:01', '2020-07-08 10:24:18', '');

-- ----------------------------
-- Table structure for `ant_article`
-- ----------------------------
DROP TABLE IF EXISTS `ant_article`;
CREATE TABLE `ant_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '标题',
  `subtitle` varchar(150) DEFAULT NULL COMMENT '副标题',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 启用  0 关闭',
  `img_url` varchar(150) NOT NULL COMMENT '图片',
  `imgs_url` varchar(500) DEFAULT NULL COMMENT '多图  用 ;切割',
  `content` text COMMENT '内容',
  `add_uid` int(11) NOT NULL COMMENT '添加人',
  `create_time` datetime NOT NULL,
  `update_uid` int(11) NOT NULL,
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章';

-- ----------------------------
-- Records of ant_article
-- ----------------------------
INSERT INTO `ant_article` VALUES ('1', '更努力更奋斗', '方向只是一部分，努力了么。', '1', '/uploads/image/1/Article/54/963d062b7a1b0af100a716d0565dae.png', '/uploads/image/1/Article/b2/5b7d902d3f699f52838dd62d1d42de.jpg;/uploads/image/1/Article/7e/455cea3e80a70dc857916a5288940e.jpg;/uploads/image/1/Article/c1/eb1a0cda98e8b49c3f433029850769.jpg', '<p>人生不就是走走停停，时不时停下来看看身边的东西，很多美好的事情就在身侧。</p><h4>（<em>错把陈醋</em>当成墨,写尽半生都是酸）走对路，很重要。珍惜当下，也很重要！', '1', '2020-07-10 16:28:58', '1', '2020-07-10 16:28:58');

-- ----------------------------
-- Table structure for `ant_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `ant_login_log`;
CREATE TABLE `ant_login_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `uid` int(11) NOT NULL COMMENT '登录用户',
  `login_ip` varchar(15) NOT NULL COMMENT '登录ip',
  `login_area` varchar(55) DEFAULT NULL COMMENT '登录地区',
  `create_time` datetime DEFAULT NULL COMMENT '登录时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志';

-- ----------------------------
-- Records of ant_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for `ant_node`
-- ----------------------------
DROP TABLE IF EXISTS `ant_node`;
CREATE TABLE `ant_node` (
  `node_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `node_name` varchar(50) NOT NULL COMMENT '节点英文名称',
  `node_enname` varchar(50) NOT NULL,
  `node_path` varchar(55) NOT NULL DEFAULT '#' COMMENT '节点路径',
  `node_pid` int(11) NOT NULL COMMENT '所属节点',
  `node_order` mediumint(5) NOT NULL DEFAULT '0',
  `node_icon` varchar(55) DEFAULT NULL COMMENT '节点图标',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1 不是 2 是',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`node_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='节点菜单表';

-- ----------------------------
-- Records of ant_node
-- ----------------------------
INSERT INTO `ant_node` VALUES ('1', '初始菜单', 'Home page', '/adminback/index/index', '0', '1000', 'layui-icon layui-icon-home', '1', '2020-07-03 14:17:38');
INSERT INTO `ant_node` VALUES ('2', '首页', 'Home', '/adminback/index/welcome', '1', '0', '', '1', '2020-07-03 14:18:24');
INSERT INTO `ant_node` VALUES ('3', '修改密码', 'Change Password', '/adminback/UserManage/editpwd', '1', '0', '', '1', '2020-07-03 14:19:03');
INSERT INTO `ant_node` VALUES ('4', '权限管理', 'Authority Management', '#', '0', '0', 'layui-icon layui-icon-template', '2', '2020-07-03 14:19:34');
INSERT INTO `ant_node` VALUES ('5', '管理员管理', 'Manage Administrator', '/adminback/UserManage/index', '4', '0', '', '2', '2020-07-03 14:27:42');
INSERT INTO `ant_node` VALUES ('6', '添加管理员', 'Add Administrator', 'adminback/UserManage/addAdminUser', '5', '0', '', '1', '2020-07-03 14:28:26');
INSERT INTO `ant_node` VALUES ('7', '编辑管理员', 'Edit Administrator', '/adminback/UserManage/editAdminUser', '5', '0', '', '1', '2020-07-03 14:28:43');
INSERT INTO `ant_node` VALUES ('8', '删除管理员', 'Remove Administrator', '/adminback/UserManager/delAdminUser', '5', '0', '', '1', '2020-07-03 14:29:14');
INSERT INTO `ant_node` VALUES ('9', '日志管理', 'Log Manage', '#', '0', '3', 'layui-icon layui-icon-table', '2', '2020-07-08 16:07:36');
INSERT INTO `ant_node` VALUES ('10', '清除菜单缓存', 'Clear Menu Cache', '/adminback/index/clearMenuCache', '1', '0', null, '1', '2020-07-07 14:41:07');
INSERT INTO `ant_node` VALUES ('11', '登录日志', 'Login log', '/adminback/log/loginLog', '9', '2', '', '2', '2020-07-08 16:26:27');
INSERT INTO `ant_node` VALUES ('12', '操作日志', 'Operation log', '/adminback/log/operateLog', '9', '0', '', '2', '2020-07-08 17:02:10');
INSERT INTO `ant_node` VALUES ('13', '角色管理', 'Role Manage', '/adminback/role/index', '4', '0', '', '2', '2020-07-09 21:35:54');
INSERT INTO `ant_node` VALUES ('14', '添加角色', 'Add Role', '/adminback/role/add', '13', '0', '', '1', '2020-07-09 21:40:06');
INSERT INTO `ant_node` VALUES ('15', '编辑角色', 'Edit Role', '/adminback/role/edit', '13', '0', '', '1', '2020-07-09 21:40:53');
INSERT INTO `ant_node` VALUES ('16', '删除角色', 'Delete Role', '/adminback/role/delete', '13', '0', '', '1', '2020-07-09 21:41:07');
INSERT INTO `ant_node` VALUES ('17', '权限分配', 'Permission Assignment', '/adminback/role/roleSetting', '13', '0', '', '1', '2020-07-09 21:41:38');
INSERT INTO `ant_node` VALUES ('18', '节点管理', 'Node Manage', '/adminback/node/index', '4', '0', '', '2', '2020-07-09 21:42:06');
INSERT INTO `ant_node` VALUES ('19', '添加节点', 'Add Node', '/adminback/node/add', '18', '0', '', '1', '2020-07-09 21:42:51');
INSERT INTO `ant_node` VALUES ('20', '编辑节点', 'Edit Node', '/adminback/node/edit', '18', '0', '', '1', '2020-07-09 21:43:29');
INSERT INTO `ant_node` VALUES ('21', '删除节点', 'Delete Node', '/adminback/node/delete', '18', '0', '', '1', '2020-07-09 21:43:44');
INSERT INTO `ant_node` VALUES ('22', '拉黑（启用）管理员', 'Blackout (enable) administrator', '/adminback/UserManager/statusAdminUser', '5', '0', '', '1', null);
INSERT INTO `ant_node` VALUES ('23', '拉黑（启用）角色', 'Blackout (Enable) Eole', '/adminback/role/statusRole', '13', '0', '', '1', null);
INSERT INTO `ant_node` VALUES ('24', '文章管理', 'Article Management', '#', '0', '2', 'layui-icon layui-icon-read', '2', '2020-07-08 10:47:57');
INSERT INTO `ant_node` VALUES ('25', '文章列表', 'Article List', '/adminback/Article/index', '24', '0', '', '2', '2020-07-08 10:49:42');
INSERT INTO `ant_node` VALUES ('26', '添加文章', 'Add Article', '/adminback/Article/add', '25', '0', '', '1', '2020-07-10 14:33:59');
INSERT INTO `ant_node` VALUES ('27', '修改文章', 'Edit Article', '/adminback/Article/edit', '25', '0', '', '1', '2020-07-10 14:35:14');
INSERT INTO `ant_node` VALUES ('28', '删除文章', 'Delete Article', '/adminback/Article/delete', '25', '0', '', '1', '2020-07-10 14:36:42');
INSERT INTO `ant_node` VALUES ('29', '禁用（启用）文章', 'Blackout (Enable) Article', '/adminback/Article/statusArticle', '25', '0', '', '1', '2020-07-10 14:37:56');

-- ----------------------------
-- Table structure for `ant_operate_log`
-- ----------------------------
DROP TABLE IF EXISTS `ant_operate_log`;
CREATE TABLE `ant_operate_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '操作日志id',
  `uid` varchar(55) NOT NULL COMMENT '操作用户',
  `operator_ip` varchar(15) NOT NULL COMMENT '操作者ip',
  `operate_desc` varchar(5000) NOT NULL COMMENT '操作简述',
  `create_time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`log_id`),
  KEY `uid_idx` (`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- ----------------------------
-- Records of ant_operate_log
-- ----------------------------

-- ----------------------------
-- Table structure for `ant_role`
-- ----------------------------
DROP TABLE IF EXISTS `ant_role`;
CREATE TABLE `ant_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(55) NOT NULL COMMENT '角色名称',
  `role_node` varchar(300) NOT NULL COMMENT '角色拥有的权限节点',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '角色状态 1 启用 0 禁用',
  `remarks` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='角色';

-- ----------------------------
-- Records of ant_role
-- ----------------------------
INSERT INTO `ant_role` VALUES ('1', '超级管理员', '', '1', '拥有所有权限');
