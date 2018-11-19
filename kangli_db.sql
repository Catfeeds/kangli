/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1_3306
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : kangli_db

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-19 17:32:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for fw_accesstoken
-- ----------------------------
DROP TABLE IF EXISTS `fw_accesstoken`;
CREATE TABLE `fw_accesstoken` (
  `at_id` int(11) NOT NULL AUTO_INCREMENT,
  `at_unitcode` varchar(32) NOT NULL COMMENT '企业编号',
  `at_unitopenid` varchar(256) NOT NULL COMMENT '企业openid',
  `at_openid` varchar(256) NOT NULL COMMENT '用户wxopenid',
  `at_userid` int(11) DEFAULT '0' COMMENT '用户ID',
  `at_username` varchar(256) DEFAULT NULL COMMENT '用户名',
  `at_token` varchar(256) NOT NULL COMMENT 'access_token',
  `at_retoken` varchar(256) DEFAULT NULL COMMENT '刷新access_token',
  `at_retime` int(11) NOT NULL DEFAULT '0' COMMENT 'token刷新时间',
  `at_clentip` varchar(32) NOT NULL COMMENT '登录IP',
  `at_addtime` int(11) NOT NULL COMMENT '登录时间',
  `at_status` int(4) NOT NULL DEFAULT '0' COMMENT '在线状态',
  PRIMARY KEY (`at_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_accesstoken
-- ----------------------------

-- ----------------------------
-- Table structure for fw_adinfo
-- ----------------------------
DROP TABLE IF EXISTS `fw_adinfo`;
CREATE TABLE `fw_adinfo` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_unitcode` varchar(32) DEFAULT NULL,
  `ad_group` int(11) DEFAULT '0' COMMENT '海报分组',
  `ad_name` varchar(64) DEFAULT NULL,
  `ad_des` varchar(256) DEFAULT NULL,
  `ad_pic` varchar(32) DEFAULT NULL,
  `ad_url` varchar(128) DEFAULT NULL,
  `ad_addtime` int(11) DEFAULT '0',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='海报设置';

-- ----------------------------
-- Records of fw_adinfo
-- ----------------------------
INSERT INTO `fw_adinfo` VALUES ('7', '9999', '1', '海报1', '', '9999/15129731985.jpg', '', '1512973198');
INSERT INTO `fw_adinfo` VALUES ('8', '9999', '1', '海报2', '', '9999/15129732106.jpg', '', '1512973210');
INSERT INTO `fw_adinfo` VALUES ('9', '9999', '1', '海报3', '', '9999/15129732243.jpg', '', '1512973224');

-- ----------------------------
-- Table structure for fw_applogin
-- ----------------------------
DROP TABLE IF EXISTS `fw_applogin`;
CREATE TABLE `fw_applogin` (
  `lg_id` int(11) NOT NULL AUTO_INCREMENT,
  `lg_unitcode` varchar(32) DEFAULT NULL,
  `lg_userid` int(11) DEFAULT NULL,
  `lg_username` varchar(64) DEFAULT NULL,
  `lg_token` varchar(64) DEFAULT NULL,
  `lg_imei` varchar(32) DEFAULT NULL,
  `lg_time` int(11) DEFAULT NULL,
  `lg_ip` varchar(32) DEFAULT NULL,
  `lg_useragent` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`lg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='app出货登录状态';

-- ----------------------------
-- Records of fw_applogin
-- ----------------------------

-- ----------------------------
-- Table structure for fw_applydltype
-- ----------------------------
DROP TABLE IF EXISTS `fw_applydltype`;
CREATE TABLE `fw_applydltype` (
  `apply_id` int(11) NOT NULL AUTO_INCREMENT,
  `apply_unitcode` varchar(32) DEFAULT NULL,
  `apply_dlid` int(11) DEFAULT '0' COMMENT '申请代理id',
  `apply_agobelong` int(11) DEFAULT '0' COMMENT '申请前上家',
  `apply_agodltype` int(11) DEFAULT '0' COMMENT '申请前级别',
  `apply_afterbelong` int(11) DEFAULT '0' COMMENT '申请后的上家',
  `apply_afterdltype` int(11) DEFAULT '0' COMMENT '申请的级别',
  `apply_pic` varchar(64) DEFAULT NULL COMMENT '凭证',
  `apply_addtime` int(11) DEFAULT '0' COMMENT '申请时间',
  `apply_dealtime` int(11) DEFAULT '0' COMMENT '处理时间',
  `apply_remark` varchar(256) DEFAULT NULL COMMENT '处理备注',
  `apply_state` int(11) DEFAULT '0' COMMENT '处理状态',
  PRIMARY KEY (`apply_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='代理申请调整级别';

-- ----------------------------
-- Records of fw_applydltype
-- ----------------------------
INSERT INTO `fw_applydltype` VALUES ('6', '9999', '34', '32', '8', '0', '7', '20180202\\c4b087ed86a10b516ad4f8eb7a5b5366.png', '1517546257', '0', '', '0');
INSERT INTO `fw_applydltype` VALUES ('7', '9999', '63', '61', '9', '32', '8', '9999/5b8f7d46a8d398293.jpeg', '1536130377', '0', '', '0');

-- ----------------------------
-- Table structure for fw_balance
-- ----------------------------
DROP TABLE IF EXISTS `fw_balance`;
CREATE TABLE `fw_balance` (
  `bl_id` int(11) NOT NULL AUTO_INCREMENT,
  `bl_unitcode` varchar(32) DEFAULT NULL,
  `bl_type` int(11) DEFAULT '0' COMMENT '余额类型',
  `bl_sendid` int(11) DEFAULT '0' COMMENT '发款方id',
  `bl_receiveid` int(11) DEFAULT '0' COMMENT '收款方id',
  `bl_money` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `bl_odid` int(11) DEFAULT '0' COMMENT '订单id',
  `bl_orderid` varchar(32) DEFAULT NULL COMMENT '订单号',
  `bl_odblid` int(11) DEFAULT '0' COMMENT '订单关系id',
  `bl_addtime` int(11) DEFAULT '0',
  `bl_remark` varchar(256) DEFAULT NULL COMMENT '简单说明',
  `bl_state` int(11) DEFAULT '0' COMMENT '状态',
  `bl_rcid` int(11) DEFAULT '0' COMMENT '对应提现id',
  `bl_isyfk` int(11) DEFAULT '0' COMMENT '预付款支付订单款项',
  PRIMARY KEY (`bl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='代理商余额明细表';

-- ----------------------------
-- Records of fw_balance
-- ----------------------------
INSERT INTO `fw_balance` VALUES ('6', '9999', '1', '0', '79', '6000.00', '0', '', '0', '1541145204', 'test', '1', '0', '0');
INSERT INTO `fw_balance` VALUES ('7', '9999', '1', '0', '79', '3000.00', '0', '', '0', '1541145215', 'test', '1', '0', '0');
INSERT INTO `fw_balance` VALUES ('8', '9999', '1', '79', '0', '2000.00', '0', '', '0', '1541145223', 'test', '1', '0', '0');
INSERT INTO `fw_balance` VALUES ('9', '9999', '1', '0', '80', '200.00', '0', '', '0', '1541208717', 'test', '1', '0', '0');
INSERT INTO `fw_balance` VALUES ('10', '9999', '1', '80', '0', '10.00', '0', '', '0', '1541208728', 'test', '1', '0', '0');

-- ----------------------------
-- Table structure for fw_batch
-- ----------------------------
DROP TABLE IF EXISTS `fw_batch`;
CREATE TABLE `fw_batch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitcode` varchar(32) DEFAULT NULL,
  `codebegin` int(11) DEFAULT NULL,
  `codeend` int(11) DEFAULT NULL,
  `voice` varchar(256) DEFAULT NULL,
  `smsnote` varchar(500) DEFAULT NULL,
  `resmsnote` varchar(500) DEFAULT NULL,
  `errsmsnote` varchar(500) DEFAULT NULL,
  `oversmsnote` varchar(500) DEFAULT NULL,
  `datetime` int(11) DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`id`),
  KEY `unitcode` (`unitcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='码分批处理';

-- ----------------------------
-- Records of fw_batch
-- ----------------------------

-- ----------------------------
-- Table structure for fw_brand
-- ----------------------------
DROP TABLE IF EXISTS `fw_brand`;
CREATE TABLE `fw_brand` (
  `br_id` int(11) NOT NULL AUTO_INCREMENT,
  `br_unitcode` varchar(32) DEFAULT NULL,
  `br_name` varchar(64) DEFAULT NULL,
  `br_pic` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`br_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='授权品牌';

-- ----------------------------
-- Records of fw_brand
-- ----------------------------

-- ----------------------------
-- Table structure for fw_brandattorney
-- ----------------------------
DROP TABLE IF EXISTS `fw_brandattorney`;
CREATE TABLE `fw_brandattorney` (
  `ba_id` int(11) NOT NULL AUTO_INCREMENT,
  `ba_unitcode` varchar(32) DEFAULT NULL,
  `ba_brandid` int(11) DEFAULT NULL,
  `ba_dealerid` int(11) DEFAULT NULL,
  `ba_pic` varchar(64) DEFAULT NULL,
  `ba_level` int(11) DEFAULT '0' COMMENT '代理级别',
  PRIMARY KEY (`ba_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='品牌授权图片';

-- ----------------------------
-- Records of fw_brandattorney
-- ----------------------------

-- ----------------------------
-- Table structure for fw_chaibox
-- ----------------------------
DROP TABLE IF EXISTS `fw_chaibox`;
CREATE TABLE `fw_chaibox` (
  `chai_id` int(11) NOT NULL AUTO_INCREMENT,
  `chai_unitcode` varchar(32) DEFAULT NULL,
  `chai_deliver` int(11) DEFAULT '0',
  `chai_addtime` int(11) DEFAULT NULL,
  `chai_barcode` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`chai_id`),
  KEY `chai_unitcode` (`chai_unitcode`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='拆箱记录';

-- ----------------------------
-- Records of fw_chaibox
-- ----------------------------
INSERT INTO `fw_chaibox` VALUES ('12', '9999', '32', '1540782942', '16000002');

-- ----------------------------
-- Table structure for fw_code
-- ----------------------------
DROP TABLE IF EXISTS `fw_code`;
CREATE TABLE `fw_code` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `unitcode` varchar(4) DEFAULT NULL,
  `address` int(11) DEFAULT NULL,
  `codea` varchar(32) DEFAULT NULL,
  `codeb` varchar(32) DEFAULT NULL,
  `codec` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=2024778 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_code
-- ----------------------------
INSERT INTO `fw_code` VALUES ('2024777', '9999', '2316', '7406', '1461', '6858');
INSERT INTO `fw_code` VALUES ('2024776', '9999', '2315', '4349', '9179', '9938');
INSERT INTO `fw_code` VALUES ('2024775', '9999', '2314', '9155', '2215', '2840');
INSERT INTO `fw_code` VALUES ('2024774', '9999', '2313', '9863', '2346', '2563');
INSERT INTO `fw_code` VALUES ('2024773', '9999', '2312', '2360', '4239', '8107');
INSERT INTO `fw_code` VALUES ('2024772', '9999', '2311', '9435', '7410', '8527');
INSERT INTO `fw_code` VALUES ('2024771', '9999', '2310', '8047', '3866', '7911');
INSERT INTO `fw_code` VALUES ('2024770', '9999', '2309', '9516', '9425', '8206');
INSERT INTO `fw_code` VALUES ('2024769', '9999', '2308', '4415', '6906', '8608');
INSERT INTO `fw_code` VALUES ('2024768', '9999', '2307', '6485', '3862', '0116');
INSERT INTO `fw_code` VALUES ('2024767', '9999', '2306', '6205', '8667', '4429');
INSERT INTO `fw_code` VALUES ('2024766', '9999', '2305', '4282', '1453', '1268');
INSERT INTO `fw_code` VALUES ('2024765', '9999', '2304', '1826', '0568', '5563');
INSERT INTO `fw_code` VALUES ('2024764', '9999', '2303', '9303', '1957', '1188');
INSERT INTO `fw_code` VALUES ('2024763', '9999', '2302', '8017', '2115', '4309');
INSERT INTO `fw_code` VALUES ('2024762', '9999', '2301', '0367', '4266', '1505');
INSERT INTO `fw_code` VALUES ('2024761', '9999', '2300', '1008', '6671', '2559');
INSERT INTO `fw_code` VALUES ('2024760', '9999', '2299', '3892', '2492', '2300');
INSERT INTO `fw_code` VALUES ('2024759', '9999', '2298', '7162', '2242', '6237');
INSERT INTO `fw_code` VALUES ('2024758', '9999', '2297', '5641', '3246', '8282');
INSERT INTO `fw_code` VALUES ('2024757', '9999', '2296', '9833', '0595', '8961');
INSERT INTO `fw_code` VALUES ('2024756', '9999', '2295', '2249', '0472', '4827');
INSERT INTO `fw_code` VALUES ('2024755', '9999', '2294', '6308', '2369', '8166');
INSERT INTO `fw_code` VALUES ('2024754', '9999', '2293', '0901', '7937', '4050');
INSERT INTO `fw_code` VALUES ('2024753', '9999', '2292', '9299', '6925', '6416');
INSERT INTO `fw_code` VALUES ('2024752', '9999', '2291', '3424', '6548', '8425');
INSERT INTO `fw_code` VALUES ('2024751', '9999', '2290', '4639', '3631', '1862');
INSERT INTO `fw_code` VALUES ('2024750', '9999', '2289', '4960', '9833', '7389');
INSERT INTO `fw_code` VALUES ('2024749', '9999', '2288', '1074', '4397', '1229');
INSERT INTO `fw_code` VALUES ('2024748', '9999', '2287', '4599', '2623', '2023');
INSERT INTO `fw_code` VALUES ('2024747', '9999', '2286', '7590', '7179', '0273');
INSERT INTO `fw_code` VALUES ('2024746', '9999', '2285', '9258', '5917', '6577');
INSERT INTO `fw_code` VALUES ('2024745', '9999', '2284', '6175', '6917', '0827');
INSERT INTO `fw_code` VALUES ('2024744', '9999', '2283', '2890', '2877', '5880');
INSERT INTO `fw_code` VALUES ('2024743', '9999', '2282', '8912', '2996', '2219');
INSERT INTO `fw_code` VALUES ('2024742', '9999', '2281', '5881', '7433', '4130');
INSERT INTO `fw_code` VALUES ('2024741', '9999', '2280', '4812', '0091', '9041');
INSERT INTO `fw_code` VALUES ('2024740', '9999', '2279', '3210', '9080', '1407');
INSERT INTO `fw_code` VALUES ('2024739', '9999', '2278', '5214', '8309', '4246');
INSERT INTO `fw_code` VALUES ('2024738', '9999', '2277', '0794', '9202', '5541');
INSERT INTO `fw_code` VALUES ('2024737', '9999', '2276', '2569', '6675', '0354');
INSERT INTO `fw_code` VALUES ('2024736', '9999', '2275', '3531', '5282', '6934');
INSERT INTO `fw_code` VALUES ('2024735', '9999', '2274', '2610', '7683', '0193');
INSERT INTO `fw_code` VALUES ('2024734', '9999', '2273', '0433', '1992', '0175');
INSERT INTO `fw_code` VALUES ('2024733', '9999', '2272', '0326', '3258', '1666');
INSERT INTO `fw_code` VALUES ('2024732', '9999', '2271', '8805', '4262', '3711');
INSERT INTO `fw_code` VALUES ('2024731', '9999', '2270', '2997', '1611', '4389');
INSERT INTO `fw_code` VALUES ('2024730', '9999', '2269', '2783', '4143', '7371');
INSERT INTO `fw_code` VALUES ('2024729', '9999', '2268', '9472', '3385', '3595');
INSERT INTO `fw_code` VALUES ('2024728', '9999', '2267', '4065', '8953', '9479');
INSERT INTO `fw_code` VALUES ('2024727', '9999', '2266', '3464', '7556', '8264');
INSERT INTO `fw_code` VALUES ('2024726', '9999', '2265', '7376', '9710', '3255');
INSERT INTO `fw_code` VALUES ('2024725', '9999', '2264', '5107', '9575', '5737');
INSERT INTO `fw_code` VALUES ('2024724', '9999', '2263', '0113', '5790', '4648');
INSERT INTO `fw_code` VALUES ('2024723', '9999', '2262', '0754', '8195', '5702');
INSERT INTO `fw_code` VALUES ('2024722', '9999', '2261', '3358', '8821', '9755');
INSERT INTO `fw_code` VALUES ('2024721', '9999', '2260', '1715', '6802', '2282');
INSERT INTO `fw_code` VALUES ('2024720', '9999', '2259', '3571', '6290', '6773');
INSERT INTO `fw_code` VALUES ('2024719', '9999', '2258', '3251', '0087', '1246');
INSERT INTO `fw_code` VALUES ('2024718', '9999', '2257', '9339', '7932', '6255');
INSERT INTO `fw_code` VALUES ('2024717', '9999', '2256', '3037', '2619', '4228');
INSERT INTO `fw_code` VALUES ('2024716', '9999', '2255', '7950', '4389', '5639');
INSERT INTO `fw_code` VALUES ('2024715', '9999', '2254', '2076', '4012', '7648');
INSERT INTO `fw_code` VALUES ('2024714', '9999', '2253', '4319', '7429', '6336');
INSERT INTO `fw_code` VALUES ('2024713', '9999', '2252', '9045', '8449', '9559');
INSERT INTO `fw_code` VALUES ('2024712', '9999', '2251', '8765', '3254', '3871');
INSERT INTO `fw_code` VALUES ('2024711', '9999', '2250', '6842', '6040', '0711');
INSERT INTO `fw_code` VALUES ('2024710', '9999', '2249', '4385', '5155', '5005');
INSERT INTO `fw_code` VALUES ('2024709', '9999', '2248', '8378', '9325', '9675');
INSERT INTO `fw_code` VALUES ('2024708', '9999', '2247', '3958', '0218', '0970');
INSERT INTO `fw_code` VALUES ('2024707', '9999', '2246', '4492', '3889', '3514');
INSERT INTO `fw_code` VALUES ('2024706', '9999', '2245', '0300', '4701', '9497');
INSERT INTO `fw_code` VALUES ('2024705', '9999', '2244', '2035', '1166', '4470');
INSERT INTO `fw_code` VALUES ('2024704', '9999', '2243', '0941', '7106', '0550');
INSERT INTO `fw_code` VALUES ('2024703', '9999', '2242', '6200', '1796', '6318');
INSERT INTO `fw_code` VALUES ('2024702', '9999', '2241', '6480', '6991', '2006');
INSERT INTO `fw_code` VALUES ('2024701', '9999', '2240', '8230', '7745', '7988');
INSERT INTO `fw_code` VALUES ('2024700', '9999', '2239', '2609', '5844', '6854');
INSERT INTO `fw_code` VALUES ('2024699', '9999', '2238', '1434', '9769', '3256');
INSERT INTO `fw_code` VALUES ('2024698', '9999', '2237', '6414', '9265', '3336');
INSERT INTO `fw_code` VALUES ('2024697', '9999', '2236', '9766', '1030', '6952');
INSERT INTO `fw_code` VALUES ('2024696', '9999', '2235', '2182', '0908', '2818');
INSERT INTO `fw_code` VALUES ('2024695', '9999', '2234', '9552', '3562', '9934');
INSERT INTO `fw_code` VALUES ('2024694', '9999', '2233', '7121', '9396', '3060');
INSERT INTO `fw_code` VALUES ('2024693', '9999', '2232', '4919', '6987', '4211');
INSERT INTO `fw_code` VALUES ('2024692', '9999', '2231', '0834', '8372', '2041');
INSERT INTO `fw_code` VALUES ('2024691', '9999', '2230', '2329', '0649', '1166');
INSERT INTO `fw_code` VALUES ('2024690', '9999', '2229', '8164', '0019', '9318');
INSERT INTO `fw_code` VALUES ('2024689', '9999', '2228', '5280', '4197', '9577');
INSERT INTO `fw_code` VALUES ('2024688', '9999', '2227', '5386', '2931', '8086');
INSERT INTO `fw_code` VALUES ('2024687', '9999', '2226', '7228', '8130', '1569');
INSERT INTO `fw_code` VALUES ('2024686', '9999', '2225', '4705', '9519', '7193');
INSERT INTO `fw_code` VALUES ('2024685', '9999', '2224', '7549', '4332', '7095');
INSERT INTO `fw_code` VALUES ('2024684', '9999', '2223', '6801', '3193', '7533');
INSERT INTO `fw_code` VALUES ('2024683', '9999', '2222', '1007', '4832', '9220');
INSERT INTO `fw_code` VALUES ('2024682', '9999', '2221', '2248', '8634', '1488');
INSERT INTO `fw_code` VALUES ('2024681', '9999', '2220', '6882', '5209', '7211');
INSERT INTO `fw_code` VALUES ('2024680', '9999', '2219', '2289', '9642', '1327');
INSERT INTO `fw_code` VALUES ('2024679', '9999', '2218', '0112', '3951', '1310');
INSERT INTO `fw_code` VALUES ('2024678', '9999', '2217', '6735', '5467', '8863');
INSERT INTO `fw_code` VALUES ('2024677', '9999', '2216', '3677', '3185', '1943');
INSERT INTO `fw_code` VALUES ('2024676', '9999', '2215', '8484', '6221', '4845');
INSERT INTO `fw_code` VALUES ('2024675', '9999', '2214', '9191', '6352', '4568');
INSERT INTO `fw_code` VALUES ('2024674', '9999', '2213', '2462', '6102', '8506');
INSERT INTO `fw_code` VALUES ('2024673', '9999', '2212', '2823', '3312', '3872');
INSERT INTO `fw_code` VALUES ('2024672', '9999', '2211', '1501', '7495', '1926');
INSERT INTO `fw_code` VALUES ('2024671', '9999', '2210', '3744', '0912', '0613');
INSERT INTO `fw_code` VALUES ('2024670', '9999', '2209', '5239', '3189', '9738');
INSERT INTO `fw_code` VALUES ('2024669', '9999', '2208', '4746', '0527', '7033');
INSERT INTO `fw_code` VALUES ('2024668', '9999', '2207', '8189', '6737', '8149');
INSERT INTO `fw_code` VALUES ('2024667', '9999', '2206', '6267', '9523', '4988');
INSERT INTO `fw_code` VALUES ('2024666', '9999', '2205', '1154', '4574', '7568');
INSERT INTO `fw_code` VALUES ('2024665', '9999', '2204', '3143', '9515', '9399');
INSERT INTO `fw_code` VALUES ('2024664', '9999', '2203', '1287', '0027', '4908');
INSERT INTO `fw_code` VALUES ('2024663', '9999', '2202', '7803', '2808', '3952');
INSERT INTO `fw_code` VALUES ('2024662', '9999', '2201', '1261', '3308', '6077');
INSERT INTO `fw_code` VALUES ('2024661', '9999', '2200', '1114', '3566', '7729');
INSERT INTO `fw_code` VALUES ('2024660', '9999', '2199', '2502', '7110', '8345');
INSERT INTO `fw_code` VALUES ('2024659', '9999', '2198', '2543', '8118', '8184');
INSERT INTO `fw_code` VALUES ('2024658', '9999', '2197', '4105', '8122', '5979');
INSERT INTO `fw_code` VALUES ('2024657', '9999', '2196', '9364', '2812', '1747');
INSERT INTO `fw_code` VALUES ('2024656', '9999', '2195', '6989', '3943', '5720');
INSERT INTO `fw_code` VALUES ('2024655', '9999', '2194', '1394', '8761', '3417');
INSERT INTO `fw_code` VALUES ('2024654', '9999', '2193', '9578', '0281', '8765');
INSERT INTO `fw_code` VALUES ('2024653', '9999', '2192', '5346', '1923', '8247');
INSERT INTO `fw_code` VALUES ('2024652', '9999', '2191', '2716', '4578', '5363');
INSERT INTO `fw_code` VALUES ('2024651', '9999', '2190', '9405', '3820', '1586');
INSERT INTO `fw_code` VALUES ('2024650', '9999', '2189', '7630', '6348', '6774');
INSERT INTO `fw_code` VALUES ('2024649', '9999', '2188', '8083', '8003', '9640');
INSERT INTO `fw_code` VALUES ('2024648', '9999', '2187', '3998', '9388', '7470');
INSERT INTO `fw_code` VALUES ('2024647', '9999', '2186', '2396', '8376', '9836');
INSERT INTO `fw_code` VALUES ('2024646', '9999', '2185', '1328', '1035', '4747');
INSERT INTO `fw_code` VALUES ('2024645', '9999', '2184', '8444', '5213', '5006');
INSERT INTO `fw_code` VALUES ('2024644', '9999', '2183', '6521', '7999', '1845');
INSERT INTO `fw_code` VALUES ('2024643', '9999', '2182', '6053', '2055', '7970');
INSERT INTO `fw_code` VALUES ('2024642', '9999', '2181', '7869', '0535', '2622');
INSERT INTO `fw_code` VALUES ('2024641', '9999', '2180', '8057', '1284', '0809');
INSERT INTO `fw_code` VALUES ('2024640', '9999', '2179', '4171', '5848', '4649');
INSERT INTO `fw_code` VALUES ('2024639', '9999', '2178', '7696', '4074', '5443');
INSERT INTO `fw_code` VALUES ('2024638', '9999', '2177', '5412', '9650', '6917');
INSERT INTO `fw_code` VALUES ('2024637', '9999', '2176', '5453', '0658', '6756');
INSERT INTO `fw_code` VALUES ('2024636', '9999', '2175', '0687', '8630', '3693');
INSERT INTO `fw_code` VALUES ('2024635', '9999', '2174', '0620', '0903', '5024');
INSERT INTO `fw_code` VALUES ('2024634', '9999', '2173', '5946', '3320', '9461');
INSERT INTO `fw_code` VALUES ('2024633', '9999', '2172', '9898', '6483', '4292');
INSERT INTO `fw_code` VALUES ('2024632', '9999', '2171', '6841', '4201', '7372');
INSERT INTO `fw_code` VALUES ('2024631', '9999', '2170', '2355', '7368', '9997');
INSERT INTO `fw_code` VALUES ('2024630', '9999', '2169', '4852', '9261', '5542');
INSERT INTO `fw_code` VALUES ('2024629', '9999', '2168', '6160', '0789', '6479');
INSERT INTO `fw_code` VALUES ('2024628', '9999', '2167', '5840', '4586', '0953');
INSERT INTO `fw_code` VALUES ('2024627', '9999', '2166', '1928', '2431', '5961');
INSERT INTO `fw_code` VALUES ('2024626', '9999', '2165', '5626', '7118', '3935');
INSERT INTO `fw_code` VALUES ('2024625', '9999', '2164', '0539', '8888', '5345');
INSERT INTO `fw_code` VALUES ('2024624', '9999', '2163', '6908', '1928', '6042');
INSERT INTO `fw_code` VALUES ('2024623', '9999', '2162', '7291', '0824', '5467');
INSERT INTO `fw_code` VALUES ('2024622', '9999', '2161', '7585', '0308', '2163');
INSERT INTO `fw_code` VALUES ('2024621', '9999', '2160', '5195', '7149', '5127');
INSERT INTO `fw_code` VALUES ('2024620', '9999', '2159', '0683', '3598', '8922');
INSERT INTO `fw_code` VALUES ('2024619', '9999', '2158', '2779', '7272', '9261');
INSERT INTO `fw_code` VALUES ('2024618', '9999', '2157', '3165', '1201', '3458');
INSERT INTO `fw_code` VALUES ('2024617', '9999', '2156', '4594', '5752', '3913');
INSERT INTO `fw_code` VALUES ('2024616', '9999', '2155', '8760', '6383', '5761');
INSERT INTO `fw_code` VALUES ('2024615', '9999', '2154', '0790', '2332', '7431');
INSERT INTO `fw_code` VALUES ('2024614', '9999', '2153', '8974', '3852', '2779');
INSERT INTO `fw_code` VALUES ('2024613', '9999', '2152', '4981', '9681', '8109');
INSERT INTO `fw_code` VALUES ('2024612', '9999', '2151', '7478', '1574', '3654');
INSERT INTO `fw_code` VALUES ('2024611', '9999', '2150', '6049', '7022', '3199');
INSERT INTO `fw_code` VALUES ('2024610', '9999', '2149', '7545', '9300', '2324');
INSERT INTO `fw_code` VALUES ('2024609', '9999', '2148', '5449', '5625', '1984');
INSERT INTO `fw_code` VALUES ('2024608', '9999', '2147', '7265', '4106', '6636');
INSERT INTO `fw_code` VALUES ('2024607', '9999', '2146', '9747', '1709', '1172');
INSERT INTO `fw_code` VALUES ('2024606', '9999', '2145', '4808', '3221', '0931');
INSERT INTO `fw_code` VALUES ('2024605', '9999', '2144', '2672', '8538', '0752');
INSERT INTO `fw_code` VALUES ('2024604', '9999', '2143', '5342', '6891', '3475');
INSERT INTO `fw_code` VALUES ('2024603', '9999', '2142', '9294', '0054', '8306');
INSERT INTO `fw_code` VALUES ('2024602', '9999', '2141', '3699', '4872', '6002');
INSERT INTO `fw_code` VALUES ('2024601', '9999', '2140', '5235', '8157', '4966');
INSERT INTO `fw_code` VALUES ('2024600', '9999', '2139', '1324', '6002', '9975');
INSERT INTO `fw_code` VALUES ('2024599', '9999', '2138', '9935', '2459', '9359');
INSERT INTO `fw_code` VALUES ('2024598', '9999', '2137', '4060', '2082', '1368');
INSERT INTO `fw_code` VALUES ('2024597', '9999', '2136', '6303', '5498', '0056');
INSERT INTO `fw_code` VALUES ('2024596', '9999', '2135', '1029', '6519', '3279');
INSERT INTO `fw_code` VALUES ('2024595', '9999', '2134', '7799', '7776', '9181');
INSERT INTO `fw_code` VALUES ('2024594', '9999', '2133', '7184', '2090', '6958');
INSERT INTO `fw_code` VALUES ('2024593', '9999', '2132', '0362', '7395', '3395');
INSERT INTO `fw_code` VALUES ('2024592', '9999', '2131', '5942', '8288', '4690');
INSERT INTO `fw_code` VALUES ('2024591', '9999', '2130', '6477', '1959', '7234');
INSERT INTO `fw_code` VALUES ('2024590', '9999', '2129', '1924', '7399', '1190');
INSERT INTO `fw_code` VALUES ('2024589', '9999', '2128', '3953', '3348', '2859');
INSERT INTO `fw_code` VALUES ('2024588', '9999', '2127', '8333', '1447', '1725');
INSERT INTO `fw_code` VALUES ('2024587', '9999', '2126', '7158', '5371', '8127');
INSERT INTO `fw_code` VALUES ('2024586', '9999', '2125', '8145', '0697', '3538');
INSERT INTO `fw_code` VALUES ('2024585', '9999', '2124', '7906', '6510', '7690');
INSERT INTO `fw_code` VALUES ('2024584', '9999', '2123', '1003', '9800', '4448');
INSERT INTO `fw_code` VALUES ('2024583', '9999', '2122', '1110', '8534', '2957');
INSERT INTO `fw_code` VALUES ('2024582', '9999', '2121', '9081', '2586', '1288');
INSERT INTO `fw_code` VALUES ('2024581', '9999', '2120', '2524', '8796', '2404');
INSERT INTO `fw_code` VALUES ('2024580', '9999', '2119', '6731', '0435', '4091');
INSERT INTO `fw_code` VALUES ('2024579', '9999', '2118', '0255', '8661', '4886');
INSERT INTO `fw_code` VALUES ('2024578', '9999', '2117', '8012', '5244', '6198');
INSERT INTO `fw_code` VALUES ('2024577', '9999', '2116', '5902', '7281', '4851');
INSERT INTO `fw_code` VALUES ('2024576', '9999', '2115', '5836', '9554', '6181');
INSERT INTO `fw_code` VALUES ('2024575', '9999', '2114', '2458', '1070', '3734');
INSERT INTO `fw_code` VALUES ('2024574', '9999', '2113', '9401', '8788', '6815');
INSERT INTO `fw_code` VALUES ('2024573', '9999', '2112', '6863', '5888', '1431');
INSERT INTO `fw_code` VALUES ('2024572', '9999', '2111', '4488', '7018', '5404');
INSERT INTO `fw_code` VALUES ('2024571', '9999', '2110', '8546', '8915', '8743');
INSERT INTO `fw_code` VALUES ('2024570', '9999', '2109', '3099', '3475', '4788');
INSERT INTO `fw_code` VALUES ('2024569', '9999', '2108', '3924', '1597', '9257');
INSERT INTO `fw_code` VALUES ('2024568', '9999', '2107', '8222', '7681', '8445');
INSERT INTO `fw_code` VALUES ('2024567', '9999', '2106', '5099', '7672', '2855');
INSERT INTO `fw_code` VALUES ('2024566', '9999', '2105', '3242', '8184', '8364');
INSERT INTO `fw_code` VALUES ('2024565', '9999', '2104', '9758', '0966', '7409');
INSERT INTO `fw_code` VALUES ('2024564', '9999', '2103', '5872', '5530', '1248');
INSERT INTO `fw_code` VALUES ('2024563', '9999', '2102', '3069', '1724', '1185');
INSERT INTO `fw_code` VALUES ('2024562', '9999', '2101', '4458', '5268', '1802');
INSERT INTO `fw_code` VALUES ('2024561', '9999', '2100', '6060', '6280', '9435');
INSERT INTO `fw_code` VALUES ('2024560', '9999', '2099', '2321', '0585', '1623');
INSERT INTO `fw_code` VALUES ('2024559', '9999', '2098', '1320', '0970', '5204');
INSERT INTO `fw_code` VALUES ('2024558', '9999', '2097', '6554', '8942', '2141');
INSERT INTO `fw_code` VALUES ('2024557', '9999', '2096', '4885', '0204', '5837');
INSERT INTO `fw_code` VALUES ('2024556', '9999', '2095', '1360', '1978', '5043');
INSERT INTO `fw_code` VALUES ('2024555', '9999', '2094', '5953', '7545', '0927');
INSERT INTO `fw_code` VALUES ('2024554', '9999', '2093', '7448', '9823', '0052');
INSERT INTO `fw_code` VALUES ('2024553', '9999', '2092', '0399', '3371', '8462');
INSERT INTO `fw_code` VALUES ('2024552', '9999', '2091', '2347', '7304', '0454');
INSERT INTO `fw_code` VALUES ('2024551', '9999', '2090', '8008', '0212', '1427');
INSERT INTO `fw_code` VALUES ('2024550', '9999', '2089', '1920', '2367', '6418');
INSERT INTO `fw_code` VALUES ('2024549', '9999', '2088', '2642', '6788', '7150');
INSERT INTO `fw_code` VALUES ('2024548', '9999', '2087', '5231', '3125', '0195');
INSERT INTO `fw_code` VALUES ('2024547', '9999', '2086', '8797', '2359', '0828');
INSERT INTO `fw_code` VALUES ('2024546', '9999', '2085', '3883', '0589', '9418');
INSERT INTO `fw_code` VALUES ('2024545', '9999', '2084', '0933', '7042', '1007');
INSERT INTO `fw_code` VALUES ('2024544', '9999', '2083', '0358', '2363', '8623');
INSERT INTO `fw_code` VALUES ('2024543', '9999', '2082', '7088', '2613', '4686');
INSERT INTO `fw_code` VALUES ('2024542', '9999', '2081', '8263', '8688', '8284');
INSERT INTO `fw_code` VALUES ('2024541', '9999', '2080', '2922', '1982', '2837');
INSERT INTO `fw_code` VALUES ('2024540', '9999', '2079', '5846', '8811', '2418');
INSERT INTO `fw_code` VALUES ('2024539', '9999', '2078', '6380', '2482', '4962');
INSERT INTO `fw_code` VALUES ('2024538', '9999', '2077', '7662', '7291', '7069');
INSERT INTO `fw_code` VALUES ('2024537', '9999', '2076', '5485', '1601', '7052');
INSERT INTO `fw_code` VALUES ('2024536', '9999', '2075', '2108', '3117', '4605');
INSERT INTO `fw_code` VALUES ('2024535', '9999', '2074', '5379', '2867', '8543');
INSERT INTO `fw_code` VALUES ('2024534', '9999', '2073', '6513', '7935', '2302');
INSERT INTO `fw_code` VALUES ('2024533', '9999', '2072', '4697', '9454', '7650');
INSERT INTO `fw_code` VALUES ('2024532', '9999', '2071', '8049', '1220', '1266');
INSERT INTO `fw_code` VALUES ('2024531', '9999', '2070', '0465', '1097', '7132');
INSERT INTO `fw_code` VALUES ('2024530', '9999', '2069', '7835', '3752', '4248');
INSERT INTO `fw_code` VALUES ('2024529', '9999', '2068', '2749', '5522', '5659');
INSERT INTO `fw_code` VALUES ('2024528', '9999', '2067', '7515', '7550', '8721');
INSERT INTO `fw_code` VALUES ('2024527', '9999', '2066', '2988', '9708', '1507');
INSERT INTO `fw_code` VALUES ('2024526', '9999', '2065', '3176', '0458', '9694');
INSERT INTO `fw_code` VALUES ('2024525', '9999', '2064', '0572', '9831', '5641');
INSERT INTO `fw_code` VALUES ('2024524', '9999', '2063', '5739', '0077', '3909');
INSERT INTO `fw_code` VALUES ('2024523', '9999', '2062', '7474', '6542', '8882');
INSERT INTO `fw_code` VALUES ('2024522', '9999', '2061', '9972', '8434', '4427');
INSERT INTO `fw_code` VALUES ('2024521', '9999', '2060', '0745', '6292', '2820');
INSERT INTO `fw_code` VALUES ('2024520', '9999', '2059', '1106', '3502', '8186');
INSERT INTO `fw_code` VALUES ('2024519', '9999', '2058', '7128', '3621', '4525');
INSERT INTO `fw_code` VALUES ('2024518', '9999', '2057', '3817', '2863', '0748');
INSERT INTO `fw_code` VALUES ('2024517', '9999', '2056', '9437', '4764', '1882');
INSERT INTO `fw_code` VALUES ('2024516', '9999', '2055', '6914', '6153', '7507');
INSERT INTO `fw_code` VALUES ('2024515', '9999', '2054', '9010', '9827', '7846');
INSERT INTO `fw_code` VALUES ('2024514', '9999', '2053', '9861', '4668', '1146');
INSERT INTO `fw_code` VALUES ('2024513', '9999', '2052', '7231', '7323', '8262');
INSERT INTO `fw_code` VALUES ('2024512', '9999', '2051', '9647', '7200', '4128');
INSERT INTO `fw_code` VALUES ('2024511', '9999', '2050', '8940', '7069', '4405');
INSERT INTO `fw_code` VALUES ('2024510', '9999', '2049', '1677', '3148', '5798');
INSERT INTO `fw_code` VALUES ('2024509', '9999', '2048', '2292', '8834', '8021');
INSERT INTO `fw_code` VALUES ('2024508', '9999', '2047', '7831', '8720', '9476');
INSERT INTO `fw_code` VALUES ('2024507', '9999', '2046', '8472', '1124', '0530');
INSERT INTO `fw_code` VALUES ('2024506', '9999', '2045', '9941', '4845', '7486');
INSERT INTO `fw_code` VALUES ('2024505', '9999', '2044', '0501', '5234', '8861');
INSERT INTO `fw_code` VALUES ('2024504', '9999', '2043', '2317', '3714', '3513');
INSERT INTO `fw_code` VALUES ('2024503', '9999', '2042', '5160', '8528', '3414');
INSERT INTO `fw_code` VALUES ('2024502', '9999', '2041', '7724', '8147', '7629');
INSERT INTO `fw_code` VALUES ('2024501', '9999', '2040', '0394', '6500', '0352');
INSERT INTO `fw_code` VALUES ('2024500', '9999', '2039', '0608', '3968', '7370');
INSERT INTO `fw_code` VALUES ('2024499', '9999', '2038', '1356', '5107', '6932');
INSERT INTO `fw_code` VALUES ('2024498', '9999', '2037', '2357', '4722', '3352');
INSERT INTO `fw_code` VALUES ('2024497', '9999', '2036', '9580', '7635', '2120');
INSERT INTO `fw_code` VALUES ('2024496', '9999', '2035', '0755', '3710', '5718');
INSERT INTO `fw_code` VALUES ('2024495', '9999', '2034', '6976', '7008', '8066');
INSERT INTO `fw_code` VALUES ('2024494', '9999', '2033', '2210', '4980', '5004');
INSERT INTO `fw_code` VALUES ('2024493', '9999', '2032', '5241', '0544', '3093');
INSERT INTO `fw_code` VALUES ('2024492', '9999', '2031', '6162', '8143', '9834');
INSERT INTO `fw_code` VALUES ('2024491', '9999', '2030', '5348', '9278', '1602');
INSERT INTO `fw_code` VALUES ('2024490', '9999', '2029', '3665', '6250', '4289');
INSERT INTO `fw_code` VALUES ('2024489', '9999', '2028', '5669', '5480', '7129');
INSERT INTO `fw_code` VALUES ('2024488', '9999', '2027', '8298', '2825', '0013');
INSERT INTO `fw_code` VALUES ('2024487', '9999', '2026', '8232', '5099', '1343');
INSERT INTO `fw_code` VALUES ('2024486', '9999', '2025', '3558', '7516', '5781');
INSERT INTO `fw_code` VALUES ('2024485', '9999', '2024', '2464', '3456', '1861');
INSERT INTO `fw_code` VALUES ('2024484', '9999', '2023', '3772', '4984', '2798');
INSERT INTO `fw_code` VALUES ('2024483', '9999', '2022', '3451', '8782', '7272');
INSERT INTO `fw_code` VALUES ('2024482', '9999', '2021', '4520', '6123', '2361');
INSERT INTO `fw_code` VALUES ('2024481', '9999', '2020', '6589', '3079', '3870');
INSERT INTO `fw_code` VALUES ('2024480', '9999', '2019', '6015', '8401', '1486');
INSERT INTO `fw_code` VALUES ('2024479', '9999', '2018', '3919', '4726', '1147');
INSERT INTO `fw_code` VALUES ('2024478', '9999', '2017', '4240', '0929', '6673');
INSERT INTO `fw_code` VALUES ('2024477', '9999', '2016', '4880', '3333', '7727');
INSERT INTO `fw_code` VALUES ('2024476', '9999', '2015', '1142', '7639', '9914');
INSERT INTO `fw_code` VALUES ('2024475', '9999', '2014', '5374', '5996', '0432');
INSERT INTO `fw_code` VALUES ('2024474', '9999', '2013', '6122', '7135', '9995');
INSERT INTO `fw_code` VALUES ('2024473', '9999', '2012', '3492', '9790', '7111');
INSERT INTO `fw_code` VALUES ('2024472', '9999', '2011', '3171', '3587', '1584');
INSERT INTO `fw_code` VALUES ('2024471', '9999', '2010', '0991', '2865', '6795');
INSERT INTO `fw_code` VALUES ('2024470', '9999', '2009', '6184', '9829', '3893');
INSERT INTO `fw_code` VALUES ('2024469', '9999', '2008', '7400', '6913', '7330');
INSERT INTO `fw_code` VALUES ('2024468', '9999', '2007', '3061', '9821', '8303');
INSERT INTO `fw_code` VALUES ('2024467', '9999', '2006', '4877', '8301', '2955');
INSERT INTO `fw_code` VALUES ('2024466', '9999', '2005', '6972', '1976', '3295');
INSERT INTO `fw_code` VALUES ('2024465', '9999', '2004', '3834', '7679', '6696');
INSERT INTO `fw_code` VALUES ('2024464', '9999', '2003', '7359', '5905', '7491');
INSERT INTO `fw_code` VALUES ('2024463', '9999', '2002', '2420', '7416', '7250');
INSERT INTO `fw_code` VALUES ('2024462', '9999', '2001', '9709', '8055', '4687');
INSERT INTO `fw_code` VALUES ('2024461', '9999', '2000', '0350', '0460', '5741');
INSERT INTO `fw_code` VALUES ('2024460', '9999', '1999', '0284', '2734', '7071');
INSERT INTO `fw_code` VALUES ('2024459', '9999', '1998', '6906', '4250', '4625');
INSERT INTO `fw_code` VALUES ('2024458', '9999', '1997', '6505', '6032', '9420');
INSERT INTO `fw_code` VALUES ('2024457', '9999', '1996', '1311', '9067', '2321');
INSERT INTO `fw_code` VALUES ('2024456', '9999', '1995', '8935', '0198', '6294');
INSERT INTO `fw_code` VALUES ('2024455', '9999', '1994', '2633', '4885', '4268');
INSERT INTO `fw_code` VALUES ('2024454', '9999', '1993', '5650', '6159', '1348');
INSERT INTO `fw_code` VALUES ('2024453', '9999', '1992', '7547', '6654', '5678');
INSERT INTO `fw_code` VALUES ('2024452', '9999', '1991', '3915', '9694', '6375');
INSERT INTO `fw_code` VALUES ('2024451', '9999', '1990', '5411', '1972', '5500');
INSERT INTO `fw_code` VALUES ('2024450', '9999', '1989', '8361', '5520', '3911');
INSERT INTO `fw_code` VALUES ('2024449', '9999', '1988', '4796', '6286', '3277');
INSERT INTO `fw_code` VALUES ('2024448', '9999', '1987', '6438', '8305', '0750');
INSERT INTO `fw_code` VALUES ('2024447', '9999', '1986', '3982', '7421', '5045');
INSERT INTO `fw_code` VALUES ('2024446', '9999', '1985', '7974', '1591', '9714');
INSERT INTO `fw_code` VALUES ('2024445', '9999', '1984', '3554', '2484', '1009');
INSERT INTO `fw_code` VALUES ('2024444', '9999', '1983', '4088', '6155', '3553');
INSERT INTO `fw_code` VALUES ('2024443', '9999', '1982', '3941', '6413', '5205');
INSERT INTO `fw_code` VALUES ('2024442', '9999', '1981', '5370', '0964', '5661');
INSERT INTO `fw_code` VALUES ('2024441', '9999', '1980', '9816', '6790', '3196');
INSERT INTO `fw_code` VALUES ('2024440', '9999', '1979', '1565', '7543', '9178');
INSERT INTO `fw_code` VALUES ('2024439', '9999', '1978', '5945', '5643', '8044');
INSERT INTO `fw_code` VALUES ('2024438', '9999', '1977', '4770', '9567', '4446');
INSERT INTO `fw_code` VALUES ('2024437', '9999', '1976', '9749', '9063', '4527');
INSERT INTO `fw_code` VALUES ('2024436', '9999', '1975', '5757', '4893', '9857');
INSERT INTO `fw_code` VALUES ('2024435', '9999', '1974', '5517', '0706', '4009');
INSERT INTO `fw_code` VALUES ('2024434', '9999', '1973', '5543', '7425', '2839');
INSERT INTO `fw_code` VALUES ('2024433', '9999', '1972', '2232', '6667', '9063');
INSERT INTO `fw_code` VALUES ('2024432', '9999', '1971', '6825', '2234', '4946');
INSERT INTO `fw_code` VALUES ('2024431', '9999', '1970', '5223', '1222', '7313');
INSERT INTO `fw_code` VALUES ('2024430', '9999', '1969', '8615', '3996', '0768');
INSERT INTO `fw_code` VALUES ('2024429', '9999', '1968', '8722', '2730', '9277');
INSERT INTO `fw_code` VALUES ('2024428', '9999', '1967', '6692', '6781', '7607');
INSERT INTO `fw_code` VALUES ('2024427', '9999', '1966', '0564', '7929', '2759');
INSERT INTO `fw_code` VALUES ('2024426', '9999', '1965', '8040', '9317', '8384');
INSERT INTO `fw_code` VALUES ('2024425', '9999', '1964', '0884', '4131', '8286');
INSERT INTO `fw_code` VALUES ('2024424', '9999', '1963', '0136', '2992', '8723');
INSERT INTO `fw_code` VALUES ('2024423', '9999', '1962', '4342', '4631', '0410');
INSERT INTO `fw_code` VALUES ('2024422', '9999', '1961', '7867', '2857', '1205');
INSERT INTO `fw_code` VALUES ('2024421', '9999', '1960', '5584', '8432', '2678');
INSERT INTO `fw_code` VALUES ('2024420', '9999', '1959', '5624', '9440', '2518');
INSERT INTO `fw_code` VALUES ('2024419', '9999', '1958', '3514', '1476', '1170');
INSERT INTO `fw_code` VALUES ('2024418', '9999', '1957', '6118', '2103', '5223');
INSERT INTO `fw_code` VALUES ('2024417', '9999', '1956', '7013', '2984', '3134');
INSERT INTO `fw_code` VALUES ('2024416', '9999', '1955', '2527', '6151', '5759');
INSERT INTO `fw_code` VALUES ('2024415', '9999', '1954', '7680', '2107', '3018');
INSERT INTO `fw_code` VALUES ('2024414', '9999', '1953', '6331', '9571', '2241');
INSERT INTO `fw_code` VALUES ('2024413', '9999', '1952', '2099', '1214', '1723');
INSERT INTO `fw_code` VALUES ('2024412', '9999', '1951', '5797', '5901', '9696');
INSERT INTO `fw_code` VALUES ('2024411', '9999', '1950', '6158', '3111', '5062');
INSERT INTO `fw_code` VALUES ('2024410', '9999', '1949', '0711', '7670', '1107');
INSERT INTO `fw_code` VALUES ('2024409', '9999', '1948', '4836', '7294', '3116');
INSERT INTO `fw_code` VALUES ('2024408', '9999', '1947', '1805', '1730', '5027');
INSERT INTO `fw_code` VALUES ('2024407', '9999', '1946', '8575', '2988', '0928');
INSERT INTO `fw_code` VALUES ('2024406', '9999', '1945', '8081', '0325', '8223');
INSERT INTO `fw_code` VALUES ('2024405', '9999', '1944', '1525', '6536', '9339');
INSERT INTO `fw_code` VALUES ('2024404', '9999', '1943', '9602', '9321', '6179');
INSERT INTO `fw_code` VALUES ('2024403', '9999', '1942', '6479', '9313', '0589');
INSERT INTO `fw_code` VALUES ('2024402', '9999', '1941', '6718', '3500', '6437');
INSERT INTO `fw_code` VALUES ('2024401', '9999', '1940', '7252', '7171', '8982');
INSERT INTO `fw_code` VALUES ('2024400', '9999', '1939', '4449', '3365', '8919');
INSERT INTO `fw_code` VALUES ('2024399', '9999', '1938', '5838', '6908', '9535');
INSERT INTO `fw_code` VALUES ('2024398', '9999', '1937', '6799', '5516', '6116');
INSERT INTO `fw_code` VALUES ('2024397', '9999', '1936', '7440', '7920', '7169');
INSERT INTO `fw_code` VALUES ('2024396', '9999', '1935', '3702', '2226', '9357');
INSERT INTO `fw_code` VALUES ('2024395', '9999', '1934', '2980', '7806', '8625');
INSERT INTO `fw_code` VALUES ('2024394', '9999', '1933', '3595', '3492', '0848');
INSERT INTO `fw_code` VALUES ('2024393', '9999', '1932', '4729', '8559', '4607');
INSERT INTO `fw_code` VALUES ('2024392', '9999', '1931', '9109', '6659', '3473');
INSERT INTO `fw_code` VALUES ('2024391', '9999', '1930', '6265', '1845', '3571');
INSERT INTO `fw_code` VALUES ('2024390', '9999', '1929', '8681', '1722', '9437');
INSERT INTO `fw_code` VALUES ('2024389', '9999', '1928', '6051', '4377', '6553');
INSERT INTO `fw_code` VALUES ('2024388', '9999', '1927', '2740', '3619', '2777');
INSERT INTO `fw_code` VALUES ('2024387', '9999', '1926', '1418', '7802', '0830');
INSERT INTO `fw_code` VALUES ('2024386', '9999', '1925', '7333', '9186', '8660');
INSERT INTO `fw_code` VALUES ('2024385', '9999', '1924', '5731', '8174', '1027');
INSERT INTO `fw_code` VALUES ('2024384', '9999', '1923', '8829', '1464', '7785');
INSERT INTO `fw_code` VALUES ('2024383', '9999', '1922', '1886', '3746', '4705');
INSERT INTO `fw_code` VALUES ('2024382', '9999', '1921', '9856', '7797', '3036');
INSERT INTO `fw_code` VALUES ('2024381', '9999', '1920', '4048', '5147', '3714');
INSERT INTO `fw_code` VALUES ('2024380', '9999', '1919', '7263', '6428', '5219');
INSERT INTO `fw_code` VALUES ('2024379', '9999', '1918', '5020', '3011', '6531');
INSERT INTO `fw_code` VALUES ('2024378', '9999', '1917', '0254', '0983', '3469');
INSERT INTO `fw_code` VALUES ('2024377', '9999', '1916', '2843', '7321', '6514');
INSERT INTO `fw_code` VALUES ('2024376', '9999', '1915', '9466', '8837', '4067');
INSERT INTO `fw_code` VALUES ('2024375', '9999', '1914', '6408', '6555', '7148');
INSERT INTO `fw_code` VALUES ('2024374', '9999', '1913', '1215', '9590', '0049');
INSERT INTO `fw_code` VALUES ('2024373', '9999', '1912', '4419', '1614', '5317');
INSERT INTO `fw_code` VALUES ('2024372', '9999', '1911', '5554', '6682', '9076');
INSERT INTO `fw_code` VALUES ('2024371', '9999', '1910', '6475', '4281', '5817');
INSERT INTO `fw_code` VALUES ('2024370', '9999', '1909', '8545', '1237', '7326');
INSERT INTO `fw_code` VALUES ('2024369', '9999', '1908', '7970', '6559', '4942');
INSERT INTO `fw_code` VALUES ('2024368', '9999', '1907', '0920', '0107', '3353');
INSERT INTO `fw_code` VALUES ('2024367', '9999', '1906', '8998', '2892', '0192');
INSERT INTO `fw_code` VALUES ('2024366', '9999', '1905', '3885', '7944', '2772');
INSERT INTO `fw_code` VALUES ('2024365', '9999', '1904', '5874', '2884', '4603');
INSERT INTO `fw_code` VALUES ('2024364', '9999', '1903', '0534', '6178', '9157');
INSERT INTO `fw_code` VALUES ('2024363', '9999', '1902', '3458', '3007', '8737');
INSERT INTO `fw_code` VALUES ('2024362', '9999', '1901', '3992', '6678', '1281');
INSERT INTO `fw_code` VALUES ('2024361', '9999', '1900', '3845', '6936', '2933');
INSERT INTO `fw_code` VALUES ('2024360', '9999', '1899', '5233', '0479', '3549');
INSERT INTO `fw_code` VALUES ('2024359', '9999', '1898', '5274', '1487', '3388');
INSERT INTO `fw_code` VALUES ('2024358', '9999', '1897', '6836', '1491', '1183');
INSERT INTO `fw_code` VALUES ('2024357', '9999', '1896', '9720', '7313', '0924');
INSERT INTO `fw_code` VALUES ('2024356', '9999', '1895', '8504', '0229', '7487');
INSERT INTO `fw_code` VALUES ('2024355', '9999', '1894', '2309', '3650', '3969');
INSERT INTO `fw_code` VALUES ('2024354', '9999', '1893', '5661', '5416', '7585');
INSERT INTO `fw_code` VALUES ('2024353', '9999', '1892', '8077', '5293', '3451');
INSERT INTO `fw_code` VALUES ('2024352', '9999', '1891', '5447', '7948', '0567');
INSERT INTO `fw_code` VALUES ('2024351', '9999', '1890', '2136', '7190', '6790');
INSERT INTO `fw_code` VALUES ('2024350', '9999', '1889', '0361', '9717', '1978');
INSERT INTO `fw_code` VALUES ('2024349', '9999', '1888', '0814', '1372', '4844');
INSERT INTO `fw_code` VALUES ('2024348', '9999', '1887', '6729', '2757', '2674');
INSERT INTO `fw_code` VALUES ('2024347', '9999', '1886', '5127', '1745', '5040');
INSERT INTO `fw_code` VALUES ('2024346', '9999', '1885', '8224', '5035', '1799');
INSERT INTO `fw_code` VALUES ('2024345', '9999', '1884', '4059', '4404', '9951');
INSERT INTO `fw_code` VALUES ('2024344', '9999', '1883', '1175', '8583', '0210');
INSERT INTO `fw_code` VALUES ('2024343', '9999', '1882', '1281', '7317', '8719');
INSERT INTO `fw_code` VALUES ('2024342', '9999', '1881', '9252', '1368', '7049');
INSERT INTO `fw_code` VALUES ('2024341', '9999', '1880', '0467', '8451', '0487');
INSERT INTO `fw_code` VALUES ('2024340', '9999', '1879', '8784', '5424', '3175');
INSERT INTO `fw_code` VALUES ('2024339', '9999', '1878', '0600', '3904', '7826');
INSERT INTO `fw_code` VALUES ('2024338', '9999', '1877', '0040', '3515', '6451');
INSERT INTO `fw_code` VALUES ('2024337', '9999', '1876', '6902', '9218', '9853');
INSERT INTO `fw_code` VALUES ('2024336', '9999', '1875', '8143', '3019', '2121');
INSERT INTO `fw_code` VALUES ('2024335', '9999', '1874', '2777', '9594', '7844');
INSERT INTO `fw_code` VALUES ('2024334', '9999', '1873', '8184', '4027', '1960');
INSERT INTO `fw_code` VALUES ('2024333', '9999', '1872', '3351', '4273', '0228');
INSERT INTO `fw_code` VALUES ('2024332', '9999', '1871', '8677', '6690', '4666');
INSERT INTO `fw_code` VALUES ('2024331', '9999', '1870', '2630', '9853', '9496');
INSERT INTO `fw_code` VALUES ('2024330', '9999', '1869', '9572', '7571', '2576');
INSERT INTO `fw_code` VALUES ('2024329', '9999', '1868', '4379', '0606', '5478');
INSERT INTO `fw_code` VALUES ('2024328', '9999', '1867', '5086', '0737', '5201');
INSERT INTO `fw_code` VALUES ('2024327', '9999', '1866', '7583', '2630', '0746');
INSERT INTO `fw_code` VALUES ('2024326', '9999', '1865', '8357', '0488', '9139');
INSERT INTO `fw_code` VALUES ('2024325', '9999', '1864', '8718', '7698', '4505');
INSERT INTO `fw_code` VALUES ('2024324', '9999', '1863', '4740', '7817', '0844');
INSERT INTO `fw_code` VALUES ('2024323', '9999', '1862', '1134', '7575', '0371');
INSERT INTO `fw_code` VALUES ('2024322', '9999', '1861', '0641', '4912', '7665');
INSERT INTO `fw_code` VALUES ('2024321', '9999', '1860', '1429', '7059', '7067');
INSERT INTO `fw_code` VALUES ('2024320', '9999', '1859', '7863', '7825', '6433');
INSERT INTO `fw_code` VALUES ('2024319', '9999', '1858', '9506', '9844', '3906');
INSERT INTO `fw_code` VALUES ('2024318', '9999', '1857', '7049', '8959', '8201');
INSERT INTO `fw_code` VALUES ('2024317', '9999', '1856', '4526', '0348', '3826');
INSERT INTO `fw_code` VALUES ('2024316', '9999', '1855', '6622', '4023', '4165');
INSERT INTO `fw_code` VALUES ('2024315', '9999', '1854', '7156', '7694', '6710');
INSERT INTO `fw_code` VALUES ('2024314', '9999', '1853', '7009', '7952', '8362');
INSERT INTO `fw_code` VALUES ('2024313', '9999', '1852', '8397', '1495', '8978');
INSERT INTO `fw_code` VALUES ('2024312', '9999', '1851', '9359', '0102', '5558');
INSERT INTO `fw_code` VALUES ('2024311', '9999', '1850', '8438', '2503', '8817');
INSERT INTO `fw_code` VALUES ('2024310', '9999', '1849', '0000', '2507', '6612');
INSERT INTO `fw_code` VALUES ('2024309', '9999', '1848', '2604', '3134', '0665');
INSERT INTO `fw_code` VALUES ('2024308', '9999', '1847', '2884', '8329', '6353');
INSERT INTO `fw_code` VALUES ('2024307', '9999', '1846', '4633', '9082', '2335');
INSERT INTO `fw_code` VALUES ('2024306', '9999', '1845', '2817', '0602', '7683');
INSERT INTO `fw_code` VALUES ('2024305', '9999', '1844', '3524', '0733', '7406');
INSERT INTO `fw_code` VALUES ('2024304', '9999', '1843', '1322', '8324', '8558');
INSERT INTO `fw_code` VALUES ('2024303', '9999', '1842', '9893', '3773', '8103');
INSERT INTO `fw_code` VALUES ('2024302', '9999', '1841', '3631', '9467', '5915');
INSERT INTO `fw_code` VALUES ('2024301', '9999', '1840', '1108', '0856', '1540');
INSERT INTO `fw_code` VALUES ('2024300', '9999', '1839', '3952', '5670', '1442');
INSERT INTO `fw_code` VALUES ('2024299', '9999', '1838', '0066', '0234', '5282');
INSERT INTO `fw_code` VALUES ('2024298', '9999', '1837', '6582', '3015', '4326');
INSERT INTO `fw_code` VALUES ('2024297', '9999', '1836', '6515', '5289', '5656');
INSERT INTO `fw_code` VALUES ('2024296', '9999', '1835', '9186', '3642', '8380');
INSERT INTO `fw_code` VALUES ('2024295', '9999', '1834', '3138', '6805', '3210');
INSERT INTO `fw_code` VALUES ('2024294', '9999', '1833', '8250', '1753', '0630');
INSERT INTO `fw_code` VALUES ('2024293', '9999', '1832', '0747', '3646', '6174');
INSERT INTO `fw_code` VALUES ('2024292', '9999', '1831', '9399', '1110', '5397');
INSERT INTO `fw_code` VALUES ('2024291', '9999', '1830', '9079', '4908', '9871');
INSERT INTO `fw_code` VALUES ('2024290', '9999', '1829', '8902', '3415', '7920');
INSERT INTO `fw_code` VALUES ('2024289', '9999', '1828', '6018', '7594', '8179');
INSERT INTO `fw_code` VALUES ('2024288', '9999', '1827', '6552', '1265', '0724');
INSERT INTO `fw_code` VALUES ('2024287', '9999', '1826', '8688', '5947', '0902');
INSERT INTO `fw_code` VALUES ('2024286', '9999', '1825', '3347', '9241', '5456');
INSERT INTO `fw_code` VALUES ('2024285', '9999', '1824', '5911', '8860', '9670');
INSERT INTO `fw_code` VALUES ('2024284', '9999', '1823', '8515', '9487', '3724');
INSERT INTO `fw_code` VALUES ('2024283', '9999', '1822', '6191', '4054', '5358');
INSERT INTO `fw_code` VALUES ('2024282', '9999', '1821', '1852', '6963', '6331');
INSERT INTO `fw_code` VALUES ('2024281', '9999', '1820', '3668', '5443', '0983');
INSERT INTO `fw_code` VALUES ('2024280', '9999', '1819', '5764', '9118', '1322');
INSERT INTO `fw_code` VALUES ('2024279', '9999', '1818', '9970', '0757', '3010');
INSERT INTO `fw_code` VALUES ('2024278', '9999', '1817', '5697', '1392', '2652');
INSERT INTO `fw_code` VALUES ('2024277', '9999', '1816', '7727', '7340', '4322');
INSERT INTO `fw_code` VALUES ('2024276', '9999', '1815', '1786', '9237', '7661');
INSERT INTO `fw_code` VALUES ('2024275', '9999', '1814', '4202', '9114', '3527');
INSERT INTO `fw_code` VALUES ('2024274', '9999', '1813', '0077', '9491', '1518');
INSERT INTO `fw_code` VALUES ('2024273', '9999', '1812', '9329', '8352', '1956');
INSERT INTO `fw_code` VALUES ('2024272', '9999', '1811', '6618', '7152', '6055');
INSERT INTO `fw_code` VALUES ('2024271', '9999', '1810', '0997', '5251', '4921');
INSERT INTO `fw_code` VALUES ('2024270', '9999', '1809', '9822', '9176', '1323');
INSERT INTO `fw_code` VALUES ('2024269', '9999', '1808', '4802', '8672', '1403');
INSERT INTO `fw_code` VALUES ('2024268', '9999', '1807', '8153', '0438', '5019');
INSERT INTO `fw_code` VALUES ('2024267', '9999', '1806', '0570', '0315', '0885');
INSERT INTO `fw_code` VALUES ('2024266', '9999', '1805', '7940', '2970', '8001');
INSERT INTO `fw_code` VALUES ('2024265', '9999', '1804', '4629', '2212', '4225');
INSERT INTO `fw_code` VALUES ('2024264', '9999', '1803', '3306', '6394', '2278');
INSERT INTO `fw_code` VALUES ('2024263', '9999', '1802', '9222', '7779', '0108');
INSERT INTO `fw_code` VALUES ('2024262', '9999', '1801', '7619', '6767', '2474');
INSERT INTO `fw_code` VALUES ('2024261', '9999', '1800', '0717', '0057', '9233');
INSERT INTO `fw_code` VALUES ('2024260', '9999', '1799', '6551', '9426', '7385');
INSERT INTO `fw_code` VALUES ('2024259', '9999', '1798', '3667', '3605', '7644');
INSERT INTO `fw_code` VALUES ('2024258', '9999', '1797', '1745', '6390', '4483');
INSERT INTO `fw_code` VALUES ('2024257', '9999', '1796', '2960', '3473', '7921');
INSERT INTO `fw_code` VALUES ('2024256', '9999', '1795', '1277', '0446', '0609');
INSERT INTO `fw_code` VALUES ('2024255', '9999', '1794', '3093', '8926', '5260');
INSERT INTO `fw_code` VALUES ('2024254', '9999', '1793', '3280', '9676', '3448');
INSERT INTO `fw_code` VALUES ('2024253', '9999', '1792', '2533', '8537', '3885');
INSERT INTO `fw_code` VALUES ('2024252', '9999', '1791', '9395', '4240', '7287');
INSERT INTO `fw_code` VALUES ('2024251', '9999', '1790', '2920', '2466', '8082');
INSERT INTO `fw_code` VALUES ('2024250', '9999', '1789', '0636', '8041', '9555');
INSERT INTO `fw_code` VALUES ('2024249', '9999', '1788', '0676', '9049', '9394');
INSERT INTO `fw_code` VALUES ('2024248', '9999', '1787', '5910', '7021', '6332');
INSERT INTO `fw_code` VALUES ('2024247', '9999', '1786', '1170', '1712', '2100');
INSERT INTO `fw_code` VALUES ('2024246', '9999', '1785', '5122', '4875', '6930');
INSERT INTO `fw_code` VALUES ('2024245', '9999', '1784', '2065', '2593', '0010');
INSERT INTO `fw_code` VALUES ('2024244', '9999', '1783', '6872', '5628', '2912');
INSERT INTO `fw_code` VALUES ('2024243', '9999', '1782', '7579', '5759', '2635');
INSERT INTO `fw_code` VALUES ('2024242', '9999', '1781', '1384', '9180', '9118');
INSERT INTO `fw_code` VALUES ('2024241', '9999', '1780', '1063', '2978', '3591');
INSERT INTO `fw_code` VALUES ('2024240', '9999', '1779', '7152', '0823', '8600');
INSERT INTO `fw_code` VALUES ('2024239', '9999', '1778', '0850', '5509', '6573');
INSERT INTO `fw_code` VALUES ('2024238', '9999', '1777', '1211', '2720', '1939');
INSERT INTO `fw_code` VALUES ('2024237', '9999', '1776', '5763', '7279', '7984');
INSERT INTO `fw_code` VALUES ('2024236', '9999', '1775', '7233', '2838', '8278');
INSERT INTO `fw_code` VALUES ('2024235', '9999', '1774', '2131', '0319', '8680');
INSERT INTO `fw_code` VALUES ('2024234', '9999', '1773', '4201', '7275', '0189');
INSERT INTO `fw_code` VALUES ('2024233', '9999', '1772', '3627', '2597', '7805');
INSERT INTO `fw_code` VALUES ('2024232', '9999', '1771', '3133', '9934', '5100');
INSERT INTO `fw_code` VALUES ('2024231', '9999', '1770', '0356', '2847', '3867');
INSERT INTO `fw_code` VALUES ('2024230', '9999', '1769', '1999', '4866', '1341');
INSERT INTO `fw_code` VALUES ('2024229', '9999', '1768', '1531', '8922', '7466');
INSERT INTO `fw_code` VALUES ('2024228', '9999', '1767', '7019', '5370', '1260');
INSERT INTO `fw_code` VALUES ('2024227', '9999', '1766', '6190', '2216', '2019');
INSERT INTO `fw_code` VALUES ('2024226', '9999', '1765', '9115', '9045', '1599');
INSERT INTO `fw_code` VALUES ('2024225', '9999', '1764', '9649', '2716', '4144');
INSERT INTO `fw_code` VALUES ('2024224', '9999', '1763', '9502', '2974', '5796');
INSERT INTO `fw_code` VALUES ('2024223', '9999', '1762', '0890', '6517', '6412');
INSERT INTO `fw_code` VALUES ('2024222', '9999', '1761', '1851', '5124', '2992');
INSERT INTO `fw_code` VALUES ('2024221', '9999', '1760', '0931', '7525', '6251');
INSERT INTO `fw_code` VALUES ('2024220', '9999', '1759', '2492', '7529', '4046');
INSERT INTO `fw_code` VALUES ('2024219', '9999', '1758', '8754', '1835', '6234');
INSERT INTO `fw_code` VALUES ('2024218', '9999', '1757', '5096', '8156', '8099');
INSERT INTO `fw_code` VALUES ('2024217', '9999', '1756', '8647', '3101', '7725');
INSERT INTO `fw_code` VALUES ('2024216', '9999', '1755', '7126', '4104', '9769');
INSERT INTO `fw_code` VALUES ('2024215', '9999', '1754', '4161', '6267', '0350');
INSERT INTO `fw_code` VALUES ('2024214', '9999', '1753', '2986', '0192', '6751');
INSERT INTO `fw_code` VALUES ('2024213', '9999', '1752', '5310', '5624', '5117');
INSERT INTO `fw_code` VALUES ('2024212', '9999', '1751', '1317', '1454', '0448');
INSERT INTO `fw_code` VALUES ('2024211', '9999', '1750', '3734', '1331', '6314');
INSERT INTO `fw_code` VALUES ('2024210', '9999', '1749', '1104', '3986', '3430');
INSERT INTO `fw_code` VALUES ('2024209', '9999', '1748', '7793', '3228', '9653');
INSERT INTO `fw_code` VALUES ('2024208', '9999', '1747', '3815', '3346', '5992');
INSERT INTO `fw_code` VALUES ('2024207', '9999', '1746', '2385', '8795', '5537');
INSERT INTO `fw_code` VALUES ('2024206', '9999', '1745', '0783', '7783', '7903');
INSERT INTO `fw_code` VALUES ('2024205', '9999', '1744', '3881', '1073', '4662');
INSERT INTO `fw_code` VALUES ('2024204', '9999', '1743', '9715', '0442', '2814');
INSERT INTO `fw_code` VALUES ('2024203', '9999', '1742', '6831', '4621', '3073');
INSERT INTO `fw_code` VALUES ('2024202', '9999', '1741', '6938', '3355', '1582');
INSERT INTO `fw_code` VALUES ('2024201', '9999', '1740', '4909', '7406', '9912');
INSERT INTO `fw_code` VALUES ('2024200', '9999', '1739', '3601', '5878', '8974');
INSERT INTO `fw_code` VALUES ('2024199', '9999', '1738', '6444', '0692', '8876');
INSERT INTO `fw_code` VALUES ('2024198', '9999', '1737', '2559', '5255', '2716');
INSERT INTO `fw_code` VALUES ('2024197', '9999', '1736', '6084', '3482', '3510');
INSERT INTO `fw_code` VALUES ('2024196', '9999', '1735', '8433', '5632', '0707');
INSERT INTO `fw_code` VALUES ('2024195', '9999', '1734', '3840', '0065', '4823');
INSERT INTO `fw_code` VALUES ('2024194', '9999', '1733', '9074', '8037', '1760');
INSERT INTO `fw_code` VALUES ('2024193', '9999', '1732', '9008', '0311', '3091');
INSERT INTO `fw_code` VALUES ('2024192', '9999', '1731', '1678', '8664', '5814');
INSERT INTO `fw_code` VALUES ('2024191', '9999', '1730', '5630', '1827', '0644');
INSERT INTO `fw_code` VALUES ('2024190', '9999', '1729', '5229', '3609', '5439');
INSERT INTO `fw_code` VALUES ('2024189', '9999', '1728', '0036', '6644', '8341');
INSERT INTO `fw_code` VALUES ('2024188', '9999', '1727', '0743', '6775', '8064');
INSERT INTO `fw_code` VALUES ('2024187', '9999', '1726', '3240', '8668', '3608');
INSERT INTO `fw_code` VALUES ('2024186', '9999', '1725', '1571', '9930', '7305');
INSERT INTO `fw_code` VALUES ('2024185', '9999', '1724', '7660', '7775', '2314');
INSERT INTO `fw_code` VALUES ('2024184', '9999', '1723', '1358', '2462', '0287');
INSERT INTO `fw_code` VALUES ('2024183', '9999', '1722', '4374', '3736', '7368');
INSERT INTO `fw_code` VALUES ('2024182', '9999', '1721', '2640', '7271', '2394');
INSERT INTO `fw_code` VALUES ('2024181', '9999', '1720', '7365', '8291', '5617');
INSERT INTO `fw_code` VALUES ('2024180', '9999', '1719', '6297', '0950', '0528');
INSERT INTO `fw_code` VALUES ('2024179', '9999', '1718', '7085', '3097', '9930');
INSERT INTO `fw_code` VALUES ('2024178', '9999', '1717', '3520', '3863', '9296');
INSERT INTO `fw_code` VALUES ('2024177', '9999', '1716', '2706', '4997', '1064');
INSERT INTO `fw_code` VALUES ('2024176', '9999', '1715', '4695', '9938', '2894');
INSERT INTO `fw_code` VALUES ('2024175', '9999', '1714', '0183', '6386', '6689');
INSERT INTO `fw_code` VALUES ('2024174', '9999', '1713', '6698', '9168', '5733');
INSERT INTO `fw_code` VALUES ('2024173', '9999', '1712', '2279', '0061', '7028');
INSERT INTO `fw_code` VALUES ('2024172', '9999', '1711', '2813', '3732', '9573');
INSERT INTO `fw_code` VALUES ('2024171', '9999', '1710', '2665', '3990', '1225');
INSERT INTO `fw_code` VALUES ('2024170', '9999', '1709', '4054', '7533', '1841');
INSERT INTO `fw_code` VALUES ('2024169', '9999', '1708', '5015', '6140', '8421');
INSERT INTO `fw_code` VALUES ('2024168', '9999', '1707', '5656', '8545', '9475');
INSERT INTO `fw_code` VALUES ('2024167', '9999', '1706', '1918', '2851', '1662');
INSERT INTO `fw_code` VALUES ('2024166', '9999', '1705', '8540', '4367', '9216');
INSERT INTO `fw_code` VALUES ('2024165', '9999', '1704', '1811', '4117', '3153');
INSERT INTO `fw_code` VALUES ('2024164', '9999', '1703', '0290', '5120', '5198');
INSERT INTO `fw_code` VALUES ('2024163', '9999', '1702', '3494', '7144', '0465');
INSERT INTO `fw_code` VALUES ('2024162', '9999', '1701', '8474', '6640', '0546');
INSERT INTO `fw_code` VALUES ('2024161', '9999', '1700', '4481', '2470', '5876');
INSERT INTO `fw_code` VALUES ('2024160', '9999', '1699', '4242', '8283', '0028');
INSERT INTO `fw_code` VALUES ('2024159', '9999', '1698', '4268', '5002', '8859');
INSERT INTO `fw_code` VALUES ('2024158', '9999', '1697', '0956', '4244', '5082');
INSERT INTO `fw_code` VALUES ('2024157', '9999', '1696', '9181', '6771', '0269');
INSERT INTO `fw_code` VALUES ('2024156', '9999', '1695', '6978', '4362', '1421');
INSERT INTO `fw_code` VALUES ('2024155', '9999', '1694', '5549', '9811', '0966');
INSERT INTO `fw_code` VALUES ('2024154', '9999', '1693', '3947', '8799', '3332');
INSERT INTO `fw_code` VALUES ('2024153', '9999', '1692', '7045', '2089', '0091');
INSERT INTO `fw_code` VALUES ('2024152', '9999', '1691', '2879', '1458', '8243');
INSERT INTO `fw_code` VALUES ('2024151', '9999', '1690', '7339', '1573', '6787');
INSERT INTO `fw_code` VALUES ('2024150', '9999', '1689', '9467', '5019', '3207');
INSERT INTO `fw_code` VALUES ('2024149', '9999', '1688', '0815', '7555', '3983');
INSERT INTO `fw_code` VALUES ('2024148', '9999', '1687', '2911', '1230', '4323');
INSERT INTO `fw_code` VALUES ('2024147', '9999', '1686', '7117', '2868', '6010');
INSERT INTO `fw_code` VALUES ('2024146', '9999', '1685', '0642', '1094', '6805');
INSERT INTO `fw_code` VALUES ('2024145', '9999', '1684', '8399', '7678', '8117');
INSERT INTO `fw_code` VALUES ('2024144', '9999', '1683', '6289', '9714', '6769');
INSERT INTO `fw_code` VALUES ('2024143', '9999', '1682', '2845', '3503', '5653');
INSERT INTO `fw_code` VALUES ('2024142', '9999', '1681', '9788', '1221', '8733');
INSERT INTO `fw_code` VALUES ('2024141', '9999', '1680', '7250', '8321', '3350');
INSERT INTO `fw_code` VALUES ('2024140', '9999', '1679', '5302', '4388', '1358');
INSERT INTO `fw_code` VALUES ('2024139', '9999', '1678', '4874', '9452', '7323');
INSERT INTO `fw_code` VALUES ('2024138', '9999', '1677', '8572', '4138', '5296');
INSERT INTO `fw_code` VALUES ('2024137', '9999', '1676', '8933', '1348', '0662');
INSERT INTO `fw_code` VALUES ('2024136', '9999', '1675', '7611', '5531', '8716');
INSERT INTO `fw_code` VALUES ('2024135', '9999', '1674', '9854', '8948', '7403');
INSERT INTO `fw_code` VALUES ('2024134', '9999', '1673', '4580', '9968', '0627');
INSERT INTO `fw_code` VALUES ('2024133', '9999', '1672', '0856', '8563', '3823');
INSERT INTO `fw_code` VALUES ('2024132', '9999', '1671', '4300', '4773', '4939');
INSERT INTO `fw_code` VALUES ('2024131', '9999', '1670', '2377', '7559', '1778');
INSERT INTO `fw_code` VALUES ('2024130', '9999', '1669', '9920', '6674', '6073');
INSERT INTO `fw_code` VALUES ('2024129', '9999', '1668', '7397', '8063', '1698');
INSERT INTO `fw_code` VALUES ('2024128', '9999', '1667', '9493', '1738', '2037');
INSERT INTO `fw_code` VALUES ('2024127', '9999', '1666', '0027', '5408', '4582');
INSERT INTO `fw_code` VALUES ('2024126', '9999', '1665', '7224', '1602', '4519');
INSERT INTO `fw_code` VALUES ('2024125', '9999', '1664', '8613', '5146', '5135');
INSERT INTO `fw_code` VALUES ('2024124', '9999', '1663', '9574', '3753', '1715');
INSERT INTO `fw_code` VALUES ('2024123', '9999', '1662', '0215', '6158', '2769');
INSERT INTO `fw_code` VALUES ('2024122', '9999', '1661', '7504', '6797', '0207');
INSERT INTO `fw_code` VALUES ('2024121', '9999', '1660', '5688', '8317', '5555');
INSERT INTO `fw_code` VALUES ('2024120', '9999', '1659', '1456', '9960', '5037');
INSERT INTO `fw_code` VALUES ('2024119', '9999', '1658', '8826', '2614', '2153');
INSERT INTO `fw_code` VALUES ('2024118', '9999', '1657', '5515', '1856', '8376');
INSERT INTO `fw_code` VALUES ('2024117', '9999', '1656', '6396', '8448', '5278');
INSERT INTO `fw_code` VALUES ('2024116', '9999', '1655', '0108', '7424', '4260');
INSERT INTO `fw_code` VALUES ('2024115', '9999', '1654', '8506', '6412', '6626');
INSERT INTO `fw_code` VALUES ('2024114', '9999', '1653', '7438', '9071', '1537');
INSERT INTO `fw_code` VALUES ('2024113', '9999', '1652', '4554', '3249', '1796');
INSERT INTO `fw_code` VALUES ('2024112', '9999', '1651', '4661', '1983', '0305');
INSERT INTO `fw_code` VALUES ('2024111', '9999', '1650', '2631', '6035', '8635');
INSERT INTO `fw_code` VALUES ('2024110', '9999', '1649', '6502', '7182', '3787');
INSERT INTO `fw_code` VALUES ('2024109', '9999', '1648', '3979', '8571', '9412');
INSERT INTO `fw_code` VALUES ('2024108', '9999', '1647', '6823', '3384', '9314');
INSERT INTO `fw_code` VALUES ('2024107', '9999', '1646', '6075', '2246', '9751');
INSERT INTO `fw_code` VALUES ('2024106', '9999', '1645', '0281', '3884', '1439');
INSERT INTO `fw_code` VALUES ('2024105', '9999', '1644', '3806', '2110', '2233');
INSERT INTO `fw_code` VALUES ('2024104', '9999', '1643', '1523', '7686', '3707');
INSERT INTO `fw_code` VALUES ('2024103', '9999', '1642', '6156', '4261', '9430');
INSERT INTO `fw_code` VALUES ('2024102', '9999', '1641', '1563', '8694', '3546');
INSERT INTO `fw_code` VALUES ('2024101', '9999', '1640', '6797', '6666', '0483');
INSERT INTO `fw_code` VALUES ('2024100', '9999', '1639', '9386', '3003', '3528');
INSERT INTO `fw_code` VALUES ('2024099', '9999', '1638', '7758', '5273', '7064');
INSERT INTO `fw_code` VALUES ('2024098', '9999', '1637', '0963', '7297', '2332');
INSERT INTO `fw_code` VALUES ('2024097', '9999', '1636', '2270', '8825', '3269');
INSERT INTO `fw_code` VALUES ('2024096', '9999', '1635', '1950', '2622', '7742');
INSERT INTO `fw_code` VALUES ('2024095', '9999', '1634', '8038', '0468', '2751');
INSERT INTO `fw_code` VALUES ('2024094', '9999', '1633', '1736', '5154', '0725');
INSERT INTO `fw_code` VALUES ('2024093', '9999', '1632', '2097', '2364', '6091');
INSERT INTO `fw_code` VALUES ('2024092', '9999', '1631', '6650', '6924', '2135');
INSERT INTO `fw_code` VALUES ('2024091', '9999', '1630', '3018', '9964', '2832');
INSERT INTO `fw_code` VALUES ('2024090', '9999', '1629', '5088', '6920', '4341');
INSERT INTO `fw_code` VALUES ('2024089', '9999', '1628', '4513', '2241', '1957');
INSERT INTO `fw_code` VALUES ('2024088', '9999', '1627', '4020', '9579', '9251');
INSERT INTO `fw_code` VALUES ('2024087', '9999', '1626', '5541', '8575', '7207');
INSERT INTO `fw_code` VALUES ('2024086', '9999', '1625', '0429', '3626', '9787');
INSERT INTO `fw_code` VALUES ('2024085', '9999', '1624', '0561', '9079', '7126');
INSERT INTO `fw_code` VALUES ('2024084', '9999', '1623', '7077', '1861', '6171');
INSERT INTO `fw_code` VALUES ('2024083', '9999', '1622', '0001', '8690', '5751');
INSERT INTO `fw_code` VALUES ('2024082', '9999', '1621', '0535', '2360', '8296');
INSERT INTO `fw_code` VALUES ('2024081', '9999', '1620', '0388', '2618', '9948');
INSERT INTO `fw_code` VALUES ('2024080', '9999', '1619', '1777', '6162', '0564');
INSERT INTO `fw_code` VALUES ('2024079', '9999', '1618', '2738', '4769', '7144');
INSERT INTO `fw_code` VALUES ('2024078', '9999', '1617', '1817', '7170', '0403');
INSERT INTO `fw_code` VALUES ('2024077', '9999', '1616', '3379', '7174', '8198');
INSERT INTO `fw_code` VALUES ('2024076', '9999', '1615', '9640', '1480', '0385');
INSERT INTO `fw_code` VALUES ('2024075', '9999', '1614', '6263', '2995', '7939');
INSERT INTO `fw_code` VALUES ('2024074', '9999', '1613', '0668', '7813', '5635');
INSERT INTO `fw_code` VALUES ('2024073', '9999', '1612', '5048', '5912', '4501');
INSERT INTO `fw_code` VALUES ('2024072', '9999', '1611', '8852', '9333', '0984');
INSERT INTO `fw_code` VALUES ('2024071', '9999', '1610', '4620', '0976', '0466');
INSERT INTO `fw_code` VALUES ('2024070', '9999', '1609', '1990', '3630', '7582');
INSERT INTO `fw_code` VALUES ('2024069', '9999', '1608', '8679', '2872', '3805');
INSERT INTO `fw_code` VALUES ('2024068', '9999', '1607', '6904', '5400', '8992');
INSERT INTO `fw_code` VALUES ('2024067', '9999', '1606', '7357', '7055', '1859');
INSERT INTO `fw_code` VALUES ('2024066', '9999', '1605', '3272', '8440', '9689');
INSERT INTO `fw_code` VALUES ('2024065', '9999', '1604', '5795', '7051', '4064');
INSERT INTO `fw_code` VALUES ('2024064', '9999', '1603', '7011', '4134', '7501');
INSERT INTO `fw_code` VALUES ('2024063', '9999', '1602', '7143', '9587', '4841');
INSERT INTO `fw_code` VALUES ('2024062', '9999', '1601', '3445', '4900', '6867');
INSERT INTO `fw_code` VALUES ('2024061', '9999', '1600', '6970', '3126', '7662');
INSERT INTO `fw_code` VALUES ('2024060', '9999', '1599', '9320', '5277', '4858');
INSERT INTO `fw_code` VALUES ('2024059', '9999', '1598', '5221', '2373', '1680');
INSERT INTO `fw_code` VALUES ('2024058', '9999', '1597', '0922', '6289', '2492');
INSERT INTO `fw_code` VALUES ('2024057', '9999', '1596', '1629', '6420', '2216');
INSERT INTO `fw_code` VALUES ('2024056', '9999', '1595', '4127', '8313', '7760');
INSERT INTO `fw_code` VALUES ('2024055', '9999', '1594', '5434', '9841', '8698');
INSERT INTO `fw_code` VALUES ('2024054', '9999', '1593', '1202', '1484', '8180');
INSERT INTO `fw_code` VALUES ('2024053', '9999', '1592', '4900', '6170', '6153');
INSERT INTO `fw_code` VALUES ('2024052', '9999', '1591', '5261', '3380', '1519');
INSERT INTO `fw_code` VALUES ('2024051', '9999', '1590', '1283', '3499', '7858');
INSERT INTO `fw_code` VALUES ('2024050', '9999', '1589', '2414', '3535', '6846');
INSERT INTO `fw_code` VALUES ('2024049', '9999', '1588', '4204', '5296', '2667');
INSERT INTO `fw_code` VALUES ('2024048', '9999', '1587', '9824', '7197', '3801');
INSERT INTO `fw_code` VALUES ('2024047', '9999', '1586', '1813', '2138', '5631');
INSERT INTO `fw_code` VALUES ('2024046', '9999', '1585', '7301', '8586', '9426');
INSERT INTO `fw_code` VALUES ('2024045', '9999', '1584', '9931', '5931', '2310');
INSERT INTO `fw_code` VALUES ('2024044', '9999', '1583', '1172', '9733', '4578');
INSERT INTO `fw_code` VALUES ('2024043', '9999', '1582', '1213', '0741', '4417');
INSERT INTO `fw_code` VALUES ('2024042', '9999', '1581', '9036', '5050', '4399');
INSERT INTO `fw_code` VALUES ('2024041', '9999', '1580', '5659', '6566', '1953');
INSERT INTO `fw_code` VALUES ('2024040', '9999', '1579', '7408', '7320', '7935');
INSERT INTO `fw_code` VALUES ('2024039', '9999', '1578', '3268', '3408', '4917');
INSERT INTO `fw_code` VALUES ('2024038', '9999', '1577', '5592', '8840', '3283');
INSERT INTO `fw_code` VALUES ('2024037', '9999', '1576', '4097', '6562', '4158');
INSERT INTO `fw_code` VALUES ('2024036', '9999', '1575', '4163', '4288', '2828');
INSERT INTO `fw_code` VALUES ('2024035', '9999', '1574', '9997', '3658', '0979');
INSERT INTO `fw_code` VALUES ('2024034', '9999', '1573', '6406', '7705', '1515');
INSERT INTO `fw_code` VALUES ('2024033', '9999', '1572', '2067', '0614', '2488');
INSERT INTO `fw_code` VALUES ('2024032', '9999', '1571', '1426', '8209', '1435');
INSERT INTO `fw_code` VALUES ('2024031', '9999', '1570', '9357', '1253', '9926');
INSERT INTO `fw_code` VALUES ('2024030', '9999', '1569', '9290', '3526', '1256');
INSERT INTO `fw_code` VALUES ('2024029', '9999', '1568', '5913', '5042', '8810');
INSERT INTO `fw_code` VALUES ('2024028', '9999', '1567', '2174', '9348', '0997');
INSERT INTO `fw_code` VALUES ('2024027', '9999', '1566', '7942', '0991', '0479');
INSERT INTO `fw_code` VALUES ('2024026', '9999', '1565', '1640', '5677', '8453');
INSERT INTO `fw_code` VALUES ('2024025', '9999', '1564', '7648', '1507', '3783');
INSERT INTO `fw_code` VALUES ('2024024', '9999', '1563', '4417', '2764', '9685');
INSERT INTO `fw_code` VALUES ('2024023', '9999', '1562', '6579', '4166', '8694');
INSERT INTO `fw_code` VALUES ('2024022', '9999', '1561', '4977', '3154', '1060');
INSERT INTO `fw_code` VALUES ('2024021', '9999', '1560', '6981', '2383', '3899');
INSERT INTO `fw_code` VALUES ('2024020', '9999', '1559', '4336', '0749', '0006');
INSERT INTO `fw_code` VALUES ('2024019', '9999', '1558', '5939', '1761', '7640');
INSERT INTO `fw_code` VALUES ('2024018', '9999', '1557', '8822', '7582', '7381');
INSERT INTO `fw_code` VALUES ('2024017', '9999', '1556', '9463', '9987', '8435');
INSERT INTO `fw_code` VALUES ('2024016', '9999', '1555', '3161', '4674', '6408');
INSERT INTO `fw_code` VALUES ('2024015', '9999', '1554', '7622', '4788', '4952');
INSERT INTO `fw_code` VALUES ('2024014', '9999', '1553', '7728', '3522', '3461');
INSERT INTO `fw_code` VALUES ('2024013', '9999', '1552', '5699', '7574', '1792');
INSERT INTO `fw_code` VALUES ('2024012', '9999', '1551', '7047', '0110', '2569');
INSERT INTO `fw_code` VALUES ('2024011', '9999', '1550', '5124', '2896', '9408');
INSERT INTO `fw_code` VALUES ('2024010', '9999', '1549', '6019', '3776', '7319');
INSERT INTO `fw_code` VALUES ('2024009', '9999', '1548', '3482', '0876', '1935');
INSERT INTO `fw_code` VALUES ('2024008', '9999', '1547', '1533', '6943', '9944');
INSERT INTO `fw_code` VALUES ('2024007', '9999', '1546', '6686', '2900', '7203');
INSERT INTO `fw_code` VALUES ('2024006', '9999', '1545', '5338', '0364', '6426');
INSERT INTO `fw_code` VALUES ('2024005', '9999', '1544', '5165', '3903', '9247');
INSERT INTO `fw_code` VALUES ('2024004', '9999', '1543', '9717', '8463', '5292');
INSERT INTO `fw_code` VALUES ('2024003', '9999', '1542', '7581', '3780', '5113');
INSERT INTO `fw_code` VALUES ('2024002', '9999', '1541', '4310', '4030', '1176');
INSERT INTO `fw_code` VALUES ('2024001', '9999', '1540', '8609', '0114', '0363');
INSERT INTO `fw_code` VALUES ('2024000', '9999', '1539', '0145', '3399', '9328');
INSERT INTO `fw_code` VALUES ('2023999', '9999', '1538', '5806', '6308', '0301');
INSERT INTO `fw_code` VALUES ('2023998', '9999', '1537', '6447', '8713', '1354');
INSERT INTO `fw_code` VALUES ('2023997', '9999', '1536', '2708', '3018', '3542');
INSERT INTO `fw_code` VALUES ('2023996', '9999', '1535', '1706', '3404', '7122');
INSERT INTO `fw_code` VALUES ('2023995', '9999', '1534', '8152', '3427', '2725');
INSERT INTO `fw_code` VALUES ('2023994', '9999', '1533', '8859', '3558', '2449');
INSERT INTO `fw_code` VALUES ('2023993', '9999', '1532', '6656', '1149', '3600');
INSERT INTO `fw_code` VALUES ('2023992', '9999', '1531', '5095', '1145', '5806');
INSERT INTO `fw_code` VALUES ('2023991', '9999', '1530', '8966', '2292', '0958');
INSERT INTO `fw_code` VALUES ('2023990', '9999', '1529', '4627', '5201', '1931');
INSERT INTO `fw_code` VALUES ('2023989', '9999', '1528', '6443', '3681', '6583');
INSERT INTO `fw_code` VALUES ('2023988', '9999', '1527', '9286', '8494', '6484');
INSERT INTO `fw_code` VALUES ('2023987', '9999', '1526', '6270', '7220', '9404');
INSERT INTO `fw_code` VALUES ('2023986', '9999', '1525', '3986', '2796', '0877');
INSERT INTO `fw_code` VALUES ('2023985', '9999', '1524', '4027', '3804', '0716');
INSERT INTO `fw_code` VALUES ('2023984', '9999', '1523', '1850', '8113', '0699');
INSERT INTO `fw_code` VALUES ('2023983', '9999', '1522', '4734', '3935', '0440');
INSERT INTO `fw_code` VALUES ('2023982', '9999', '1521', '4413', '7732', '4913');
INSERT INTO `fw_code` VALUES ('2023981', '9999', '1520', '9113', '2034', '9306');
INSERT INTO `fw_code` VALUES ('2023980', '9999', '1519', '3238', '1657', '1315');
INSERT INTO `fw_code` VALUES ('2023979', '9999', '1518', '5481', '5074', '0002');
INSERT INTO `fw_code` VALUES ('2023978', '9999', '1517', '6977', '7351', '9127');
INSERT INTO `fw_code` VALUES ('2023977', '9999', '1516', '8005', '3685', '4377');
INSERT INTO `fw_code` VALUES ('2023976', '9999', '1515', '3025', '4189', '4297');
INSERT INTO `fw_code` VALUES ('2023975', '9999', '1514', '9540', '6970', '3341');
INSERT INTO `fw_code` VALUES ('2023974', '9999', '1513', '2852', '7728', '7118');
INSERT INTO `fw_code` VALUES ('2023973', '9999', '1512', '1997', '7855', '9047');
INSERT INTO `fw_code` VALUES ('2023972', '9999', '1511', '3132', '2923', '2806');
INSERT INTO `fw_code` VALUES ('2023971', '9999', '1510', '7511', '1022', '1672');
INSERT INTO `fw_code` VALUES ('2023970', '9999', '1509', '6336', '4947', '8074');
INSERT INTO `fw_code` VALUES ('2023969', '9999', '1508', '1316', '4443', '8154');
INSERT INTO `fw_code` VALUES ('2023968', '9999', '1507', '9820', '2165', '9029');
INSERT INTO `fw_code` VALUES ('2023967', '9999', '1506', '8259', '2161', '1234');
INSERT INTO `fw_code` VALUES ('2023966', '9999', '1505', '7791', '6217', '7359');
INSERT INTO `fw_code` VALUES ('2023965', '9999', '1504', '9607', '4697', '2011');
INSERT INTO `fw_code` VALUES ('2023964', '9999', '1503', '5909', '0010', '4038');
INSERT INTO `fw_code` VALUES ('2023963', '9999', '1502', '7150', '3812', '6306');
INSERT INTO `fw_code` VALUES ('2023962', '9999', '1501', '7190', '4820', '6145');
INSERT INTO `fw_code` VALUES ('2023961', '9999', '1500', '1636', '0645', '3681');
INSERT INTO `fw_code` VALUES ('2023960', '9999', '1499', '3386', '1399', '9663');
INSERT INTO `fw_code` VALUES ('2023959', '9999', '1498', '4093', '1530', '9386');
INSERT INTO `fw_code` VALUES ('2023958', '9999', '1497', '7898', '4951', '5868');
INSERT INTO `fw_code` VALUES ('2023957', '9999', '1496', '7577', '8748', '0342');
INSERT INTO `fw_code` VALUES ('2023956', '9999', '1495', '7364', '1280', '3324');
INSERT INTO `fw_code` VALUES ('2023955', '9999', '1494', '2277', '3050', '4734');
INSERT INTO `fw_code` VALUES ('2023954', '9999', '1493', '8645', '6090', '5431');
INSERT INTO `fw_code` VALUES ('2023953', '9999', '1492', '0715', '3046', '6940');
INSERT INTO `fw_code` VALUES ('2023952', '9999', '1491', '0141', '8367', '4556');
INSERT INTO `fw_code` VALUES ('2023951', '9999', '1490', '8045', '4693', '4216');
INSERT INTO `fw_code` VALUES ('2023950', '9999', '1489', '2704', '7986', '8770');
INSERT INTO `fw_code` VALUES ('2023949', '9999', '1488', '7404', '2288', '3163');
INSERT INTO `fw_code` VALUES ('2023948', '9999', '1487', '8365', '0895', '9743');
INSERT INTO `fw_code` VALUES ('2023947', '9999', '1486', '9006', '3300', '0797');
INSERT INTO `fw_code` VALUES ('2023946', '9999', '1485', '1890', '9121', '0538');
INSERT INTO `fw_code` VALUES ('2023945', '9999', '1484', '0675', '2038', '7100');
INSERT INTO `fw_code` VALUES ('2023944', '9999', '1483', '9500', '5963', '3502');
INSERT INTO `fw_code` VALUES ('2023943', '9999', '1482', '0248', '7101', '3065');
INSERT INTO `fw_code` VALUES ('2023942', '9999', '1481', '7618', '9756', '0181');
INSERT INTO `fw_code` VALUES ('2023941', '9999', '1480', '8899', '4566', '2288');
INSERT INTO `fw_code` VALUES ('2023940', '9999', '1479', '7297', '3554', '4654');
INSERT INTO `fw_code` VALUES ('2023939', '9999', '1478', '6229', '6212', '9565');
INSERT INTO `fw_code` VALUES ('2023938', '9999', '1477', '3345', '0391', '9824');
INSERT INTO `fw_code` VALUES ('2023937', '9999', '1476', '1423', '3177', '6663');
INSERT INTO `fw_code` VALUES ('2023936', '9999', '1475', '3691', '0140', '2596');
INSERT INTO `fw_code` VALUES ('2023935', '9999', '1474', '1234', '9255', '6890');
INSERT INTO `fw_code` VALUES ('2023934', '9999', '1473', '9098', '4572', '6712');
INSERT INTO `fw_code` VALUES ('2023933', '9999', '1472', '5720', '6088', '4265');
INSERT INTO `fw_code` VALUES ('2023932', '9999', '1471', '1982', '0394', '6453');
INSERT INTO `fw_code` VALUES ('2023931', '9999', '1470', '1448', '6723', '3908');
INSERT INTO `fw_code` VALUES ('2023930', '9999', '1469', '6361', '8493', '5319');
INSERT INTO `fw_code` VALUES ('2023929', '9999', '1468', '2729', '1533', '6015');
INSERT INTO `fw_code` VALUES ('2023928', '9999', '1467', '4225', '3810', '5140');
INSERT INTO `fw_code` VALUES ('2023927', '9999', '1466', '6788', '3429', '9355');
INSERT INTO `fw_code` VALUES ('2023926', '9999', '1465', '0380', '9382', '8819');
INSERT INTO `fw_code` VALUES ('2023925', '9999', '1464', '4759', '7481', '7685');
INSERT INTO `fw_code` VALUES ('2023924', '9999', '1463', '3584', '1406', '4087');
INSERT INTO `fw_code` VALUES ('2023923', '9999', '1462', '7429', '5834', '0408');
INSERT INTO `fw_code` VALUES ('2023922', '9999', '1461', '7536', '4568', '8917');
INSERT INTO `fw_code` VALUES ('2023921', '9999', '1460', '5507', '8620', '7248');
INSERT INTO `fw_code` VALUES ('2023920', '9999', '1459', '3157', '6469', '0051');
INSERT INTO `fw_code` VALUES ('2023919', '9999', '1458', '6682', '4695', '0846');
INSERT INTO `fw_code` VALUES ('2023918', '9999', '1457', '4438', '1279', '2158');
INSERT INTO `fw_code` VALUES ('2023917', '9999', '1456', '5827', '4822', '2774');
INSERT INTO `fw_code` VALUES ('2023916', '9999', '1455', '1341', '7989', '5399');
INSERT INTO `fw_code` VALUES ('2023915', '9999', '1454', '4973', '4949', '4703');
INSERT INTO `fw_code` VALUES ('2023914', '9999', '1453', '7389', '4826', '0569');
INSERT INTO `fw_code` VALUES ('2023913', '9999', '1452', '6895', '2164', '7864');
INSERT INTO `fw_code` VALUES ('2023912', '9999', '1451', '4118', '5076', '6631');
INSERT INTO `fw_code` VALUES ('2023911', '9999', '1450', '5293', '1152', '0230');
INSERT INTO `fw_code` VALUES ('2023910', '9999', '1449', '3264', '5203', '8560');
INSERT INTO `fw_code` VALUES ('2023909', '9999', '1448', '4652', '8747', '9176');
INSERT INTO `fw_code` VALUES ('2023908', '9999', '1447', '5613', '7354', '5756');
INSERT INTO `fw_code` VALUES ('2023907', '9999', '1446', '6254', '9759', '6810');
INSERT INTO `fw_code` VALUES ('2023906', '9999', '1445', '2516', '4064', '8998');
INSERT INTO `fw_code` VALUES ('2023905', '9999', '1444', '2409', '5330', '0489');
INSERT INTO `fw_code` VALUES ('2023904', '9999', '1443', '5079', '3683', '3212');
INSERT INTO `fw_code` VALUES ('2023903', '9999', '1442', '4866', '6215', '6194');
INSERT INTO `fw_code` VALUES ('2023902', '9999', '1441', '6147', '1025', '8301');
INSERT INTO `fw_code` VALUES ('2023901', '9999', '1440', '4545', '0013', '0667');
INSERT INTO `fw_code` VALUES ('2023900', '9999', '1439', '7643', '3302', '7426');
INSERT INTO `fw_code` VALUES ('2023899', '9999', '1438', '0700', '5584', '4346');
INSERT INTO `fw_code` VALUES ('2023898', '9999', '1437', '6321', '7485', '5480');
INSERT INTO `fw_code` VALUES ('2023897', '9999', '1436', '2836', '0267', '4524');
INSERT INTO `fw_code` VALUES ('2023896', '9999', '1435', '8991', '5838', '8203');
INSERT INTO `fw_code` VALUES ('2023895', '9999', '1434', '3798', '8874', '1105');
INSERT INTO `fw_code` VALUES ('2023894', '9999', '1433', '7002', '0898', '6373');
INSERT INTO `fw_code` VALUES ('2023893', '9999', '1432', '4078', '4069', '6792');
INSERT INTO `fw_code` VALUES ('2023892', '9999', '1431', '1127', '0521', '8382');
INSERT INTO `fw_code` VALUES ('2023891', '9999', '1430', '6468', '7227', '3828');
INSERT INTO `fw_code` VALUES ('2023890', '9999', '1429', '6041', '2291', '9792');
INSERT INTO `fw_code` VALUES ('2023889', '9999', '1428', '6575', '5961', '2337');
INSERT INTO `fw_code` VALUES ('2023888', '9999', '1427', '2688', '8686', '2838');
INSERT INTO `fw_code` VALUES ('2023887', '9999', '1426', '5038', '0837', '0034');
INSERT INTO `fw_code` VALUES ('2023886', '9999', '1425', '4117', '3238', '3293');
INSERT INTO `fw_code` VALUES ('2023885', '9999', '1424', '0939', '7933', '6856');
INSERT INTO `fw_code` VALUES ('2023884', '9999', '1423', '2968', '3881', '8525');
INSERT INTO `fw_code` VALUES ('2023883', '9999', '1422', '7348', '1980', '7391');
INSERT INTO `fw_code` VALUES ('2023882', '9999', '1421', '4504', '7166', '7489');
INSERT INTO `fw_code` VALUES ('2023881', '9999', '1420', '6921', '7044', '3356');
INSERT INTO `fw_code` VALUES ('2023880', '9999', '1419', '0979', '8940', '6695');
INSERT INTO `fw_code` VALUES ('2023879', '9999', '1418', '3970', '3496', '4945');
INSERT INTO `fw_code` VALUES ('2023878', '9999', '1417', '7068', '6786', '1704');
INSERT INTO `fw_code` VALUES ('2023877', '9999', '1416', '0018', '0333', '0114');
INSERT INTO `fw_code` VALUES ('2023876', '9999', '1415', '8095', '3119', '6954');
INSERT INTO `fw_code` VALUES ('2023875', '9999', '1414', '9311', '0202', '0391');
INSERT INTO `fw_code` VALUES ('2023874', '9999', '1413', '7628', '7175', '3079');
INSERT INTO `fw_code` VALUES ('2023873', '9999', '1412', '9631', '6405', '5918');
INSERT INTO `fw_code` VALUES ('2023872', '9999', '1411', '8884', '5266', '6355');
INSERT INTO `fw_code` VALUES ('2023871', '9999', '1410', '5746', '0968', '9757');
INSERT INTO `fw_code` VALUES ('2023870', '9999', '1409', '9270', '9194', '0552');
INSERT INTO `fw_code` VALUES ('2023869', '9999', '1408', '1620', '1345', '7748');
INSERT INTO `fw_code` VALUES ('2023868', '9999', '1407', '7027', '5778', '1864');
INSERT INTO `fw_code` VALUES ('2023867', '9999', '1406', '2261', '3750', '8802');
INSERT INTO `fw_code` VALUES ('2023866', '9999', '1405', '2195', '6024', '0132');
INSERT INTO `fw_code` VALUES ('2023865', '9999', '1404', '7521', '8441', '4570');
INSERT INTO `fw_code` VALUES ('2023864', '9999', '1403', '1473', '1603', '9400');
INSERT INTO `fw_code` VALUES ('2023863', '9999', '1402', '3930', '2488', '5106');
INSERT INTO `fw_code` VALUES ('2023862', '9999', '1401', '6427', '4381', '0650');
INSERT INTO `fw_code` VALUES ('2023861', '9999', '1400', '7414', '9706', '6061');
INSERT INTO `fw_code` VALUES ('2023860', '9999', '1399', '3502', '7552', '1070');
INSERT INTO `fw_code` VALUES ('2023859', '9999', '1398', '7201', '2238', '9043');
INSERT INTO `fw_code` VALUES ('2023858', '9999', '1397', '7561', '9448', '4409');
INSERT INTO `fw_code` VALUES ('2023857', '9999', '1396', '8482', '7048', '1150');
INSERT INTO `fw_code` VALUES ('2023856', '9999', '1395', '0552', '4004', '2659');
INSERT INTO `fw_code` VALUES ('2023855', '9999', '1394', '9484', '6663', '7570');
INSERT INTO `fw_code` VALUES ('2023854', '9999', '1393', '0272', '8809', '6971');
INSERT INTO `fw_code` VALUES ('2023853', '9999', '1392', '8350', '1595', '3811');
INSERT INTO `fw_code` VALUES ('2023852', '9999', '1391', '5893', '0710', '8105');
INSERT INTO `fw_code` VALUES ('2023851', '9999', '1390', '7882', '5651', '9936');
INSERT INTO `fw_code` VALUES ('2023850', '9999', '1389', '3370', '2099', '3730');
INSERT INTO `fw_code` VALUES ('2023849', '9999', '1388', '2541', '8944', '4490');
INSERT INTO `fw_code` VALUES ('2023848', '9999', '1387', '6000', '9444', '6614');
INSERT INTO `fw_code` VALUES ('2023847', '9999', '1386', '5852', '9702', '8266');
INSERT INTO `fw_code` VALUES ('2023846', '9999', '1385', '8202', '1853', '5463');
INSERT INTO `fw_code` VALUES ('2023845', '9999', '1384', '8843', '4258', '6516');
INSERT INTO `fw_code` VALUES ('2023844', '9999', '1383', '1727', '0079', '6257');
INSERT INTO `fw_code` VALUES ('2023843', '9999', '1382', '3477', '0833', '2239');
INSERT INTO `fw_code` VALUES ('2023842', '9999', '1381', '9337', '6921', '9222');
INSERT INTO `fw_code` VALUES ('2023841', '9999', '1380', '1661', '2353', '7587');
INSERT INTO `fw_code` VALUES ('2023840', '9999', '1379', '7668', '8182', '2918');
INSERT INTO `fw_code` VALUES ('2023839', '9999', '1378', '0084', '8060', '8784');
INSERT INTO `fw_code` VALUES ('2023838', '9999', '1377', '7455', '0714', '5900');
INSERT INTO `fw_code` VALUES ('2023837', '9999', '1376', '4143', '9956', '2123');
INSERT INTO `fw_code` VALUES ('2023836', '9999', '1375', '8736', '5524', '8007');
INSERT INTO `fw_code` VALUES ('2023835', '9999', '1374', '7134', '4512', '0373');
INSERT INTO `fw_code` VALUES ('2023834', '9999', '1373', '3182', '1349', '5543');
INSERT INTO `fw_code` VALUES ('2023833', '9999', '1372', '3289', '0083', '4052');
INSERT INTO `fw_code` VALUES ('2023832', '9999', '1371', '1259', '4135', '2382');
INSERT INTO `fw_code` VALUES ('2023831', '9999', '1370', '8136', '4127', '6793');
INSERT INTO `fw_code` VALUES ('2023830', '9999', '1369', '9952', '2607', '1445');
INSERT INTO `fw_code` VALUES ('2023829', '9999', '1368', '2795', '7420', '1347');
INSERT INTO `fw_code` VALUES ('2023828', '9999', '1367', '8910', '1984', '5186');
INSERT INTO `fw_code` VALUES ('2023827', '9999', '1366', '2434', '0210', '5981');
INSERT INTO `fw_code` VALUES ('2023826', '9999', '1365', '4784', '2361', '3177');
INSERT INTO `fw_code` VALUES ('2023825', '9999', '1364', '0191', '6794', '7293');
INSERT INTO `fw_code` VALUES ('2023824', '9999', '1363', '5425', '4766', '4231');
INSERT INTO `fw_code` VALUES ('2023823', '9999', '1362', '1981', '8555', '3114');
INSERT INTO `fw_code` VALUES ('2023822', '9999', '1361', '1580', '0337', '7909');
INSERT INTO `fw_code` VALUES ('2023821', '9999', '1360', '6386', '3373', '0811');
INSERT INTO `fw_code` VALUES ('2023820', '9999', '1359', '9591', '5397', '6079');
INSERT INTO `fw_code` VALUES ('2023819', '9999', '1358', '8243', '2861', '5302');
INSERT INTO `fw_code` VALUES ('2023818', '9999', '1357', '4011', '4504', '4784');
INSERT INTO `fw_code` VALUES ('2023817', '9999', '1356', '7709', '9190', '2757');
INSERT INTO `fw_code` VALUES ('2023816', '9999', '1355', '0725', '0464', '9838');
INSERT INTO `fw_code` VALUES ('2023815', '9999', '1354', '2622', '0960', '4168');
INSERT INTO `fw_code` VALUES ('2023814', '9999', '1353', '6747', '0583', '6177');
INSERT INTO `fw_code` VALUES ('2023813', '9999', '1352', '8990', '4000', '4864');
INSERT INTO `fw_code` VALUES ('2023812', '9999', '1351', '3716', '5020', '8088');
INSERT INTO `fw_code` VALUES ('2023811', '9999', '1350', '0486', '6278', '3989');
INSERT INTO `fw_code` VALUES ('2023810', '9999', '1349', '3436', '9825', '2400');
INSERT INTO `fw_code` VALUES ('2023809', '9999', '1348', '9871', '0591', '1766');
INSERT INTO `fw_code` VALUES ('2023808', '9999', '1347', '1513', '2611', '9239');
INSERT INTO `fw_code` VALUES ('2023807', '9999', '1346', '6534', '3115', '9159');
INSERT INTO `fw_code` VALUES ('2023806', '9999', '1345', '9016', '0718', '3695');
INSERT INTO `fw_code` VALUES ('2023805', '9999', '1344', '1366', '2869', '0891');
INSERT INTO `fw_code` VALUES ('2023804', '9999', '1343', '0445', '5270', '4150');
INSERT INTO `fw_code` VALUES ('2023803', '9999', '1342', '2007', '5274', '1945');
INSERT INTO `fw_code` VALUES ('2023802', '9999', '1341', '4891', '1095', '1686');
INSERT INTO `fw_code` VALUES ('2023801', '9999', '1340', '8162', '0845', '5624');
INSERT INTO `fw_code` VALUES ('2023800', '9999', '1339', '6641', '1849', '7668');
INSERT INTO `fw_code` VALUES ('2023799', '9999', '1338', '1020', '9948', '6534');
INSERT INTO `fw_code` VALUES ('2023798', '9999', '1337', '9845', '3873', '2936');
INSERT INTO `fw_code` VALUES ('2023797', '9999', '1336', '4825', '3369', '3016');
INSERT INTO `fw_code` VALUES ('2023796', '9999', '1335', '0832', '9198', '8347');
INSERT INTO `fw_code` VALUES ('2023795', '9999', '1334', '0593', '5012', '2498');
INSERT INTO `fw_code` VALUES ('2023794', '9999', '1333', '7307', '0972', '7552');
INSERT INTO `fw_code` VALUES ('2023793', '9999', '1332', '3329', '1091', '3891');
INSERT INTO `fw_code` VALUES ('2023792', '9999', '1331', '1900', '6540', '3436');
INSERT INTO `fw_code` VALUES ('2023791', '9999', '1330', '0298', '5528', '5802');
INSERT INTO `fw_code` VALUES ('2023790', '9999', '1329', '3396', '8817', '2561');
INSERT INTO `fw_code` VALUES ('2023789', '9999', '1328', '3797', '7035', '7766');
INSERT INTO `fw_code` VALUES ('2023788', '9999', '1327', '1768', '1087', '6096');
INSERT INTO `fw_code` VALUES ('2023787', '9999', '1326', '3116', '3623', '6873');
INSERT INTO `fw_code` VALUES ('2023786', '9999', '1325', '5959', '8436', '6775');
INSERT INTO `fw_code` VALUES ('2023785', '9999', '1324', '9418', '8936', '8900');
INSERT INTO `fw_code` VALUES ('2023784', '9999', '1323', '2943', '7162', '9695');
INSERT INTO `fw_code` VALUES ('2023783', '9999', '1322', '0659', '2738', '1168');
INSERT INTO `fw_code` VALUES ('2023782', '9999', '1321', '4180', '5932', '7191');
INSERT INTO `fw_code` VALUES ('2023781', '9999', '1320', '4821', '8337', '8244');
INSERT INTO `fw_code` VALUES ('2023780', '9999', '1319', '4754', '0610', '9575');
INSERT INTO `fw_code` VALUES ('2023779', '9999', '1318', '7425', '8964', '2298');
INSERT INTO `fw_code` VALUES ('2023778', '9999', '1317', '5782', '6944', '4825');
INSERT INTO `fw_code` VALUES ('2023777', '9999', '1316', '8986', '8968', '0093');
INSERT INTO `fw_code` VALUES ('2023776', '9999', '1315', '7638', '6432', '9316');
INSERT INTO `fw_code` VALUES ('2023775', '9999', '1314', '3406', '8075', '8798');
INSERT INTO `fw_code` VALUES ('2023774', '9999', '1313', '7104', '2761', '6771');
INSERT INTO `fw_code` VALUES ('2023773', '9999', '1312', '7465', '9971', '2137');
INSERT INTO `fw_code` VALUES ('2023772', '9999', '1311', '2018', '4531', '8182');
INSERT INTO `fw_code` VALUES ('2023771', '9999', '1310', '6143', '4154', '0191');
INSERT INTO `fw_code` VALUES ('2023770', '9999', '1309', '3112', '8591', '2102');
INSERT INTO `fw_code` VALUES ('2023769', '9999', '1308', '9881', '9848', '8003');
INSERT INTO `fw_code` VALUES ('2023768', '9999', '1307', '9388', '7186', '5298');
INSERT INTO `fw_code` VALUES ('2023767', '9999', '1306', '2832', '3396', '6414');
INSERT INTO `fw_code` VALUES ('2023766', '9999', '1305', '6611', '0098', '4066');
INSERT INTO `fw_code` VALUES ('2023765', '9999', '1304', '0909', '6182', '3253');
INSERT INTO `fw_code` VALUES ('2023764', '9999', '1303', '8452', '5297', '7548');
INSERT INTO `fw_code` VALUES ('2023763', '9999', '1302', '7786', '6174', '7664');
INSERT INTO `fw_code` VALUES ('2023762', '9999', '1301', '5929', '6686', '3173');
INSERT INTO `fw_code` VALUES ('2023761', '9999', '1300', '8025', '0360', '3512');
INSERT INTO `fw_code` VALUES ('2023760', '9999', '1299', '8559', '4031', '6057');
INSERT INTO `fw_code` VALUES ('2023759', '9999', '1298', '8106', '2376', '3191');
INSERT INTO `fw_code` VALUES ('2023758', '9999', '1297', '9841', '8841', '8164');
INSERT INTO `fw_code` VALUES ('2023757', '9999', '1296', '5008', '9086', '6432');
INSERT INTO `fw_code` VALUES ('2023756', '9999', '1295', '4007', '9472', '0012');
INSERT INTO `fw_code` VALUES ('2023755', '9999', '1294', '4287', '4666', '5700');
INSERT INTO `fw_code` VALUES ('2023754', '9999', '1293', '4902', '0352', '7923');
INSERT INTO `fw_code` VALUES ('2023753', '9999', '1292', '6036', '5420', '1682');
INSERT INTO `fw_code` VALUES ('2023752', '9999', '1291', '0416', '3519', '0548');
INSERT INTO `fw_code` VALUES ('2023751', '9999', '1290', '9241', '7444', '6950');
INSERT INTO `fw_code` VALUES ('2023750', '9999', '1289', '4220', '6940', '7030');
INSERT INTO `fw_code` VALUES ('2023749', '9999', '1288', '4928', '7071', '6753');
INSERT INTO `fw_code` VALUES ('2023748', '9999', '1287', '2725', '4662', '7905');
INSERT INTO `fw_code` VALUES ('2023747', '9999', '1286', '5034', '5805', '5262');
INSERT INTO `fw_code` VALUES ('2023746', '9999', '1285', '0696', '8714', '6235');
INSERT INTO `fw_code` VALUES ('2023745', '9999', '1284', '2511', '7194', '0887');
INSERT INTO `fw_code` VALUES ('2023744', '9999', '1283', '5355', '2007', '0789');
INSERT INTO `fw_code` VALUES ('2023743', '9999', '1282', '4607', '0868', '1227');
INSERT INTO `fw_code` VALUES ('2023742', '9999', '1281', '0055', '6309', '5182');
INSERT INTO `fw_code` VALUES ('2023741', '9999', '1280', '7918', '1626', '5003');
INSERT INTO `fw_code` VALUES ('2023740', '9999', '1279', '0589', '9979', '7726');
INSERT INTO `fw_code` VALUES ('2023739', '9999', '1278', '4541', '3142', '2557');
INSERT INTO `fw_code` VALUES ('2023738', '9999', '1277', '1484', '0860', '5637');
INSERT INTO `fw_code` VALUES ('2023737', '9999', '1276', '6290', '3896', '8539');
INSERT INTO `fw_code` VALUES ('2023736', '9999', '1275', '9495', '5920', '3807');
INSERT INTO `fw_code` VALUES ('2023735', '9999', '1274', '0802', '7448', '4744');
INSERT INTO `fw_code` VALUES ('2023734', '9999', '1273', '0482', '1245', '9218');
INSERT INTO `fw_code` VALUES ('2023733', '9999', '1272', '0268', '3777', '2200');
INSERT INTO `fw_code` VALUES ('2023732', '9999', '1271', '0629', '0987', '7566');
INSERT INTO `fw_code` VALUES ('2023731', '9999', '1270', '5182', '5547', '3610');
INSERT INTO `fw_code` VALUES ('2023730', '9999', '1269', '9307', '5170', '5619');
INSERT INTO `fw_code` VALUES ('2023729', '9999', '1268', '1550', '8587', '4307');
INSERT INTO `fw_code` VALUES ('2023728', '9999', '1267', '3620', '5543', '5816');
INSERT INTO `fw_code` VALUES ('2023727', '9999', '1266', '3045', '0864', '3432');
INSERT INTO `fw_code` VALUES ('2023726', '9999', '1265', '2552', '8202', '0726');
INSERT INTO `fw_code` VALUES ('2023725', '9999', '1264', '5996', '4412', '1843');
INSERT INTO `fw_code` VALUES ('2023724', '9999', '1263', '4073', '7198', '8682');
INSERT INTO `fw_code` VALUES ('2023723', '9999', '1262', '9093', '7702', '8602');
INSERT INTO `fw_code` VALUES ('2023722', '9999', '1261', '5609', '0483', '7646');
INSERT INTO `fw_code` VALUES ('2023721', '9999', '1260', '8920', '1241', '1423');
INSERT INTO `fw_code` VALUES ('2023720', '9999', '1259', '0309', '4785', '2039');
INSERT INTO `fw_code` VALUES ('2023719', '9999', '1258', '0349', '5793', '1878');
INSERT INTO `fw_code` VALUES ('2023718', '9999', '1257', '1911', '5797', '9673');
INSERT INTO `fw_code` VALUES ('2023717', '9999', '1256', '7171', '0487', '5441');
INSERT INTO `fw_code` VALUES ('2023716', '9999', '1255', '4795', '1618', '9414');
INSERT INTO `fw_code` VALUES ('2023715', '9999', '1254', '9200', '6436', '7110');
INSERT INTO `fw_code` VALUES ('2023714', '9999', '1253', '3579', '4535', '5976');
INSERT INTO `fw_code` VALUES ('2023713', '9999', '1252', '2405', '8460', '2378');
INSERT INTO `fw_code` VALUES ('2023712', '9999', '1251', '7384', '7956', '2459');
INSERT INTO `fw_code` VALUES ('2023711', '9999', '1250', '0736', '9721', '6075');
INSERT INTO `fw_code` VALUES ('2023710', '9999', '1249', '3152', '9599', '1941');
INSERT INTO `fw_code` VALUES ('2023709', '9999', '1248', '0522', '2253', '9057');
INSERT INTO `fw_code` VALUES ('2023708', '9999', '1247', '5889', '5678', '3334');
INSERT INTO `fw_code` VALUES ('2023707', '9999', '1246', '1804', '7063', '1164');
INSERT INTO `fw_code` VALUES ('2023706', '9999', '1245', '0202', '6051', '3530');
INSERT INTO `fw_code` VALUES ('2023705', '9999', '1244', '3299', '9340', '0289');
INSERT INTO `fw_code` VALUES ('2023704', '9999', '1243', '9134', '8710', '8441');
INSERT INTO `fw_code` VALUES ('2023703', '9999', '1242', '6250', '2888', '8700');
INSERT INTO `fw_code` VALUES ('2023702', '9999', '1241', '6357', '1622', '7209');
INSERT INTO `fw_code` VALUES ('2023701', '9999', '1240', '4327', '5674', '5539');
INSERT INTO `fw_code` VALUES ('2023700', '9999', '1239', '3859', '9730', '1664');
INSERT INTO `fw_code` VALUES ('2023699', '9999', '1238', '5675', '8210', '6316');
INSERT INTO `fw_code` VALUES ('2023698', '9999', '1237', '5115', '7821', '4941');
INSERT INTO `fw_code` VALUES ('2023697', '9999', '1236', '1977', '3523', '8343');
INSERT INTO `fw_code` VALUES ('2023696', '9999', '1235', '5502', '1749', '9137');
INSERT INTO `fw_code` VALUES ('2023695', '9999', '1234', '3219', '7325', '0611');
INSERT INTO `fw_code` VALUES ('2023694', '9999', '1233', '7852', '3900', '6334');
INSERT INTO `fw_code` VALUES ('2023693', '9999', '1232', '3259', '8333', '0450');
INSERT INTO `fw_code` VALUES ('2023692', '9999', '1231', '8427', '8578', '8717');
INSERT INTO `fw_code` VALUES ('2023691', '9999', '1230', '3753', '0995', '3155');
INSERT INTO `fw_code` VALUES ('2023690', '9999', '1229', '7705', '4158', '7985');
INSERT INTO `fw_code` VALUES ('2023689', '9999', '1228', '4648', '1876', '1066');
INSERT INTO `fw_code` VALUES ('2023688', '9999', '1227', '0161', '5043', '3691');
INSERT INTO `fw_code` VALUES ('2023687', '9999', '1226', '3966', '8464', '0173');
INSERT INTO `fw_code` VALUES ('2023686', '9999', '1225', '3646', '2261', '4646');
INSERT INTO `fw_code` VALUES ('2023685', '9999', '1224', '9734', '0106', '9655');
INSERT INTO `fw_code` VALUES ('2023684', '9999', '1223', '3432', '4793', '7628');
INSERT INTO `fw_code` VALUES ('2023683', '9999', '1222', '3793', '2003', '2994');
INSERT INTO `fw_code` VALUES ('2023682', '9999', '1221', '8346', '6563', '9039');
INSERT INTO `fw_code` VALUES ('2023681', '9999', '1220', '4714', '9603', '9735');
INSERT INTO `fw_code` VALUES ('2023680', '9999', '1219', '6209', '1880', '8860');
INSERT INTO `fw_code` VALUES ('2023679', '9999', '1218', '6504', '1364', '5557');
INSERT INTO `fw_code` VALUES ('2023678', '9999', '1217', '2939', '2130', '4923');
INSERT INTO `fw_code` VALUES ('2023677', '9999', '1216', '2125', '3265', '6691');
INSERT INTO `fw_code` VALUES ('2023676', '9999', '1215', '4114', '8206', '8521');
INSERT INTO `fw_code` VALUES ('2023675', '9999', '1214', '9601', '4654', '2316');
INSERT INTO `fw_code` VALUES ('2023674', '9999', '1213', '8773', '1499', '3075');
INSERT INTO `fw_code` VALUES ('2023673', '9999', '1212', '2231', '1999', '5200');
INSERT INTO `fw_code` VALUES ('2023672', '9999', '1211', '2084', '2257', '6851');
INSERT INTO `fw_code` VALUES ('2023671', '9999', '1210', '3473', '5801', '7468');
INSERT INTO `fw_code` VALUES ('2023670', '9999', '1209', '4434', '4408', '4048');
INSERT INTO `fw_code` VALUES ('2023669', '9999', '1208', '3513', '6809', '7307');
INSERT INTO `fw_code` VALUES ('2023668', '9999', '1207', '5075', '6813', '5101');
INSERT INTO `fw_code` VALUES ('2023667', '9999', '1206', '1336', '1118', '7289');
INSERT INTO `fw_code` VALUES ('2023666', '9999', '1205', '7679', '7440', '9155');
INSERT INTO `fw_code` VALUES ('2023665', '9999', '1204', '1230', '2384', '8780');
INSERT INTO `fw_code` VALUES ('2023664', '9999', '1203', '2975', '8106', '9990');
INSERT INTO `fw_code` VALUES ('2023663', '9999', '1202', '1800', '2031', '6392');
INSERT INTO `fw_code` VALUES ('2023662', '9999', '1201', '2548', '3169', '5955');
INSERT INTO `fw_code` VALUES ('2023661', '9999', '1200', '9918', '5824', '3071');
INSERT INTO `fw_code` VALUES ('2023660', '9999', '1199', '1200', '0634', '5178');
INSERT INTO `fw_code` VALUES ('2023659', '9999', '1198', '9598', '9622', '7544');
INSERT INTO `fw_code` VALUES ('2023658', '9999', '1197', '5645', '6459', '2713');
INSERT INTO `fw_code` VALUES ('2023657', '9999', '1196', '5752', '5193', '1222');
INSERT INTO `fw_code` VALUES ('2023656', '9999', '1195', '3723', '9245', '9553');
INSERT INTO `fw_code` VALUES ('2023655', '9999', '1194', '5259', '2530', '8517');
INSERT INTO `fw_code` VALUES ('2023654', '9999', '1193', '1373', '7094', '2356');
INSERT INTO `fw_code` VALUES ('2023653', '9999', '1192', '7248', '7471', '0347');
INSERT INTO `fw_code` VALUES ('2023652', '9999', '1191', '2655', '1904', '4464');
INSERT INTO `fw_code` VALUES ('2023651', '9999', '1190', '7889', '9876', '1401');
INSERT INTO `fw_code` VALUES ('2023650', '9999', '1189', '4445', '3665', '0285');
INSERT INTO `fw_code` VALUES ('2023649', '9999', '1188', '8850', '8483', '7981');
INSERT INTO `fw_code` VALUES ('2023648', '9999', '1187', '9557', '8614', '7705');
INSERT INTO `fw_code` VALUES ('2023647', '9999', '1186', '2054', '0507', '3249');
INSERT INTO `fw_code` VALUES ('2023646', '9999', '1185', '3189', '5574', '7008');
INSERT INTO `fw_code` VALUES ('2023645', '9999', '1184', '5085', '6070', '1338');
INSERT INTO `fw_code` VALUES ('2023644', '9999', '1183', '9211', '5693', '3347');
INSERT INTO `fw_code` VALUES ('2023643', '9999', '1182', '1454', '9110', '2035');
INSERT INTO `fw_code` VALUES ('2023642', '9999', '1181', '6180', '0130', '5258');
INSERT INTO `fw_code` VALUES ('2023641', '9999', '1180', '5900', '4935', '9571');
INSERT INTO `fw_code` VALUES ('2023640', '9999', '1179', '2334', '5701', '8937');
INSERT INTO `fw_code` VALUES ('2023639', '9999', '1178', '3977', '7721', '6410');
INSERT INTO `fw_code` VALUES ('2023638', '9999', '1177', '1520', '6836', '0704');
INSERT INTO `fw_code` VALUES ('2023637', '9999', '1176', '3509', '1777', '2535');
INSERT INTO `fw_code` VALUES ('2023636', '9999', '1175', '8997', '8225', '6329');
INSERT INTO `fw_code` VALUES ('2023635', '9999', '1174', '1627', '5570', '9213');
INSERT INTO `fw_code` VALUES ('2023634', '9999', '1173', '1480', '5828', '0865');
INSERT INTO `fw_code` VALUES ('2023633', '9999', '1172', '2868', '9372', '1481');
INSERT INTO `fw_code` VALUES ('2023632', '9999', '1171', '3830', '7979', '8062');
INSERT INTO `fw_code` VALUES ('2023631', '9999', '1170', '2909', '0380', '1321');
INSERT INTO `fw_code` VALUES ('2023630', '9999', '1169', '4470', '0384', '9115');
INSERT INTO `fw_code` VALUES ('2023629', '9999', '1168', '0732', '4689', '1303');
INSERT INTO `fw_code` VALUES ('2023628', '9999', '1167', '7354', '6205', '8856');
INSERT INTO `fw_code` VALUES ('2023627', '9999', '1166', '0625', '5955', '2794');
INSERT INTO `fw_code` VALUES ('2023626', '9999', '1165', '3483', '5058', '3704');
INSERT INTO `fw_code` VALUES ('2023625', '9999', '1164', '2308', '8983', '0106');
INSERT INTO `fw_code` VALUES ('2023624', '9999', '1163', '7288', '8479', '0187');
INSERT INTO `fw_code` VALUES ('2023623', '9999', '1162', '3082', '6840', '8499');
INSERT INTO `fw_code` VALUES ('2023622', '9999', '1161', '9771', '6082', '4722');
INSERT INTO `fw_code` VALUES ('2023621', '9999', '1160', '7995', '8610', '9910');
INSERT INTO `fw_code` VALUES ('2023620', '9999', '1159', '5793', '6201', '1062');
INSERT INTO `fw_code` VALUES ('2023619', '9999', '1158', '4364', '1650', '0606');
INSERT INTO `fw_code` VALUES ('2023618', '9999', '1157', '2761', '0638', '2972');
INSERT INTO `fw_code` VALUES ('2023617', '9999', '1156', '1693', '3296', '7883');
INSERT INTO `fw_code` VALUES ('2023616', '9999', '1155', '6154', '3411', '6428');
INSERT INTO `fw_code` VALUES ('2023615', '9999', '1154', '8102', '7344', '8419');
INSERT INTO `fw_code` VALUES ('2023614', '9999', '1153', '5579', '8733', '4044');
INSERT INTO `fw_code` VALUES ('2023613', '9999', '1152', '0412', '8487', '5776');
INSERT INTO `fw_code` VALUES ('2023612', '9999', '1151', '3163', '8856', '8178');
INSERT INTO `fw_code` VALUES ('2023611', '9999', '1150', '1052', '0892', '6830');
INSERT INTO `fw_code` VALUES ('2023610', '9999', '1149', '7609', '4681', '5713');
INSERT INTO `fw_code` VALUES ('2023609', '9999', '1148', '2014', '9499', '3410');
INSERT INTO `fw_code` VALUES ('2023608', '9999', '1147', '5218', '1523', '8678');
INSERT INTO `fw_code` VALUES ('2023607', '9999', '1146', '3550', '2784', '2374');
INSERT INTO `fw_code` VALUES ('2023606', '9999', '1145', '8249', '7086', '6767');
INSERT INTO `fw_code` VALUES ('2023605', '9999', '1144', '9343', '1146', '0687');
INSERT INTO `fw_code` VALUES ('2023604', '9999', '1143', '9063', '5951', '4999');
INSERT INTO `fw_code` VALUES ('2023603', '9999', '1142', '7141', '8737', '1838');
INSERT INTO `fw_code` VALUES ('2023602', '9999', '1141', '4684', '7852', '6133');
INSERT INTO `fw_code` VALUES ('2023601', '9999', '1140', '4257', '2915', '2097');
INSERT INTO `fw_code` VALUES ('2023600', '9999', '1139', '4791', '6586', '4642');
INSERT INTO `fw_code` VALUES ('2023599', '9999', '1138', '6073', '1396', '6749');
INSERT INTO `fw_code` VALUES ('2023598', '9999', '1137', '0518', '7221', '4285');
INSERT INTO `fw_code` VALUES ('2023597', '9999', '1136', '2268', '7975', '0267');
INSERT INTO `fw_code` VALUES ('2023596', '9999', '1135', '6647', '6074', '9133');
INSERT INTO `fw_code` VALUES ('2023595', '9999', '1134', '5472', '9999', '5535');
INSERT INTO `fw_code` VALUES ('2023594', '9999', '1133', '0452', '9495', '5615');
INSERT INTO `fw_code` VALUES ('2023593', '9999', '1132', '3804', '1260', '9231');
INSERT INTO `fw_code` VALUES ('2023592', '9999', '1131', '1159', '9626', '5339');
INSERT INTO `fw_code` VALUES ('2023591', '9999', '1130', '8957', '7217', '6490');
INSERT INTO `fw_code` VALUES ('2023590', '9999', '1129', '1266', '8360', '3847');
INSERT INTO `fw_code` VALUES ('2023589', '9999', '1128', '6927', '1269', '4821');
INSERT INTO `fw_code` VALUES ('2023588', '9999', '1127', '8743', '9749', '9472');
INSERT INTO `fw_code` VALUES ('2023587', '9999', '1126', '0839', '3423', '9812');
INSERT INTO `fw_code` VALUES ('2023586', '9999', '1125', '5045', '5062', '1499');
INSERT INTO `fw_code` VALUES ('2023585', '9999', '1124', '6286', '8864', '3767');
INSERT INTO `fw_code` VALUES ('2023584', '9999', '1123', '6327', '9872', '3606');
INSERT INTO `fw_code` VALUES ('2023583', '9999', '1122', '0772', '5697', '1142');
INSERT INTO `fw_code` VALUES ('2023582', '9999', '1121', '7034', '0003', '3330');
INSERT INTO `fw_code` VALUES ('2023581', '9999', '1120', '6500', '6332', '0785');
INSERT INTO `fw_code` VALUES ('2023580', '9999', '1119', '1413', '8102', '2196');
INSERT INTO `fw_code` VALUES ('2023579', '9999', '1118', '5539', '7725', '4205');
INSERT INTO `fw_code` VALUES ('2023578', '9999', '1117', '7782', '1142', '2892');
INSERT INTO `fw_code` VALUES ('2023577', '9999', '1116', '9277', '3419', '2017');
INSERT INTO `fw_code` VALUES ('2023576', '9999', '1115', '2227', '6967', '0428');
INSERT INTO `fw_code` VALUES ('2023575', '9999', '1114', '0305', '9753', '7267');
INSERT INTO `fw_code` VALUES ('2023574', '9999', '1113', '9391', '9551', '3576');
INSERT INTO `fw_code` VALUES ('2023573', '9999', '1112', '6040', '7785', '9960');
INSERT INTO `fw_code` VALUES ('2023572', '9999', '1111', '8964', '4614', '9541');
INSERT INTO `fw_code` VALUES ('2023571', '9999', '1110', '9351', '8543', '3737');
INSERT INTO `fw_code` VALUES ('2023570', '9999', '1109', '1701', '0694', '0934');
INSERT INTO `fw_code` VALUES ('2023569', '9999', '1108', '0780', '3094', '4192');
INSERT INTO `fw_code` VALUES ('2023568', '9999', '1107', '2342', '3098', '1987');
INSERT INTO `fw_code` VALUES ('2023567', '9999', '1106', '5226', '8920', '1728');
INSERT INTO `fw_code` VALUES ('2023566', '9999', '1105', '4010', '1836', '8291');
INSERT INTO `fw_code` VALUES ('2023565', '9999', '1104', '7815', '5257', '4773');
INSERT INTO `fw_code` VALUES ('2023564', '9999', '1103', '3583', '6900', '4255');
INSERT INTO `fw_code` VALUES ('2023563', '9999', '1102', '7642', '8797', '7594');
INSERT INTO `fw_code` VALUES ('2023562', '9999', '1101', '5867', '1324', '2782');
INSERT INTO `fw_code` VALUES ('2023561', '9999', '1100', '6320', '2979', '5648');
INSERT INTO `fw_code` VALUES ('2023560', '9999', '1099', '2235', '4364', '3478');
INSERT INTO `fw_code` VALUES ('2023559', '9999', '1098', '0633', '3352', '5844');
INSERT INTO `fw_code` VALUES ('2023558', '9999', '1097', '9565', '6011', '0755');
INSERT INTO `fw_code` VALUES ('2023557', '9999', '1096', '4758', '2975', '7853');
INSERT INTO `fw_code` VALUES ('2023556', '9999', '1095', '5973', '0059', '1291');
INSERT INTO `fw_code` VALUES ('2023555', '9999', '1094', '4290', '7031', '3978');
INSERT INTO `fw_code` VALUES ('2023554', '9999', '1093', '6106', '5511', '8630');
INSERT INTO `fw_code` VALUES ('2023553', '9999', '1092', '6294', '6261', '6817');
INSERT INTO `fw_code` VALUES ('2023552', '9999', '1091', '5933', '9051', '1451');
INSERT INTO `fw_code` VALUES ('2023551', '9999', '1090', '8283', '1202', '8648');
INSERT INTO `fw_code` VALUES ('2023550', '9999', '1089', '3690', '5634', '2764');
INSERT INTO `fw_code` VALUES ('2023549', '9999', '1088', '8924', '3606', '9701');
INSERT INTO `fw_code` VALUES ('2023548', '9999', '1087', '8857', '5880', '1032');
INSERT INTO `fw_code` VALUES ('2023547', '9999', '1086', '9885', '2213', '6282');
INSERT INTO `fw_code` VALUES ('2023546', '9999', '1085', '3089', '4237', '1550');
INSERT INTO `fw_code` VALUES ('2023545', '9999', '1084', '4397', '5765', '2487');
INSERT INTO `fw_code` VALUES ('2023544', '9999', '1083', '0165', '7408', '1969');
INSERT INTO `fw_code` VALUES ('2023543', '9999', '1082', '0246', '9424', '1648');
INSERT INTO `fw_code` VALUES ('2023542', '9999', '1081', '6935', '8666', '7871');
INSERT INTO `fw_code` VALUES ('2023541', '9999', '1080', '3369', '9432', '7237');
INSERT INTO `fw_code` VALUES ('2023540', '9999', '1079', '5012', '1451', '4710');
INSERT INTO `fw_code` VALUES ('2023539', '9999', '1078', '0032', '1955', '4630');
INSERT INTO `fw_code` VALUES ('2023538', '9999', '1077', '9204', '8801', '5389');
INSERT INTO `fw_code` VALUES ('2023537', '9999', '1076', '2128', '5630', '4969');
INSERT INTO `fw_code` VALUES ('2023536', '9999', '1075', '4865', '1710', '6362');
INSERT INTO `fw_code` VALUES ('2023535', '9999', '1074', '3944', '4110', '9621');
INSERT INTO `fw_code` VALUES ('2023534', '9999', '1073', '5506', '4114', '7416');
INSERT INTO `fw_code` VALUES ('2023533', '9999', '1072', '8110', '4741', '1469');
INSERT INTO `fw_code` VALUES ('2023532', '9999', '1071', '0139', '0689', '3139');
INSERT INTO `fw_code` VALUES ('2023531', '9999', '1070', '8323', '2209', '8487');
INSERT INTO `fw_code` VALUES ('2023530', '9999', '1069', '5399', '5380', '8907');
INSERT INTO `fw_code` VALUES ('2023529', '9999', '1068', '7922', '3991', '3282');
INSERT INTO `fw_code` VALUES ('2023528', '9999', '1067', '4798', '3983', '7692');
INSERT INTO `fw_code` VALUES ('2023527', '9999', '1066', '6614', '2463', '2344');
INSERT INTO `fw_code` VALUES ('2023526', '9999', '1065', '9458', '7277', '2246');
INSERT INTO `fw_code` VALUES ('2023525', '9999', '1064', '8710', '6138', '2684');
INSERT INTO `fw_code` VALUES ('2023524', '9999', '1063', '5572', '1841', '6085');
INSERT INTO `fw_code` VALUES ('2023523', '9999', '1062', '9097', '0067', '6880');
INSERT INTO `fw_code` VALUES ('2023522', '9999', '1061', '4157', '1578', '6639');
INSERT INTO `fw_code` VALUES ('2023521', '9999', '1060', '1447', '2217', '4076');
INSERT INTO `fw_code` VALUES ('2023520', '9999', '1059', '2088', '4622', '5130');
INSERT INTO `fw_code` VALUES ('2023519', '9999', '1058', '4692', '5249', '9183');
INSERT INTO `fw_code` VALUES ('2023518', '9999', '1057', '8644', '8412', '4014');
INSERT INTO `fw_code` VALUES ('2023517', '9999', '1056', '3049', '3229', '1710');
INSERT INTO `fw_code` VALUES ('2023516', '9999', '1055', '3756', '3360', '1434');
INSERT INTO `fw_code` VALUES ('2023515', '9999', '1054', '6253', '5253', '6978');
INSERT INTO `fw_code` VALUES ('2023514', '9999', '1053', '4905', '2717', '6201');
INSERT INTO `fw_code` VALUES ('2023513', '9999', '1052', '4585', '6515', '0675');
INSERT INTO `fw_code` VALUES ('2023512', '9999', '1051', '0673', '4360', '5683');
INSERT INTO `fw_code` VALUES ('2023511', '9999', '1050', '7388', '0321', '0737');
INSERT INTO `fw_code` VALUES ('2023510', '9999', '1049', '9285', '0816', '5067');
INSERT INTO `fw_code` VALUES ('2023509', '9999', '1048', '3410', '0440', '7076');
INSERT INTO `fw_code` VALUES ('2023508', '9999', '1047', '5653', '3856', '5764');
INSERT INTO `fw_code` VALUES ('2023507', '9999', '1046', '0379', '4876', '8987');
INSERT INTO `fw_code` VALUES ('2023506', '9999', '1045', '7148', '6134', '4889');
INSERT INTO `fw_code` VALUES ('2023505', '9999', '1044', '0099', '9682', '3300');
INSERT INTO `fw_code` VALUES ('2023504', '9999', '1043', '8176', '2467', '0139');
INSERT INTO `fw_code` VALUES ('2023503', '9999', '1042', '3196', '2971', '0058');
INSERT INTO `fw_code` VALUES ('2023502', '9999', '1041', '9712', '5753', '9103');
INSERT INTO `fw_code` VALUES ('2023501', '9999', '1040', '5679', '0575', '4594');
INSERT INTO `fw_code` VALUES ('2023500', '9999', '1039', '8029', '2725', '1791');
INSERT INTO `fw_code` VALUES ('2023499', '9999', '1038', '8670', '5130', '2844');
INSERT INTO `fw_code` VALUES ('2023498', '9999', '1037', '1554', '0952', '2585');
INSERT INTO `fw_code` VALUES ('2023497', '9999', '1036', '4824', '0702', '6523');
INSERT INTO `fw_code` VALUES ('2023496', '9999', '1035', '3303', '1705', '8567');
INSERT INTO `fw_code` VALUES ('2023495', '9999', '1034', '7682', '9805', '7433');
INSERT INTO `fw_code` VALUES ('2023494', '9999', '1033', '6507', '3729', '3835');
INSERT INTO `fw_code` VALUES ('2023493', '9999', '1032', '7495', '9055', '9246');
INSERT INTO `fw_code` VALUES ('2023492', '9999', '1031', '7255', '4868', '3398');
INSERT INTO `fw_code` VALUES ('2023491', '9999', '1030', '7281', '1587', '2228');
INSERT INTO `fw_code` VALUES ('2023490', '9999', '1029', '9992', '0948', '4791');
INSERT INTO `fw_code` VALUES ('2023489', '9999', '1028', '8563', '6396', '4335');
INSERT INTO `fw_code` VALUES ('2023488', '9999', '1027', '0353', '8158', '0157');
INSERT INTO `fw_code` VALUES ('2023487', '9999', '1026', '0459', '6892', '8666');
INSERT INTO `fw_code` VALUES ('2023486', '9999', '1025', '8430', '0943', '6996');
INSERT INTO `fw_code` VALUES ('2023485', '9999', '1024', '7962', '4999', '3121');
INSERT INTO `fw_code` VALUES ('2023484', '9999', '1023', '1874', '7154', '8112');
INSERT INTO `fw_code` VALUES ('2023483', '9999', '1022', '9605', '7019', '0594');
INSERT INTO `fw_code` VALUES ('2023482', '9999', '1021', '4611', '3233', '9505');
INSERT INTO `fw_code` VALUES ('2023481', '9999', '1020', '7362', '3602', '1907');
INSERT INTO `fw_code` VALUES ('2023480', '9999', '1019', '7856', '6265', '4612');
INSERT INTO `fw_code` VALUES ('2023479', '9999', '1018', '1808', '9428', '9442');
INSERT INTO `fw_code` VALUES ('2023478', '9999', '1017', '8750', '7146', '2523');
INSERT INTO `fw_code` VALUES ('2023477', '9999', '1016', '6213', '4245', '7139');
INSERT INTO `fw_code` VALUES ('2023476', '9999', '1015', '8069', '3733', '1630');
INSERT INTO `fw_code` VALUES ('2023475', '9999', '1014', '7749', '7531', '6103');
INSERT INTO `fw_code` VALUES ('2023474', '9999', '1013', '3837', '5376', '1112');
INSERT INTO `fw_code` VALUES ('2023473', '9999', '1012', '7535', '0063', '9085');
INSERT INTO `fw_code` VALUES ('2023472', '9999', '1011', '7896', '7273', '4451');
INSERT INTO `fw_code` VALUES ('2023471', '9999', '1010', '6574', '1456', '2505');
INSERT INTO `fw_code` VALUES ('2023470', '9999', '1009', '5078', '7339', '0041');
INSERT INTO `fw_code` VALUES ('2023469', '9999', '1008', '9804', '8359', '3265');
INSERT INTO `fw_code` VALUES ('2023468', '9999', '1007', '6573', '9617', '9166');
INSERT INTO `fw_code` VALUES ('2023467', '9999', '1006', '6080', '6954', '6461');
INSERT INTO `fw_code` VALUES ('2023466', '9999', '1005', '9524', '3165', '7577');
INSERT INTO `fw_code` VALUES ('2023465', '9999', '1004', '3302', '9867', '5229');
INSERT INTO `fw_code` VALUES ('2023464', '9999', '1003', '7601', '5950', '4416');
INSERT INTO `fw_code` VALUES ('2023463', '9999', '1002', '5144', '5066', '8711');
INSERT INTO `fw_code` VALUES ('2023462', '9999', '1001', '4477', '5942', '8827');
INSERT INTO `fw_code` VALUES ('2023461', '9999', '1000', '2621', '6454', '4336');
INSERT INTO `fw_code` VALUES ('2023460', '9999', '999', '9137', '9236', '3381');
INSERT INTO `fw_code` VALUES ('2023459', '9999', '998', '4717', '0129', '4675');
INSERT INTO `fw_code` VALUES ('2023458', '9999', '997', '5251', '3800', '7220');
INSERT INTO `fw_code` VALUES ('2023457', '9999', '996', '2448', '9994', '7157');
INSERT INTO `fw_code` VALUES ('2023456', '9999', '995', '3836', '3537', '7773');
INSERT INTO `fw_code` VALUES ('2023455', '9999', '994', '6533', '8609', '9327');
INSERT INTO `fw_code` VALUES ('2023454', '9999', '993', '5439', '4549', '5407');
INSERT INTO `fw_code` VALUES ('2023453', '9999', '992', '1700', '8855', '7595');
INSERT INTO `fw_code` VALUES ('2023452', '9999', '991', '0698', '9240', '1175');
INSERT INTO `fw_code` VALUES ('2023451', '9999', '990', '0978', '4435', '6863');
INSERT INTO `fw_code` VALUES ('2023450', '9999', '989', '1593', '0121', '9086');
INSERT INTO `fw_code` VALUES ('2023449', '9999', '988', '2728', '5188', '2845');
INSERT INTO `fw_code` VALUES ('2023448', '9999', '987', '7107', '3288', '1711');
INSERT INTO `fw_code` VALUES ('2023447', '9999', '986', '5932', '7212', '8113');
INSERT INTO `fw_code` VALUES ('2023446', '9999', '985', '0912', '6708', '8193');
INSERT INTO `fw_code` VALUES ('2023445', '9999', '984', '4264', '8474', '1809');
INSERT INTO `fw_code` VALUES ('2023444', '9999', '983', '6680', '8351', '7675');
INSERT INTO `fw_code` VALUES ('2023443', '9999', '982', '0739', '0248', '1014');
INSERT INTO `fw_code` VALUES ('2023442', '9999', '981', '1619', '6839', '7917');
INSERT INTO `fw_code` VALUES ('2023441', '9999', '980', '9417', '4431', '9068');
INSERT INTO `fw_code` VALUES ('2023440', '9999', '979', '5332', '5815', '6898');
INSERT INTO `fw_code` VALUES ('2023439', '9999', '978', '3730', '4803', '9264');
INSERT INTO `fw_code` VALUES ('2023438', '9999', '977', '6827', '8093', '6023');
INSERT INTO `fw_code` VALUES ('2023437', '9999', '976', '2662', '7462', '4175');
INSERT INTO `fw_code` VALUES ('2023436', '9999', '975', '9884', '0375', '2943');
INSERT INTO `fw_code` VALUES ('2023435', '9999', '974', '7855', '4426', '1273');
INSERT INTO `fw_code` VALUES ('2023434', '9999', '973', '1726', '5573', '6425');
INSERT INTO `fw_code` VALUES ('2023433', '9999', '972', '7387', '8482', '7399');
INSERT INTO `fw_code` VALUES ('2023432', '9999', '971', '9203', '6962', '2050');
INSERT INTO `fw_code` VALUES ('2023431', '9999', '970', '2047', '1776', '1952');
INSERT INTO `fw_code` VALUES ('2023430', '9999', '969', '1299', '0637', '2390');
INSERT INTO `fw_code` VALUES ('2023429', '9999', '968', '5505', '2276', '4077');
INSERT INTO `fw_code` VALUES ('2023428', '9999', '967', '9030', '0502', '4872');
INSERT INTO `fw_code` VALUES ('2023427', '9999', '966', '6746', '6077', '6345');
INSERT INTO `fw_code` VALUES ('2023426', '9999', '965', '1380', '2653', '2068');
INSERT INTO `fw_code` VALUES ('2023425', '9999', '964', '6787', '7085', '6184');
INSERT INTO `fw_code` VALUES ('2023424', '9999', '963', '2021', '5057', '3122');
INSERT INTO `fw_code` VALUES ('2023423', '9999', '962', '4610', '1395', '6166');
INSERT INTO `fw_code` VALUES ('2023422', '9999', '961', '7280', '9748', '8890');
INSERT INTO `fw_code` VALUES ('2023421', '9999', '960', '1233', '2911', '3720');
INSERT INTO `fw_code` VALUES ('2023420', '9999', '959', '8175', '0629', '6800');
INSERT INTO `fw_code` VALUES ('2023419', '9999', '958', '2982', '3664', '9702');
INSERT INTO `fw_code` VALUES ('2023418', '9999', '957', '3689', '3796', '9425');
INSERT INTO `fw_code` VALUES ('2023417', '9999', '956', '6186', '5688', '4970');
INSERT INTO `fw_code` VALUES ('2023416', '9999', '955', '7494', '7216', '5908');
INSERT INTO `fw_code` VALUES ('2023415', '9999', '954', '7174', '1014', '0381');
INSERT INTO `fw_code` VALUES ('2023414', '9999', '953', '3262', '8859', '5390');
INSERT INTO `fw_code` VALUES ('2023413', '9999', '952', '6960', '3546', '3363');
INSERT INTO `fw_code` VALUES ('2023412', '9999', '951', '7321', '0756', '8729');
INSERT INTO `fw_code` VALUES ('2023411', '9999', '950', '1873', '5315', '4774');
INSERT INTO `fw_code` VALUES ('2023410', '9999', '949', '5999', '4939', '6783');
INSERT INTO `fw_code` VALUES ('2023409', '9999', '948', '8242', '8355', '5470');
INSERT INTO `fw_code` VALUES ('2023408', '9999', '947', '0312', '5311', '6979');
INSERT INTO `fw_code` VALUES ('2023407', '9999', '946', '9737', '0633', '4595');
INSERT INTO `fw_code` VALUES ('2023406', '9999', '945', '9244', '7970', '1890');
INSERT INTO `fw_code` VALUES ('2023405', '9999', '944', '2687', '4181', '3006');
INSERT INTO `fw_code` VALUES ('2023404', '9999', '943', '6466', '0883', '0657');
INSERT INTO `fw_code` VALUES ('2023403', '9999', '942', '0765', '6966', '9845');
INSERT INTO `fw_code` VALUES ('2023402', '9999', '941', '7641', '6958', '4256');
INSERT INTO `fw_code` VALUES ('2023401', '9999', '940', '5785', '7470', '9765');
INSERT INTO `fw_code` VALUES ('2023400', '9999', '939', '2301', '0252', '8809');
INSERT INTO `fw_code` VALUES ('2023399', '9999', '938', '5225', '7081', '8389');
INSERT INTO `fw_code` VALUES ('2023398', '9999', '937', '5612', '1010', '2586');
INSERT INTO `fw_code` VALUES ('2023397', '9999', '936', '7000', '4553', '3202');
INSERT INTO `fw_code` VALUES ('2023396', '9999', '935', '7041', '5561', '3041');
INSERT INTO `fw_code` VALUES ('2023395', '9999', '934', '8603', '5565', '0836');
INSERT INTO `fw_code` VALUES ('2023394', '9999', '933', '4864', '9871', '3023');
INSERT INTO `fw_code` VALUES ('2023393', '9999', '932', '3862', '0256', '6604');
INSERT INTO `fw_code` VALUES ('2023392', '9999', '931', '4757', '1137', '4515');
INSERT INTO `fw_code` VALUES ('2023391', '9999', '930', '5892', '6204', '8274');
INSERT INTO `fw_code` VALUES ('2023390', '9999', '929', '0271', '4304', '7140');
INSERT INTO `fw_code` VALUES ('2023389', '9999', '928', '9096', '8228', '3541');
INSERT INTO `fw_code` VALUES ('2023388', '9999', '927', '4076', '7724', '3622');
INSERT INTO `fw_code` VALUES ('2023387', '9999', '926', '7428', '9490', '7238');
INSERT INTO `fw_code` VALUES ('2023386', '9999', '925', '9844', '9367', '3104');
INSERT INTO `fw_code` VALUES ('2023385', '9999', '924', '7214', '2022', '0220');
INSERT INTO `fw_code` VALUES ('2023384', '9999', '923', '3903', '1264', '6443');
INSERT INTO `fw_code` VALUES ('2023383', '9999', '922', '2127', '3791', '1631');
INSERT INTO `fw_code` VALUES ('2023382', '9999', '921', '2581', '5447', '4497');
INSERT INTO `fw_code` VALUES ('2023381', '9999', '920', '8496', '6831', '2327');
INSERT INTO `fw_code` VALUES ('2023380', '9999', '919', '6894', '5819', '4693');
INSERT INTO `fw_code` VALUES ('2023379', '9999', '918', '9991', '9109', '1452');
INSERT INTO `fw_code` VALUES ('2023378', '9999', '917', '5826', '8478', '9604');
INSERT INTO `fw_code` VALUES ('2023377', '9999', '916', '2942', '2657', '9863');
INSERT INTO `fw_code` VALUES ('2023376', '9999', '915', '3048', '1391', '8372');
INSERT INTO `fw_code` VALUES ('2023375', '9999', '914', '1019', '5442', '6702');
INSERT INTO `fw_code` VALUES ('2023374', '9999', '913', '0551', '9498', '2827');
INSERT INTO `fw_code` VALUES ('2023373', '9999', '912', '2367', '7978', '7479');
INSERT INTO `fw_code` VALUES ('2023372', '9999', '911', '2555', '8728', '5666');
INSERT INTO `fw_code` VALUES ('2023371', '9999', '910', '1807', '7589', '6104');
INSERT INTO `fw_code` VALUES ('2023370', '9999', '909', '8669', '3292', '9506');
INSERT INTO `fw_code` VALUES ('2023369', '9999', '908', '2194', '1518', '0300');
INSERT INTO `fw_code` VALUES ('2023368', '9999', '907', '9910', '7093', '1774');
INSERT INTO `fw_code` VALUES ('2023367', '9999', '906', '4544', '3669', '7497');
INSERT INTO `fw_code` VALUES ('2023366', '9999', '905', '9951', '8101', '1613');
INSERT INTO `fw_code` VALUES ('2023365', '9999', '904', '5185', '6073', '8550');
INSERT INTO `fw_code` VALUES ('2023364', '9999', '903', '5118', '8347', '9881');
INSERT INTO `fw_code` VALUES ('2023363', '9999', '902', '0444', '0764', '4318');
INSERT INTO `fw_code` VALUES ('2023362', '9999', '901', '4396', '3927', '9149');
INSERT INTO `fw_code` VALUES ('2023361', '9999', '900', '1339', '1645', '2229');
INSERT INTO `fw_code` VALUES ('2023360', '9999', '899', '6146', '4680', '5131');
INSERT INTO `fw_code` VALUES ('2023359', '9999', '898', '6853', '4812', '4854');
INSERT INTO `fw_code` VALUES ('2023358', '9999', '897', '9350', '6704', '0398');
INSERT INTO `fw_code` VALUES ('2023357', '9999', '896', '0658', '8232', '1336');
INSERT INTO `fw_code` VALUES ('2023356', '9999', '895', '0338', '2030', '5809');
INSERT INTO `fw_code` VALUES ('2023355', '9999', '894', '6426', '9875', '0818');
INSERT INTO `fw_code` VALUES ('2023354', '9999', '893', '0124', '4562', '8792');
INSERT INTO `fw_code` VALUES ('2023353', '9999', '892', '0485', '1772', '4157');
INSERT INTO `fw_code` VALUES ('2023352', '9999', '891', '5037', '6331', '0202');
INSERT INTO `fw_code` VALUES ('2023351', '9999', '890', '1406', '9371', '0899');
INSERT INTO `fw_code` VALUES ('2023350', '9999', '889', '3476', '6327', '2407');
INSERT INTO `fw_code` VALUES ('2023349', '9999', '888', '2901', '1649', '0024');
INSERT INTO `fw_code` VALUES ('2023348', '9999', '887', '2407', '8986', '7318');
INSERT INTO `fw_code` VALUES ('2023347', '9999', '886', '9630', '1899', '6086');
INSERT INTO `fw_code` VALUES ('2023346', '9999', '885', '1273', '3918', '3559');
INSERT INTO `fw_code` VALUES ('2023345', '9999', '884', '0805', '7974', '9684');
INSERT INTO `fw_code` VALUES ('2023344', '9999', '883', '6293', '4422', '3479');
INSERT INTO `fw_code` VALUES ('2023343', '9999', '882', '5465', '1268', '4238');
INSERT INTO `fw_code` VALUES ('2023342', '9999', '881', '8389', '8097', '3818');
INSERT INTO `fw_code` VALUES ('2023341', '9999', '880', '8776', '2026', '8015');
INSERT INTO `fw_code` VALUES ('2023340', '9999', '879', '0164', '5569', '8631');
INSERT INTO `fw_code` VALUES ('2023339', '9999', '878', '1126', '4177', '5211');
INSERT INTO `fw_code` VALUES ('2023338', '9999', '877', '0205', '6577', '8470');
INSERT INTO `fw_code` VALUES ('2023337', '9999', '876', '1767', '6581', '6265');
INSERT INTO `fw_code` VALUES ('2023336', '9999', '875', '8028', '0887', '8452');
INSERT INTO `fw_code` VALUES ('2023335', '9999', '874', '4371', '7208', '0318');
INSERT INTO `fw_code` VALUES ('2023334', '9999', '873', '4651', '2403', '6006');
INSERT INTO `fw_code` VALUES ('2023333', '9999', '872', '7921', '2153', '9943');
INSERT INTO `fw_code` VALUES ('2023332', '9999', '871', '6400', '3156', '1988');
INSERT INTO `fw_code` VALUES ('2023331', '9999', '870', '3435', '5320', '2568');
INSERT INTO `fw_code` VALUES ('2023330', '9999', '869', '2260', '9244', '8970');
INSERT INTO `fw_code` VALUES ('2023329', '9999', '868', '4584', '4676', '7336');
INSERT INTO `fw_code` VALUES ('2023328', '9999', '867', '0592', '0506', '2666');
INSERT INTO `fw_code` VALUES ('2023327', '9999', '866', '3008', '0383', '8533');
INSERT INTO `fw_code` VALUES ('2023326', '9999', '865', '0378', '3038', '5649');
INSERT INTO `fw_code` VALUES ('2023325', '9999', '864', '7067', '2280', '1872');
INSERT INTO `fw_code` VALUES ('2023324', '9999', '863', '5291', '4807', '7059');
INSERT INTO `fw_code` VALUES ('2023323', '9999', '862', '1660', '7847', '7756');
INSERT INTO `fw_code` VALUES ('2023322', '9999', '861', '0058', '6835', '0122');
INSERT INTO `fw_code` VALUES ('2023321', '9999', '860', '3155', '0125', '6881');
INSERT INTO `fw_code` VALUES ('2023320', '9999', '859', '8989', '9494', '5032');
INSERT INTO `fw_code` VALUES ('2023319', '9999', '858', '6105', '3673', '5291');
INSERT INTO `fw_code` VALUES ('2023318', '9999', '857', '6212', '2407', '3800');
INSERT INTO `fw_code` VALUES ('2023317', '9999', '856', '4183', '6458', '2131');
INSERT INTO `fw_code` VALUES ('2023316', '9999', '855', '5398', '3542', '5568');
INSERT INTO `fw_code` VALUES ('2023315', '9999', '854', '1059', '6450', '6541');
INSERT INTO `fw_code` VALUES ('2023314', '9999', '853', '2875', '4930', '1193');
INSERT INTO `fw_code` VALUES ('2023313', '9999', '852', '5719', '9744', '1095');
INSERT INTO `fw_code` VALUES ('2023312', '9999', '851', '4971', '8605', '1532');
INSERT INTO `fw_code` VALUES ('2023311', '9999', '850', '1833', '4308', '4934');
INSERT INTO `fw_code` VALUES ('2023310', '9999', '849', '5358', '2534', '5729');
INSERT INTO `fw_code` VALUES ('2023309', '9999', '848', '0418', '4045', '5488');
INSERT INTO `fw_code` VALUES ('2023308', '9999', '847', '7708', '4685', '2925');
INSERT INTO `fw_code` VALUES ('2023307', '9999', '846', '3115', '9117', '7042');
INSERT INTO `fw_code` VALUES ('2023306', '9999', '845', '8349', '7089', '3979');
INSERT INTO `fw_code` VALUES ('2023305', '9999', '844', '8282', '9363', '5309');
INSERT INTO `fw_code` VALUES ('2023304', '9999', '843', '0953', '7716', '8032');
INSERT INTO `fw_code` VALUES ('2023303', '9999', '842', '4503', '2661', '7658');
INSERT INTO `fw_code` VALUES ('2023302', '9999', '841', '9310', '5696', '0559');
INSERT INTO `fw_code` VALUES ('2023301', '9999', '840', '0017', '5827', '0283');
INSERT INTO `fw_code` VALUES ('2023300', '9999', '839', '2514', '7720', '5827');
INSERT INTO `fw_code` VALUES ('2023299', '9999', '838', '1166', '5184', '5050');
INSERT INTO `fw_code` VALUES ('2023298', '9999', '837', '0846', '8982', '9523');
INSERT INTO `fw_code` VALUES ('2023297', '9999', '836', '6934', '6827', '4532');
INSERT INTO `fw_code` VALUES ('2023296', '9999', '835', '3649', '2788', '9586');
INSERT INTO `fw_code` VALUES ('2023295', '9999', '834', '5546', '3283', '3916');
INSERT INTO `fw_code` VALUES ('2023294', '9999', '833', '8146', '8878', '3198');
INSERT INTO `fw_code` VALUES ('2023293', '9999', '832', '2871', '9898', '6421');
INSERT INTO `fw_code` VALUES ('2023292', '9999', '831', '9641', '1156', '2323');
INSERT INTO `fw_code` VALUES ('2023291', '9999', '830', '1803', '2557', '1332');
INSERT INTO `fw_code` VALUES ('2023290', '9999', '829', '2591', '4704', '0734');
INSERT INTO `fw_code` VALUES ('2023289', '9999', '828', '9026', '5470', '0100');
INSERT INTO `fw_code` VALUES ('2023288', '9999', '827', '0669', '7489', '7573');
INSERT INTO `fw_code` VALUES ('2023287', '9999', '826', '8212', '6604', '1868');
INSERT INTO `fw_code` VALUES ('2023286', '9999', '825', '0201', '1545', '3698');
INSERT INTO `fw_code` VALUES ('2023285', '9999', '824', '5689', '7993', '7493');
INSERT INTO `fw_code` VALUES ('2023284', '9999', '823', '2204', '0775', '6537');
INSERT INTO `fw_code` VALUES ('2023283', '9999', '822', '7785', '1668', '7832');
INSERT INTO `fw_code` VALUES ('2023282', '9999', '821', '8319', '5339', '0377');
INSERT INTO `fw_code` VALUES ('2023281', '9999', '820', '8171', '5597', '2029');
INSERT INTO `fw_code` VALUES ('2023280', '9999', '819', '9560', '9140', '2645');
INSERT INTO `fw_code` VALUES ('2023279', '9999', '818', '0521', '7747', '9225');
INSERT INTO `fw_code` VALUES ('2023278', '9999', '817', '9600', '0148', '2484');
INSERT INTO `fw_code` VALUES ('2023277', '9999', '816', '1162', '0152', '0278');
INSERT INTO `fw_code` VALUES ('2023276', '9999', '815', '7424', '4458', '2466');
INSERT INTO `fw_code` VALUES ('2023275', '9999', '814', '3766', '0779', '4332');
INSERT INTO `fw_code` VALUES ('2023274', '9999', '813', '4046', '5974', '0020');
INSERT INTO `fw_code` VALUES ('2023273', '9999', '812', '7317', '5724', '3957');
INSERT INTO `fw_code` VALUES ('2023272', '9999', '811', '5796', '6727', '6001');
INSERT INTO `fw_code` VALUES ('2023271', '9999', '810', '0175', '4827', '4868');
INSERT INTO `fw_code` VALUES ('2023270', '9999', '809', '9000', '8751', '1269');
INSERT INTO `fw_code` VALUES ('2023269', '9999', '808', '3980', '8247', '1350');
INSERT INTO `fw_code` VALUES ('2023268', '9999', '807', '9987', '4077', '6680');
INSERT INTO `fw_code` VALUES ('2023267', '9999', '806', '9748', '9890', '0832');
INSERT INTO `fw_code` VALUES ('2023266', '9999', '805', '9774', '6609', '9662');
INSERT INTO `fw_code` VALUES ('2023265', '9999', '804', '6462', '5851', '5886');
INSERT INTO `fw_code` VALUES ('2023264', '9999', '803', '4687', '8378', '1073');
INSERT INTO `fw_code` VALUES ('2023263', '9999', '802', '2484', '5969', '2225');
INSERT INTO `fw_code` VALUES ('2023262', '9999', '801', '1055', '1418', '1770');
INSERT INTO `fw_code` VALUES ('2023261', '9999', '800', '9453', '0406', '4136');
INSERT INTO `fw_code` VALUES ('2023260', '9999', '799', '2551', '3696', '0895');
INSERT INTO `fw_code` VALUES ('2023259', '9999', '798', '8385', '3065', '9046');
INSERT INTO `fw_code` VALUES ('2023258', '9999', '797', '2952', '1914', '6100');
INSERT INTO `fw_code` VALUES ('2023257', '9999', '796', '0923', '5965', '4430');
INSERT INTO `fw_code` VALUES ('2023256', '9999', '795', '4794', '7112', '9582');
INSERT INTO `fw_code` VALUES ('2023255', '9999', '794', '0455', '0021', '0555');
INSERT INTO `fw_code` VALUES ('2023254', '9999', '793', '2271', '8501', '5207');
INSERT INTO `fw_code` VALUES ('2023253', '9999', '792', '5114', '3315', '5109');
INSERT INTO `fw_code` VALUES ('2023252', '9999', '791', '4367', '2176', '5546');
INSERT INTO `fw_code` VALUES ('2023251', '9999', '790', '2098', '2041', '8028');
INSERT INTO `fw_code` VALUES ('2023250', '9999', '789', '9814', '7616', '9502');
INSERT INTO `fw_code` VALUES ('2023249', '9999', '788', '7103', '8255', '6939');
INSERT INTO `fw_code` VALUES ('2023248', '9999', '787', '9855', '8624', '9341');
INSERT INTO `fw_code` VALUES ('2023247', '9999', '786', '7744', '0660', '7993');
INSERT INTO `fw_code` VALUES ('2023246', '9999', '785', '7678', '2934', '9323');
INSERT INTO `fw_code` VALUES ('2023245', '9999', '784', '0348', '1287', '2046');
INSERT INTO `fw_code` VALUES ('2023244', '9999', '783', '1243', '2168', '9957');
INSERT INTO `fw_code` VALUES ('2023243', '9999', '782', '8706', '9267', '4573');
INSERT INTO `fw_code` VALUES ('2023242', '9999', '781', '1910', '1291', '9841');
INSERT INTO `fw_code` VALUES ('2023241', '9999', '780', '0562', '8755', '9064');
INSERT INTO `fw_code` VALUES ('2023240', '9999', '779', '0241', '2553', '3537');
INSERT INTO `fw_code` VALUES ('2023239', '9999', '778', '6330', '0398', '8546');
INSERT INTO `fw_code` VALUES ('2023238', '9999', '777', '0028', '5085', '6519');
INSERT INTO `fw_code` VALUES ('2023237', '9999', '776', '0389', '2295', '1885');
INSERT INTO `fw_code` VALUES ('2023236', '9999', '775', '4941', '6854', '7930');
INSERT INTO `fw_code` VALUES ('2023235', '9999', '774', '9066', '6477', '9939');
INSERT INTO `fw_code` VALUES ('2023234', '9999', '773', '1309', '9894', '8627');
INSERT INTO `fw_code` VALUES ('2023233', '9999', '772', '6035', '0914', '1850');
INSERT INTO `fw_code` VALUES ('2023232', '9999', '771', '2805', '2172', '7752');
INSERT INTO `fw_code` VALUES ('2023231', '9999', '770', '2311', '9509', '5046');
INSERT INTO `fw_code` VALUES ('2023230', '9999', '769', '5755', '5720', '6162');
INSERT INTO `fw_code` VALUES ('2023229', '9999', '768', '9534', '2422', '3814');
INSERT INTO `fw_code` VALUES ('2023228', '9999', '767', '3833', '8505', '3002');
INSERT INTO `fw_code` VALUES ('2023227', '9999', '766', '1376', '7620', '7296');
INSERT INTO `fw_code` VALUES ('2023226', '9999', '765', '0709', '8497', '7412');
INSERT INTO `fw_code` VALUES ('2023225', '9999', '764', '8853', '9009', '2921');
INSERT INTO `fw_code` VALUES ('2023224', '9999', '763', '5368', '1791', '1966');
INSERT INTO `fw_code` VALUES ('2023223', '9999', '762', '0949', '2684', '3261');
INSERT INTO `fw_code` VALUES ('2023222', '9999', '761', '1483', '6355', '5805');
INSERT INTO `fw_code` VALUES ('2023221', '9999', '760', '8680', '2549', '5743');
INSERT INTO `fw_code` VALUES ('2023220', '9999', '759', '0068', '6092', '6359');
INSERT INTO `fw_code` VALUES ('2023219', '9999', '758', '2764', '1164', '7912');
INSERT INTO `fw_code` VALUES ('2023218', '9999', '757', '1670', '7104', '3992');
INSERT INTO `fw_code` VALUES ('2023217', '9999', '756', '7932', '1410', '6180');
INSERT INTO `fw_code` VALUES ('2023216', '9999', '755', '6930', '1795', '9761');
INSERT INTO `fw_code` VALUES ('2023215', '9999', '754', '7210', '6990', '5448');
INSERT INTO `fw_code` VALUES ('2023214', '9999', '753', '7825', '2676', '7671');
INSERT INTO `fw_code` VALUES ('2023213', '9999', '752', '8960', '7743', '1430');
INSERT INTO `fw_code` VALUES ('2023212', '9999', '751', '3339', '5843', '0296');
INSERT INTO `fw_code` VALUES ('2023211', '9999', '750', '2164', '9767', '6698');
INSERT INTO `fw_code` VALUES ('2023210', '9999', '749', '7144', '9263', '6778');
INSERT INTO `fw_code` VALUES ('2023209', '9999', '748', '0495', '1029', '0394');
INSERT INTO `fw_code` VALUES ('2023208', '9999', '747', '2912', '0906', '6260');
INSERT INTO `fw_code` VALUES ('2023207', '9999', '746', '6971', '2803', '9600');
INSERT INTO `fw_code` VALUES ('2023206', '9999', '745', '7851', '9394', '6502');
INSERT INTO `fw_code` VALUES ('2023205', '9999', '744', '5648', '6985', '7653');
INSERT INTO `fw_code` VALUES ('2023204', '9999', '743', '1564', '8370', '5484');
INSERT INTO `fw_code` VALUES ('2023203', '9999', '742', '9961', '7358', '7850');
INSERT INTO `fw_code` VALUES ('2023202', '9999', '741', '3059', '0648', '4609');
INSERT INTO `fw_code` VALUES ('2023201', '9999', '740', '8893', '0017', '2760');
INSERT INTO `fw_code` VALUES ('2023200', '9999', '739', '6116', '2930', '1528');
INSERT INTO `fw_code` VALUES ('2023199', '9999', '738', '4087', '6981', '9859');
INSERT INTO `fw_code` VALUES ('2023198', '9999', '737', '7958', '8128', '5011');
INSERT INTO `fw_code` VALUES ('2023197', '9999', '736', '3619', '1037', '5984');
INSERT INTO `fw_code` VALUES ('2023196', '9999', '735', '5435', '9517', '0636');
INSERT INTO `fw_code` VALUES ('2023195', '9999', '734', '8278', '4331', '0537');
INSERT INTO `fw_code` VALUES ('2023194', '9999', '733', '7531', '3192', '0975');
INSERT INTO `fw_code` VALUES ('2023193', '9999', '732', '1737', '4831', '2662');
INSERT INTO `fw_code` VALUES ('2023192', '9999', '731', '5262', '3057', '3457');
INSERT INTO `fw_code` VALUES ('2023191', '9999', '730', '2978', '8632', '4930');
INSERT INTO `fw_code` VALUES ('2023190', '9999', '729', '3019', '9640', '4769');
INSERT INTO `fw_code` VALUES ('2023189', '9999', '728', '8252', '7612', '1707');
INSERT INTO `fw_code` VALUES ('2023188', '9999', '727', '0842', '3950', '4752');
INSERT INTO `fw_code` VALUES ('2023187', '9999', '726', '3512', '2303', '7475');
INSERT INTO `fw_code` VALUES ('2023186', '9999', '725', '7464', '5466', '2305');
INSERT INTO `fw_code` VALUES ('2023185', '9999', '724', '4407', '3184', '5385');
INSERT INTO `fw_code` VALUES ('2023184', '9999', '723', '9214', '6219', '8287');
INSERT INTO `fw_code` VALUES ('2023183', '9999', '722', '9921', '6350', '8011');
INSERT INTO `fw_code` VALUES ('2023182', '9999', '721', '2418', '8243', '3555');
INSERT INTO `fw_code` VALUES ('2023181', '9999', '720', '3726', '9771', '4493');
INSERT INTO `fw_code` VALUES ('2023180', '9999', '719', '3405', '3569', '8966');
INSERT INTO `fw_code` VALUES ('2023179', '9999', '718', '9494', '1414', '3975');
INSERT INTO `fw_code` VALUES ('2023178', '9999', '717', '3192', '6101', '1948');
INSERT INTO `fw_code` VALUES ('2023177', '9999', '716', '3553', '3311', '7314');
INSERT INTO `fw_code` VALUES ('2023176', '9999', '715', '8105', '7870', '3359');
INSERT INTO `fw_code` VALUES ('2023175', '9999', '714', '2230', '7493', '5368');
INSERT INTO `fw_code` VALUES ('2023174', '9999', '713', '4473', '0910', '4055');
INSERT INTO `fw_code` VALUES ('2023173', '9999', '712', '6543', '7866', '5564');
INSERT INTO `fw_code` VALUES ('2023172', '9999', '711', '5969', '3188', '3180');
INSERT INTO `fw_code` VALUES ('2023171', '9999', '710', '5475', '0525', '0475');
INSERT INTO `fw_code` VALUES ('2023170', '9999', '709', '8919', '6736', '1591');
INSERT INTO `fw_code` VALUES ('2023169', '9999', '708', '2698', '3438', '9243');
INSERT INTO `fw_code` VALUES ('2023168', '9999', '707', '6997', '9521', '8430');
INSERT INTO `fw_code` VALUES ('2023167', '9999', '706', '3873', '9513', '2841');
INSERT INTO `fw_code` VALUES ('2023166', '9999', '705', '2017', '0025', '8350');
INSERT INTO `fw_code` VALUES ('2023165', '9999', '704', '8532', '2807', '7394');
INSERT INTO `fw_code` VALUES ('2023164', '9999', '703', '1457', '9636', '6975');
INSERT INTO `fw_code` VALUES ('2023163', '9999', '702', '1991', '3307', '9519');
INSERT INTO `fw_code` VALUES ('2023162', '9999', '701', '1844', '3565', '1171');
INSERT INTO `fw_code` VALUES ('2023161', '9999', '700', '3232', '7108', '1787');
INSERT INTO `fw_code` VALUES ('2023160', '9999', '699', '4193', '5716', '8368');
INSERT INTO `fw_code` VALUES ('2023159', '9999', '698', '3273', '8116', '1626');
INSERT INTO `fw_code` VALUES ('2023158', '9999', '697', '4834', '8120', '9421');
INSERT INTO `fw_code` VALUES ('2023157', '9999', '696', '1096', '2426', '1609');
INSERT INTO `fw_code` VALUES ('2023156', '9999', '695', '0094', '2811', '5189');
INSERT INTO `fw_code` VALUES ('2023155', '9999', '694', '7718', '3942', '9162');
INSERT INTO `fw_code` VALUES ('2023154', '9999', '693', '0989', '3692', '3100');
INSERT INTO `fw_code` VALUES ('2023153', '9999', '692', '2124', '8759', '6859');
INSERT INTO `fw_code` VALUES ('2023152', '9999', '691', '6503', '6858', '5725');
INSERT INTO `fw_code` VALUES ('2023151', '9999', '690', '5328', '0783', '2127');
INSERT INTO `fw_code` VALUES ('2023150', '9999', '689', '0308', '0279', '2207');
INSERT INTO `fw_code` VALUES ('2023149', '9999', '688', '3659', '2045', '5823');
INSERT INTO `fw_code` VALUES ('2023148', '9999', '687', '6076', '1922', '1689');
INSERT INTO `fw_code` VALUES ('2023147', '9999', '686', '3446', '4577', '8805');
INSERT INTO `fw_code` VALUES ('2023146', '9999', '685', '0135', '3819', '5028');
INSERT INTO `fw_code` VALUES ('2023145', '9999', '684', '8359', '6346', '0216');
INSERT INTO `fw_code` VALUES ('2023144', '9999', '683', '8812', '8001', '3082');
INSERT INTO `fw_code` VALUES ('2023143', '9999', '682', '4728', '9386', '0912');
INSERT INTO `fw_code` VALUES ('2023142', '9999', '681', '3125', '8374', '3278');
INSERT INTO `fw_code` VALUES ('2023141', '9999', '680', '6223', '1664', '0037');
INSERT INTO `fw_code` VALUES ('2023140', '9999', '679', '2057', '1033', '8189');
INSERT INTO `fw_code` VALUES ('2023139', '9999', '678', '9173', '5212', '8448');
INSERT INTO `fw_code` VALUES ('2023138', '9999', '677', '9280', '3946', '6957');
INSERT INTO `fw_code` VALUES ('2023137', '9999', '676', '7251', '7997', '5287');
INSERT INTO `fw_code` VALUES ('2023136', '9999', '675', '8466', '5081', '8725');
INSERT INTO `fw_code` VALUES ('2023135', '9999', '674', '6783', '2053', '1412');
INSERT INTO `fw_code` VALUES ('2023134', '9999', '673', '8599', '0533', '6064');
INSERT INTO `fw_code` VALUES ('2023133', '9999', '672', '8786', '1283', '4251');
INSERT INTO `fw_code` VALUES ('2023132', '9999', '671', '8039', '0144', '4689');
INSERT INTO `fw_code` VALUES ('2023131', '9999', '670', '4901', '5847', '8091');
INSERT INTO `fw_code` VALUES ('2023130', '9999', '669', '8426', '4073', '8886');
INSERT INTO `fw_code` VALUES ('2023129', '9999', '668', '6142', '9648', '0359');
INSERT INTO `fw_code` VALUES ('2023128', '9999', '667', '0775', '6223', '6082');
INSERT INTO `fw_code` VALUES ('2023127', '9999', '666', '6182', '0656', '0198');
INSERT INTO `fw_code` VALUES ('2023126', '9999', '665', '1416', '8628', '7135');
INSERT INTO `fw_code` VALUES ('2023125', '9999', '664', '1350', '0902', '8466');
INSERT INTO `fw_code` VALUES ('2023124', '9999', '663', '6676', '3319', '2904');
INSERT INTO `fw_code` VALUES ('2023123', '9999', '662', '0628', '6482', '7734');
INSERT INTO `fw_code` VALUES ('2023122', '9999', '661', '7571', '4200', '0814');
INSERT INTO `fw_code` VALUES ('2023121', '9999', '660', '2378', '7235', '3716');
INSERT INTO `fw_code` VALUES ('2023120', '9999', '659', '3085', '7366', '3439');
INSERT INTO `fw_code` VALUES ('2023119', '9999', '658', '5582', '9259', '8984');
INSERT INTO `fw_code` VALUES ('2023118', '9999', '657', '6890', '0787', '9921');
INSERT INTO `fw_code` VALUES ('2023117', '9999', '656', '6569', '4585', '4395');
INSERT INTO `fw_code` VALUES ('2023116', '9999', '655', '2658', '2430', '9403');
INSERT INTO `fw_code` VALUES ('2023115', '9999', '654', '6356', '7117', '7377');
INSERT INTO `fw_code` VALUES ('2023114', '9999', '653', '6717', '4327', '2743');
INSERT INTO `fw_code` VALUES ('2023113', '9999', '652', '1269', '8886', '8787');
INSERT INTO `fw_code` VALUES ('2023112', '9999', '651', '7637', '1926', '9484');
INSERT INTO `fw_code` VALUES ('2023111', '9999', '650', '9707', '8882', '0993');
INSERT INTO `fw_code` VALUES ('2023110', '9999', '649', '9133', '4204', '8609');
INSERT INTO `fw_code` VALUES ('2023109', '9999', '648', '8639', '1541', '5903');
INSERT INTO `fw_code` VALUES ('2023108', '9999', '647', '5862', '4454', '4671');
INSERT INTO `fw_code` VALUES ('2023107', '9999', '646', '7505', '6473', '2144');
INSERT INTO `fw_code` VALUES ('2023106', '9999', '645', '7037', '0529', '8269');
INSERT INTO `fw_code` VALUES ('2023105', '9999', '644', '2525', '6977', '2064');
INSERT INTO `fw_code` VALUES ('2023104', '9999', '643', '7928', '6378', '1408');
INSERT INTO `fw_code` VALUES ('2023103', '9999', '642', '0852', '3207', '0989');
INSERT INTO `fw_code` VALUES ('2023102', '9999', '641', '1386', '6878', '3533');
INSERT INTO `fw_code` VALUES ('2023101', '9999', '640', '1239', '7136', '5185');
INSERT INTO `fw_code` VALUES ('2023100', '9999', '639', '2628', '0679', '5801');
INSERT INTO `fw_code` VALUES ('2023099', '9999', '638', '3589', '9286', '2381');
INSERT INTO `fw_code` VALUES ('2023098', '9999', '637', '2668', '1687', '5640');
INSERT INTO `fw_code` VALUES ('2023097', '9999', '636', '4230', '1691', '3435');
INSERT INTO `fw_code` VALUES ('2023096', '9999', '635', '0492', '5997', '5623');
INSERT INTO `fw_code` VALUES ('2023095', '9999', '634', '6834', '2318', '7488');
INSERT INTO `fw_code` VALUES ('2023094', '9999', '633', '7114', '7513', '3176');
INSERT INTO `fw_code` VALUES ('2023093', '9999', '632', '0385', '7263', '7114');
INSERT INTO `fw_code` VALUES ('2023092', '9999', '631', '8863', '8266', '9158');
INSERT INTO `fw_code` VALUES ('2023091', '9999', '630', '5899', '0429', '9739');
INSERT INTO `fw_code` VALUES ('2023090', '9999', '629', '4724', '4354', '6140');
INSERT INTO `fw_code` VALUES ('2023089', '9999', '628', '7048', '9786', '4506');
INSERT INTO `fw_code` VALUES ('2023088', '9999', '627', '3055', '5616', '9837');
INSERT INTO `fw_code` VALUES ('2023087', '9999', '626', '5471', '5493', '5703');
INSERT INTO `fw_code` VALUES ('2023086', '9999', '625', '2841', '8148', '2819');
INSERT INTO `fw_code` VALUES ('2023085', '9999', '624', '9530', '7390', '9042');
INSERT INTO `fw_code` VALUES ('2023084', '9999', '623', '7755', '9917', '4230');
INSERT INTO `fw_code` VALUES ('2023083', '9999', '622', '5552', '7508', '5381');
INSERT INTO `fw_code` VALUES ('2023082', '9999', '621', '4123', '2957', '4926');
INSERT INTO `fw_code` VALUES ('2023081', '9999', '620', '2521', '1945', '7292');
INSERT INTO `fw_code` VALUES ('2023080', '9999', '619', '5619', '5235', '4051');
INSERT INTO `fw_code` VALUES ('2023079', '9999', '618', '1453', '4604', '2203');
INSERT INTO `fw_code` VALUES ('2023078', '9999', '617', '8569', '8783', '2462');
INSERT INTO `fw_code` VALUES ('2023077', '9999', '616', '8676', '7517', '0971');
INSERT INTO `fw_code` VALUES ('2023076', '9999', '615', '6646', '1568', '9301');
INSERT INTO `fw_code` VALUES ('2023075', '9999', '614', '7862', '8651', '2739');
INSERT INTO `fw_code` VALUES ('2023074', '9999', '613', '3523', '1560', '3712');
INSERT INTO `fw_code` VALUES ('2023073', '9999', '612', '5339', '0040', '8363');
INSERT INTO `fw_code` VALUES ('2023072', '9999', '611', '8182', '4854', '8265');
INSERT INTO `fw_code` VALUES ('2023071', '9999', '610', '7434', '3715', '8703');
INSERT INTO `fw_code` VALUES ('2023070', '9999', '609', '4296', '9417', '2105');
INSERT INTO `fw_code` VALUES ('2023069', '9999', '608', '7821', '7644', '2899');
INSERT INTO `fw_code` VALUES ('2023068', '9999', '607', '2882', '9155', '2658');
INSERT INTO `fw_code` VALUES ('2023067', '9999', '606', '0171', '9794', '0096');
INSERT INTO `fw_code` VALUES ('2023066', '9999', '605', '5578', '4227', '4212');
INSERT INTO `fw_code` VALUES ('2023065', '9999', '604', '0812', '2199', '1149');
INSERT INTO `fw_code` VALUES ('2023064', '9999', '603', '0746', '4473', '2480');
INSERT INTO `fw_code` VALUES ('2023063', '9999', '602', '3416', '2826', '5203');
INSERT INTO `fw_code` VALUES ('2023062', '9999', '601', '7368', '5989', '0033');
INSERT INTO `fw_code` VALUES ('2023061', '9999', '600', '6967', '7771', '4828');
INSERT INTO `fw_code` VALUES ('2023060', '9999', '599', '1773', '0806', '7730');
INSERT INTO `fw_code` VALUES ('2023059', '9999', '598', '2481', '0937', '7453');
INSERT INTO `fw_code` VALUES ('2023058', '9999', '597', '4978', '2830', '2998');
INSERT INTO `fw_code` VALUES ('2023057', '9999', '596', '3630', '0294', '2221');
INSERT INTO `fw_code` VALUES ('2023056', '9999', '595', '3309', '4092', '6694');
INSERT INTO `fw_code` VALUES ('2023055', '9999', '594', '9397', '1937', '1703');
INSERT INTO `fw_code` VALUES ('2023054', '9999', '593', '3095', '6624', '9676');
INSERT INTO `fw_code` VALUES ('2023053', '9999', '592', '6112', '7898', '6757');
INSERT INTO `fw_code` VALUES ('2023052', '9999', '591', '8009', '8393', '1087');
INSERT INTO `fw_code` VALUES ('2023051', '9999', '590', '2134', '8016', '3096');
INSERT INTO `fw_code` VALUES ('2023050', '9999', '589', '4377', '1433', '1783');
INSERT INTO `fw_code` VALUES ('2023049', '9999', '588', '9103', '2453', '5007');
INSERT INTO `fw_code` VALUES ('2023048', '9999', '587', '5873', '3711', '0908');
INSERT INTO `fw_code` VALUES ('2023047', '9999', '586', '8035', '5112', '9917');
INSERT INTO `fw_code` VALUES ('2023046', '9999', '585', '8823', '7259', '9319');
INSERT INTO `fw_code` VALUES ('2023045', '9999', '584', '5258', '8025', '8685');
INSERT INTO `fw_code` VALUES ('2023044', '9999', '583', '6900', '0044', '6158');
INSERT INTO `fw_code` VALUES ('2023043', '9999', '582', '4444', '9159', '0453');
INSERT INTO `fw_code` VALUES ('2023042', '9999', '581', '6433', '4100', '2283');
INSERT INTO `fw_code` VALUES ('2023041', '9999', '580', '1921', '0548', '6078');
INSERT INTO `fw_code` VALUES ('2023040', '9999', '579', '8436', '3330', '5122');
INSERT INTO `fw_code` VALUES ('2023039', '9999', '578', '4016', '4223', '6417');
INSERT INTO `fw_code` VALUES ('2023038', '9999', '577', '4550', '7894', '8962');
INSERT INTO `fw_code` VALUES ('2023037', '9999', '576', '4403', '8152', '0614');
INSERT INTO `fw_code` VALUES ('2023036', '9999', '575', '5792', '1695', '1230');
INSERT INTO `fw_code` VALUES ('2023035', '9999', '574', '6753', '0302', '7810');
INSERT INTO `fw_code` VALUES ('2023034', '9999', '573', '5832', '2703', '1069');
INSERT INTO `fw_code` VALUES ('2023033', '9999', '572', '7394', '2707', '8864');
INSERT INTO `fw_code` VALUES ('2023032', '9999', '571', '3655', '7013', '1051');
INSERT INTO `fw_code` VALUES ('2023031', '9999', '570', '9998', '3334', '2917');
INSERT INTO `fw_code` VALUES ('2023030', '9999', '569', '0278', '8529', '8605');
INSERT INTO `fw_code` VALUES ('2023029', '9999', '568', '3549', '8279', '2542');
INSERT INTO `fw_code` VALUES ('2023028', '9999', '567', '2027', '9282', '4587');
INSERT INTO `fw_code` VALUES ('2023027', '9999', '566', '6407', '7381', '3453');
INSERT INTO `fw_code` VALUES ('2023026', '9999', '565', '5232', '1306', '9855');
INSERT INTO `fw_code` VALUES ('2023025', '9999', '564', '0212', '0802', '9935');
INSERT INTO `fw_code` VALUES ('2023024', '9999', '563', '6219', '6632', '5265');
INSERT INTO `fw_code` VALUES ('2023023', '9999', '562', '5979', '2445', '9417');
INSERT INTO `fw_code` VALUES ('2023022', '9999', '561', '6005', '9163', '8248');
INSERT INTO `fw_code` VALUES ('2023021', '9999', '560', '2694', '8406', '4471');
INSERT INTO `fw_code` VALUES ('2023020', '9999', '559', '0919', '0933', '9658');
INSERT INTO `fw_code` VALUES ('2023019', '9999', '558', '8716', '8524', '0810');
INSERT INTO `fw_code` VALUES ('2023018', '9999', '557', '7287', '3973', '0355');
INSERT INTO `fw_code` VALUES ('2023017', '9999', '556', '5685', '2961', '2721');
INSERT INTO `fw_code` VALUES ('2023016', '9999', '555', '8782', '6251', '9480');
INSERT INTO `fw_code` VALUES ('2023015', '9999', '554', '4617', '5620', '7632');
INSERT INTO `fw_code` VALUES ('2023014', '9999', '553', '9077', '5735', '6176');
INSERT INTO `fw_code` VALUES ('2023013', '9999', '552', '9184', '4469', '4685');
INSERT INTO `fw_code` VALUES ('2023012', '9999', '551', '7154', '8520', '3015');
INSERT INTO `fw_code` VALUES ('2023011', '9999', '550', '1026', '9667', '8167');
INSERT INTO `fw_code` VALUES ('2023010', '9999', '549', '6687', '2576', '9140');
INSERT INTO `fw_code` VALUES ('2023009', '9999', '548', '8503', '1056', '3792');
INSERT INTO `fw_code` VALUES ('2023008', '9999', '547', '1346', '5870', '3694');
INSERT INTO `fw_code` VALUES ('2023007', '9999', '546', '0598', '4731', '4131');
INSERT INTO `fw_code` VALUES ('2023006', '9999', '545', '4804', '6370', '5819');
INSERT INTO `fw_code` VALUES ('2023005', '9999', '544', '8329', '4596', '6613');
INSERT INTO `fw_code` VALUES ('2023004', '9999', '543', '6046', '0171', '8087');
INSERT INTO `fw_code` VALUES ('2023003', '9999', '542', '3335', '0810', '5524');
INSERT INTO `fw_code` VALUES ('2023002', '9999', '541', '6086', '1179', '7926');
INSERT INTO `fw_code` VALUES ('2023001', '9999', '540', '3976', '3215', '6578');
INSERT INTO `fw_code` VALUES ('2023000', '9999', '539', '3910', '5489', '7908');
INSERT INTO `fw_code` VALUES ('2022999', '9999', '538', '6580', '3842', '0631');
INSERT INTO `fw_code` VALUES ('2022998', '9999', '537', '0532', '7005', '5462');
INSERT INTO `fw_code` VALUES ('2022997', '9999', '536', '7475', '4723', '8542');
INSERT INTO `fw_code` VALUES ('2022996', '9999', '535', '4937', '1822', '3158');
INSERT INTO `fw_code` VALUES ('2022995', '9999', '534', '2989', '7889', '1167');
INSERT INTO `fw_code` VALUES ('2022994', '9999', '533', '8142', '3846', '8426');
INSERT INTO `fw_code` VALUES ('2022993', '9999', '532', '6793', '1310', '7649');
INSERT INTO `fw_code` VALUES ('2022992', '9999', '531', '6473', '5108', '2122');
INSERT INTO `fw_code` VALUES ('2022991', '9999', '530', '2561', '2953', '7131');
INSERT INTO `fw_code` VALUES ('2022990', '9999', '529', '6259', '7640', '5105');
INSERT INTO `fw_code` VALUES ('2022989', '9999', '528', '6620', '4850', '0471');
INSERT INTO `fw_code` VALUES ('2022988', '9999', '527', '1173', '9409', '6515');
INSERT INTO `fw_code` VALUES ('2022987', '9999', '526', '5298', '9032', '8524');
INSERT INTO `fw_code` VALUES ('2022986', '9999', '525', '7541', '2449', '7212');
INSERT INTO `fw_code` VALUES ('2022985', '9999', '524', '2267', '3469', '0435');
INSERT INTO `fw_code` VALUES ('2022984', '9999', '523', '9037', '4727', '6337');
INSERT INTO `fw_code` VALUES ('2022983', '9999', '522', '8543', '2064', '3631');
INSERT INTO `fw_code` VALUES ('2022982', '9999', '521', '1987', '8275', '4748');
INSERT INTO `fw_code` VALUES ('2022981', '9999', '520', '5766', '4977', '2399');
INSERT INTO `fw_code` VALUES ('2022980', '9999', '519', '0064', '1060', '1587');
INSERT INTO `fw_code` VALUES ('2022979', '9999', '518', '7608', '0175', '5882');
INSERT INTO `fw_code` VALUES ('2022978', '9999', '517', '6941', '1052', '5997');
INSERT INTO `fw_code` VALUES ('2022977', '9999', '516', '5084', '1564', '1506');
INSERT INTO `fw_code` VALUES ('2022976', '9999', '515', '1600', '4346', '0551');
INSERT INTO `fw_code` VALUES ('2022975', '9999', '514', '7180', '5239', '1846');
INSERT INTO `fw_code` VALUES ('2022974', '9999', '513', '7714', '8910', '4390');
INSERT INTO `fw_code` VALUES ('2022973', '9999', '512', '4911', '5104', '4328');
INSERT INTO `fw_code` VALUES ('2022972', '9999', '511', '6300', '8647', '4944');
INSERT INTO `fw_code` VALUES ('2022971', '9999', '510', '7261', '7254', '1524');
INSERT INTO `fw_code` VALUES ('2022970', '9999', '509', '8996', '3719', '6498');
INSERT INTO `fw_code` VALUES ('2022969', '9999', '508', '7902', '9659', '2578');
INSERT INTO `fw_code` VALUES ('2022968', '9999', '507', '4164', '3965', '4765');
INSERT INTO `fw_code` VALUES ('2022967', '9999', '506', '3162', '4350', '8346');
INSERT INTO `fw_code` VALUES ('2022966', '9999', '505', '3442', '9544', '4033');
INSERT INTO `fw_code` VALUES ('2022965', '9999', '504', '4057', '5231', '6256');
INSERT INTO `fw_code` VALUES ('2022964', '9999', '503', '5191', '0298', '0015');
INSERT INTO `fw_code` VALUES ('2022963', '9999', '502', '9571', '8397', '8881');
INSERT INTO `fw_code` VALUES ('2022962', '9999', '501', '8396', '2322', '5283');
INSERT INTO `fw_code` VALUES ('2022961', '9999', '500', '3375', '1818', '5364');
INSERT INTO `fw_code` VALUES ('2022960', '9999', '499', '6727', '3584', '8980');
INSERT INTO `fw_code` VALUES ('2022959', '9999', '498', '9143', '3461', '4846');
INSERT INTO `fw_code` VALUES ('2022958', '9999', '497', '6514', '6116', '1962');
INSERT INTO `fw_code` VALUES ('2022957', '9999', '496', '3202', '5358', '8185');
INSERT INTO `fw_code` VALUES ('2022956', '9999', '495', '4083', '1949', '5087');
INSERT INTO `fw_code` VALUES ('2022955', '9999', '494', '1880', '9540', '6239');
INSERT INTO `fw_code` VALUES ('2022954', '9999', '493', '7795', '0925', '4069');
INSERT INTO `fw_code` VALUES ('2022953', '9999', '492', '6193', '9913', '6435');
INSERT INTO `fw_code` VALUES ('2022952', '9999', '491', '9291', '3203', '3194');
INSERT INTO `fw_code` VALUES ('2022951', '9999', '490', '5125', '2572', '1346');
INSERT INTO `fw_code` VALUES ('2022950', '9999', '489', '2241', '6751', '1605');
INSERT INTO `fw_code` VALUES ('2022949', '9999', '488', '2348', '5485', '0113');
INSERT INTO `fw_code` VALUES ('2022948', '9999', '487', '0318', '9536', '8444');
INSERT INTO `fw_code` VALUES ('2022947', '9999', '486', '4190', '0683', '3596');
INSERT INTO `fw_code` VALUES ('2022946', '9999', '485', '9851', '3592', '4569');
INSERT INTO `fw_code` VALUES ('2022945', '9999', '484', '1666', '2072', '9221');
INSERT INTO `fw_code` VALUES ('2022944', '9999', '483', '4510', '6886', '9123');
INSERT INTO `fw_code` VALUES ('2022943', '9999', '482', '3762', '5747', '9560');
INSERT INTO `fw_code` VALUES ('2022942', '9999', '481', '7968', '7386', '1247');
INSERT INTO `fw_code` VALUES ('2022941', '9999', '480', '1493', '5612', '2042');
INSERT INTO `fw_code` VALUES ('2022940', '9999', '479', '9210', '1187', '3515');
INSERT INTO `fw_code` VALUES ('2022939', '9999', '478', '3843', '7762', '9238');
INSERT INTO `fw_code` VALUES ('2022938', '9999', '477', '9250', '2195', '3355');
INSERT INTO `fw_code` VALUES ('2022937', '9999', '476', '4484', '0167', '0292');
INSERT INTO `fw_code` VALUES ('2022936', '9999', '475', '7073', '6505', '3337');
INSERT INTO `fw_code` VALUES ('2022935', '9999', '474', '9744', '4858', '6060');
INSERT INTO `fw_code` VALUES ('2022934', '9999', '473', '3696', '8021', '0890');
INSERT INTO `fw_code` VALUES ('2022933', '9999', '472', '0639', '5739', '3971');
INSERT INTO `fw_code` VALUES ('2022932', '9999', '471', '5445', '8774', '6872');
INSERT INTO `fw_code` VALUES ('2022931', '9999', '470', '6153', '8905', '6596');
INSERT INTO `fw_code` VALUES ('2022930', '9999', '469', '8650', '0798', '2140');
INSERT INTO `fw_code` VALUES ('2022929', '9999', '468', '9957', '2326', '3078');
INSERT INTO `fw_code` VALUES ('2022928', '9999', '467', '9637', '6124', '7551');
INSERT INTO `fw_code` VALUES ('2022927', '9999', '466', '5725', '3969', '2560');
INSERT INTO `fw_code` VALUES ('2022926', '9999', '465', '9423', '8656', '0533');
INSERT INTO `fw_code` VALUES ('2022925', '9999', '464', '9784', '5866', '5899');
INSERT INTO `fw_code` VALUES ('2022924', '9999', '463', '4337', '0425', '1944');
INSERT INTO `fw_code` VALUES ('2022923', '9999', '462', '8462', '0048', '3953');
INSERT INTO `fw_code` VALUES ('2022922', '9999', '461', '0705', '3465', '2640');
INSERT INTO `fw_code` VALUES ('2022921', '9999', '460', '2775', '0421', '4149');
INSERT INTO `fw_code` VALUES ('2022920', '9999', '459', '2201', '5743', '1765');
INSERT INTO `fw_code` VALUES ('2022919', '9999', '458', '1707', '3080', '9060');
INSERT INTO `fw_code` VALUES ('2022918', '9999', '457', '5151', '9290', '0176');
INSERT INTO `fw_code` VALUES ('2022917', '9999', '456', '8930', '5993', '7828');
INSERT INTO `fw_code` VALUES ('2022916', '9999', '455', '3228', '2076', '7016');
INSERT INTO `fw_code` VALUES ('2022915', '9999', '454', '8116', '7127', '9596');
INSERT INTO `fw_code` VALUES ('2022914', '9999', '453', '0105', '2068', '1426');
INSERT INTO `fw_code` VALUES ('2022913', '9999', '452', '8248', '2580', '6935');
INSERT INTO `fw_code` VALUES ('2022912', '9999', '451', '4764', '5362', '5980');
INSERT INTO `fw_code` VALUES ('2022911', '9999', '450', '7688', '2191', '5560');
INSERT INTO `fw_code` VALUES ('2022910', '9999', '449', '8223', '5862', '8104');
INSERT INTO `fw_code` VALUES ('2022909', '9999', '448', '8075', '6120', '9756');
INSERT INTO `fw_code` VALUES ('2022908', '9999', '447', '9464', '9663', '0372');
INSERT INTO `fw_code` VALUES ('2022907', '9999', '446', '0425', '8270', '6953');
INSERT INTO `fw_code` VALUES ('2022906', '9999', '445', '9504', '0671', '0212');
INSERT INTO `fw_code` VALUES ('2022905', '9999', '444', '1066', '0675', '8006');
INSERT INTO `fw_code` VALUES ('2022904', '9999', '443', '7328', '4981', '0194');
INSERT INTO `fw_code` VALUES ('2022903', '9999', '442', '6326', '5366', '3774');
INSERT INTO `fw_code` VALUES ('2022902', '9999', '441', '3950', '6497', '7747');
INSERT INTO `fw_code` VALUES ('2022901', '9999', '440', '7221', '6247', '1685');
INSERT INTO `fw_code` VALUES ('2022900', '9999', '439', '8355', '1314', '5444');
INSERT INTO `fw_code` VALUES ('2022899', '9999', '438', '2735', '9413', '4310');
INSERT INTO `fw_code` VALUES ('2022898', '9999', '437', '1560', '3338', '0712');
INSERT INTO `fw_code` VALUES ('2022897', '9999', '436', '6539', '2834', '0792');
INSERT INTO `fw_code` VALUES ('2022896', '9999', '435', '9891', '4600', '4408');
INSERT INTO `fw_code` VALUES ('2022895', '9999', '434', '2307', '4477', '0274');
INSERT INTO `fw_code` VALUES ('2022894', '9999', '433', '9677', '7132', '7390');
INSERT INTO `fw_code` VALUES ('2022893', '9999', '432', '8167', '7392', '5672');
INSERT INTO `fw_code` VALUES ('2022892', '9999', '431', '2933', '9420', '8734');
INSERT INTO `fw_code` VALUES ('2022891', '9999', '430', '9088', '4992', '2413');
INSERT INTO `fw_code` VALUES ('2022890', '9999', '429', '8274', '6127', '4180');
INSERT INTO `fw_code` VALUES ('2022889', '9999', '428', '6590', '3099', '6868');
INSERT INTO `fw_code` VALUES ('2022888', '9999', '427', '8594', '2329', '9707');
INSERT INTO `fw_code` VALUES ('2022887', '9999', '426', '7846', '1190', '0145');
INSERT INTO `fw_code` VALUES ('2022886', '9999', '425', '1224', '9674', '2591');
INSERT INTO `fw_code` VALUES ('2022885', '9999', '424', '1158', '1948', '3921');
INSERT INTO `fw_code` VALUES ('2022884', '9999', '423', '6484', '4365', '8359');
INSERT INTO `fw_code` VALUES ('2022883', '9999', '422', '5390', '0305', '4439');
INSERT INTO `fw_code` VALUES ('2022882', '9999', '421', '6377', '5631', '9850');
INSERT INTO `fw_code` VALUES ('2022881', '9999', '420', '1077', '9932', '4243');
INSERT INTO `fw_code` VALUES ('2022880', '9999', '419', '2546', '5492', '4538');
INSERT INTO `fw_code` VALUES ('2022879', '9999', '418', '9515', '9928', '6448');
INSERT INTO `fw_code` VALUES ('2022878', '9999', '417', '8447', '2587', '1359');
INSERT INTO `fw_code` VALUES ('2022877', '9999', '416', '9235', '4734', '0761');
INSERT INTO `fw_code` VALUES ('2022876', '9999', '415', '5670', '5500', '0127');
INSERT INTO `fw_code` VALUES ('2022875', '9999', '414', '6845', '1575', '3725');
INSERT INTO `fw_code` VALUES ('2022874', '9999', '413', '2332', '8023', '7520');
INSERT INTO `fw_code` VALUES ('2022873', '9999', '412', '7165', '7777', '9252');
INSERT INTO `fw_code` VALUES ('2022872', '9999', '411', '7806', '0182', '0306');
INSERT INTO `fw_code` VALUES ('2022871', '9999', '410', '0410', '0809', '4359');
INSERT INTO `fw_code` VALUES ('2022870', '9999', '409', '3961', '5754', '3984');
INSERT INTO `fw_code` VALUES ('2022869', '9999', '408', '2439', '6757', '6029');
INSERT INTO `fw_code` VALUES ('2022868', '9999', '407', '0623', '8277', '1377');
INSERT INTO `fw_code` VALUES ('2022867', '9999', '406', '6631', '4107', '6707');
INSERT INTO `fw_code` VALUES ('2022866', '9999', '405', '1331', '8408', '1100');
INSERT INTO `fw_code` VALUES ('2022865', '9999', '404', '5029', '3095', '9073');
INSERT INTO `fw_code` VALUES ('2022864', '9999', '403', '2145', '7274', '9332');
INSERT INTO `fw_code` VALUES ('2022863', '9999', '402', '2252', '6008', '7841');
INSERT INTO `fw_code` VALUES ('2022862', '9999', '401', '1438', '7142', '9609');
INSERT INTO `fw_code` VALUES ('2022861', '9999', '400', '7099', '0051', '0582');
INSERT INTO `fw_code` VALUES ('2022860', '9999', '399', '7872', '7909', '8975');
INSERT INTO `fw_code` VALUES ('2022859', '9999', '398', '6458', '7646', '9529');
INSERT INTO `fw_code` VALUES ('2022858', '9999', '397', '3747', '8285', '6966');
INSERT INTO `fw_code` VALUES ('2022857', '9999', '396', '9154', '2718', '1082');
INSERT INTO `fw_code` VALUES ('2022856', '9999', '395', '6992', '1317', '2073');
INSERT INTO `fw_code` VALUES ('2022855', '9999', '394', '0944', '4480', '6904');
INSERT INTO `fw_code` VALUES ('2022854', '9999', '393', '8554', '1321', '9868');
INSERT INTO `fw_code` VALUES ('2022853', '9999', '392', '6885', '2583', '3564');
INSERT INTO `fw_code` VALUES ('2022852', '9999', '391', '2973', '0428', '8573');
INSERT INTO `fw_code` VALUES ('2022851', '9999', '390', '1585', '6884', '7957');
INSERT INTO `fw_code` VALUES ('2022850', '9999', '389', '5710', '6508', '9966');
INSERT INTO `fw_code` VALUES ('2022849', '9999', '388', '2679', '0944', '1877');
INSERT INTO `fw_code` VALUES ('2022848', '9999', '387', '9449', '2202', '7779');
INSERT INTO `fw_code` VALUES ('2022847', '9999', '386', '1611', '3603', '6788');
INSERT INTO `fw_code` VALUES ('2022846', '9999', '385', '2399', '5750', '6189');
INSERT INTO `fw_code` VALUES ('2022845', '9999', '384', '2012', '1821', '1993');
INSERT INTO `fw_code` VALUES ('2022844', '9999', '383', '7979', '6643', '7484');
INSERT INTO `fw_code` VALUES ('2022843', '9999', '382', '9368', '0186', '8100');
INSERT INTO `fw_code` VALUES ('2022842', '9999', '381', '0329', '8793', '4681');
INSERT INTO `fw_code` VALUES ('2022841', '9999', '380', '0970', '1198', '5734');
INSERT INTO `fw_code` VALUES ('2022840', '9999', '379', '3854', '7020', '5475');
INSERT INTO `fw_code` VALUES ('2022839', '9999', '378', '6244', '8340', '9172');
INSERT INTO `fw_code` VALUES ('2022838', '9999', '377', '5069', '2264', '5574');
INSERT INTO `fw_code` VALUES ('2022837', '9999', '376', '0048', '1760', '5654');
INSERT INTO `fw_code` VALUES ('2022836', '9999', '375', '6056', '7590', '0985');
INSERT INTO `fw_code` VALUES ('2022835', '9999', '374', '5816', '3403', '5136');
INSERT INTO `fw_code` VALUES ('2022834', '9999', '373', '5842', '0122', '3967');
INSERT INTO `fw_code` VALUES ('2022833', '9999', '372', '2531', '9364', '0190');
INSERT INTO `fw_code` VALUES ('2022832', '9999', '371', '0756', '1891', '5378');
INSERT INTO `fw_code` VALUES ('2022831', '9999', '370', '8553', '9483', '6529');
INSERT INTO `fw_code` VALUES ('2022830', '9999', '369', '7124', '4931', '6074');
INSERT INTO `fw_code` VALUES ('2022829', '9999', '368', '5522', '3919', '8440');
INSERT INTO `fw_code` VALUES ('2022828', '9999', '367', '8619', '7209', '5199');
INSERT INTO `fw_code` VALUES ('2022827', '9999', '366', '4454', '6578', '3351');
INSERT INTO `fw_code` VALUES ('2022826', '9999', '365', '8914', '6693', '1895');
INSERT INTO `fw_code` VALUES ('2022825', '9999', '364', '9021', '5427', '0404');
INSERT INTO `fw_code` VALUES ('2022824', '9999', '363', '6991', '9478', '8735');
INSERT INTO `fw_code` VALUES ('2022823', '9999', '362', '0862', '0625', '3887');
INSERT INTO `fw_code` VALUES ('2022822', '9999', '361', '6524', '3534', '4860');
INSERT INTO `fw_code` VALUES ('2022821', '9999', '360', '8339', '2014', '9512');
INSERT INTO `fw_code` VALUES ('2022820', '9999', '359', '1183', '6828', '9413');
INSERT INTO `fw_code` VALUES ('2022819', '9999', '358', '0435', '5689', '9851');
INSERT INTO `fw_code` VALUES ('2022818', '9999', '357', '4641', '7328', '1538');
INSERT INTO `fw_code` VALUES ('2022817', '9999', '356', '8166', '5554', '2333');
INSERT INTO `fw_code` VALUES ('2022816', '9999', '355', '5883', '1129', '3806');
INSERT INTO `fw_code` VALUES ('2022815', '9999', '354', '3172', '1768', '1244');
INSERT INTO `fw_code` VALUES ('2022814', '9999', '353', '5923', '2137', '3645');
INSERT INTO `fw_code` VALUES ('2022813', '9999', '352', '3813', '4173', '2297');
INSERT INTO `fw_code` VALUES ('2022812', '9999', '351', '3746', '6447', '3628');
INSERT INTO `fw_code` VALUES ('2022811', '9999', '350', '6417', '4800', '6351');
INSERT INTO `fw_code` VALUES ('2022810', '9999', '349', '0369', '7963', '1181');
INSERT INTO `fw_code` VALUES ('2022809', '9999', '348', '7312', '5681', '4261');
INSERT INTO `fw_code` VALUES ('2022808', '9999', '347', '4774', '2780', '8878');
INSERT INTO `fw_code` VALUES ('2022807', '9999', '346', '2826', '8848', '6887');
INSERT INTO `fw_code` VALUES ('2022806', '9999', '345', '7978', '4804', '4146');
INSERT INTO `fw_code` VALUES ('2022805', '9999', '344', '6630', '2268', '3369');
INSERT INTO `fw_code` VALUES ('2022804', '9999', '343', '6310', '6066', '7842');
INSERT INTO `fw_code` VALUES ('2022803', '9999', '342', '2398', '3911', '2851');
INSERT INTO `fw_code` VALUES ('2022802', '9999', '341', '6096', '8598', '0824');
INSERT INTO `fw_code` VALUES ('2022801', '9999', '340', '6457', '5808', '6190');
INSERT INTO `fw_code` VALUES ('2022800', '9999', '339', '1010', '0367', '2235');
INSERT INTO `fw_code` VALUES ('2022799', '9999', '338', '5135', '9991', '4244');
INSERT INTO `fw_code` VALUES ('2022798', '9999', '337', '7378', '3407', '2931');
INSERT INTO `fw_code` VALUES ('2022797', '9999', '336', '2104', '4427', '6155');
INSERT INTO `fw_code` VALUES ('2022796', '9999', '335', '8873', '5685', '2056');
INSERT INTO `fw_code` VALUES ('2022795', '9999', '334', '8380', '3022', '9351');
INSERT INTO `fw_code` VALUES ('2022794', '9999', '333', '1824', '9233', '0467');
INSERT INTO `fw_code` VALUES ('2022793', '9999', '332', '5603', '5935', '8119');
INSERT INTO `fw_code` VALUES ('2022792', '9999', '331', '9901', '2018', '7306');
INSERT INTO `fw_code` VALUES ('2022791', '9999', '330', '7444', '1133', '1601');
INSERT INTO `fw_code` VALUES ('2022790', '9999', '329', '6778', '2010', '1717');
INSERT INTO `fw_code` VALUES ('2022789', '9999', '328', '4921', '2522', '7226');
INSERT INTO `fw_code` VALUES ('2022788', '9999', '327', '1437', '5304', '6270');
INSERT INTO `fw_code` VALUES ('2022787', '9999', '326', '7017', '6197', '7565');
INSERT INTO `fw_code` VALUES ('2022786', '9999', '325', '7551', '9868', '0110');
INSERT INTO `fw_code` VALUES ('2022785', '9999', '324', '4748', '6062', '0047');
INSERT INTO `fw_code` VALUES ('2022784', '9999', '323', '6137', '9605', '0663');
INSERT INTO `fw_code` VALUES ('2022783', '9999', '322', '7098', '8213', '7244');
INSERT INTO `fw_code` VALUES ('2022782', '9999', '321', '8833', '4677', '2217');
INSERT INTO `fw_code` VALUES ('2022781', '9999', '320', '7739', '0617', '8297');
INSERT INTO `fw_code` VALUES ('2022780', '9999', '319', '4000', '4923', '0485');
INSERT INTO `fw_code` VALUES ('2022779', '9999', '318', '2999', '5308', '4065');
INSERT INTO `fw_code` VALUES ('2022778', '9999', '317', '3279', '0503', '9753');
INSERT INTO `fw_code` VALUES ('2022777', '9999', '316', '3894', '6189', '1976');
INSERT INTO `fw_code` VALUES ('2022776', '9999', '315', '5028', '1256', '5735');
INSERT INTO `fw_code` VALUES ('2022775', '9999', '314', '9408', '9356', '4601');
INSERT INTO `fw_code` VALUES ('2022774', '9999', '313', '8233', '3280', '1003');
INSERT INTO `fw_code` VALUES ('2022773', '9999', '312', '3212', '2776', '1083');
INSERT INTO `fw_code` VALUES ('2022772', '9999', '311', '6564', '4542', '4699');
INSERT INTO `fw_code` VALUES ('2022771', '9999', '310', '8980', '4419', '0565');
INSERT INTO `fw_code` VALUES ('2022770', '9999', '309', '6350', '7074', '7681');
INSERT INTO `fw_code` VALUES ('2022769', '9999', '308', '3039', '6316', '3904');
INSERT INTO `fw_code` VALUES ('2022768', '9999', '307', '3920', '2907', '0806');
INSERT INTO `fw_code` VALUES ('2022767', '9999', '306', '1717', '0498', '1958');
INSERT INTO `fw_code` VALUES ('2022766', '9999', '305', '7632', '1883', '9788');
INSERT INTO `fw_code` VALUES ('2022765', '9999', '304', '6030', '0871', '2154');
INSERT INTO `fw_code` VALUES ('2022764', '9999', '303', '9128', '4161', '8913');
INSERT INTO `fw_code` VALUES ('2022763', '9999', '302', '4962', '3530', '7065');
INSERT INTO `fw_code` VALUES ('2022762', '9999', '301', '2078', '7709', '7324');
INSERT INTO `fw_code` VALUES ('2022761', '9999', '300', '2185', '6443', '5833');
INSERT INTO `fw_code` VALUES ('2022760', '9999', '299', '0155', '0494', '4163');
INSERT INTO `fw_code` VALUES ('2022759', '9999', '298', '4026', '1641', '9315');
INSERT INTO `fw_code` VALUES ('2022758', '9999', '297', '9688', '4550', '0288');
INSERT INTO `fw_code` VALUES ('2022757', '9999', '296', '1503', '3030', '4940');
INSERT INTO `fw_code` VALUES ('2022756', '9999', '295', '4347', '7844', '4842');
INSERT INTO `fw_code` VALUES ('2022755', '9999', '294', '3599', '6705', '5280');
INSERT INTO `fw_code` VALUES ('2022754', '9999', '293', '7805', '8344', '6967');
INSERT INTO `fw_code` VALUES ('2022753', '9999', '292', '1330', '6570', '7762');
INSERT INTO `fw_code` VALUES ('2022752', '9999', '291', '9047', '2145', '9235');
INSERT INTO `fw_code` VALUES ('2022751', '9999', '290', '3680', '8721', '4958');
INSERT INTO `fw_code` VALUES ('2022750', '9999', '289', '9087', '3153', '9074');
INSERT INTO `fw_code` VALUES ('2022749', '9999', '288', '4321', '1125', '6011');
INSERT INTO `fw_code` VALUES ('2022748', '9999', '287', '6910', '7463', '9056');
INSERT INTO `fw_code` VALUES ('2022747', '9999', '286', '9581', '5816', '1780');
INSERT INTO `fw_code` VALUES ('2022746', '9999', '285', '3533', '8979', '6610');
INSERT INTO `fw_code` VALUES ('2022745', '9999', '284', '0476', '6697', '9690');
INSERT INTO `fw_code` VALUES ('2022744', '9999', '283', '5282', '9732', '2592');
INSERT INTO `fw_code` VALUES ('2022743', '9999', '282', '5989', '9864', '2315');
INSERT INTO `fw_code` VALUES ('2022742', '9999', '281', '8487', '1756', '7860');
INSERT INTO `fw_code` VALUES ('2022741', '9999', '280', '9794', '3284', '8797');
INSERT INTO `fw_code` VALUES ('2022740', '9999', '279', '9474', '7082', '3271');
INSERT INTO `fw_code` VALUES ('2022739', '9999', '278', '5562', '4927', '8279');
INSERT INTO `fw_code` VALUES ('2022738', '9999', '277', '9260', '9614', '6253');
INSERT INTO `fw_code` VALUES ('2022737', '9999', '276', '9621', '6824', '1619');
INSERT INTO `fw_code` VALUES ('2022736', '9999', '275', '4174', '1383', '7663');
INSERT INTO `fw_code` VALUES ('2022735', '9999', '274', '8299', '1006', '9672');
INSERT INTO `fw_code` VALUES ('2022734', '9999', '273', '0542', '4423', '8360');
INSERT INTO `fw_code` VALUES ('2022733', '9999', '272', '2612', '1379', '9869');
INSERT INTO `fw_code` VALUES ('2022732', '9999', '271', '2037', '6701', '7485');
INSERT INTO `fw_code` VALUES ('2022731', '9999', '270', '1544', '4038', '4779');
INSERT INTO `fw_code` VALUES ('2022730', '9999', '269', '4988', '0249', '5896');
INSERT INTO `fw_code` VALUES ('2022729', '9999', '268', '8767', '6951', '3547');
INSERT INTO `fw_code` VALUES ('2022728', '9999', '267', '3065', '3034', '2735');
INSERT INTO `fw_code` VALUES ('2022727', '9999', '266', '7953', '8086', '5315');
INSERT INTO `fw_code` VALUES ('2022726', '9999', '265', '9942', '3026', '7145');
INSERT INTO `fw_code` VALUES ('2022725', '9999', '264', '8085', '3538', '2655');
INSERT INTO `fw_code` VALUES ('2022724', '9999', '263', '4601', '6320', '1699');
INSERT INTO `fw_code` VALUES ('2022723', '9999', '262', '7525', '3149', '1279');
INSERT INTO `fw_code` VALUES ('2022722', '9999', '261', '8059', '6820', '3824');
INSERT INTO `fw_code` VALUES ('2022721', '9999', '260', '7912', '7078', '5476');
INSERT INTO `fw_code` VALUES ('2022720', '9999', '259', '9301', '0621', '6092');
INSERT INTO `fw_code` VALUES ('2022719', '9999', '258', '0262', '9229', '2672');
INSERT INTO `fw_code` VALUES ('2022718', '9999', '257', '9341', '1629', '5931');
INSERT INTO `fw_code` VALUES ('2022717', '9999', '256', '0903', '1633', '3726');
INSERT INTO `fw_code` VALUES ('2022716', '9999', '255', '7164', '5939', '5913');
INSERT INTO `fw_code` VALUES ('2022715', '9999', '254', '6163', '6324', '9494');
INSERT INTO `fw_code` VALUES ('2022714', '9999', '253', '3787', '7455', '3467');
INSERT INTO `fw_code` VALUES ('2022713', '9999', '252', '7058', '7205', '7404');
INSERT INTO `fw_code` VALUES ('2022712', '9999', '251', '8192', '2272', '1163');
INSERT INTO `fw_code` VALUES ('2022711', '9999', '250', '2571', '0371', '0029');
INSERT INTO `fw_code` VALUES ('2022710', '9999', '249', '1397', '4296', '6431');
INSERT INTO `fw_code` VALUES ('2022709', '9999', '248', '6376', '3792', '6512');
INSERT INTO `fw_code` VALUES ('2022708', '9999', '247', '9728', '5558', '0128');
INSERT INTO `fw_code` VALUES ('2022707', '9999', '246', '2144', '5435', '5994');
INSERT INTO `fw_code` VALUES ('2022706', '9999', '245', '9514', '8090', '3110');
INSERT INTO `fw_code` VALUES ('2022705', '9999', '244', '6203', '7332', '9333');
INSERT INTO `fw_code` VALUES ('2022704', '9999', '243', '4428', '9859', '4520');
INSERT INTO `fw_code` VALUES ('2022703', '9999', '242', '4881', '1514', '7387');
INSERT INTO `fw_code` VALUES ('2022702', '9999', '241', '0796', '2899', '5217');
INSERT INTO `fw_code` VALUES ('2022701', '9999', '240', '9194', '1887', '7583');
INSERT INTO `fw_code` VALUES ('2022700', '9999', '239', '2291', '5177', '4342');
INSERT INTO `fw_code` VALUES ('2022699', '9999', '238', '8126', '4546', '2494');
INSERT INTO `fw_code` VALUES ('2022698', '9999', '237', '5242', '8725', '2753');
INSERT INTO `fw_code` VALUES ('2022697', '9999', '236', '5349', '7459', '1262');
INSERT INTO `fw_code` VALUES ('2022696', '9999', '235', '3319', '1510', '9592');
INSERT INTO `fw_code` VALUES ('2022695', '9999', '234', '4535', '8594', '3029');
INSERT INTO `fw_code` VALUES ('2022694', '9999', '233', '2851', '5566', '5717');
INSERT INTO `fw_code` VALUES ('2022693', '9999', '232', '4667', '4046', '0369');
INSERT INTO `fw_code` VALUES ('2022692', '9999', '231', '4855', '4796', '8556');
INSERT INTO `fw_code` VALUES ('2022691', '9999', '230', '4107', '3657', '8994');
INSERT INTO `fw_code` VALUES ('2022690', '9999', '229', '0969', '9360', '2396');
INSERT INTO `fw_code` VALUES ('2022689', '9999', '228', '4494', '7586', '3190');
INSERT INTO `fw_code` VALUES ('2022688', '9999', '227', '2211', '3161', '4664');
INSERT INTO `fw_code` VALUES ('2022687', '9999', '226', '6844', '9737', '0387');
INSERT INTO `fw_code` VALUES ('2022686', '9999', '225', '2251', '4169', '4503');
INSERT INTO `fw_code` VALUES ('2022685', '9999', '224', '7485', '2141', '1440');
INSERT INTO `fw_code` VALUES ('2022684', '9999', '223', '7419', '4415', '2770');
INSERT INTO `fw_code` VALUES ('2022683', '9999', '222', '2745', '6832', '7208');
INSERT INTO `fw_code` VALUES ('2022682', '9999', '221', '6697', '9995', '2038');
INSERT INTO `fw_code` VALUES ('2022681', '9999', '220', '3640', '7713', '5119');
INSERT INTO `fw_code` VALUES ('2022680', '9999', '219', '8446', '0748', '8020');
INSERT INTO `fw_code` VALUES ('2022679', '9999', '218', '9153', '0879', '7744');
INSERT INTO `fw_code` VALUES ('2022678', '9999', '217', '1651', '2772', '3288');
INSERT INTO `fw_code` VALUES ('2022677', '9999', '216', '2958', '4300', '4226');
INSERT INTO `fw_code` VALUES ('2022676', '9999', '215', '2638', '8098', '8699');
INSERT INTO `fw_code` VALUES ('2022675', '9999', '214', '8726', '5943', '3708');
INSERT INTO `fw_code` VALUES ('2022674', '9999', '213', '2424', '0630', '1681');
INSERT INTO `fw_code` VALUES ('2022673', '9999', '212', '2785', '7840', '7047');
INSERT INTO `fw_code` VALUES ('2022672', '9999', '211', '7338', '2399', '3092');
INSERT INTO `fw_code` VALUES ('2022671', '9999', '210', '8807', '7959', '3386');
INSERT INTO `fw_code` VALUES ('2022670', '9999', '209', '3706', '5439', '3789');
INSERT INTO `fw_code` VALUES ('2022669', '9999', '208', '5776', '2395', '5297');
INSERT INTO `fw_code` VALUES ('2022668', '9999', '207', '5201', '7717', '2914');
INSERT INTO `fw_code` VALUES ('2022667', '9999', '206', '4708', '5054', '0208');
INSERT INTO `fw_code` VALUES ('2022666', '9999', '205', '5496', '7201', '9610');
INSERT INTO `fw_code` VALUES ('2022665', '9999', '204', '1931', '7967', '8976');
INSERT INTO `fw_code` VALUES ('2022664', '9999', '203', '3573', '9986', '6449');
INSERT INTO `fw_code` VALUES ('2022663', '9999', '202', '1117', '9102', '0744');
INSERT INTO `fw_code` VALUES ('2022662', '9999', '201', '3106', '4042', '2574');
INSERT INTO `fw_code` VALUES ('2022661', '9999', '200', '8593', '0490', '6369');
INSERT INTO `fw_code` VALUES ('2022660', '9999', '199', '7765', '7336', '7128');
INSERT INTO `fw_code` VALUES ('2022659', '9999', '198', '0689', '4165', '6708');
INSERT INTO `fw_code` VALUES ('2022658', '9999', '197', '1223', '7836', '9253');
INSERT INTO `fw_code` VALUES ('2022657', '9999', '196', '1076', '8094', '0905');
INSERT INTO `fw_code` VALUES ('2022656', '9999', '195', '2465', '1637', '1521');
INSERT INTO `fw_code` VALUES ('2022655', '9999', '194', '3426', '0245', '8101');
INSERT INTO `fw_code` VALUES ('2022654', '9999', '193', '2505', '2645', '1360');
INSERT INTO `fw_code` VALUES ('2022653', '9999', '192', '4067', '2649', '9154');
INSERT INTO `fw_code` VALUES ('2022652', '9999', '191', '0328', '6955', '1342');
INSERT INTO `fw_code` VALUES ('2022651', '9999', '190', '6671', '3276', '3208');
INSERT INTO `fw_code` VALUES ('2022650', '9999', '189', '6951', '8471', '8896');
INSERT INTO `fw_code` VALUES ('2022649', '9999', '188', '0222', '8221', '2833');
INSERT INTO `fw_code` VALUES ('2022648', '9999', '187', '8700', '9224', '4877');
INSERT INTO `fw_code` VALUES ('2022647', '9999', '186', '5735', '1387', '5458');
INSERT INTO `fw_code` VALUES ('2022646', '9999', '185', '4560', '5312', '1860');
INSERT INTO `fw_code` VALUES ('2022645', '9999', '184', '6884', '0744', '0226');
INSERT INTO `fw_code` VALUES ('2022644', '9999', '183', '2892', '6574', '5556');
INSERT INTO `fw_code` VALUES ('2022643', '9999', '182', '5308', '6451', '1422');
INSERT INTO `fw_code` VALUES ('2022642', '9999', '181', '2678', '9106', '8538');
INSERT INTO `fw_code` VALUES ('2022641', '9999', '180', '9367', '8348', '4762');
INSERT INTO `fw_code` VALUES ('2022640', '9999', '179', '7592', '0875', '9949');
INSERT INTO `fw_code` VALUES ('2022639', '9999', '178', '5389', '8467', '1101');
INSERT INTO `fw_code` VALUES ('2022638', '9999', '177', '3960', '3915', '0646');
INSERT INTO `fw_code` VALUES ('2022637', '9999', '176', '2358', '2903', '3012');
INSERT INTO `fw_code` VALUES ('2022636', '9999', '175', '5455', '6193', '9771');
INSERT INTO `fw_code` VALUES ('2022635', '9999', '174', '1290', '5562', '7922');
INSERT INTO `fw_code` VALUES ('2022634', '9999', '173', '8406', '9741', '8181');
INSERT INTO `fw_code` VALUES ('2022633', '9999', '172', '8513', '8475', '6690');
INSERT INTO `fw_code` VALUES ('2022632', '9999', '171', '6483', '2526', '5021');
INSERT INTO `fw_code` VALUES ('2022631', '9999', '170', '7699', '9610', '8458');
INSERT INTO `fw_code` VALUES ('2022630', '9999', '169', '3360', '2518', '9431');
INSERT INTO `fw_code` VALUES ('2022629', '9999', '168', '5175', '0998', '4083');
INSERT INTO `fw_code` VALUES ('2022628', '9999', '167', '8019', '5812', '3985');
INSERT INTO `fw_code` VALUES ('2022627', '9999', '166', '7271', '4673', '4422');
INSERT INTO `fw_code` VALUES ('2022626', '9999', '165', '4133', '0376', '7824');
INSERT INTO `fw_code` VALUES ('2022625', '9999', '164', '7658', '8602', '8619');
INSERT INTO `fw_code` VALUES ('2022624', '9999', '163', '2719', '0113', '8378');
INSERT INTO `fw_code` VALUES ('2022623', '9999', '162', '0008', '0752', '5815');
INSERT INTO `fw_code` VALUES ('2022622', '9999', '161', '5415', '5185', '9931');
INSERT INTO `fw_code` VALUES ('2022621', '9999', '160', '0649', '3157', '6869');
INSERT INTO `fw_code` VALUES ('2022620', '9999', '159', '0582', '5431', '8199');
INSERT INTO `fw_code` VALUES ('2022619', '9999', '158', '3253', '3784', '0922');
INSERT INTO `fw_code` VALUES ('2022618', '9999', '157', '7205', '6947', '5753');
INSERT INTO `fw_code` VALUES ('2022617', '9999', '156', '6804', '8729', '0547');
INSERT INTO `fw_code` VALUES ('2022616', '9999', '155', '1610', '1764', '3449');
INSERT INTO `fw_code` VALUES ('2022615', '9999', '154', '8549', '4450', '1758');
INSERT INTO `fw_code` VALUES ('2022614', '9999', '153', '1046', '6343', '7302');
INSERT INTO `fw_code` VALUES ('2022613', '9999', '152', '9698', '3807', '6525');
INSERT INTO `fw_code` VALUES ('2022612', '9999', '151', '9378', '7605', '0998');
INSERT INTO `fw_code` VALUES ('2022611', '9999', '150', '5466', '5450', '6007');
INSERT INTO `fw_code` VALUES ('2022610', '9999', '149', '9164', '0137', '3981');
INSERT INTO `fw_code` VALUES ('2022609', '9999', '148', '2181', '1411', '1061');
INSERT INTO `fw_code` VALUES ('2022608', '9999', '147', '4077', '1906', '5391');
INSERT INTO `fw_code` VALUES ('2022607', '9999', '146', '8203', '1529', '7400');
INSERT INTO `fw_code` VALUES ('2022606', '9999', '145', '0446', '4946', '6088');
INSERT INTO `fw_code` VALUES ('2022605', '9999', '144', '5172', '5966', '9311');
INSERT INTO `fw_code` VALUES ('2022604', '9999', '143', '1941', '7224', '5213');
INSERT INTO `fw_code` VALUES ('2022603', '9999', '142', '4103', '8625', '4222');
INSERT INTO `fw_code` VALUES ('2022602', '9999', '141', '4892', '0772', '3624');
INSERT INTO `fw_code` VALUES ('2022601', '9999', '140', '1326', '1538', '2990');
INSERT INTO `fw_code` VALUES ('2022600', '9999', '139', '2969', '3557', '0463');
INSERT INTO `fw_code` VALUES ('2022599', '9999', '138', '0512', '2672', '4758');
INSERT INTO `fw_code` VALUES ('2022598', '9999', '137', '2501', '7613', '6588');
INSERT INTO `fw_code` VALUES ('2022597', '9999', '136', '7989', '4061', '0382');
INSERT INTO `fw_code` VALUES ('2022596', '9999', '135', '4505', '6843', '9427');
INSERT INTO `fw_code` VALUES ('2022595', '9999', '134', '0085', '7736', '0722');
INSERT INTO `fw_code` VALUES ('2022594', '9999', '133', '0619', '1407', '3266');
INSERT INTO `fw_code` VALUES ('2022593', '9999', '132', '0472', '1665', '4918');
INSERT INTO `fw_code` VALUES ('2022592', '9999', '131', '1860', '5208', '5534');
INSERT INTO `fw_code` VALUES ('2022591', '9999', '130', '2822', '3815', '2115');
INSERT INTO `fw_code` VALUES ('2022590', '9999', '129', '1901', '6216', '5374');
INSERT INTO `fw_code` VALUES ('2022589', '9999', '128', '3462', '6220', '3168');
INSERT INTO `fw_code` VALUES ('2022588', '9999', '127', '9724', '0526', '5356');
INSERT INTO `fw_code` VALUES ('2022587', '9999', '126', '6066', '6847', '7222');
INSERT INTO `fw_code` VALUES ('2022586', '9999', '125', '6346', '2042', '2909');
INSERT INTO `fw_code` VALUES ('2022585', '9999', '124', '9617', '1792', '6847');
INSERT INTO `fw_code` VALUES ('2022584', '9999', '123', '8096', '2795', '8891');
INSERT INTO `fw_code` VALUES ('2022583', '9999', '122', '2475', '0894', '7757');
INSERT INTO `fw_code` VALUES ('2022582', '9999', '121', '1300', '4819', '4159');
INSERT INTO `fw_code` VALUES ('2022581', '9999', '120', '6280', '4315', '4240');
INSERT INTO `fw_code` VALUES ('2022580', '9999', '119', '2288', '0145', '9570');
INSERT INTO `fw_code` VALUES ('2022579', '9999', '118', '2048', '5958', '3722');
INSERT INTO `fw_code` VALUES ('2022578', '9999', '117', '2074', '2677', '2552');
INSERT INTO `fw_code` VALUES ('2022577', '9999', '116', '8763', '1919', '8776');
INSERT INTO `fw_code` VALUES ('2022576', '9999', '115', '6987', '4446', '3963');
INSERT INTO `fw_code` VALUES ('2022575', '9999', '114', '4785', '2037', '5115');
INSERT INTO `fw_code` VALUES ('2022574', '9999', '113', '3356', '7486', '4659');
INSERT INTO `fw_code` VALUES ('2022573', '9999', '112', '1753', '6474', '7025');
INSERT INTO `fw_code` VALUES ('2022572', '9999', '111', '4851', '9764', '3784');
INSERT INTO `fw_code` VALUES ('2022571', '9999', '110', '0685', '9133', '1936');
INSERT INTO `fw_code` VALUES ('2022570', '9999', '109', '5146', '9248', '0481');
INSERT INTO `fw_code` VALUES ('2022569', '9999', '108', '5252', '7982', '8989');
INSERT INTO `fw_code` VALUES ('2022568', '9999', '107', '3223', '2033', '7320');
INSERT INTO `fw_code` VALUES ('2022567', '9999', '106', '7094', '3180', '2472');
INSERT INTO `fw_code` VALUES ('2022566', '9999', '105', '2755', '6089', '3445');
INSERT INTO `fw_code` VALUES ('2022565', '9999', '104', '4571', '4569', '8097');
INSERT INTO `fw_code` VALUES ('2022564', '9999', '103', '7415', '9383', '7999');
INSERT INTO `fw_code` VALUES ('2022563', '9999', '102', '6667', '8244', '8436');
INSERT INTO `fw_code` VALUES ('2022562', '9999', '101', '0873', '9883', '0123');
INSERT INTO `fw_code` VALUES ('2022561', '9999', '100', '4398', '8109', '0918');
INSERT INTO `fw_code` VALUES ('2022560', '9999', '99', '2114', '3684', '2391');
INSERT INTO `fw_code` VALUES ('2022559', '9999', '98', '9404', '4323', '9829');
INSERT INTO `fw_code` VALUES ('2022558', '9999', '97', '2155', '4692', '2231');
INSERT INTO `fw_code` VALUES ('2022557', '9999', '96', '0044', '6728', '0883');
INSERT INTO `fw_code` VALUES ('2022556', '9999', '95', '9978', '9002', '2213');
INSERT INTO `fw_code` VALUES ('2022555', '9999', '94', '2648', '7355', '4936');
INSERT INTO `fw_code` VALUES ('2022554', '9999', '93', '6601', '0518', '9766');
INSERT INTO `fw_code` VALUES ('2022553', '9999', '92', '3543', '8236', '2847');
INSERT INTO `fw_code` VALUES ('2022552', '9999', '91', '1006', '5335', '7463');
INSERT INTO `fw_code` VALUES ('2022551', '9999', '90', '9057', '1402', '5472');
INSERT INTO `fw_code` VALUES ('2022550', '9999', '89', '4210', '7359', '2731');
INSERT INTO `fw_code` VALUES ('2022549', '9999', '88', '2862', '4823', '1954');
INSERT INTO `fw_code` VALUES ('2022548', '9999', '87', '2542', '8621', '6427');
INSERT INTO `fw_code` VALUES ('2022547', '9999', '86', '8630', '6466', '1436');
INSERT INTO `fw_code` VALUES ('2022546', '9999', '85', '2328', '1153', '9409');
INSERT INTO `fw_code` VALUES ('2022545', '9999', '84', '2689', '8363', '4775');
INSERT INTO `fw_code` VALUES ('2022544', '9999', '83', '7241', '2922', '0820');
INSERT INTO `fw_code` VALUES ('2022543', '9999', '82', '1367', '2545', '2829');
INSERT INTO `fw_code` VALUES ('2022542', '9999', '81', '3610', '5962', '1516');
INSERT INTO `fw_code` VALUES ('2022541', '9999', '80', '8335', '6982', '4740');
INSERT INTO `fw_code` VALUES ('2022540', '9999', '79', '5105', '8240', '0641');
INSERT INTO `fw_code` VALUES ('2022539', '9999', '78', '4612', '5577', '7936');
INSERT INTO `fw_code` VALUES ('2022538', '9999', '77', '8055', '1788', '9052');
INSERT INTO `fw_code` VALUES ('2022537', '9999', '76', '1834', '8490', '6704');
INSERT INTO `fw_code` VALUES ('2022536', '9999', '75', '6133', '4573', '5892');
INSERT INTO `fw_code` VALUES ('2022535', '9999', '74', '3676', '3688', '0186');
INSERT INTO `fw_code` VALUES ('2022534', '9999', '73', '3009', '4565', '0302');
INSERT INTO `fw_code` VALUES ('2022533', '9999', '72', '1153', '5077', '5811');
INSERT INTO `fw_code` VALUES ('2022532', '9999', '71', '7669', '7859', '4856');
INSERT INTO `fw_code` VALUES ('2022531', '9999', '70', '3249', '8752', '6150');
INSERT INTO `fw_code` VALUES ('2022530', '9999', '69', '3783', '2423', '8695');
INSERT INTO `fw_code` VALUES ('2022529', '9999', '68', '0980', '8617', '8632');
INSERT INTO `fw_code` VALUES ('2022528', '9999', '67', '2368', '2160', '9248');
INSERT INTO `fw_code` VALUES ('2022527', '9999', '66', '3330', '0767', '5829');
INSERT INTO `fw_code` VALUES ('2022526', '9999', '65', '5065', '7232', '0802');
INSERT INTO `fw_code` VALUES ('2022525', '9999', '64', '3971', '3172', '6882');
INSERT INTO `fw_code` VALUES ('2022524', '9999', '63', '0232', '7478', '9070');
INSERT INTO `fw_code` VALUES ('2022523', '9999', '62', '9230', '7863', '2650');
INSERT INTO `fw_code` VALUES ('2022522', '9999', '61', '9510', '3058', '8338');
INSERT INTO `fw_code` VALUES ('2022521', '9999', '60', '0125', '8744', '0561');
INSERT INTO `fw_code` VALUES ('2022520', '9999', '59', '1260', '3811', '4320');
INSERT INTO `fw_code` VALUES ('2022519', '9999', '58', '5639', '1910', '3186');
INSERT INTO `fw_code` VALUES ('2022518', '9999', '57', '4464', '5835', '9588');
INSERT INTO `fw_code` VALUES ('2022517', '9999', '56', '9444', '5331', '9668');
INSERT INTO `fw_code` VALUES ('2022516', '9999', '55', '2796', '7097', '3284');
INSERT INTO `fw_code` VALUES ('2022515', '9999', '54', '5212', '6974', '9150');
INSERT INTO `fw_code` VALUES ('2022514', '9999', '53', '2582', '9629', '6266');
INSERT INTO `fw_code` VALUES ('2022513', '9999', '52', '9271', '8871', '2490');
INSERT INTO `fw_code` VALUES ('2022512', '9999', '51', '0151', '5462', '9392');
INSERT INTO `fw_code` VALUES ('2022511', '9999', '50', '7949', '3053', '0543');
INSERT INTO `fw_code` VALUES ('2022510', '9999', '49', '3864', '4438', '8373');
INSERT INTO `fw_code` VALUES ('2022509', '9999', '48', '2262', '3426', '0740');
INSERT INTO `fw_code` VALUES ('2022508', '9999', '47', '5359', '6716', '7498');
INSERT INTO `fw_code` VALUES ('2022507', '9999', '46', '1194', '6085', '5650');
INSERT INTO `fw_code` VALUES ('2022506', '9999', '45', '8310', '0264', '5909');
INSERT INTO `fw_code` VALUES ('2022505', '9999', '44', '8416', '8998', '4418');
INSERT INTO `fw_code` VALUES ('2022504', '9999', '43', '6387', '3049', '2749');
INSERT INTO `fw_code` VALUES ('2022503', '9999', '42', '0258', '4196', '7901');
INSERT INTO `fw_code` VALUES ('2022502', '9999', '41', '5919', '7105', '8874');
INSERT INTO `fw_code` VALUES ('2022501', '9999', '40', '7735', '5585', '3525');
INSERT INTO `fw_code` VALUES ('2022500', '9999', '39', '0579', '0399', '3427');
INSERT INTO `fw_code` VALUES ('2022499', '9999', '38', '9831', '9260', '3865');
INSERT INTO `fw_code` VALUES ('2022498', '9999', '37', '4037', '0899', '5552');
INSERT INTO `fw_code` VALUES ('2022497', '9999', '36', '7562', '9125', '6347');
INSERT INTO `fw_code` VALUES ('2022496', '9999', '35', '5278', '4700', '7820');
INSERT INTO `fw_code` VALUES ('2022495', '9999', '34', '9912', '1275', '3543');
INSERT INTO `fw_code` VALUES ('2022494', '9999', '33', '5319', '5708', '7659');
INSERT INTO `fw_code` VALUES ('2022493', '9999', '32', '0553', '3680', '4597');
INSERT INTO `fw_code` VALUES ('2022492', '9999', '31', '3142', '0018', '7642');
INSERT INTO `fw_code` VALUES ('2022491', '9999', '30', '5812', '8371', '0365');
INSERT INTO `fw_code` VALUES ('2022490', '9999', '29', '9764', '1534', '5195');
INSERT INTO `fw_code` VALUES ('2022489', '9999', '28', '6707', '9252', '8275');
INSERT INTO `fw_code` VALUES ('2022488', '9999', '27', '1514', '2287', '1177');
INSERT INTO `fw_code` VALUES ('2022487', '9999', '26', '2221', '2418', '0900');
INSERT INTO `fw_code` VALUES ('2022486', '9999', '25', '4718', '4311', '6445');
INSERT INTO `fw_code` VALUES ('2022485', '9999', '24', '6026', '5839', '7383');
INSERT INTO `fw_code` VALUES ('2022484', '9999', '23', '5706', '9637', '1856');
INSERT INTO `fw_code` VALUES ('2022483', '9999', '22', '1794', '7482', '6865');
INSERT INTO `fw_code` VALUES ('2022482', '9999', '21', '5492', '2169', '4838');
INSERT INTO `fw_code` VALUES ('2022481', '9999', '20', '5853', '9379', '0204');
INSERT INTO `fw_code` VALUES ('2022480', '9999', '19', '0405', '3938', '6249');
INSERT INTO `fw_code` VALUES ('2022479', '9999', '18', '4531', '3561', '8258');
INSERT INTO `fw_code` VALUES ('2022478', '9999', '17', '6774', '6978', '6945');
INSERT INTO `fw_code` VALUES ('2022477', '9999', '16', '8844', '3934', '8454');
INSERT INTO `fw_code` VALUES ('2022476', '9999', '15', '8269', '9256', '6070');
INSERT INTO `fw_code` VALUES ('2022475', '9999', '14', '7775', '6593', '3365');
INSERT INTO `fw_code` VALUES ('2022474', '9999', '13', '1219', '2804', '4481');
INSERT INTO `fw_code` VALUES ('2022473', '9999', '12', '4998', '9506', '2132');
INSERT INTO `fw_code` VALUES ('2022472', '9999', '11', '9297', '5589', '1320');
INSERT INTO `fw_code` VALUES ('2022471', '9999', '10', '4184', '0641', '3900');
INSERT INTO `fw_code` VALUES ('2022470', '9999', '9', '6173', '5581', '5731');
INSERT INTO `fw_code` VALUES ('2022469', '9999', '8', '4317', '6093', '1240');
INSERT INTO `fw_code` VALUES ('2022468', '9999', '7', '0833', '8875', '0284');
INSERT INTO `fw_code` VALUES ('2022467', '9999', '6', '3757', '5704', '9865');
INSERT INTO `fw_code` VALUES ('2022466', '9999', '5', '4291', '9375', '2409');
INSERT INTO `fw_code` VALUES ('2022465', '9999', '4', '4144', '9633', '4061');
INSERT INTO `fw_code` VALUES ('2022464', '9999', '3', '5532', '3176', '4677');
INSERT INTO `fw_code` VALUES ('2022463', '9999', '2', '6494', '1783', '1257');
INSERT INTO `fw_code` VALUES ('2022462', '9999', '1', '5573', '4184', '4516');

-- ----------------------------
-- Table structure for fw_cust
-- ----------------------------
DROP TABLE IF EXISTS `fw_cust`;
CREATE TABLE `fw_cust` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `unitcode` varchar(4) DEFAULT NULL,
  `unitname` varchar(64) DEFAULT NULL,
  `addr` varchar(64) DEFAULT NULL,
  `master` varchar(80) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `post` varchar(20) DEFAULT NULL,
  `fax` varchar(64) DEFAULT NULL,
  `property` varchar(100) DEFAULT NULL,
  `remark` int(254) DEFAULT NULL,
  `codelen` int(11) DEFAULT NULL,
  `mlength` int(11) DEFAULT NULL,
  `maxvalue` varchar(64) DEFAULT NULL,
  `regdate` datetime DEFAULT NULL,
  `operator` varchar(64) DEFAULT NULL,
  `overk` int(11) DEFAULT NULL,
  `voicewelcome` varchar(254) DEFAULT NULL,
  `smsnote` varchar(500) DEFAULT NULL,
  `bcode` varchar(1) DEFAULT NULL,
  `upyn` varchar(1) DEFAULT NULL,
  `voicere` varchar(150) DEFAULT NULL,
  `renote` varchar(500) DEFAULT NULL,
  `vlen` int(11) DEFAULT NULL,
  `jfyn` varchar(1) DEFAULT NULL,
  `zjyn` varchar(1) DEFAULT NULL,
  `aajf` decimal(18,2) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `p_no` varchar(20) DEFAULT NULL,
  `unitinfo` varchar(500) DEFAULT NULL,
  `prodinfo` varchar(500) DEFAULT NULL,
  `zp` longblob,
  `ccodeyn` varchar(1) DEFAULT NULL,
  `ctype` varchar(20) DEFAULT NULL,
  `sntype` varchar(32) DEFAULT NULL,
  `snLen` int(11) DEFAULT NULL,
  `msnlength` int(11) DEFAULT NULL,
  `dckyn` varchar(1) DEFAULT NULL,
  `snpr` varchar(10) DEFAULT NULL,
  `chrtype` varchar(32) DEFAULT NULL,
  `ncxtype` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_cust
-- ----------------------------
INSERT INTO `fw_cust` VALUES ('1', '9999', '测试（大小标流水码）', '', '', '', '', '', '', '0', '12', '2316', '800000万', '2015-08-26 00:00:00', '', '0', '', '您好，您查询的防伪码为正牌产品,请放心使用!', 'N', 'N', '', '', '0', 'N', 'N', '0.00', '', '', '', '', null, 'N', '', '4-双码流水号2', null, '0', 'N', '', '', '');

-- ----------------------------
-- Table structure for fw_dealer
-- ----------------------------
DROP TABLE IF EXISTS `fw_dealer`;
CREATE TABLE `fw_dealer` (
  `dl_id` int(11) NOT NULL AUTO_INCREMENT,
  `dl_unitcode` varchar(32) DEFAULT NULL,
  `dl_openid` varchar(64) DEFAULT NULL COMMENT '微信openid',
  `dl_username` varchar(64) DEFAULT NULL,
  `dl_pwd` varchar(64) DEFAULT NULL,
  `dl_number` varchar(32) DEFAULT NULL,
  `dl_name` varchar(128) DEFAULT NULL,
  `dl_des` text,
  `dl_area` varchar(128) DEFAULT NULL,
  `dl_type` int(11) DEFAULT '0' COMMENT '代理级别分类1',
  `dl_sttype` int(11) DEFAULT '0' COMMENT '代理级别分类2',
  `dl_belong` int(11) DEFAULT '0' COMMENT '该经销商所属 上家',
  `dl_referee` int(11) DEFAULT '0' COMMENT '推荐人',
  `dl_level` int(4) DEFAULT '0' COMMENT '经销商级数',
  `dl_contact` varchar(32) DEFAULT NULL,
  `dl_tel` varchar(32) DEFAULT NULL,
  `dl_fax` varchar(32) DEFAULT NULL,
  `dl_email` varchar(64) DEFAULT NULL,
  `dl_weixin` varchar(32) DEFAULT NULL,
  `dl_wxnickname` varchar(64) DEFAULT NULL,
  `dl_wxsex` int(4) DEFAULT '0',
  `dl_wxprovince` varchar(32) DEFAULT NULL,
  `dl_wxcity` varchar(32) DEFAULT NULL,
  `dl_wxcountry` varchar(32) DEFAULT NULL,
  `dl_wxheadimg` varchar(512) DEFAULT NULL,
  `dl_qq` varchar(32) DEFAULT NULL,
  `dl_country` int(11) DEFAULT '0' COMMENT '国家',
  `dl_sheng` int(11) DEFAULT '0',
  `dl_shi` int(11) DEFAULT '0',
  `dl_qu` int(11) DEFAULT '0',
  `dl_qustr` varchar(64) DEFAULT NULL,
  `dl_address` varchar(64) DEFAULT NULL,
  `dl_idcard` varchar(64) DEFAULT NULL,
  `dl_idcardpic` varchar(64) DEFAULT NULL COMMENT '身份证图片',
  `dl_idcardpic2` varchar(64) DEFAULT NULL,
  `dl_bank` int(11) NOT NULL DEFAULT '0' COMMENT '开户行类型',
  `dl_bankcard` varchar(128) NOT NULL COMMENT '开户行卡号',
  `dl_tbdian` varchar(128) DEFAULT NULL COMMENT '淘宝店店铺名',
  `dl_tbzhanggui` varchar(128) DEFAULT NULL COMMENT '淘宝店掌柜名',
  `dl_tbsqpic` varchar(64) DEFAULT NULL COMMENT '淘宝授权书',
  `dl_tblevel` int(11) DEFAULT NULL COMMENT '淘宝授权级别',
  `dl_remark` varchar(512) DEFAULT NULL,
  `dl_status` int(4) DEFAULT NULL,
  `dl_startdate` int(11) DEFAULT NULL,
  `dl_enddate` int(11) DEFAULT NULL,
  `dl_addtime` int(11) DEFAULT NULL,
  `dl_pic` varchar(64) DEFAULT NULL,
  `dl_brand` varchar(128) DEFAULT NULL COMMENT '授权品牌',
  `dl_brandlevel` varchar(64) DEFAULT NULL COMMENT '授权品牌级别',
  `dl_oddtime` int(11) DEFAULT '0' COMMENT '出货单号计数日期',
  `dl_oddcount` int(11) DEFAULT '0' COMMENT '出货单号计数',
  `dl_logintime` int(11) DEFAULT '0',
  `dl_fanli` decimal(10,2) DEFAULT '0.00' COMMENT '代理返利金额',
  `dl_jifen` int(11) DEFAULT '0' COMMENT '代理积分',
  `dl_lastflid` int(11) DEFAULT '0' COMMENT '记录最近计算结束的返利明细id',
  `dl_flmodel` int(11) DEFAULT '0' COMMENT '[明臣使用]推荐人选择的返利模式，1-一次性  ',
  `dl_deposit` decimal(10,2) DEFAULT '0.00' COMMENT '保证金',
  `dl_depositpic` varchar(32) DEFAULT NULL COMMENT '保证金支付图',
  `dl_paypic` varchar(32) DEFAULT NULL COMMENT '支付凭证图',
  `dl_stockpic` varchar(64) NOT NULL COMMENT '股权证书图',
  PRIMARY KEY (`dl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_dealer
-- ----------------------------
INSERT INTO `fw_dealer` VALUES ('32', '9999', '', 'test', '66730c784751efc66db25382bd59bbbb', 'No:0000032', '李生', '', '', '7', '0', '0', '0', '1', '李生', '13999999999', '', '', 'test99', '', '0', '', '', '', '', '', '0', '11', '1101', '0', '北京 东城区 ', '北京东城区', '110101199901012198', '', '', '3', '1a49iPyvFM2v3K/fSxRY56oJVIsTclUcj6RlmX+UByw469GaUJpFiJhQuuC1jsYg', '', '', null, null, '', '1', '1510588800', '1567065677', '1510623703', '9999/1542179205_32_4968.jpg', '', '', '0', '0', '1542594204', '0.00', '0', '0', '0', '1000.00', null, null, '');
INSERT INTO `fw_dealer` VALUES ('79', '9999', '', '15875872791', '587ccacd43c51cad35df059b107a9577', 'A0000079', '钟琪1', null, null, '7', '0', '0', '32', '1', '钟琪1', '15875872791', null, null, '15875872791', '', '0', '', '', '', '', null, '0', '44', '4401', '440103', '广东 广州 荔湾区', '广东广州荔湾区', '440804199606160571', '', '', '1', 'b3d4RCuRO70KhvZpb8Nr4u9qVUpCiJ0lW4wpnuM4oBOIMdQ1jqZujEvvuA', '', '', null, null, '', '1', '1540950485', '1572486485', '1540950475', null, '', '', '0', '0', '0', '0.00', '0', '0', '0', '0.00', null, null, '');
INSERT INTO `fw_dealer` VALUES ('80', '9999', '', '15875872792', '1bde2478115e4e64b4f71e030dc33710', 'A0000080', '钟琪2', null, null, '7', '0', '0', '79', '1', '钟琪2', '15875872792', null, null, '15875872792', '', '0', '', '', '', '', null, '0', '44', '4401', '440103', '广东 广州 荔湾区', '广东广州荔湾区', '440804199606160572', '', '', '1', '855fe2zbD/+UOTNkVM3Hbhy9ae88+oGBvye5i5eHhOivOvCWhV4vKzd/yJE7Im8', '', '', null, null, '', '1', '1540950657', '1572486657', '1540950647', null, '', '', '0', '0', '0', '0.00', '0', '0', '0', '0.00', null, null, '');
INSERT INTO `fw_dealer` VALUES ('78', '9999', '', '15875872790', 'a1192f2a37b6ed6186223e5bde729817', 'No:0000043', '钟琪', '', '', '8', '0', '32', '79', '2', '15875872791', '15875872790', '15875872791', '522402295@qq.com', '15875872790', '', '0', null, null, null, null, '522402295', '0', '0', '0', '0', null, '广东省', '440804199606160571', '', null, '0', '', '', '', null, '0', 'sdf', '1', null, null, '1540782043', '', null, null, '0', '0', '1541408978', '0.00', '0', '0', '0', '0.00', null, null, '');
INSERT INTO `fw_dealer` VALUES ('81', null, null, null, null, null, null, null, null, '0', '0', '0', '79', '0', null, null, null, null, null, null, '0', null, null, null, null, null, '0', '0', '0', '0', null, null, null, null, null, '0', '', null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', '0', '0.00', '0', '0', '0', '0.00', null, null, '');

-- ----------------------------
-- Table structure for fw_dealerlogs
-- ----------------------------
DROP TABLE IF EXISTS `fw_dealerlogs`;
CREATE TABLE `fw_dealerlogs` (
  `dlg_id` int(11) NOT NULL AUTO_INCREMENT,
  `dlg_unitcode` int(32) DEFAULT NULL COMMENT '企业码',
  `dlg_dlid` int(11) DEFAULT '0' COMMENT '对应代理id',
  `dlg_type` int(11) DEFAULT '0' COMMENT '0-公司操作 1-代理操作',
  `dlg_operatid` int(11) DEFAULT '0' COMMENT '操作者id',
  `dlg_dlusername` varchar(32) DEFAULT NULL COMMENT '操作者用户名',
  `dlg_dlname` varchar(32) DEFAULT NULL COMMENT '操作者名',
  `dlg_action` varchar(64) DEFAULT NULL COMMENT '动作',
  `dlg_addtime` int(11) DEFAULT NULL COMMENT '操作时间',
  `dlg_link` varchar(256) DEFAULT NULL COMMENT '操作链接',
  `dlg_ip` varchar(32) DEFAULT NULL COMMENT '操作ip',
  PRIMARY KEY (`dlg_id`),
  KEY `dlg_unitcode` (`dlg_unitcode`),
  KEY `dlg_dlid` (`dlg_dlid`)
) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=utf8 COMMENT='代理商操作日志表';

-- ----------------------------
-- Records of fw_dealerlogs
-- ----------------------------
INSERT INTO `fw_dealerlogs` VALUES ('106', '9999', '42', '1', '42', 'test08', '康生', '代理商注册 自己申请', '1512100814', '/Kangli/Kangli/Apply/index', '127.0.0.1');
INSERT INTO `fw_dealerlogs` VALUES ('107', '9999', '44', '1', '44', 'test0301', '李生', '代理商注册 自己申请', '1516171715', 'D:\\wamp64\\www\\Klapi\\klapi/controller/v1/dealer/apply', '192.168.1.134');
INSERT INTO `fw_dealerlogs` VALUES ('108', '9999', '45', '1', '45', 'test0101', '康生', '代理商注册 自己申请', '1526525736', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('109', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1526525924', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('110', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1526525986', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('111', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1526526001', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('112', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1526526018', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('113', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1526526050', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('114', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1526526069', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('115', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1526526075', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('116', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1526526154', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('117', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1526526240', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('118', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1526526272', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('119', '9999', '45', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1526526404', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('120', '9999', '38', '1', '38', '蔡生', 'test03', '代理商申请提现', '1526639732', '192.168.1.134/klapi/controller/fanli/recash_save', '192.168.1.134');
INSERT INTO `fw_dealerlogs` VALUES ('121', '9999', '44', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-9', '1534920579', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('122', '9999', '42', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1534926210', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('123', '9999', '44', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535004810', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('124', '9999', '44', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-9', '1535004822', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('125', '9999', '48', '1', '48', '13226269695', '钟琪', '代理商注册 推荐人：test99 上家：总公司', '1535092816', '/Kangli/Kangli/Dealer/apply', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('126', '9999', '48', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535092953', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('127', '9999', '32', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535093581', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('128', '9999', '49', '1', '49', '13226269696', '钟琪2', '代理商注册 自己申请', '1535093967', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('129', '9999', '49', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535094012', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('130', '9999', '49', '0', '995', 'kangli', 'kangli', '修改经销商有效时间-2', '1535096487', '/Kangli/Mp/Dealer/update_date', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('131', '9999', '50', '1', '50', '13226269652', '钟琪3', '代理商注册 推荐人：test99 上家：总公司', '1535160559', '/Kangli/Kangli/Dealer/apply', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('132', '9999', '50', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535160764', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('133', '9999', '50', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535161302', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('134', '9999', '51', '1', '51', '13226269652', '钟琪3', '代理商注册 自己申请', '1535161807', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('135', '9999', '51', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535161860', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('136', '9999', '44', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535162395', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('137', '9999', '52', '1', '52', '13226269620', '钟琪4', '代理商注册 自己申请', '1535162408', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('138', '9999', '52', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535162534', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('139', '9999', '53', '1', '53', '13226269542', '钟琪5', '代理商注册 自己申请', '1535181999', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('140', '9999', '53', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535182148', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('141', '9999', '53', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535182282', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('142', '9999', '32', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-9', '1535187688', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('143', '9999', '32', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535187698', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('144', '9999', '54', '1', '54', '13226269524', 'z', '代理商注册 自己申请', '1535188450', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('145', '9999', '54', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535188496', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('146', '9999', '55', '1', '55', '13226265489', 'c', '代理商注册 自己申请', '1535189263', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('147', '9999', '55', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535189317', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('148', '9999', '56', '1', '56', '15875872797', '钟琪5', '代理商注册 自己申请', '1535333668', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('149', '9999', '56', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535333888', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('150', '9999', '57', '1', '57', '15875872798', '钟琪6', '代理商注册 自己申请', '1535334065', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('151', '9999', '57', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535334179', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('152', '9999', '58', '1', '58', '15875872798', '钟琪6', '代理商注册 自己申请', '1535334570', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('153', '9999', '58', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535334637', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('154', '9999', '59', '1', '59', '15875872798', '钟琪6', '代理商注册 自己申请', '1535334889', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('155', '9999', '59', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535334939', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('156', '9999', '60', '1', '60', '15875872711', '钟琪7', '代理商注册 自己申请', '1535335722', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('157', '9999', '60', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535335787', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('158', '9999', '61', '1', '61', '15875872712', '钟琪8', '代理商注册 自己申请', '1535336255', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('159', '9999', '61', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535336430', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('160', '9999', '62', '1', '62', '15875872798', '钟琪6', '代理商注册 自己申请', '1535340598', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('161', '9999', '62', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535340626', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('162', '9999', '63', '1', '63', '15875872799', '钟琪9', '代理商注册 自己申请', '1535341499', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('163', '9999', '63', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535341543', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('164', '9999', '46', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1535440844', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('165', '9999', '46', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-9', '1535440959', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('166', '9999', '64', '1', '64', '15875872801', '钟琪10', '代理商注册 自己申请', '1535511657', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('167', '9999', '64', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535511728', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('168', '9999', '65', '1', '65', '15875872802', '钟琪11', '代理商注册 自己申请', '1535512090', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('169', '9999', '65', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535512150', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('170', '9999', '32', '0', '995', 'kangli', 'kangli', '修改经销商有效时间-1', '1535529677', '/Kangli/Mp/Dealer/update_date', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('171', '9999', '32', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1535529684', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('172', '9999', '32', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535529695', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('173', '9999', '32', '0', '995', 'kangli', 'kangli', '修改经销商保证金-1000', '1535530883', '/Kangli/Mp/Dealer/deposit_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('174', '9999', '32', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1535536414', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('175', '9999', '32', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535536423', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('176', '9999', '32', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535536488', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('177', '9999', '66', '1', '66', '15875872803', '钟琪12', '代理商注册 自己申请', '1535592894', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('178', '9999', '66', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535593040', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('179', '9999', '66', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-0', '1535593066', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('180', '9999', '67', '1', '67', '15875872804', '钟琪13', '代理商注册 自己申请', '1535593432', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('181', '9999', '68', '1', '68', '15875872805', '钟琪14', '代理商注册 自己申请', '1535597272', '/Kangli/Kangli/Apply/index', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('182', '9999', '68', '0', '995', 'kangli', 'kangli', '审核/禁用经销商-1', '1535597346', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('183', '9999', '69', '1', '69', '124512365489', '低功耗', '代理商注册 推荐人：test99 上家：总公司', '1535959069', '/Kangli/Kangli/Dealer/apply', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('184', '9999', '32', '1', '32', 'test99', '李生', '代理商申请提现', '1536136544', '/Kangli/Kangli/Fanli/recash_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('185', '9999', '32', '1', '32', 'test99', '李生', '代理商申请提现', '1536136850', '/Kangli/Kangli/Fanli/recash_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('186', '9999', '56', '1', '56', '15875872797', '钟琪5', '代理商申请提现', '1536222662', '/Kangli/Kangli/Fanli/recash_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('187', '9999', '68', '0', '995', 'test', 'test', '手动增加余额：10000', '1540542855', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('188', '9999', '68', '0', '995', 'test', 'test', '手动增加预付款：20000', '1540542868', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('189', '9999', '49', '0', '995', 'test', 'test', '手动增加预付款：20000', '1540542911', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('190', '9999', '79', '1', '79', '15875872791', '钟琪1', '代理商注册 推荐人：test 上家：总公司', '1540950475', '/Kangli/Kangli/Dealer/apply', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('191', '9999', '79', '0', '995', 'test', 'test', '审核/禁用经销商-1', '1540950485', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('192', '9999', '80', '1', '80', '15875872792', '钟琪2', '代理商注册 推荐人：z522402295 上家：总公司', '1540950647', '/Kangli/Kangli/Dealer/apply', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('193', '9999', '80', '0', '995', 'test', 'test', '审核/禁用经销商-1', '1540950657', '/Kangli/Mp/Dealer/active', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('194', '9999', '32', '0', '995', 'test', 'test', '手动增加预付款：1000', '1541123145', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('195', '9999', '32', '0', '995', 'test', 'test', '手动增加余额：999', '1541123161', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('196', '9999', '32', '0', '995', 'test', 'test', '手动增加预付款：65', '1541145056', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('197', '9999', '32', '0', '995', 'test', 'test', '手动增加预付款：66', '1541145065', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('198', '9999', '32', '0', '995', 'test', 'test', '手动增加余额：569', '1541145074', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('199', '9999', '32', '0', '995', 'test', 'test', '手动减少余额：63', '1541145082', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('200', '9999', '32', '0', '995', 'test', 'test', '手动减少余额：5', '1541145091', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('201', '9999', '79', '0', '995', 'test', 'test', '手动增加预付款：1000', '1541145172', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('202', '9999', '79', '0', '995', 'test', 'test', '手动增加预付款：800', '1541145182', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('203', '9999', '79', '0', '995', 'test', 'test', '手动减少预付款：20', '1541145192', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('204', '9999', '79', '0', '995', 'test', 'test', '手动增加余额：6000', '1541145204', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('205', '9999', '79', '0', '995', 'test', 'test', '手动增加余额：3000', '1541145215', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('206', '9999', '79', '0', '995', 'test', 'test', '手动减少余额：2000', '1541145223', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('207', '9999', '80', '0', '995', 'test', 'test', '手动增加预付款：100', '1541208698', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('208', '9999', '80', '0', '995', 'test', 'test', '手动减少预付款：20', '1541208707', '/Kangli/Mp/Capital/yufukuanadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('209', '9999', '80', '0', '995', 'test', 'test', '手动增加余额：200', '1541208717', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');
INSERT INTO `fw_dealerlogs` VALUES ('210', '9999', '80', '0', '995', 'test', 'test', '手动减少余额：10', '1541208728', '/Kangli/Mp/Capital/yueadd_save', '0.0.0.0');

-- ----------------------------
-- Table structure for fw_denyip
-- ----------------------------
DROP TABLE IF EXISTS `fw_denyip`;
CREATE TABLE `fw_denyip` (
  `deny_id` int(11) NOT NULL AUTO_INCREMENT,
  `deny_ip` varchar(32) DEFAULT NULL,
  `deny_remark` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`deny_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='禁止ip表';

-- ----------------------------
-- Records of fw_denyip
-- ----------------------------

-- ----------------------------
-- Table structure for fw_dladdress
-- ----------------------------
DROP TABLE IF EXISTS `fw_dladdress`;
CREATE TABLE `fw_dladdress` (
  `dladd_id` int(11) NOT NULL AUTO_INCREMENT,
  `dladd_unitcode` varchar(32) DEFAULT NULL,
  `dladd_dlid` int(11) DEFAULT NULL COMMENT '代理商id',
  `dladd_contact` varchar(64) DEFAULT NULL COMMENT '联系人',
  `dladd_sheng` int(11) DEFAULT '0' COMMENT '省',
  `dladd_shi` int(11) DEFAULT '0' COMMENT '市',
  `dladd_qu` int(11) DEFAULT '0' COMMENT '区',
  `dladd_diqustr` varchar(64) DEFAULT NULL COMMENT '地区',
  `dladd_address` varchar(64) DEFAULT NULL COMMENT '地址',
  `dladd_tel` varchar(32) DEFAULT NULL,
  `dladd_default` int(11) DEFAULT '0' COMMENT '默认',
  `dladd_customer` int(11) DEFAULT '0' COMMENT '是否代理的客户',
  PRIMARY KEY (`dladd_id`),
  KEY `dladd_unitcode` (`dladd_unitcode`),
  KEY `dladd_dlid` (`dladd_dlid`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='经销商地址表';

-- ----------------------------
-- Records of fw_dladdress
-- ----------------------------
INSERT INTO `fw_dladdress` VALUES ('52', '9999', '32', '周生', '440000', '440100', '440104', '广东省 广州市 越秀区', '广东省广州市越秀区越华路112 珠江国际大厦', '13999999998', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('38', '9999', '33', '陈生', '44', '4401', '440104', '广东 广州 越秀区', '广东广州越秀区', '13011111111', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('39', '9999', '34', '陈生', '44', '4401', '440104', '广东 广州 越秀区', '广东广州越秀区', '13011010101', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('40', '9999', '35', '罗生', '12', '1201', '0', '天津 和平区 ', '天津和平区', '13022020202', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('41', '9999', '36', '邓生', '31', '3101', '0', '上海 黄浦区 ', '上海黄浦区', '13002010201', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('42', '9999', '37', '钟生', '44', '4401', '440103', '广东 广州 荔湾区', '广东广州荔湾区', '13001001001', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('43', '9999', '38', '蔡生', '21', '2101', '210103', '辽宁 沈阳 沈河区', '辽宁沈阳沈河区', '13003030303', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('44', '9999', '39', '刘生', '44', '4401', '440104', '广东 广州 越秀区', '广东广州越秀区', '13011110110', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('46', '9999', '41', '邱生', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13666060606', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('47', '9999', '42', '康生', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13666666666', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('49', '9999', '44', '李生', '440000', '440100', '440103', '广东省 广州市 荔湾区', '广东省广州市荔湾区西关 西关', '13003010301', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('51', '9999', '32', '李生', '440000', '440100', '440104', '广东省 广州市 越秀区', '广东省广州市越秀区府前路1号 广州市政府', '13999999999', '0', '0');
INSERT INTO `fw_dladdress` VALUES ('54', '9999', '45', '康生', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13901010101', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('55', '9999', '48', '钟琪', '11', '1101', '0', '北京 东城区 ', '北京东城区', '15875872797', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('56', '9999', '49', '钟琪2', '11', '1101', '0', '北京 东城区 ', '北京东城区', '15875872799', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('69', '9999', '62', '钟琪6', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523911', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('59', '9999', '52', '钟琪4', '11', '1101', '0', '北京 东城区 ', '北京东城区', '12154232154', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('67', '9999', '60', '钟琪7', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523909', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('63', '9999', '56', '钟琪5', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523907', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('62', '9999', '55', 'c', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822521420', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('68', '9999', '61', '钟琪8', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523910', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('70', '9999', '63', '钟琪9', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523912', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('71', '9999', '64', '钟琪10', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523913', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('72', '9999', '65', '钟琪11', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523914', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('73', '9999', '66', '钟琪12', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523915', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('74', '9999', '67', '钟琪13', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523916', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('75', '9999', '68', '钟琪14', '11', '1101', '0', '北京 东城区 ', '北京东城区', '13822523917', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('77', '9999', '78', '钟琪', '44', '4401', '440103', '广东 广州 荔湾区', '广东广州荔湾区', '15875872797', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('78', '9999', '79', '钟琪1', '44', '4401', '440103', '广东 广州 荔湾区', '广东广州荔湾区', '15875872791', '1', '0');
INSERT INTO `fw_dladdress` VALUES ('79', '9999', '80', '钟琪2', '44', '4401', '440103', '广东 广州 荔湾区', '广东广州荔湾区', '15875872792', '1', '0');

-- ----------------------------
-- Table structure for fw_dljfdetail
-- ----------------------------
DROP TABLE IF EXISTS `fw_dljfdetail`;
CREATE TABLE `fw_dljfdetail` (
  `dljf_id` int(11) NOT NULL AUTO_INCREMENT,
  `dljf_unitcode` varchar(32) DEFAULT NULL,
  `dljf_dlid` int(11) DEFAULT '0' COMMENT '代理id',
  `dljf_username` varchar(32) DEFAULT NULL COMMENT '代理用户名',
  `dljf_type` int(11) DEFAULT '0' COMMENT '积分类型',
  `dljf_jf` int(11) DEFAULT '0' COMMENT '积分',
  `dljf_addtime` int(11) DEFAULT NULL,
  `dljf_ip` varchar(32) DEFAULT NULL,
  `dljf_actionuser` varchar(32) DEFAULT NULL COMMENT '积分操作者',
  `dljf_odid` int(11) DEFAULT '0' COMMENT '订单流水id',
  `dljf_orderid` varchar(32) DEFAULT NULL COMMENT '订单orderid',
  `dljf_odblid` int(11) DEFAULT '0' COMMENT '订单关系id',
  `dljf_proid` int(11) DEFAULT '0' COMMENT '订单产品id',
  `dljf_qty` int(11) DEFAULT '0' COMMENT '订单数量',
  `dljf_remark` varchar(256) DEFAULT NULL COMMENT '简单说明',
  PRIMARY KEY (`dljf_id`),
  KEY `jf_uintcode` (`dljf_unitcode`),
  KEY `jf_code` (`dljf_orderid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='代购积分详细';

-- ----------------------------
-- Records of fw_dljfdetail
-- ----------------------------
INSERT INTO `fw_dljfdetail` VALUES ('1', '9999', '68', '15875872805', '2', '100', '1540622312', '0.0.0.0', 'test', '0', '', '0', '0', '0', 'dfgdf');
INSERT INTO `fw_dljfdetail` VALUES ('2', '9999', '68', '15875872805', '2', '120', '1540622343', '0.0.0.0', 'test', '0', '', '0', '0', '0', 'yhj');
INSERT INTO `fw_dljfdetail` VALUES ('3', '9999', '67', '15875872804', '2', '40', '1540622554', '0.0.0.0', 'test', '0', '', '0', '0', '0', 'setyety');
INSERT INTO `fw_dljfdetail` VALUES ('4', '9999', '66', '15875872803', '2', '60', '1540622592', '0.0.0.0', 'test', '0', '', '0', '0', '0', 'gfhjf');

-- ----------------------------
-- Table structure for fw_dljfexchange
-- ----------------------------
DROP TABLE IF EXISTS `fw_dljfexchange`;
CREATE TABLE `fw_dljfexchange` (
  `exch_id` int(11) NOT NULL AUTO_INCREMENT,
  `exch_unitcode` varchar(32) DEFAULT NULL,
  `exch_jf` int(11) DEFAULT NULL,
  `exch_qty` int(11) DEFAULT NULL,
  `exch_dlid` int(11) DEFAULT '0' COMMENT '兑换代理id',
  `exch_username` varchar(64) DEFAULT NULL COMMENT '用户名',
  `exch_contact` varchar(32) DEFAULT NULL,
  `exch_tel` varchar(32) DEFAULT NULL,
  `exch_address` varchar(254) DEFAULT NULL,
  `exch_msg` varchar(512) DEFAULT NULL,
  `exch_kuaidi` varchar(32) DEFAULT NULL,
  `exch_kdhao` varchar(32) DEFAULT NULL,
  `exch_time` int(11) DEFAULT NULL,
  `exch_remark` varchar(512) DEFAULT NULL,
  `exch_state` int(4) DEFAULT NULL,
  `exch_ip` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`exch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代购积分兑换';

-- ----------------------------
-- Records of fw_dljfexchange
-- ----------------------------

-- ----------------------------
-- Table structure for fw_dljfexchdetail
-- ----------------------------
DROP TABLE IF EXISTS `fw_dljfexchdetail`;
CREATE TABLE `fw_dljfexchdetail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_exchid` int(11) DEFAULT NULL,
  `detail_unitcode` varchar(32) DEFAULT NULL,
  `detail_giftid` int(11) DEFAULT NULL,
  `detail_giftname` varchar(128) DEFAULT NULL,
  `detail_xnid` int(11) DEFAULT '0' COMMENT '虚拟礼品兑换数据id',
  `detail_xncardid` varchar(64) DEFAULT NULL,
  `detail_xnpwd` varchar(256) DEFAULT NULL,
  `detail_jf` int(11) DEFAULT NULL,
  `detail_qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代理积分兑换详细';

-- ----------------------------
-- Records of fw_dljfexchdetail
-- ----------------------------

-- ----------------------------
-- Table structure for fw_dljfgift
-- ----------------------------
DROP TABLE IF EXISTS `fw_dljfgift`;
CREATE TABLE `fw_dljfgift` (
  `gif_id` int(11) NOT NULL AUTO_INCREMENT,
  `gif_unitcode` varchar(32) DEFAULT NULL,
  `gif_type` int(4) DEFAULT NULL,
  `gif_name` varchar(128) DEFAULT NULL,
  `gif_pic` varchar(64) DEFAULT NULL,
  `gif_jf` int(11) DEFAULT NULL,
  `gif_qty` int(11) DEFAULT NULL,
  `gif_brief` varchar(254) DEFAULT NULL,
  `gif_des` text,
  `gif_addtime` int(11) DEFAULT NULL,
  `gif_active` int(4) DEFAULT NULL,
  PRIMARY KEY (`gif_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代理积分礼品';

-- ----------------------------
-- Records of fw_dljfgift
-- ----------------------------

-- ----------------------------
-- Table structure for fw_dlsttype
-- ----------------------------
DROP TABLE IF EXISTS `fw_dlsttype`;
CREATE TABLE `fw_dlsttype` (
  `dlstt_id` int(11) NOT NULL AUTO_INCREMENT,
  `dlstt_unitcode` varchar(32) DEFAULT NULL,
  `dlstt_name` varchar(64) DEFAULT NULL,
  `dlstt_level` int(11) DEFAULT '0' COMMENT '代理级别',
  `dlstt_fanli1` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利1级',
  `dlstt_fanli2` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利2级',
  PRIMARY KEY (`dlstt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代理级别分类2';

-- ----------------------------
-- Records of fw_dlsttype
-- ----------------------------

-- ----------------------------
-- Table structure for fw_dltype
-- ----------------------------
DROP TABLE IF EXISTS `fw_dltype`;
CREATE TABLE `fw_dltype` (
  `dlt_id` int(11) NOT NULL AUTO_INCREMENT,
  `dlt_unitcode` varchar(32) DEFAULT NULL,
  `dlt_name` varchar(64) DEFAULT NULL,
  `dlt_level` int(11) DEFAULT '0' COMMENT '代理级别',
  `dlt_fanli1` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利1级',
  `dlt_fanli2` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利2级',
  `dlt_fanli3` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利3级',
  `dlt_fanli4` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利4',
  `dlt_fanli5` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利5',
  `dlt_fanli6` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利6',
  `dlt_fanli7` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利7',
  `dlt_fanli8` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利8',
  `dlt_fanli9` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利9',
  `dlt_fanli10` decimal(10,2) DEFAULT '0.00' COMMENT '推荐返利10',
  `dlt_firstquota` decimal(10,2) DEFAULT '0.00' COMMENT '首次下单金额',
  `dlt_minnum` int(11) DEFAULT '0' COMMENT '最低补货数量',
  `dlt_butie` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总公司补贴',
  PRIMARY KEY (`dlt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='代理级别分类1';

-- ----------------------------
-- Records of fw_dltype
-- ----------------------------
INSERT INTO `fw_dltype` VALUES ('7', '9999', '旗舰店', '1', '10000.00', '7000.00', '6900.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00');
INSERT INTO `fw_dltype` VALUES ('8', '9999', '体验店', '2', '6000.00', '2000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '2000.00');
INSERT INTO `fw_dltype` VALUES ('9', '9999', '工作室', '3', '1500.00', '1000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '500.00');
INSERT INTO `fw_dltype` VALUES ('10', '9999', '合伙人', '4', '900.00', '500.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00');
INSERT INTO `fw_dltype` VALUES ('14', '9999', 'vip', '5', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00');

-- ----------------------------
-- Table structure for fw_express
-- ----------------------------
DROP TABLE IF EXISTS `fw_express`;
CREATE TABLE `fw_express` (
  `exp_id` int(11) NOT NULL AUTO_INCREMENT,
  `exp_name` varchar(32) DEFAULT NULL COMMENT '快递名称',
  `exp_code` varchar(32) DEFAULT NULL COMMENT '快递100接口对应快递代码',
  `exp_addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`exp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='快递表';

-- ----------------------------
-- Records of fw_express
-- ----------------------------
INSERT INTO `fw_express` VALUES ('5', '无需物流', '', '1500707836');
INSERT INTO `fw_express` VALUES ('6', '顺丰快递', 'shunfeng', '1500707833');
INSERT INTO `fw_express` VALUES ('7', '申通快递', 'shentong', '1500707785');
INSERT INTO `fw_express` VALUES ('8', '圆通快递', 'yuantong', '1500707811');
INSERT INTO `fw_express` VALUES ('9', '韵达快递', 'yunda', '1500707819');
INSERT INTO `fw_express` VALUES ('10', '中通快递', 'zhongtong', '1500707788');
INSERT INTO `fw_express` VALUES ('11', '德邦物流', 'debangwuliu', '1497510935');
INSERT INTO `fw_express` VALUES ('12', '百世汇通', 'huitongkuaidi', '1500707816');
INSERT INTO `fw_express` VALUES ('13', '国通快递', 'guotongkuaidi', '1497511162');
INSERT INTO `fw_express` VALUES ('14', '邮政包裹/平邮/挂号信', 'youzhengguonei', '1500703723');
INSERT INTO `fw_express` VALUES ('15', 'EMS', 'ems', '1500703783');
INSERT INTO `fw_express` VALUES ('16', '佳吉物流', 'jiajiwuliu', '1500703867');
INSERT INTO `fw_express` VALUES ('17', '加运美', 'jiayunmeiwuliu', '1500703892');
INSERT INTO `fw_express` VALUES ('18', '龙邦物流', 'longbanwuliu', '1500703920');
INSERT INTO `fw_express` VALUES ('19', '联邦快递', 'lianbangkuaidi', '1500703948');
INSERT INTO `fw_express` VALUES ('20', '全日通', 'quanritongkuaidi', '1500703984');
INSERT INTO `fw_express` VALUES ('21', '全峰快递', 'quanfengkuaidi', '1500704000');
INSERT INTO `fw_express` VALUES ('22', '如风达快递', 'rufengda', '1500704018');
INSERT INTO `fw_express` VALUES ('23', '天天快递', 'tiantian', '1500704054');
INSERT INTO `fw_express` VALUES ('24', '优速物流', 'youshuwuliu', '1500704390');
INSERT INTO `fw_express` VALUES ('25', '运通快递', 'yuntongkuaidi', '1500707666');
INSERT INTO `fw_express` VALUES ('26', '速尔物流', 'suer', '1500707766');

-- ----------------------------
-- Table structure for fw_fanlidetail
-- ----------------------------
DROP TABLE IF EXISTS `fw_fanlidetail`;
CREATE TABLE `fw_fanlidetail` (
  `fl_id` int(11) NOT NULL AUTO_INCREMENT,
  `fl_unitcode` varchar(32) DEFAULT NULL COMMENT '企业码',
  `fl_dlid` int(11) DEFAULT '0' COMMENT '接收返利的经销商id（推荐人）',
  `fl_senddlid` int(11) DEFAULT '0' COMMENT '发放返利的代理',
  `fl_type` int(11) DEFAULT '0' COMMENT '返利类型',
  `fl_money` decimal(10,2) DEFAULT '0.00' COMMENT '返利金额',
  `fl_refedlid` int(11) DEFAULT '0' COMMENT '推荐返利中被推荐的经销商id（申请人）',
  `fl_oddlid` int(11) DEFAULT '0' COMMENT '订单返利中下单的经销商id',
  `fl_odid` int(11) DEFAULT '0' COMMENT '订单返利中订单id',
  `fl_orderid` varchar(32) DEFAULT NULL COMMENT '订单orderid',
  `fl_odblid` int(11) DEFAULT '0' COMMENT '订单关系id',
  `fl_proid` int(11) DEFAULT '0' COMMENT '订单产品id',
  `fl_qty` int(11) DEFAULT '0' COMMENT '订单产品数量',
  `fl_level` int(11) DEFAULT '0' COMMENT '该返利是第几级返利',
  `fl_addtime` int(11) DEFAULT '0' COMMENT '返利时间',
  `fl_remark` varchar(256) DEFAULT NULL COMMENT '简单说明',
  `fl_state` int(11) DEFAULT '0' COMMENT '0-待收款 1-已收款 2-收款中 9-取消',
  `fl_rcid` int(11) DEFAULT '0' COMMENT '对应提现id',
  PRIMARY KEY (`fl_id`),
  KEY `fl_unitcode` (`fl_unitcode`),
  KEY `fl_dlid` (`fl_dlid`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='返利明细';

-- ----------------------------
-- Records of fw_fanlidetail
-- ----------------------------
INSERT INTO `fw_fanlidetail` VALUES ('31', '9999', '38', '32', '1', '6000.00', '44', '0', '0', '', '0', '0', '0', '1', '1517395593', '邀请 test0301 成为 联合创始人 一次性返利', '1', '4');
INSERT INTO `fw_fanlidetail` VALUES ('32', '9999', '32', '0', '2', '1500.00', '0', '45', '69', '201805171547287695', '0', '5', '300', '1', '1526543562', '代理 test0101 订购 测试产品 数量 300', '1', '3');
INSERT INTO `fw_fanlidetail` VALUES ('33', '9999', '32', '0', '2', '50.00', '0', '45', '70', '201805171737126006', '0', '5', '10', '1', '1526549867', '代理 test0101 订购 测试产品 数量 10', '1', '3');
INSERT INTO `fw_fanlidetail` VALUES ('34', '9999', '32', '0', '1', '10000.00', '49', '0', '0', '', '0', '0', '0', '1', '1535094012', '你邀请的 13226269695 再邀请13226269696 成为 分公司', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('35', '9999', '48', '0', '2', '40.00', '0', '49', '78', '201808241521543705', '0', '7', '1', '1', '1535095369', '代理 13226269696 订购 测试产品3 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('36', '9999', '32', '0', '2', '40.00', '0', '49', '78', '201808241521543705', '0', '7', '1', '2', '1535095369', '代理 钟琪 的邀请代理 13226269696 订购 测试产品3 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('37', '9999', '32', '0', '2', '40.00', '0', '48', '81', '201808241618596518', '0', '7', '1', '1', '1535098815', '代理 13226269695 订购 测试产品3 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('38', '9999', '32', '0', '2', '5.00', '0', '48', '80', '201808241618245892', '0', '5', '1', '1', '1535098891', '代理 13226269695 订购 测试产品 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('39', '9999', '32', '0', '1', '10000.00', '55', '0', '0', '', '0', '0', '0', '1', '1535189317', '邀请 13226265489 成为 总代 公司补贴 0.00', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('40', '9999', '32', '0', '2', '40.00', '0', '55', '84', '201808251733254798', '0', '7', '1', '1', '1535189750', '代理 13226265489 订购 测试产品3 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('41', '9999', '32', '0', '1', '10000.00', '56', '0', '0', '', '0', '0', '0', '1', '1535333888', '邀请 15875872797 成为 总代 公司补贴 0.00', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('42', '9999', '56', '0', '1', '10000.00', '57', '0', '0', '', '0', '0', '0', '1', '1535334179', '邀请 15875872798 成为 总代 公司补贴 0.00', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('43', '9999', '32', '0', '1', '7000.00', '57', '0', '0', '', '0', '0', '0', '1', '1535334179', '你邀请的 15875872797 再邀请15875872798 成为 总代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('44', '9999', '56', '0', '1', '10000.00', '58', '0', '0', '', '0', '0', '0', '1', '1535334637', '邀请 15875872798 成为 总代 公司补贴 0.00', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('45', '9999', '32', '0', '1', '7000.00', '58', '0', '0', '', '0', '0', '0', '1', '1535334637', '你邀请的 15875872797 再邀请15875872798 成为 总代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('46', '9999', '32', '0', '1', '6000.00', '59', '0', '0', '', '0', '0', '0', '1', '1535334939', '邀请 15875872798 成为 省代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('47', '9999', '56', '0', '1', '6000.00', '60', '0', '0', '', '0', '0', '0', '1', '1535335787', '邀请 15875872711 成为 省代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('48', '9999', '32', '0', '1', '2000.00', '60', '0', '0', '', '0', '0', '0', '1', '1535335787', '你邀请的 15875872797 再邀请15875872711 成为 省代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('49', '9999', '32', '0', '1', '6000.00', '61', '0', '0', '', '0', '0', '0', '1', '1535336430', '邀请 15875872712 成为 省代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('50', '9999', '32', '0', '2', '41.00', '0', '56', '85', '201808271103597083', '0', '7', '1', '1', '1535339825', '代理 15875872797 订购 测试产品3 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('51', '9999', '56', '0', '1', '10000.00', '62', '0', '0', '', '0', '0', '0', '1', '1535340626', '邀请 15875872798 成为 总代 公司补贴 0.00', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('52', '9999', '32', '0', '1', '7000.00', '62', '0', '0', '', '0', '0', '0', '1', '1535340626', '你邀请的 15875872797 再邀请15875872798 成为 总代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('53', '9999', '61', '0', '1', '1500.00', '63', '0', '0', '', '0', '0', '0', '1', '1535341543', '邀请 15875872799 成为 市代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('54', '9999', '32', '0', '1', '1000.00', '63', '0', '0', '', '0', '0', '0', '1', '1535341543', '你邀请的 15875872712 再邀请15875872799 成为 市代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('55', '9999', '56', '0', '2', '41.00', '0', '62', '86', '201808271153024346', '0', '7', '1', '1', '1535342021', '代理 15875872798 订购 测试产品3 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('56', '9999', '32', '0', '2', '40.00', '0', '62', '86', '201808271153024346', '0', '7', '1', '2', '1535342021', '代理 钟琪5 的邀请代理 15875872798 订购 测试产品3 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('57', '9999', '56', '0', '2', '41.00', '0', '62', '93', '201808271518433388', '0', '7', '1', '1', '1535354383', '代理 15875872798 订购 测试产品3 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('58', '9999', '32', '0', '2', '40.00', '0', '62', '93', '201808271518433388', '0', '7', '1', '2', '1535354383', '代理 钟琪5 的邀请代理 15875872798 订购 测试产品3 数量 1', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('59', '9999', '56', '0', '2', '82.00', '0', '62', '94', '201808271521228400', '0', '7', '2', '1', '1535354507', '代理 15875872798 订购 测试产品3 数量 2', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('60', '9999', '32', '0', '2', '80.00', '0', '62', '94', '201808271521228400', '0', '7', '2', '2', '1535354507', '代理 钟琪5 的邀请代理 15875872798 订购 测试产品3 数量 2', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('61', '9999', '32', '0', '1', '10000.00', '64', '0', '0', '', '0', '0', '0', '1', '1535511728', '邀请 15875872801 成为 总代 公司补贴 0.00', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('62', '9999', '32', '0', '1', '6000.00', '65', '0', '0', '', '0', '0', '0', '1', '1535512150', '邀请 15875872802 成为 省代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('63', '9999', '61', '0', '1', '10000.00', '68', '0', '0', '', '0', '0', '0', '1', '1535597346', '邀请 15875872805 成为 总代 公司补贴 0.00', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('64', '9999', '32', '0', '1', '7000.00', '68', '0', '0', '', '0', '0', '0', '1', '1535597346', '你邀请的 15875872712 再邀请15875872805 成为 总代', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('65', '9999', '68', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('66', '9999', '67', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('67', '9999', '66', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('68', '9999', '64', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('69', '9999', '62', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('70', '9999', '56', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('71', '9999', '52', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('72', '9999', '49', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('73', '9999', '48', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('74', '9999', '45', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('75', '9999', '42', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('76', '9999', '37', '0', '7', '0.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:0', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('77', '9999', '32', '0', '7', '50.00', '0', '0', '0', '', '0', '0', '0', '1', '1535731200', '2018年09月分红奖:50', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('78', '9999', '32', '0', '1', '10000.00', '79', '0', '0', '', '0', '0', '0', '1', '1540950485', '邀请 15875872791 成为 旗舰店 公司补贴 0.00', '0', '0');
INSERT INTO `fw_fanlidetail` VALUES ('79', '9999', '78', '0', '1', '10000.00', '80', '0', '0', '', '0', '0', '0', '1', '1540950657', '邀请 15875872792 成为 旗舰店 公司补贴 0.00', '0', '0');

-- ----------------------------
-- Table structure for fw_jfdetail
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfdetail`;
CREATE TABLE `fw_jfdetail` (
  `jf_id` int(11) NOT NULL AUTO_INCREMENT,
  `jf_unitcode` varchar(32) DEFAULT NULL,
  `jf_userid` int(11) DEFAULT NULL,
  `jf_username` varchar(32) DEFAULT NULL,
  `jf_type` int(11) DEFAULT NULL,
  `jf_jf` int(11) DEFAULT NULL,
  `jf_addtime` int(11) DEFAULT NULL,
  `jf_ip` varchar(32) DEFAULT NULL,
  `jf_actionuser` int(11) DEFAULT NULL,
  `jf_code` varchar(32) DEFAULT NULL,
  `jf_proid` int(11) DEFAULT NULL,
  `jf_proname` varchar(64) DEFAULT NULL,
  `jf_pronumber` varchar(32) DEFAULT NULL,
  `jf_remark` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`jf_id`),
  KEY `jf_uintcode` (`jf_unitcode`),
  KEY `jf_code` (`jf_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户积分详细';

-- ----------------------------
-- Records of fw_jfdetail
-- ----------------------------

-- ----------------------------
-- Table structure for fw_jfexchange
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfexchange`;
CREATE TABLE `fw_jfexchange` (
  `exch_id` int(11) NOT NULL AUTO_INCREMENT,
  `exch_unitcode` varchar(32) DEFAULT NULL,
  `exch_jf` int(11) DEFAULT NULL,
  `exch_qty` int(11) DEFAULT NULL,
  `exch_userid` int(11) DEFAULT NULL,
  `exch_username` varchar(64) DEFAULT NULL,
  `exch_contact` varchar(32) DEFAULT NULL,
  `exch_tel` varchar(32) DEFAULT NULL,
  `exch_address` varchar(254) DEFAULT NULL,
  `exch_msg` varchar(512) DEFAULT NULL,
  `exch_kuaidi` varchar(32) DEFAULT NULL,
  `exch_kdhao` varchar(32) DEFAULT NULL,
  `exch_time` int(11) DEFAULT NULL,
  `exch_remark` varchar(512) DEFAULT NULL,
  `exch_state` int(4) DEFAULT NULL,
  `exch_ip` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`exch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户积分兑换';

-- ----------------------------
-- Records of fw_jfexchange
-- ----------------------------

-- ----------------------------
-- Table structure for fw_jfexchdetail
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfexchdetail`;
CREATE TABLE `fw_jfexchdetail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_exchid` int(11) DEFAULT NULL,
  `detail_unitcode` varchar(32) DEFAULT NULL,
  `detail_giftid` int(11) DEFAULT NULL,
  `detail_giftname` varchar(128) DEFAULT NULL,
  `detail_xnid` int(11) DEFAULT '0' COMMENT '虚拟礼品兑换数据id',
  `detail_xncardid` varchar(64) DEFAULT NULL,
  `detail_xnpwd` varchar(256) DEFAULT NULL,
  `detail_jf` int(11) DEFAULT NULL,
  `detail_qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户积分兑换详细';

-- ----------------------------
-- Records of fw_jfexchdetail
-- ----------------------------

-- ----------------------------
-- Table structure for fw_jffeedback
-- ----------------------------
DROP TABLE IF EXISTS `fw_jffeedback`;
CREATE TABLE `fw_jffeedback` (
  `fb_id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_unitcode` varchar(32) DEFAULT NULL,
  `fb_type` int(4) DEFAULT NULL,
  `fb_userid` int(11) DEFAULT NULL,
  `fb_username` varchar(32) DEFAULT NULL,
  `fb_contact` varchar(64) DEFAULT NULL,
  `fb_tel` varchar(64) DEFAULT NULL,
  `fb_qq` varchar(32) DEFAULT NULL,
  `fb_email` varchar(64) DEFAULT NULL,
  `fb_content` text,
  `fb_recontent` text,
  `fb_addtime` int(11) DEFAULT NULL,
  `fb_ip` varchar(32) DEFAULT NULL,
  `fb_state` int(4) DEFAULT NULL,
  PRIMARY KEY (`fb_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='反馈留言';

-- ----------------------------
-- Records of fw_jffeedback
-- ----------------------------
INSERT INTO `fw_jffeedback` VALUES ('6', '9999', '1', '0', '', '李生', '163165161', '5221615', '256156@qq.com', 'dfadfadf', null, '1515554713', '192.168.1.134', '1');
INSERT INTO `fw_jffeedback` VALUES ('5', '9999', '1', '0', '', '李生', '163165161', '5221615', '256156@qq.com', 'dfadfadf', null, '1515554497', '192.168.1.134', '1');
INSERT INTO `fw_jffeedback` VALUES ('7', '9999', '1', '0', '', 'fadfadf1', '1651565', '5156156', '566516@qq.com', '464596569', null, '1515555047', '192.168.1.134', '1');
INSERT INTO `fw_jffeedback` VALUES ('8', '9999', '1', '32', 'test99', '李生', '13888888888', '54645645', '', '反馈测试', null, '1524640761', '192.168.1.134', '1');

-- ----------------------------
-- Table structure for fw_jfgift
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfgift`;
CREATE TABLE `fw_jfgift` (
  `gif_id` int(11) NOT NULL AUTO_INCREMENT,
  `gif_unitcode` varchar(32) DEFAULT NULL,
  `gif_type` int(4) DEFAULT NULL COMMENT '虚拟礼品 实物礼品',
  `gif_gifttype` int(11) NOT NULL DEFAULT '0' COMMENT '礼品分类',
  `gif_name` varchar(128) DEFAULT NULL,
  `gif_pic` varchar(64) DEFAULT NULL,
  `gif_jf` int(11) DEFAULT NULL,
  `gif_qty` int(11) DEFAULT NULL,
  `gif_brief` varchar(254) DEFAULT NULL,
  `gif_des` text,
  `gif_addtime` int(11) DEFAULT NULL,
  `gif_active` int(4) DEFAULT NULL,
  PRIMARY KEY (`gif_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分礼品';

-- ----------------------------
-- Records of fw_jfgift
-- ----------------------------

-- ----------------------------
-- Table structure for fw_jfgifttype
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfgifttype`;
CREATE TABLE `fw_jfgifttype` (
  `giftype_id` int(11) NOT NULL AUTO_INCREMENT,
  `giftype_unitcode` varchar(32) DEFAULT NULL,
  `giftype_name` varchar(128) DEFAULT NULL,
  `giftype_order` int(11) DEFAULT '0',
  PRIMARY KEY (`giftype_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_jfgifttype
-- ----------------------------

-- ----------------------------
-- Table structure for fw_jfmobasic
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfmobasic`;
CREATE TABLE `fw_jfmobasic` (
  `bas_id` int(11) NOT NULL AUTO_INCREMENT,
  `bas_unitcode` varchar(32) DEFAULT NULL,
  `bas_sitename` varchar(128) DEFAULT NULL,
  `bas_company` varchar(254) DEFAULT NULL,
  `bas_address` varchar(254) DEFAULT NULL,
  `bas_hotline` varchar(64) DEFAULT NULL,
  `bas_tel` varchar(64) DEFAULT NULL,
  `bas_fax` varchar(64) DEFAULT NULL,
  `bas_website` varchar(254) DEFAULT NULL,
  `bas_weixin` varchar(254) DEFAULT NULL,
  `bas_wxpic` varchar(64) DEFAULT NULL,
  `bas_weibo` varchar(254) DEFAULT NULL,
  `bas_wbpic` varchar(64) DEFAULT NULL,
  `bas_logopic` varchar(32) DEFAULT NULL COMMENT 'logo',
  `bas_footpic` varchar(32) DEFAULT NULL COMMENT '页面底部图片',
  `bas_profile` text,
  `bas_contact` text,
  `bas_agreement` text,
  `bas_rule` text,
  `bas_help` text,
  `bas_buyer` text,
  `bas_buyer2` text,
  `bas_buyer3` text,
  `bas_ppzc` text COMMENT '品牌政策',
  PRIMARY KEY (`bas_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='积分商城手机端基本资料';

-- ----------------------------
-- Records of fw_jfmobasic
-- ----------------------------
INSERT INTO `fw_jfmobasic` VALUES ('2', '9999', null, null, null, null, null, null, null, null, null, null, null, null, null, '公司简介内容', null, null, null, null, null, null, null, '公司政策测试');

-- ----------------------------
-- Table structure for fw_jfmonews
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfmonews`;
CREATE TABLE `fw_jfmonews` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_unitcode` varchar(32) DEFAULT NULL,
  `news_title` varchar(254) DEFAULT NULL,
  `news_type` int(4) DEFAULT NULL,
  `news_pic` varchar(64) DEFAULT NULL,
  `news_content` text,
  `news_addtime` int(11) DEFAULT NULL,
  `news_isgg` int(11) DEFAULT '0' COMMENT '是否公告',
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='积分商城手机端企业动态';

-- ----------------------------
-- Records of fw_jfmonews
-- ----------------------------
INSERT INTO `fw_jfmonews` VALUES ('6', '9999', '买家秀测试1', '2', '3052/15108833267.jpg', '低热量', '1510883326', '0');
INSERT INTO `fw_jfmonews` VALUES ('7', '9999', '买家秀测试2', '2', '3052/15108833949.jpg', '瘦身养颜', '1510883394', '0');
INSERT INTO `fw_jfmonews` VALUES ('8', '9999', '商家活动测试', '7', '', '商家活动测试22', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('9', '9999', '招商政策', '5', '', '招商政策22', '1511147139', '0');
INSERT INTO `fw_jfmonews` VALUES ('10', '9999', '素材圈测试', '4', '', '素材圈测试222', '1511169668', '0');
INSERT INTO `fw_jfmonews` VALUES ('11', '9999', '商家活动测试2', '7', '', '商家活动测试22', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('12', '9999', '商家活动测试3', '7', '', '商家活动测试22', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('13', '9999', '商家活动测试4', '7', '', '商家活动测试4', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('14', '9999', '商家活动测试5', '7', '', '商家活动测试5', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('15', '9999', '商家活动测试6', '7', '', '商家活动测试6', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('16', '9999', '商家活动测试7', '7', '', '商家活动测试7', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('17', '9999', '商家活动测试8', '7', '', '商家活动测试8', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('18', '9999', '商家活动测试9', '7', '', '商家活动测试9', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('19', '9999', '商家活动测试10', '7', '', '商家活动测试10', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('20', '9999', '商家活动测试11', '7', '', '商家活动测试11', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('21', '9999', '商家活动测试12', '7', '', '商家活动测试12', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('22', '9999', '商家活动测试13', '7', '', '商家活动测试13', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('23', '9999', '商家活动测试14', '7', '', '商家活动测试14', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('24', '9999', '商家活动测试15', '7', '', '商家活动测试15', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('25', '9999', '商家活动测试16', '7', '', '商家活动测试16', '1511002732', '0');
INSERT INTO `fw_jfmonews` VALUES ('26', '9999', '动态1', '1', '9999/15354242238.jpg', '都符合上述说法', '1535424223', '0');

-- ----------------------------
-- Table structure for fw_jfmopics
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfmopics`;
CREATE TABLE `fw_jfmopics` (
  `pics_id` int(11) NOT NULL AUTO_INCREMENT,
  `pics_unitcode` varchar(32) DEFAULT NULL,
  `pics_title` varchar(64) DEFAULT NULL,
  `pics_group` int(11) DEFAULT NULL,
  `pics_name` varchar(64) DEFAULT NULL,
  `pics_name_s` varchar(64) DEFAULT NULL,
  `pics_addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`pics_id`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COMMENT='图片管理';

-- ----------------------------
-- Records of fw_jfmopics
-- ----------------------------

-- ----------------------------
-- Table structure for fw_jfproduct
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfproduct`;
CREATE TABLE `fw_jfproduct` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_unitcode` varchar(32) DEFAULT NULL,
  `pro_typeid` int(11) DEFAULT NULL,
  `pro_name` varchar(254) DEFAULT NULL,
  `pro_number` varchar(32) DEFAULT NULL,
  `pro_pic` varchar(64) DEFAULT NULL,
  `pro_price` decimal(8,2) DEFAULT NULL,
  `pro_desc` text,
  `pro_link` varchar(512) DEFAULT NULL,
  `pro_active` int(4) DEFAULT NULL,
  `pro_addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品展示仅用于微站，无防窜';

-- ----------------------------
-- Records of fw_jfproduct
-- ----------------------------

-- ----------------------------
-- Table structure for fw_jfprotype
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfprotype`;
CREATE TABLE `fw_jfprotype` (
  `protype_id` int(11) NOT NULL AUTO_INCREMENT,
  `protype_unitcode` varchar(32) DEFAULT NULL,
  `protype_name` varchar(128) DEFAULT NULL,
  `protype_iswho` int(11) DEFAULT '0',
  `protype_order` int(11) DEFAULT '0',
  PRIMARY KEY (`protype_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品分类';

-- ----------------------------
-- Records of fw_jfprotype
-- ----------------------------

-- ----------------------------
-- Table structure for fw_jfuser
-- ----------------------------
DROP TABLE IF EXISTS `fw_jfuser`;
CREATE TABLE `fw_jfuser` (
  `jfuser_id` int(11) NOT NULL AUTO_INCREMENT,
  `jfuser_unitcode` varchar(32) DEFAULT NULL,
  `jfuser_openid` varchar(64) DEFAULT NULL COMMENT '微信openid',
  `jfuser_username` varchar(64) DEFAULT NULL,
  `jfuser_pwd` varchar(64) DEFAULT NULL,
  `jfuser_truename` varchar(32) DEFAULT NULL,
  `jfuser_tel` varchar(32) DEFAULT NULL,
  `jfuser_email` varchar(64) DEFAULT NULL,
  `jfuser_qq` varchar(32) DEFAULT NULL,
  `jfuser_sheng` int(11) DEFAULT NULL,
  `jfuser_shi` int(11) DEFAULT NULL,
  `jfuser_qu` int(11) DEFAULT NULL,
  `jfuser_diqustr` varchar(64) DEFAULT NULL,
  `jfuser_address` varchar(64) DEFAULT NULL,
  `jfuser_jf` int(11) DEFAULT '0',
  `jfuser_logintime` int(11) DEFAULT NULL,
  `jfuser_addtime` int(11) DEFAULT NULL,
  `jfuser_active` int(4) DEFAULT NULL,
  `jfuser_remark` varchar(512) DEFAULT NULL,
  `jfuser_weixin` varchar(32) DEFAULT NULL,
  `jfuser_wxnickname` varchar(128) DEFAULT NULL COMMENT '微信昵称',
  `jfuser_wxsex` int(4) DEFAULT NULL,
  `jfuser_wxprovince` varchar(32) DEFAULT NULL,
  `jfuser_wxcity` varchar(32) DEFAULT NULL,
  `jfuser_wxcountry` varchar(32) DEFAULT NULL,
  `jfuser_wxheadimg` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`jfuser_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分用户';

-- ----------------------------
-- Records of fw_jfuser
-- ----------------------------

-- ----------------------------
-- Table structure for fw_log
-- ----------------------------
DROP TABLE IF EXISTS `fw_log`;
CREATE TABLE `fw_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_qyid` int(11) DEFAULT NULL,
  `log_user` varchar(32) DEFAULT NULL,
  `log_qycode` varchar(32) DEFAULT NULL,
  `log_action` varchar(32) DEFAULT NULL,
  `log_addtime` int(11) DEFAULT NULL,
  `log_ip` varchar(32) DEFAULT NULL,
  `log_link` varchar(128) NOT NULL,
  `log_remark` text,
  `log_type` int(11) DEFAULT '0' COMMENT '日志分类0-系统 1-企业 2-经销商',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1814 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_log
-- ----------------------------
INSERT INTO `fw_log` VALUES ('1025', '994', 'kangli', '9999', '企业登录', '1512027899', '58.63.146.151', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1026', '34', 'test01', '9999', '经销商账号登录', '1512029294', '58.63.146.151', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1027', '994', 'kangli', '9999', '企业登录', '1512038496', '58.63.146.151', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1028', '995', 'kangli', '9999', '企业登录', '1512092642', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1029', '995', 'kangli', null, '企业子用户入库', '1512092655', '127.0.0.1', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"2000741245345\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"20\",\"stor_barcode\":\"150000001\",\"stor_date\":1512092655,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1030', '34', 'test01', '9999', '经销商账号登录', '1512095026', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1031', '32', 'test99', '9999', '经销商账号登录', '1512095532', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1032', '42', 'test08', '9999', '代理商注册', '1512100814', '127.0.0.1', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"test08\",\"dl_pwd\":\"9a2aac6349b0cd0af564fdb9ffe9e9b5\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u5eb7\\u751f\",\"dl_contact\":\"\\u5eb7\\u751f\",\"dl_tel\":\"13666666666\",\"dl_idcard\":\"110101199901010838\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1512100814,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"test08\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"1d2aYhXTQwy9n0AqBOWcrFJzk7Y9Fc4HIngk8z+0u4O5u5uYPELA2GT1qgDSnl4X\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1033', '32', 'test99', '9999', '经销商账号登录', '1512110550', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1034', '32', 'test99', '9999', '经销商账号登录', '1512124957', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1035', '34', 'test01', '9999', '经销商账号登录', '1512177847', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1036', '34', 'test01', '9999', '经销商账号登录', '1512178637', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1037', '32', 'test99', '9999', '经销商账号登录', '1512179818', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1038', '32', 'test99', '9999', '经销商账号登录', '1512180067', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1039', '995', 'kangli', '9999', '企业登录', '1512353443', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1040', '995', 'kangli', '9999', '企业登录', '1512355238', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1041', '995', 'kangli', '9999', '企业登录', '1512381294', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1042', '34', 'test01', '9999', '经销商账号登录', '1512532367', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1043', '32', 'test99', '9999', '经销商账号登录', '1512554705', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1044', '995', 'kangli', '9999', '企业登录', '1512787741', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1045', '995', 'kangli', '9999', '企业登录', '1512973161', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1046', '32', 'test99', '9999', '经销商账号登录', '1514280155', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1047', '32', 'test99', '9999', '经销商账号登录', '1514280200', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1048', '32', 'test99', '9999', '经销商账号登录', '1514280732', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1049', '32', 'test99', '9999', '经销商账号登录', '1514281180', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1050', '32', 'test99', '9999', '经销商账号登录', '1514283256', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1051', '32', 'test99', '9999', '经销商账号登录', '1514283338', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1052', '32', 'test99', '9999', '经销商账号登录', '1514283433', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1053', '32', 'test99', '9999', '经销商账号登录', '1514339894', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1054', '32', 'test99', '9999', '经销商账号登录', '1514341547', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1055', '32', 'test99', '9999', '经销商账号登录', '1514354727', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1056', '32', 'test99', '9999', '经销商账号登录', '1514356459', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1057', '32', 'test99', '9999', '经销商账号登录', '1514358287', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1058', '32', 'test99', '9999', '经销商账号登录', '1514363888', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1059', null, null, null, '经销商账号登录', '1514444866', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1060', null, null, null, '经销商账号登录', '1514445150', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1061', null, null, null, '经销商账号登录', '1514445308', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1062', null, null, null, '经销商账号登录', '1514449912', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1063', null, null, null, '经销商账号登录', '1514457284', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1064', null, null, null, '经销商账号登录', '1514513314', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1065', null, null, null, '经销商账号登录', '1515047631', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1066', null, null, null, '经销商账号登录', '1515058745', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1067', null, null, null, '经销商账号登录', '1515058796', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1068', null, null, null, '经销商账号登录', '1515059569', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1069', null, null, null, '经销商账号登录', '1515117299', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1070', null, null, null, '经销商账号登录', '1515134581', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1071', null, null, null, '经销商账号登录', '1515204607', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1072', null, null, null, '经销商账号登录', '1515205364', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1073', null, null, null, '经销商账号登录', '1515205664', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1074', null, null, null, '经销商账号登录', '1515206272', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1075', '32', 'test99', '9999', '经销商账号登录', '1515206482', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1076', null, null, null, '经销商账号登录', '1515211150', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1077', null, null, null, '经销商账号登录', '1515211374', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1078', null, null, null, '经销商账号登录', '1515211495', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1079', null, null, null, '经销商账号登录', '1515211569', '127.0.0.1', '127.0.0.1/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1080', '32', 'test99', '9999', '经销商账号登录', '1515218783', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1081', '34', 'test01', '9999', '经销商账号登录', '1515226736', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1082', '34', 'test01', '9999', '经销商账号登录', '1515229973', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1083', '34', 'test01', '9999', '经销商账号登录', '1515230895', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1084', '34', 'test01', '9999', '经销商账号登录', '1515232784', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1085', null, null, null, '经销商账号登录', '1515553939', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1086', null, null, null, '经销商账号登录', '1515553976', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1087', null, null, null, '经销商账号登录', '1516260511', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1088', null, null, null, '经销商账号登录', '1516260769', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1089', null, null, null, '经销商账号登录', '1516260877', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1090', null, null, null, '经销商账号登录', '1516260916', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1091', null, null, null, '经销商账号登录', '1516261006', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1092', null, null, null, '经销商账号登录', '1516261647', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1093', null, null, null, '经销商账号登录', '1516331656', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1094', null, null, null, '经销商账号登录', '1516347590', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1095', null, null, null, '经销商账号登录', '1516347835', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1096', null, null, null, '经销商账号登录', '1516348834', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1097', null, null, null, '经销商账号登录', '1516413113', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1098', null, null, null, '经销商账号登录', '1516603217', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1099', null, null, null, '经销商账号登录', '1516603220', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1100', null, null, null, '经销商账号登录', '1516613418', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1101', null, null, null, '经销商账号登录', '1516613729', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1102', null, null, null, '经销商账号登录', '1516613810', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1103', null, null, null, '经销商账号登录', '1516678286', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1104', null, null, null, '经销商账号登录', '1516679213', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1105', null, null, null, '经销商账号登录', '1516679267', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1106', null, null, null, '经销商账号登录', '1516679356', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1107', null, null, null, '经销商账号登录', '1516679616', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1108', null, null, null, '经销商账号登录', '1516679709', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1109', null, null, null, '经销商账号登录', '1516679848', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1110', null, null, null, '经销商账号登录', '1516690019', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1111', null, null, null, '经销商账号登录', '1516690114', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1112', null, null, null, '经销商账号登录', '1516690142', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1113', null, null, null, '经销商账号登录', '1516690258', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1114', null, null, null, '经销商账号登录', '1516690994', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1115', null, null, null, '经销商账号登录', '1516699176', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1116', null, null, null, '经销商账号登录', '1516757789', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1117', null, null, null, '经销商账号登录', '1516765327', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1118', null, null, null, '经销商账号登录', '1516773979', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1119', null, null, null, '经销商账号登录', '1516781593', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1120', null, null, null, '经销商账号登录', '1516845563', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1121', null, null, null, '经销商账号登录', '1516852778', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1122', null, null, null, '经销商账号登录', '1516860784', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1123', '32', 'test99', '9999', '经销商账号登录', '1516868069', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1124', '995', 'kangli', '9999', '企业登录', '1516868137', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1125', '995', 'kangli', '9999', '企业登录', '1516868417', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1126', null, null, null, '经销商账号登录', '1516868851', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1127', null, null, null, '经销商账号登录', '1516877072', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1128', null, null, null, '经销商账号登录', '1516884293', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1129', null, null, null, '经销商账号登录', '1516937303', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1130', null, null, null, '经销商账号登录', '1516946924', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1131', '32', 'test99', '9999', '经销商账号登录', '1516948485', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1132', null, null, null, '经销商账号登录', '1516954291', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1133', null, null, null, '经销商账号登录', '1516961529', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1134', '995', 'kangli', '9999', '企业登录', '1516961632', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1135', '995', 'kangli', '9999', '产品返利设置', '1516968214', '0.0.0.0', '/Kangli/Mp/Product/profanli_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5206\\u516c\\u53f8\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"30000.00\",\"dlt_fanli2\":\"10000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"239.00\",\"pfl_fanli2\":\"0.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"9\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u8054\\u5408\\u521b\\u59cb\\u4eba\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"pfl_fanli1\":\"239.00\",\"pfl_fanli2\":\"0.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"9\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"2000.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"pfl_fanli1\":\"259.00\",\"pfl_fanli2\":\"0.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"9\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"0.00\",\"dlt_fanli2\":\"0.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"399.00\",\"pfl_fanli2\":\"0.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"9\"}]', '1');
INSERT INTO `fw_log` VALUES ('1136', '995', 'kangli', '9999', '修改产品价格体系', '1516968444', '0.0.0.0', '/Kangli/Mp/Product/propriceedit_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5206\\u516c\\u53f8\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"30000.00\",\"dlt_fanli2\":\"10000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"239.00\",\"pro_id\":\"9\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u8054\\u5408\\u521b\\u59cb\\u4eba\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"priprice\":\"239.00\",\"pro_id\":\"9\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"2000.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"priprice\":\"259.00\",\"pro_id\":\"9\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"0.00\",\"dlt_fanli2\":\"0.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"399.00\",\"pro_id\":\"9\"}]', '1');
INSERT INTO `fw_log` VALUES ('1137', null, null, null, '经销商账号登录', '1516968761', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1138', null, null, null, '经销商账号登录', '1517016258', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1139', null, null, null, '经销商账号登录', '1517023855', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1140', null, null, null, '经销商账号登录', '1517033334', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1141', '32', 'test99', '9999', '经销商账号登录', '1517036086', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1142', null, null, null, '经销商账号登录', '1517042020', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1143', null, null, null, '经销商账号登录', '1517042313', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1144', null, null, null, '经销商账号登录', '1517042435', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1145', null, null, null, '经销商账号登录', '1517042922', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1146', null, null, null, '经销商账号登录', '1517043130', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1147', null, null, null, '经销商账号登录', '1517043793', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1148', null, null, null, '经销商账号登录', '1517189371', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1149', null, null, null, '经销商账号登录', '1517190487', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1150', '995', 'kangli', '9999', '企业登录', '1517190727', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1151', '995', 'kangli', '9999', '企业登录', '1517191577', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1152', '34', 'test01', '9999', '经销商账号登录', '1517192459', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1153', null, null, null, '经销商账号登录', '1517208590', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1154', null, null, null, '经销商账号登录', '1517216071', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1155', null, null, null, '经销商账号登录', '1517223713', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1156', null, null, null, '经销商账号登录', '1517275166', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1157', '32', 'test99', '9999', '经销商账号登录', '1517279557', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1158', null, null, null, '经销商账号登录', '1517282376', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1159', null, null, null, '经销商账号登录', '1517292262', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1160', '32', 'test99', '9999', '经销商账号登录', '1517296948', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1161', null, null, null, '经销商账号登录', '1517300822', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1162', null, null, null, '经销商账号登录', '1517308507', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1163', '32', 'test99', '9999', '经销商账号登录', '1517362734', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1164', null, null, null, '经销商账号登录', '1517362813', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1165', null, null, null, '经销商账号登录', '1517371124', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1166', null, null, null, '经销商账号登录', '1517379637', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1167', null, null, null, '经销商账号登录', '1517386886', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1168', null, null, null, '经销商账号登录', '1517395482', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1169', '32', 'test99', '9999', '经销商删除下级', '1517395707', '192.168.1.134', '192.168.1.134/klapi/controller/v1/dealer/apply_del', '{\"dl_id\":41,\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"test06\",\"dl_pwd\":\"93ed26f2733db629fb675be19b22de80\",\"dl_number\":\"A0000041\",\"dl_name\":\"\\u90b1\\u751f\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":8,\"dl_sttype\":0,\"dl_belong\":32,\"dl_referee\":34,\"dl_level\":2,\"dl_contact\":\"\\u90b1\\u751f\",\"dl_tel\":\"13666060606\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"test06\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":0,\"dl_sheng\":11,\"dl_shi\":1101,\"dl_qu\":0,\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_idcard\":\"110101199901017677\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":3,\"dl_bankcard\":\"7acdruGLTY2BjHGpascTK32EtN1yJfJuHOgQHgYRaPdw2aJGEDh5CuF9IfRcZyDs\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":0,\"dl_startdate\":null,\"dl_enddate\":null,\"dl_addtime\":1511232186,\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":0,\"dl_oddcount\":0,\"dl_logintime\":0,\"dl_fanli\":\"0.00\",\"dl_jifen\":0,\"dl_lastflid\":0,\"dl_flmodel\":0,\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1170', null, null, null, '经销商账号登录', '1517449587', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1171', '32', 'test99', '9999', '经销商账号登录', '1517449669', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1172', null, null, null, '经销商账号登录', '1517456915', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1173', '34', 'test01', '9999', '经销商账号登录', '1517466490', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1174', null, null, null, '经销商账号登录', '1517466885', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1175', null, null, null, '经销商账号登录', '1517474104', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1176', null, null, null, '经销商账号登录', '1517476215', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1177', '32', 'test99', '9999', '经销商账号登录', '1517476828', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1178', null, null, null, '经销商账号登录', '1517478062', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1179', null, null, null, '经销商账号登录', '1517478460', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1180', null, null, null, '经销商账号登录', '1517478514', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1181', null, null, null, '经销商账号登录', '1517478515', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1182', null, null, null, '经销商账号登录', '1517478719', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1183', null, null, null, '经销商账号登录', '1517479068', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1184', null, null, null, '经销商账号登录', '1517479243', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1185', null, null, null, '经销商账号登录', '1517488791', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1186', '32', 'test99', '9999', '经销商账号登录', '1517488827', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1187', null, null, null, '经销商账号登录', '1517536626', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1188', '32', 'test99', '9999', '经销商账号登录', '1517536791', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1189', null, null, null, '经销商账号登录', '1517538728', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1190', null, null, null, '经销商账号登录', '1517546204', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1191', null, null, null, '经销商账号登录', '1517553418', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1192', null, null, null, '经销商账号登录', '1517561578', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1193', null, null, null, '经销商账号登录', '1517621003', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1194', '34', 'test01', '9999', '经销商账号登录', '1517622536', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1195', null, null, null, '经销商账号登录', '1517622570', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1196', null, null, null, '经销商账号登录', '1517624660', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1197', null, null, null, '经销商账号登录', '1517639039', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1198', null, null, null, '经销商账号登录', '1517639049', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1199', null, null, null, '经销商账号登录', '1517643740', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1200', null, null, null, '经销商账号登录', '1517644179', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1201', null, null, null, '经销商账号登录', '1517651462', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1202', null, null, null, '经销商账号登录', '1517658727', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1203', null, null, null, '经销商账号登录', '1517794784', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1204', null, null, null, '经销商账号登录', '1517794834', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1205', null, null, null, '经销商账号登录', '1517795237', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1206', '32', 'test99', '9999', '经销商账号登录', '1517796320', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1207', '995', 'kangli', '9999', '企业登录', '1517803681', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1208', null, null, null, '经销商账号登录', '1517813212', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1209', null, null, null, '经销商账号登录', '1517814874', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1210', null, null, null, '经销商账号登录', '1517814969', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1211', null, null, null, '经销商账号登录', '1517815116', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1212', null, null, null, '经销商账号登录', '1517815316', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1213', null, null, null, '经销商账号登录', '1517822927', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1214', null, null, null, '经销商账号登录', '1517834777', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1215', null, null, null, '经销商账号登录', '1517881598', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1216', null, null, null, '经销商账号登录', '1517889010', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1217', null, null, null, '经销商账号登录', '1517897402', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1218', '32', 'test99', '9999', '经销商账号登录', '1517903942', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1219', null, null, null, '经销商账号登录', '1517904761', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1220', null, null, null, '经销商账号登录', '1517905212', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1221', null, null, null, '经销商账号登录', '1517912539', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1222', null, null, null, '经销商账号登录', '1517967409', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1223', '32', 'test99', '9999', '经销商账号登录', '1517967636', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1224', '32', 'test99', '9999', '经销商出货', '1517984173', '0.0.0.0', '/Kangli/Kangli/Orders/odshipping/od_id/52/oddt_id/61/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201712011024061985\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":52,\"ship_oddtid\":61,\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":160000010101,\"ship_date\":1517984173,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1225', null, null, null, '经销商账号登录', '1517984487', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1226', '32', 'test99', '9999', '经销商出货', '1517984742', '0.0.0.0', '/Kangli/Kangli/Orders/odshipping/od_id/52/oddt_id/61/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201712011024061985\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":52,\"ship_oddtid\":61,\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":160000010101,\"ship_date\":1517984742,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1227', '32', 'test99', '9999', '经销商出货', '1517986562', '0.0.0.0', '/Kangli/Kangli/Orders/odshipping/od_id/52/oddt_id/61/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201712011024061985\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":52,\"ship_oddtid\":61,\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":160000010101,\"ship_date\":1517986562,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1228', null, null, null, '经销商账号登录', '1517995119', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1229', '34', 'test01', '9999', '经销商账号登录', '1517997531', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1230', '32', 'test99', '9999', '经销商账号登录', '1517998478', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1231', null, null, null, '经销商账号登录', '1518053615', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1232', '32', 'test99', '9999', '经销商账号登录', '1518053927', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1233', null, null, null, '经销商账号登录', '1518060831', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1234', null, null, null, '经销商账号登录', '1518070525', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1235', null, null, null, '经销商账号登录', '1518070526', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1236', null, null, null, '经销商账号登录', '1518078417', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1237', null, null, null, '经销商账号登录', '1519357800', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1238', null, null, null, '经销商账号登录', '1519366532', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1239', null, null, null, '经销商账号登录', '1519373787', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1240', '32', 'test99', '9999', '经销商账号登录', '1519378102', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1241', null, null, null, '经销商账号登录', '1519437964', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1242', '32', 'test99', '9999', '经销商账号登录', '1519440512', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1243', null, null, null, '经销商账号登录', '1519445271', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1244', null, null, null, '经销商账号登录', '1519452668', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1245', '32', 'test99', '9999', '经销商出货', '1519457200', '0.0.0.0', '/Kangli/Kangli/Orders/odshipping/od_id/52/oddt_id/61/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201712011024061985\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":52,\"ship_oddtid\":61,\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":160000010101,\"ship_date\":1519457200,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1246', '32', 'test99', '9999', '经销商出货', '1519461700', '0.0.0.0', '/Kangli/Kangli/Orders/odshipping/od_id/52/oddt_id/61/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201712011024061985\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":52,\"ship_oddtid\":61,\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":160000010101,\"ship_date\":1519461700,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1247', null, null, null, '经销商账号登录', '1519461974', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1248', '32', 'test99', '9999', '经销商出货', '1519462519', '0.0.0.0', '/Kangli/Kangli/Orders/odshipping/od_id/51/oddt_id/60/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":51,\"ship_oddtid\":60,\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":160000010102,\"ship_date\":1519462519,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1249', '32', 'test99', '9999', '经销商出货', '1519462546', '0.0.0.0', '/Kangli/Kangli/Orders/odshipping/od_id/51/oddt_id/60/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":51,\"ship_oddtid\":60,\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":160000010103,\"ship_date\":1519462546,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1250', '32', 'test99', '9999', '经销商出货', '1519462666', '0.0.0.0', '/Kangli/Kangli/Orders/odshipping/od_id/51/oddt_id/60/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":51,\"ship_oddtid\":60,\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":160000010104,\"ship_date\":1519462666,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1251', '32', 'test99', '9999', '经销商出货', '1519464157', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010105\",\"ship_date\":1519464157,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1252', '32', 'test99', '9999', '经销商出货', '1519464157', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010106\",\"ship_date\":1519464157,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1253', '32', 'test99', '9999', '经销商出货', '1519464876', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010107\",\"ship_date\":1519464876,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1254', '32', 'test99', '9999', '经销商出货', '1519464976', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010108\",\"ship_date\":1519464976,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1255', null, null, null, '经销商账号登录', '1519629677', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1256', '32', 'test99', '9999', '经销商账号登录', '1519970530', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1257', null, null, null, '经销商账号登录', '1520938086', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1258', null, null, null, '经销商账号登录', '1521097469', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1259', '995', 'kangli', '9999', '企业登录', '1521181566', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1260', null, null, null, '经销商账号登录', '1521429749', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1261', null, null, null, '经销商账号登录', '1522287726', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1262', null, null, null, '经销商账号登录', '1522295081', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1263', null, null, null, '经销商账号登录', '1522295083', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1264', null, null, null, '经销商账号登录', '1522295084', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1265', null, null, null, '经销商账号登录', '1522303253', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1266', null, null, null, '经销商账号登录', '1522303255', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1267', null, null, null, '经销商账号登录', '1522310520', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1268', null, null, null, '经销商账号登录', '1522318249', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1269', '32', 'test99', '9999', '经销商账号登录', '1522373202', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1270', null, null, null, '经销商账号登录', '1522374433', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1271', null, null, null, '经销商账号登录', '1522378364', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1272', null, null, null, '经销商账号登录', '1522378567', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1273', null, null, null, '经销商账号登录', '1522378576', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1274', null, null, null, '经销商账号登录', '1522378693', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1275', null, null, null, '经销商账号登录', '1522378928', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1276', null, null, null, '经销商账号登录', '1522391640', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1277', null, null, null, '经销商账号登录', '1522398874', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1278', '995', 'kangli', '9999', '企业登录', '1522465540', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1279', '995', 'kangli', '9999', '企业登录', '1522465810', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1280', '995', 'kangli', '9999', '企业登录', '1522477269', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1281', '995', 'kangli', '9999', '企业登录', '1522486534', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1282', '995', 'kangli', '9999', '企业登录', '1522486945', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1283', '995', 'kangli', '9999', '企业登录', '1522632226', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1284', '995', 'kangli', '9999', '企业登录', '1522649854', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1285', '995', 'kangli', '9999', '企业登录', '1523184838', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1286', '995', 'kangli', '9999', '企业登录', '1523184856', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1287', '995', 'kangli', '9999', '企业登录', '1523237017', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1288', '995', 'kangli', '9999', '企业登录', '1523237068', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1289', '995', 'kangli', '9999', '企业登录', '1523241845', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1290', '995', 'kangli', '9999', '企业登录', '1523242039', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1291', null, null, null, '经销商账号登录', '1523692020', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1292', '32', 'test99', '9999', '经销商账号登录', '1523695011', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1293', '32', 'test99', '9999', '经销商出货', '1523696946', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_date\":1523696946,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1294', '32', 'test99', '9999', '经销商出货', '1523697816', '127.0.0.1', '/Kangli/Kangli/Orders/odshipping/od_id/51/oddt_id/60/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":51,\"ship_oddtid\":60,\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":160000010110,\"ship_date\":1523697816,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1295', null, null, null, '经销商账号登录', '1523865716', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1296', '32', 'test99', '9999', '经销商账号登录', '1523866323', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1297', null, null, null, '经销商账号登录', '1523872955', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1298', null, null, null, '经销商账号登录', '1523928039', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1299', null, null, null, '经销商账号登录', '1523935735', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1300', null, null, null, '经销商账号登录', '1523944940', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1301', '32', 'test99', '9999', '经销商删除出货记录', '1523947465', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":42,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523696946,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1302', '32', 'test99', '9999', '经销商删除出货记录', '1523947554', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":41,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010108\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1519464976,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1303', '32', 'test99', '9999', '经销商出货', '1523947707', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010108\",\"ship_date\":1523947707,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1304', '32', 'test99', '9999', '经销商出货', '1523947753', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_date\":1523947753,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1305', '32', 'test99', '9999', '经销商出货', '1523948036', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_date\":1523948036,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1306', '32', 'test99', '9999', '经销商删除出货记录', '1523948355', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":46,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523948036,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1307', '32', 'test99', '9999', '经销商删除出货记录', '1523948467', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":45,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523947753,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1308', '32', 'test99', '9999', '经销商出货', '1523948998', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_date\":1523948998,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1309', '32', 'test99', '9999', '经销商出货', '1523949149', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_date\":1523949149,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1310', '32', 'test99', '9999', '经销商删除出货记录', '1523949383', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":48,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523949149,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1311', '32', 'test99', '9999', '经销商删除出货记录', '1523949386', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":47,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523948998,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1312', '32', 'test99', '9999', '经销商出货', '1523949543', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_date\":1523949543,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1313', '32', 'test99', '9999', '经销商出货', '1523949747', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_date\":1523949747,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1314', '32', 'test99', '9999', '经销商删除出货记录', '1523949817', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":50,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523949747,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1315', '32', 'test99', '9999', '经销商删除出货记录', '1523949821', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":49,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523949543,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1316', '32', 'test99', '9999', '经销商出货', '1523949951', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_date\":1523949951,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1317', '32', 'test99', '9999', '经销商删除出货记录', '1523950220', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":51,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523949951,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1318', '32', 'test99', '9999', '经销商出货', '1523950353', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_date\":1523950353,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1319', '32', 'test99', '9999', '经销商删除出货记录', '1523950626', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":52,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523950353,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1320', '32', 'test99', '9999', '经销商出货', '1523950721', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_date\":1523950721,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1321', '32', 'test99', '9999', '经销商出货', '1523950932', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_date\":1523950932,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1322', '32', 'test99', '9999', '经销商出货', '1523951491', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010111\",\"ship_date\":1523951491,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1323', null, null, null, '经销商账号登录', '1523952288', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1324', '32', 'test99', '9999', '经销商删除出货记录', '1523952489', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":55,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010111\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523951491,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1325', '32', 'test99', '9999', '经销商删除出货记录', '1523952491', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":54,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523950932,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1326', '32', 'test99', '9999', '经销商出货', '1523952519', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_date\":1523952519,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1327', '32', 'test99', '9999', '经销商删除出货记录', '1523952621', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":56,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523952519,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1328', '32', 'test99', '9999', '经销商删除出货记录', '1523952623', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odship_del', '{\"ship_id\":53,\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":51,\"ship_odblid\":0,\"ship_oddtid\":60,\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":1523950721,\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":0}', '2');
INSERT INTO `fw_log` VALUES ('1329', '32', 'test99', '9999', '经销商出货', '1523952640', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010109\",\"ship_date\":1523952640,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1330', '32', 'test99', '9999', '经销商出货', '1523952690', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_date\":1523952690,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1331', '32', 'test99', '9999', '经销商出货', '1523952744', '192.168.1.134', '192.168.1.134/klapi/controller/v1/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":32,\"ship_dealer\":34,\"ship_pro\":5,\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":3,\"ship_proqty\":1,\"ship_barcode\":\"160000010111\",\"ship_date\":1523952744,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":32,\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1332', null, null, null, '经销商账号登录', '1523960019', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1333', '32', 'test99', '9999', '经销商账号登录', '1523960860', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1334', null, null, null, '经销商账号登录', '1524014725', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1335', null, null, null, '经销商账号登录', '1524022155', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1336', null, null, null, '经销商账号登录', '1524031377', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1337', null, null, null, '经销商账号登录', '1524038704', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1338', null, null, null, '经销商账号登录', '1524046393', '192.168.1.134', '192.168.1.134/klapi/public/api', '', '2');
INSERT INTO `fw_log` VALUES ('1339', null, null, null, '经销商账号登录', '1524274848', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1340', null, null, null, '经销商账号登录', '1524275399', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1341', null, null, null, '经销商账号登录', '1524282720', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1342', null, null, null, '经销商账号登录', '1524290658', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1343', '32', 'test99', '9999', '经销商账号登录', '1524294688', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1344', null, null, null, '经销商账号登录', '1524298185', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1345', null, null, null, '经销商账号登录', '1524307055', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1346', null, null, null, '经销商账号登录', '1524446320', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1347', null, null, null, '经销商账号登录', '1524475424', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1348', null, null, null, '经销商账号登录', '1524533198', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1349', '32', 'test99', '9999', '经销商删除出货记录', '1524534453', '192.168.1.134', '192.168.1.134kangli/klapi/controller/orders/odship_del', '{\"ship_id\":\"58\",\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":\"51\",\"ship_odblid\":\"0\",\"ship_oddtid\":\"60\",\"ship_whid\":\"3\",\"ship_proqty\":\"1\",\"ship_barcode\":\"160000010110\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":\"1523952690\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":\"2\",\"ship_czid\":\"32\",\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":\"0\"}', '2');
INSERT INTO `fw_log` VALUES ('1350', '32', 'test99', '9999', '经销商出货', '1524534518', '192.168.1.134', '192.168.1.134kangli/klapi/controller/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":\"51\",\"ship_oddtid\":\"60\",\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_date\":1524534518,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1351', '32', 'test99', '9999', '经销商删除出货记录', '1524535004', '192.168.1.134', '192.168.1.134kangli/klapi/controller/orders/odship_del', '{\"ship_id\":\"62\",\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291828589531\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":\"51\",\"ship_odblid\":\"0\",\"ship_oddtid\":\"60\",\"ship_whid\":\"3\",\"ship_proqty\":\"1\",\"ship_barcode\":\"160000010110\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_date\":\"1524534518\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":\"2\",\"ship_czid\":\"32\",\"ship_czuser\":\"test99\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":\"0\"}', '2');
INSERT INTO `fw_log` VALUES ('1352', '32', 'test99', '9999', '经销商出货', '1524535093', '192.168.1.134', '192.168.1.134kangli/klapi/controller/orders/odshop_sumbit', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201711291633589771\",\"ship_deliver\":\"32\",\"ship_dealer\":\"34\",\"ship_pro\":\"5\",\"ship_odid\":\"49\",\"ship_oddtid\":\"58\",\"ship_whid\":\"3\",\"ship_proqty\":1,\"ship_barcode\":\"160000010110\",\"ship_date\":1524535093,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"1600000101\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test99\"}', '2');
INSERT INTO `fw_log` VALUES ('1353', null, null, null, '经销商账号登录', '1524535443', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1354', null, null, null, '经销商账号登录', '1524535450', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1355', null, null, null, '经销商账号登录', '1524561897', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1356', null, null, null, '经销商账号登录', '1524619093', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1357', '32', 'test99', '9999', '经销商账号登录', '1524620336', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1358', null, null, null, '经销商账号登录', '1524638946', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1359', '34', 'test01', '9999', '经销商账号登录', '1524642424', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1360', null, null, null, '经销商账号登录', '1524642520', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1361', null, null, null, '经销商账号登录', '1524642527', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1362', null, null, null, '经销商账号登录', '1524648548', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1363', null, null, null, '经销商账号登录', '1524648875', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1364', null, null, null, '经销商账号登录', '1524648881', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1365', null, null, null, '经销商账号登录', '1524649034', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1366', null, null, null, '经销商账号登录', '1524649040', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1367', null, null, null, '经销商账号登录', '1524706464', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1368', '34', 'test01', '9999', '经销商账号登录', '1524706529', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1369', null, null, null, '经销商账号登录', '1525681752', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1370', null, null, null, '经销商账号登录', '1525681796', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1371', null, null, null, '经销商账号登录', '1526464133', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1372', '32', 'test99', '9999', '经销商账号登录', '1526523823', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1373', null, null, null, '经销商账号登录', '1526524167', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1374', '995', 'kangli', '9999', '企业登录', '1526525640', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1375', '45', 'test0101', '9999', '代理商注册', '1526525736', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"test0101\",\"dl_pwd\":\"acf6f3c61711cf395038f8bf3cad759a\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u5eb7\\u751f\",\"dl_contact\":\"\\u5eb7\\u751f\",\"dl_tel\":\"13901010101\",\"dl_idcard\":\"110101199901012198\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1526525736,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"test0101\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"e293nfW8XF4ehmImEPb7oOfQnkgJNHSEYsJGyGLcqo4uqNBaMbTj+mCYdKdxDE8\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1376', null, null, null, '经销商账号登录', '1526539200', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1377', '45', 'test0101', '9999', '经销商账号登录', '1526543210', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1378', '995', 'kangli', '9999', '企业登录', '1526543271', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1379', '32', 'test99', '9999', '经销商账号登录', '1526543339', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1380', '995', 'kangli', '9999', '企业登录', '1526543411', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1381', '995', 'kangli', '9999', '产品返利设置', '1526543463', '0.0.0.0', '/Kangli/Mp/Product/profanli_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5206\\u516c\\u53f8\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"30000.00\",\"dlt_fanli2\":\"10000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"5.00\",\"pfl_fanli2\":\"2.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u8054\\u5408\\u521b\\u59cb\\u4eba\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"pfl_fanli1\":\"5.00\",\"pfl_fanli2\":\"3.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"2000.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"pfl_fanli1\":\"5.00\",\"pfl_fanli2\":\"5.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"0.00\",\"dlt_fanli2\":\"0.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"70.00\",\"pfl_fanli2\":\"30.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"}]', '1');
INSERT INTO `fw_log` VALUES ('1382', null, null, null, '经销商账号登录', '1526546468', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1383', '45', 'test0101', '9999', '经销商账号登录', '1526549818', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1384', '995', 'kangli', '9999', '企业登录', '1526549842', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1385', '32', 'test99', '9999', '经销商账号登录', '1526549893', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1386', null, null, null, '经销商账号登录', '1526552483', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1387', null, null, null, '经销商账号登录', '1526552493', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1388', null, null, null, '经销商账号登录', '1526606241', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1389', null, null, null, '经销商账号登录', '1526613532', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1390', null, null, null, '经销商账号登录', '1526624828', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1391', null, null, null, '经销商账号登录', '1526632229', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1392', null, null, null, '经销商账号登录', '1526638928', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1393', null, null, null, '经销商账号登录', '1526638935', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1394', null, null, null, '经销商账号登录', '1526639762', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1395', null, null, null, '经销商账号登录', '1526639768', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1396', '32', 'test99', '9999', '经销商账号登录', '1526639813', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1397', null, null, null, '经销商账号登录', '1526692514', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1398', null, null, null, '经销商账号登录', '1526700197', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1399', null, null, null, '经销商账号登录', '1526709953', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1400', '32', 'test99', '9999', '处理提现', '1526712199', '192.168.1.134', '192.168.1.134/klapi/controller/fanli/fanli_pay_save', '{\"rc_id\":\"4\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"38\",\"rc_sdlid\":\"32\",\"rc_money\":\"6000.00\",\"rc_bank\":\"5\",\"rc_bankcard\":\"e7950VVwGvu93vhAOF6HGCoJSpkXbiLPEXYunv0X04nRpYke6+ubOuNR\",\"rc_name\":\"\\u8521\\u751f\",\"rc_addtime\":\"1526639732\",\"rc_dealtime\":1526712199,\"rc_state\":1,\"rc_verify\":\"880e24837eb9f582cfb38d30066dcc6e\",\"rc_remark\":\"\\u5904\\u7406\\u6210\\u529f\",\"rc_remark2\":null,\"rc_ip\":\"192.168.1.134\",\"rc_pic\":\"9999\\/5affc78312818.png\"}', '2');
INSERT INTO `fw_log` VALUES ('1401', '32', 'test99', '9999', '经销商账号登录', '1526714958', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1402', '34', 'test01', '9999', '经销商账号登录', '1526714981', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1403', null, null, null, '经销商账号登录', '1526717868', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1404', '32', 'test99', '9999', '经销商账号登录', '1526718148', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1405', null, null, null, '经销商账号登录', '1526724762', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1406', '34', 'test01', '9999', '经销商账号登录', '1526725175', '127.0.0.1', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1407', null, null, null, '经销商账号登录', '1526865597', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1408', null, null, null, '经销商账号登录', '1526865652', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1409', '38', 'test03', '9999', '经销商账号登录', '1526866207', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1410', null, null, null, '经销商账号登录', '1526866401', '192.168.1.134', '192.168.1.134/kangli/klapi/v1/mpwx', '', '2');
INSERT INTO `fw_log` VALUES ('1411', '995', 'kangli', '9999', '企业登录', '1527750256', '127.0.0.1', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1412', '32', 'test99', '9999', '经销商账号登录', '1527825629', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1413', '995', 'kangli', '9999', '企业登录', '1527839157', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1414', '995', 'kangli', '9999', '企业登录', '1527839333', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1415', '995', 'kangli', '9999', '企业登录', '1527839522', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1416', '32', 'test99', '9999', '经销商账号登录', '1527905087', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1417', '995', 'kangli', '9999', '企业登录', '1527905167', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1418', '995', 'kangli', '9999', '企业登录', '1527906775', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1419', '32', 'test99', '9999', '经销商账号登录', '1531215186', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1420', '32', 'test99', '9999', '经销商账号登录', '1533976058', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1421', '32', 'test99', '9999', '经销商账号登录', '1534821548', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1422', '32', 'test99', '9999', '经销商账号登录', '1534841381', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1423', '995', 'kangli', '9999', '企业登录', '1534844240', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1424', '995', 'kangli', '9999', '企业登录', '1534844693', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1425', '995', 'kangli', '9999', '删除订单', '1534845543', '0.0.0.0', '/Kangli/Mp/Orders/deleteorder/od_id/61', '{\"od_id\":\"61\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201801291657009997\",\"od_total\":\"239.00\",\"od_addtime\":\"1517216220\",\"od_oddlid\":\"32\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"9999\\/5add395b28eb0.png\",\"od_contact\":\"\\u674e\\u751f\",\"od_addressid\":\"37\",\"od_sheng\":\"11\",\"od_shi\":\"1101\",\"od_qu\":\"0\",\"od_jie\":\"0\",\"od_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"od_tel\":\"139999999999\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"0\",\"od_fugou\":\"0\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1426', '995', 'kangli', '9999', '删除订单', '1534845549', '0.0.0.0', '/Kangli/Mp/Orders/deleteorder/od_id/68', '{\"od_id\":\"68\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201804241040368675\",\"od_total\":\"478.00\",\"od_addtime\":\"1524537636\",\"od_oddlid\":\"34\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u9648\\u751f\",\"od_addressid\":\"39\",\"od_sheng\":\"44\",\"od_shi\":\"4401\",\"od_qu\":\"440104\",\"od_jie\":\"0\",\"od_address\":\"\\u5e7f\\u4e1c\\u5e7f\\u5dde\\u8d8a\\u79c0\\u533a\",\"od_tel\":\"13011010101\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"0\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"0\",\"od_fugou\":\"0\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1427', '995', 'kangli', '9999', '删除订单', '1534845554', '0.0.0.0', '/Kangli/Mp/Orders/deleteorder/od_id/63', '{\"od_id\":\"63\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201801291849442310\",\"od_total\":\"239.00\",\"od_addtime\":\"1517222984\",\"od_oddlid\":\"32\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"9999\\/5a77cbf6b7980315.jpeg\",\"od_contact\":\"\\u674e\\u751f\",\"od_addressid\":\"37\",\"od_sheng\":\"11\",\"od_shi\":\"1101\",\"od_qu\":\"0\",\"od_jie\":\"0\",\"od_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"od_tel\":\"139999999999\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"0\",\"od_fugou\":\"0\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1428', '995', 'kangli', '9999', '删除订单', '1534845566', '0.0.0.0', '/Kangli/Mp/Orders/deleteorder/od_id/60', '{\"od_id\":\"60\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201801291607083047\",\"od_total\":\"239.00\",\"od_addtime\":\"1517213228\",\"od_oddlid\":\"32\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u674e\\u751f\",\"od_addressid\":\"37\",\"od_sheng\":\"11\",\"od_shi\":\"1101\",\"od_qu\":\"0\",\"od_jie\":\"0\",\"od_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"od_tel\":\"139999999999\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"0\",\"od_fugou\":\"0\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1429', '995', 'kangli', '9999', '删除订单', '1534845621', '0.0.0.0', '/Kangli/Mp/Orders/xndeleteorder/od_id/73', '{\"od_id\":\"73\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201808211752487429\",\"od_total\":\"239.00\",\"od_addtime\":\"1534845168\",\"od_oddlid\":\"32\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u674e\\u751f\",\"od_addressid\":\"51\",\"od_sheng\":\"440000\",\"od_shi\":\"440100\",\"od_qu\":\"440104\",\"od_jie\":\"0\",\"od_address\":\"\\u5e7f\\u4e1c\\u7701\\u5e7f\\u5dde\\u5e02\\u8d8a\\u79c0\\u533a\\u5e9c\\u524d\\u8def1\\u53f7 \\u5e7f\\u5dde\\u5e02\\u653f\\u5e9c\",\"od_tel\":\"13999999999\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"1\",\"od_fugou\":\"1\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1430', '995', 'kangli', '9999', '删除订单', '1534845627', '0.0.0.0', '/Kangli/Mp/Orders/xndeleteorder/od_id/74', '{\"od_id\":\"74\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201808211756518472\",\"od_total\":\"239.00\",\"od_addtime\":\"1534845411\",\"od_oddlid\":\"32\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u674e\\u751f\",\"od_addressid\":\"51\",\"od_sheng\":\"440000\",\"od_shi\":\"440100\",\"od_qu\":\"440104\",\"od_jie\":\"0\",\"od_address\":\"\\u5e7f\\u4e1c\\u7701\\u5e7f\\u5dde\\u5e02\\u8d8a\\u79c0\\u533a\\u5e9c\\u524d\\u8def1\\u53f7 \\u5e7f\\u5dde\\u5e02\\u653f\\u5e9c\",\"od_tel\":\"13999999999\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"1\",\"od_fugou\":\"1\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1431', '995', 'kangli', '9999', '删除订单', '1534845639', '0.0.0.0', '/Kangli/Mp/Orders/xndeleteorder/od_id/72', '{\"od_id\":\"72\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201808211751024117\",\"od_total\":\"717.00\",\"od_addtime\":\"1534845062\",\"od_oddlid\":\"32\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u674e\\u751f\",\"od_addressid\":\"51\",\"od_sheng\":\"440000\",\"od_shi\":\"440100\",\"od_qu\":\"440104\",\"od_jie\":\"0\",\"od_address\":\"\\u5e7f\\u4e1c\\u7701\\u5e7f\\u5dde\\u5e02\\u8d8a\\u79c0\\u533a\\u5e9c\\u524d\\u8def1\\u53f7 \\u5e7f\\u5dde\\u5e02\\u653f\\u5e9c\",\"od_tel\":\"13999999999\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"1\",\"od_fugou\":\"1\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1432', '995', 'kangli', '9999', '企业登录', '1534903273', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1433', '995', 'kangli', '9999', '添加经销商级别', '1534908080', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba2\",\"dlt_level\":5,\"dlt_fanli1\":\"111111\",\"dlt_fanli2\":\"1111\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"333\",\"dlt_minnum\":0,\"dlt_butie\":\"11\"}', '1');
INSERT INTO `fw_log` VALUES ('1434', '995', 'kangli', '9999', '删除经销商分类', '1534908338', '0.0.0.0', '/Kangli/Mp/Dealer/dltdel/dlt_id/11', '{\"dlt_id\":\"11\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba2\",\"dlt_level\":\"5\",\"dlt_fanli1\":\"111111.00\",\"dlt_fanli2\":\"1111.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"333.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"11.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1435', '995', 'kangli', '9999', '添加经销商级别', '1534908353', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba2\",\"dlt_level\":5,\"dlt_fanli1\":\"111111\",\"dlt_fanli2\":\"1111\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"333\",\"dlt_minnum\":0,\"dlt_butie\":\"11\"}', '1');
INSERT INTO `fw_log` VALUES ('1436', '995', 'kangli', '9999', '删除经销商分类', '1534919082', '0.0.0.0', '/Kangli/Mp/Dealer/dltdel/dlt_id/12', '{\"dlt_id\":\"12\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba2\",\"dlt_level\":\"5\",\"dlt_fanli1\":\"111111.00\",\"dlt_fanli2\":\"1111.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"333.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"11.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1437', '995', 'kangli', '9999', '添加经销商', '1534923962', '0.0.0.0', '/Kangli/Mp/Dealer/edit_save', '{\"dl_username\":\"kangli\",\"dl_pwd\":\"c56d0e9a7ccec67b4ea131655038d604\",\"dl_type\":7,\"dl_belong\":32,\"dl_level\":\"1\",\"dl_number\":\"45\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u79ef\\u6781\",\"dl_area\":\"\",\"dl_contact\":\"13822523907\",\"dl_tel\":\"524215\",\"dl_fax\":\"\",\"dl_address\":\"\",\"dl_email\":\"\",\"dl_weixin\":\"13226269692\",\"dl_qq\":\"\",\"dl_idcard\":\"440804199606160570\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_remark\":\"\",\"dl_des\":\"\",\"dl_addtime\":1534923962,\"dl_status\":1,\"dl_openid\":\"\",\"dl_wxnickname\":\"\",\"dl_tblevel\":0,\"dl_referee\":0,\"dl_pic\":\"\",\"dl_idcardpic\":\"9999\\/1534923962_2417.jpg\"}', '1');
INSERT INTO `fw_log` VALUES ('1438', '995', 'kangli', '9999', '添加经销商', '1534926742', '0.0.0.0', '/Kangli/Mp/Dealer/edit_save', '{\"dl_username\":\"kangli1\",\"dl_pwd\":\"c56d0e9a7ccec67b4ea131655038d604\",\"dl_type\":7,\"dl_belong\":32,\"dl_level\":\"1\",\"dl_number\":\"No:0000046\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u79ef\\u67812i\",\"dl_area\":\"\",\"dl_contact\":\"13822523908\",\"dl_tel\":\"13822523965\",\"dl_fax\":\"\",\"dl_address\":\"\",\"dl_email\":\"\",\"dl_weixin\":\"13226269621\",\"dl_qq\":\"\",\"dl_idcard\":\"440804199606160571\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_remark\":\"\\u597d\\u5065\\u5eb7\",\"dl_des\":\"\",\"dl_addtime\":1534926742,\"dl_status\":1,\"dl_openid\":\"\",\"dl_wxnickname\":\"\",\"dl_tblevel\":0,\"dl_referee\":0,\"dl_pic\":\"\",\"dl_idcardpic\":\"9999\\/1534926742_8185.jpg\"}', '1');
INSERT INTO `fw_log` VALUES ('1439', '995', 'kangli', '9999', '企业登录', '1534986780', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1440', '995', 'kangli', '9999', '修改产品类型', '1535007832', '0.0.0.0', '/Kangli/Mp/Product/typeedit_save', '{\"protype_id\":3,\"protype_name\":\"\\u7d20\\u98df\\u5168\\u99101\",\"protype_iswho\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1441', '995', 'kangli', '9999', '修改产品类型', '1535007846', '0.0.0.0', '/Kangli/Mp/Product/typeedit_save', '{\"protype_id\":3,\"protype_name\":\"\\u7d20\\u98df\\u5168\\u9910\",\"protype_iswho\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1442', '995', 'kangli', '9999', '删除产品', '1535008707', '0.0.0.0', '/Kangli/Mp/Product/delete/pro_id/6', '{\"pro_id\":\"6\",\"pro_unitcode\":\"9999\",\"pro_typeid\":\"3\",\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c12\",\"pro_number\":\"N0002\",\"pro_barcode\":\"\",\"pro_jftype\":\"1\",\"pro_jifen\":\"0\",\"pro_jfmax\":\"0\",\"pro_dljf\":\"0\",\"pro_pic\":\"3052\\/1510641544_4101.jpg\",\"pro_pic2\":\"3052\\/15106415442_7468.jpg\",\"pro_pic3\":null,\"pro_pic4\":null,\"pro_pic5\":null,\"pro_price\":\"556.00\",\"pro_stock\":\"0\",\"pro_units\":\"\\u7bb1\",\"pro_dbiao\":\"0\",\"pro_zbiao\":\"0\",\"pro_xbiao\":\"0\",\"pro_desc\":\"\\u4f4e\\u70ed\\u91cf\",\"pro_link\":\"\",\"pro_expirydate\":null,\"pro_remark\":\"\",\"pro_order\":\"0\",\"pro_active\":\"1\",\"pro_addtime\":\"1510641544\"}', '1');
INSERT INTO `fw_log` VALUES ('1443', '995', 'kangli', '9999', '删除产品', '1535008720', '0.0.0.0', '/Kangli/Mp/Product/delete/pro_id/9', '{\"pro_id\":\"9\",\"pro_unitcode\":\"9999\",\"pro_typeid\":\"3\",\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c15\",\"pro_number\":\"N0002\",\"pro_barcode\":\"\",\"pro_jftype\":\"1\",\"pro_jifen\":\"0\",\"pro_jfmax\":\"0\",\"pro_dljf\":\"0\",\"pro_pic\":\"3052\\/1510641544_4101.jpg\",\"pro_pic2\":\"3052\\/15106415442_7468.jpg\",\"pro_pic3\":null,\"pro_pic4\":null,\"pro_pic5\":null,\"pro_price\":\"556.00\",\"pro_stock\":\"0\",\"pro_units\":\"\\u7bb1\",\"pro_dbiao\":\"0\",\"pro_zbiao\":\"0\",\"pro_xbiao\":\"0\",\"pro_desc\":\"\\u4f4e\\u70ed\\u91cf\",\"pro_link\":\"\",\"pro_expirydate\":null,\"pro_remark\":\"\",\"pro_order\":\"0\",\"pro_active\":\"1\",\"pro_addtime\":\"1510641544\"}', '1');
INSERT INTO `fw_log` VALUES ('1444', '995', 'kangli', '9999', '删除产品', '1535008726', '0.0.0.0', '/Kangli/Mp/Product/delete/pro_id/8', '{\"pro_id\":\"8\",\"pro_unitcode\":\"9999\",\"pro_typeid\":\"3\",\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c14\",\"pro_number\":\"N0002\",\"pro_barcode\":\"\",\"pro_jftype\":\"1\",\"pro_jifen\":\"0\",\"pro_jfmax\":\"0\",\"pro_dljf\":\"0\",\"pro_pic\":\"3052\\/1510641544_4101.jpg\",\"pro_pic2\":\"3052\\/15106415442_7468.jpg\",\"pro_pic3\":null,\"pro_pic4\":null,\"pro_pic5\":null,\"pro_price\":\"556.00\",\"pro_stock\":\"0\",\"pro_units\":\"\\u7bb1\",\"pro_dbiao\":\"0\",\"pro_zbiao\":\"0\",\"pro_xbiao\":\"0\",\"pro_desc\":\"\\u4f4e\\u70ed\\u91cf\",\"pro_link\":\"\",\"pro_expirydate\":null,\"pro_remark\":\"\",\"pro_order\":\"0\",\"pro_active\":\"1\",\"pro_addtime\":\"1510641544\"}', '1');
INSERT INTO `fw_log` VALUES ('1445', '995', 'kangli', '9999', '修改产品价格体系', '1535011590', '0.0.0.0', '/Kangli/Mp/Product/propriceedit_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5206\\u516c\\u53f8\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"30000.00\",\"dlt_fanli2\":\"10000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"100\",\"pro_id\":\"7\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u8054\\u5408\\u521b\\u59cb\\u4eba\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"priprice\":\"200\",\"pro_id\":\"7\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"2000.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"priprice\":\"300\",\"pro_id\":\"7\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"0.00\",\"dlt_fanli2\":\"0.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"400\",\"pro_id\":\"7\"}]', '1');
INSERT INTO `fw_log` VALUES ('1446', '995', 'kangli', '9999', '添加产品', '1535013514', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_name\":\"fasdd\",\"pro_number\":\"N0003\",\"pro_order\":0,\"pro_unitcode\":\"9999\",\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u5982\\u94c1\\u63d0\\u63d0\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\\u8272\\u5982\\u65e5\",\"pro_addtime\":1535013514,\"pro_active\":1,\"pro_price\":\"555\",\"pro_stock\":0,\"pro_units\":\"\\u76d2\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0,\"pro_pic\":\"9999\\/1535013514_5754.jpg\",\"pro_pic2\":\"9999\\/15350135142_3472.jpg\",\"0\":\"\\u767d\",\"1\":\"m\",\"2\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1447', '995', 'kangli', '9999', '企业登录', '1535072586', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1448', '32', 'test99', '9999', '经销商账号登录', '1535091221', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1449', '995', 'kangli', '9999', '删除订单', '1535092145', '0.0.0.0', '/Kangli/Mp/Orders/xndeleteorder/od_id/71', '{\"od_id\":\"71\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201805210933506377\",\"od_total\":\"478.00\",\"od_addtime\":\"1526866430\",\"od_oddlid\":\"34\",\"od_rcdlid\":\"32\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u9648\\u751f\",\"od_addressid\":\"39\",\"od_sheng\":\"44\",\"od_shi\":\"4401\",\"od_qu\":\"440104\",\"od_jie\":\"0\",\"od_address\":\"\\u5e7f\\u4e1c\\u5e7f\\u5dde\\u8d8a\\u79c0\\u533a\",\"od_tel\":\"13011010101\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"0\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"1\",\"od_fugou\":\"1\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1450', '48', '13226269695', '9999', '代理商注册', '1535092816', '0.0.0.0', '/Kangli/Kangli/Dealer/apply', '{\"dl_username\":\"13226269695\",\"dl_pwd\":\"a9048d4e8ad193f03ad47e57772a7fcc\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a\",\"dl_contact\":\"\\u949f\\u742a\",\"dl_tel\":\"15875872797\",\"dl_idcard\":\"440804199606160570\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535092816,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":32,\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"13226269695\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"3\",\"dl_bankcard\":\"c8cfE3hx\\/SlhPDScDP3x6uC12gAkH6901gTKmToNvNk6VpIqAyZQHRr\\/XA7FpTxm\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1451', '32', 'test99', '9999', '经销商账号登录', '1535093603', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1452', '49', '13226269696', '9999', '代理商注册', '1535093967', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"13226269696\",\"dl_pwd\":\"2523aa43222f38f037ea7a2ace4c3d75\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a2\",\"dl_contact\":\"\\u949f\\u742a2\",\"dl_tel\":\"15875872799\",\"dl_idcard\":\"440804199606160570\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535093967,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"48\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"13226269696\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"53e9d+4o50RMdzwvXcab7xJv9m9ylQPtEPH0+qb8GEapvvJs8JS8BwAt7vo\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1453', '49', '13226269696', '9999', '经销商账号登录', '1535094192', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1454', '995', 'kangli', '9999', '企业登录', '1535094423', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1455', '995', 'kangli', '9999', '修改产品价格体系', '1535094874', '0.0.0.0', '/Kangli/Mp/Product/propriceedit_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5206\\u516c\\u53f8\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"30000.00\",\"dlt_fanli2\":\"10000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"300\",\"pro_id\":\"10\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u8054\\u5408\\u521b\\u59cb\\u4eba\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"priprice\":\"400\",\"pro_id\":\"10\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"2000.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"priprice\":\"500\",\"pro_id\":\"10\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"0.00\",\"dlt_fanli2\":\"0.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"600\",\"pro_id\":\"10\"}]', '1');
INSERT INTO `fw_log` VALUES ('1456', '995', 'kangli', '9999', '删除产品', '1535094920', '0.0.0.0', '/Kangli/Mp/Product/delete/pro_id/10', '{\"pro_id\":\"10\",\"pro_unitcode\":\"9999\",\"pro_typeid\":\"3\",\"pro_name\":\"fasdd\",\"pro_number\":\"N0003\",\"pro_barcode\":\"\",\"pro_jftype\":\"1\",\"pro_jifen\":\"0\",\"pro_jfmax\":\"0\",\"pro_dljf\":\"0\",\"pro_pic\":\"9999\\/1535013514_5754.jpg\",\"pro_pic2\":\"9999\\/15350135142_3472.jpg\",\"pro_pic3\":null,\"pro_pic4\":null,\"pro_pic5\":null,\"pro_price\":\"555.00\",\"pro_stock\":\"0\",\"pro_units\":\"\\u76d2\",\"pro_dbiao\":\"0\",\"pro_zbiao\":\"0\",\"pro_xbiao\":\"0\",\"pro_desc\":\"\\u5982\\u94c1\\u63d0\\u63d0\",\"pro_link\":\"\",\"pro_expirydate\":null,\"pro_remark\":\"\\u8272\\u5982\\u65e5\",\"pro_order\":\"0\",\"pro_active\":\"1\",\"pro_addtime\":\"1535013514\"}', '1');
INSERT INTO `fw_log` VALUES ('1457', '995', 'kangli', '9999', '产品返利设置', '1535095106', '0.0.0.0', '/Kangli/Mp/Product/profanli_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5206\\u516c\\u53f8\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"30000.00\",\"dlt_fanli2\":\"10000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"40\",\"pfl_fanli2\":\"40\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"7\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u8054\\u5408\\u521b\\u59cb\\u4eba\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"pfl_fanli1\":\"30\",\"pfl_fanli2\":\"30\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"7\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"2000.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"pfl_fanli1\":\"20\",\"pfl_fanli2\":\"20\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"7\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5408\\u4f19\\u4eba\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"0.00\",\"dlt_fanli2\":\"0.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"10\",\"pfl_fanli2\":\"10\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"7\"}]', '1');
INSERT INTO `fw_log` VALUES ('1458', '48', '13226269695', '9999', '经销商账号登录', '1535095479', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1459', '32', 'test99', '9999', '经销商账号登录', '1535095520', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1460', '995', 'kangli', '9999', '企业登录', '1535095697', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1461', '995', 'kangli', '9999', '处理提现', '1535095950', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"3\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"1550.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"6993IqVXHebht5i+FzydRnAEpA4ao+wRJ2n90H7pOPyXVMxhp35ULl1iRUwGsudj\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1526638345\",\"rc_dealtime\":\"0\",\"rc_state\":\"0\",\"rc_verify\":\"03506a7412a91a64cdcb3c4074fd1947\",\"rc_remark\":\"\",\"rc_remark2\":null,\"rc_ip\":\"192.168.1.134\",\"rc_pic\":null}', '1');
INSERT INTO `fw_log` VALUES ('1462', '995', 'kangli', '9999', '处理提现', '1535095974', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"1\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"20000.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"994aXajhjlGPfUVW2lEkfIl28lEB513cuioU\\/foYXb2FUFmTeA\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1510908576\",\"rc_dealtime\":\"0\",\"rc_state\":\"0\",\"rc_verify\":\"db514cd9798c0b599b69a59b2120b73a\",\"rc_remark\":\"\",\"rc_remark2\":null,\"rc_ip\":\"127.0.0.1\",\"rc_pic\":\"3052\\/5a0d51b432af0468.jpeg\"}', '1');
INSERT INTO `fw_log` VALUES ('1463', '995', 'kangli', '9999', '修改经销商级别', '1535096715', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u5e02\\u7ea7\",\"dlt_level\":3,\"dlt_fanli1\":\"2000.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"500.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1464', '995', 'kangli', '9999', '修改经销商级别', '1535096733', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":1,\"dlt_fanli1\":\"30000.00\",\"dlt_fanli2\":\"10000.00\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1465', '995', 'kangli', '9999', '修改经销商级别', '1535096751', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u7701\\u7ea7\",\"dlt_level\":2,\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"2000.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1466', '995', 'kangli', '9999', '修改经销商级别', '1535096777', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u53bf\\u7ea7\",\"dlt_level\":4,\"dlt_fanli1\":\"0.00\",\"dlt_fanli2\":\"0.00\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1467', '995', 'kangli', '9999', '修改经销商级别', '1535097025', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u592e\\u7ea7\",\"dlt_level\":1,\"dlt_fanli1\":\"30000.00\",\"dlt_fanli2\":\"10000.00\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1468', '48', '13226269695', '9999', '经销商账号登录', '1535098579', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1469', '995', 'kangli', '9999', '企业登录', '1535098769', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1470', '32', 'test99', '9999', '经销商账号登录', '1535098973', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1471', '995', 'kangli', '9999', '企业登录', '1535099004', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1472', '995', 'kangli', '9999', '修改经销商级别', '1535104003', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":1,\"dlt_fanli1\":\"30000.00\",\"dlt_fanli2\":\"10000.00\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1473', '995', 'kangli', '9999', '添加经销商级别', '1535104025', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_unitcode\":\"9999\",\"dlt_name\":\"vip\",\"dlt_level\":5,\"dlt_fanli1\":0,\"dlt_fanli2\":\"5000\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":0,\"dlt_minnum\":0,\"dlt_butie\":0}', '1');
INSERT INTO `fw_log` VALUES ('1474', '32', 'test99', '9999', '经销商账号登录', '1535104579', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1475', '995', 'kangli', '9999', '企业登录', '1535104642', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1476', '995', 'kangli', '9999', '企业登录', '1535159346', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1477', '995', 'kangli', '9999', '修改经销商级别', '1535159412', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":1,\"dlt_fanli1\":\"10000\",\"dlt_fanli2\":\"7000\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1478', '995', 'kangli', '9999', '修改经销商级别', '1535159449', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u5e02\\u7ea7\",\"dlt_level\":3,\"dlt_fanli1\":\"1500\",\"dlt_fanli2\":\"1000\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"500.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1479', '995', 'kangli', '9999', '修改经销商级别', '1535159463', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u53bf\\u7ea7\",\"dlt_level\":4,\"dlt_fanli1\":\"900\",\"dlt_fanli2\":\"500\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1480', '995', 'kangli', '9999', '修改经销商级别', '1535159488', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"vip\",\"dlt_level\":5,\"dlt_fanli1\":\"400\",\"dlt_fanli2\":\"100\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1481', '995', 'kangli', '9999', '修改产品价格体系', '1535159546', '0.0.0.0', '/Kangli/Mp/Product/propriceedit_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"100.00\",\"pro_id\":\"7\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u7701\\u7ea7\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"priprice\":\"200.00\",\"pro_id\":\"7\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5e02\\u7ea7\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"1500.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"priprice\":\"300.00\",\"pro_id\":\"7\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u53bf\\u7ea7\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"900.00\",\"dlt_fanli2\":\"500.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"400.00\",\"pro_id\":\"7\"},{\"dlt_id\":\"13\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"vip\",\"dlt_level\":\"5\",\"dlt_fanli1\":\"400.00\",\"dlt_fanli2\":\"100.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"500\",\"pro_id\":\"7\"}]', '1');
INSERT INTO `fw_log` VALUES ('1482', '995', 'kangli', '9999', '修改产品价格体系', '1535159561', '0.0.0.0', '/Kangli/Mp/Product/propriceedit_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"239.00\",\"pro_id\":\"5\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u7701\\u7ea7\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"priprice\":\"239.00\",\"pro_id\":\"5\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5e02\\u7ea7\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"1500.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"priprice\":\"259.00\",\"pro_id\":\"5\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u53bf\\u7ea7\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"900.00\",\"dlt_fanli2\":\"500.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"399.00\",\"pro_id\":\"5\"},{\"dlt_id\":\"13\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"vip\",\"dlt_level\":\"5\",\"dlt_fanli1\":\"400.00\",\"dlt_fanli2\":\"100.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"500\",\"pro_id\":\"5\"}]', '1');
INSERT INTO `fw_log` VALUES ('1483', '995', 'kangli', '9999', '产品返利设置', '1535159602', '0.0.0.0', '/Kangli/Mp/Product/profanli_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"50\",\"pfl_fanli2\":\"50\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u7701\\u7ea7\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"pfl_fanli1\":\"40\",\"pfl_fanli2\":\"40\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5e02\\u7ea7\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"1500.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"pfl_fanli1\":\"30\",\"pfl_fanli2\":\"30\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u53bf\\u7ea7\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"900.00\",\"dlt_fanli2\":\"500.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"20\",\"pfl_fanli2\":\"20\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"13\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"vip\",\"dlt_level\":\"5\",\"dlt_fanli1\":\"400.00\",\"dlt_fanli2\":\"100.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"10\",\"pfl_fanli2\":\"10\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"}]', '1');
INSERT INTO `fw_log` VALUES ('1484', '995', 'kangli', '9999', '修改经销商级别', '1535159926', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u603b\\u4ee31\",\"dlt_level\":1,\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1485', '995', 'kangli', '9999', '修改经销商级别', '1535159935', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":1,\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1486', '32', 'test99', '9999', '经销商账号登录', '1535160228', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1487', '50', '13226269652', '9999', '代理商注册', '1535160559', '0.0.0.0', '/Kangli/Kangli/Dealer/apply', '{\"dl_username\":\"13226269652\",\"dl_pwd\":\"ee0a4940738d582382d75ab618cc550f\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a3\",\"dl_contact\":\"\\u949f\\u742a3\",\"dl_tel\":\"42154784565\",\"dl_idcard\":\"440804199606162541\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535160559,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":32,\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"13226269652\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"653enfnX\\/i8rh1be7uv\\/t1qTddHLHh2x6E7rD82en+vSv0ki3I8eZQXYFvH6gOV5\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1488', '32', 'test99', '9999', '经销商账号登录', '1535160817', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1489', '995', 'kangli', '9999', '企业登录', '1535160854', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1490', '32', 'test99', '9999', '经销商账号登录', '1535160967', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1491', '995', 'kangli', '9999', '企业登录', '1535161005', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1492', '995', 'kangli', '9999', '删除经销商', '1535161729', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/50', '{\"dl_id\":\"50\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"13226269652\",\"dl_pwd\":\"ee0a4940738d582382d75ab618cc550f\",\"dl_number\":\"A0000050\",\"dl_name\":\"\\u949f\\u742a3\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":\"7\",\"dl_sttype\":\"0\",\"dl_belong\":\"0\",\"dl_referee\":\"32\",\"dl_level\":\"1\",\"dl_contact\":\"\\u949f\\u742a3\",\"dl_tel\":\"42154784565\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"13226269652\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":\"0\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_idcard\":\"440804199606162541\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"653enfnX\\/i8rh1be7uv\\/t1qTddHLHh2x6E7rD82en+vSv0ki3I8eZQXYFvH6gOV5\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":\"1\",\"dl_startdate\":\"1535160764\",\"dl_enddate\":\"1566696764\",\"dl_addtime\":\"1535160559\",\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"0\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1493', '51', '13226269652', '9999', '代理商注册', '1535161807', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"13226269652\",\"dl_pwd\":\"dd9d62225e2e52d46eb76ebb1c341a8f\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a3\",\"dl_contact\":\"\\u949f\\u742a3\",\"dl_tel\":\"12412154232\",\"dl_idcard\":\"440804199606160521\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535161807,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"13226269652\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"44b2gYfo1h5ThXSyHvYHgmE7lZ0LcIZEf33Ox\\/uc4pSFtRN0VzTilpEQ\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1494', '51', '13226269652', '9999', '经销商账号登录', '1535161906', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1495', '995', 'kangli', '9999', '企业登录', '1535161929', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1496', '32', 'test99', '9999', '经销商账号登录', '1535161977', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1497', '995', 'kangli', '9999', '企业登录', '1535162041', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1498', '995', 'kangli', '9999', '企业登录', '1535162360', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1499', '52', '13226269620', '9999', '代理商注册', '1535162408', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"13226269620\",\"dl_pwd\":\"abfbc8cc14952d7e34fadab6c4374e6f\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a4\",\"dl_contact\":\"\\u949f\\u742a4\",\"dl_tel\":\"12154232154\",\"dl_idcard\":\"440804199606162543\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535162408,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"44\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"13226269620\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"3c038QKJrVisRaSBIL3D3tjwGF+ec70xQWZdrciL34wC7OYkko5nH5KPgT4X1A\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1500', '52', '13226269620', '9999', '经销商账号登录', '1535162539', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1501', '44', 'test0301', '9999', '经销商账号登录', '1535162641', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1502', '995', 'kangli', '9999', '企业登录', '1535162677', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1503', '52', '13226269620', '9999', '经销商账号登录', '1535162789', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1504', '995', 'kangli', '9999', '企业登录', '1535162835', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1505', '995', 'kangli', '9999', '企业登录', '1535164621', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1506', '995', 'kangli', '9999', '处理提现', '1535164662', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"3\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"1550.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"6993IqVXHebht5i+FzydRnAEpA4ao+wRJ2n90H7pOPyXVMxhp35ULl1iRUwGsudj\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1526638345\",\"rc_dealtime\":\"1535095950\",\"rc_state\":\"1\",\"rc_verify\":\"03506a7412a91a64cdcb3c4074fd1947\",\"rc_remark\":\"\\u6c34\\u7535\\u8d39\",\"rc_remark2\":\"\",\"rc_ip\":\"192.168.1.134\",\"rc_pic\":null}', '1');
INSERT INTO `fw_log` VALUES ('1507', '32', 'test99', '9999', '经销商账号登录', '1535180366', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1508', '995', 'kangli', '9999', '处理提现', '1535181574', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"3\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"1550.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"6993IqVXHebht5i+FzydRnAEpA4ao+wRJ2n90H7pOPyXVMxhp35ULl1iRUwGsudj\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1526638345\",\"rc_dealtime\":\"1535095950\",\"rc_state\":\"2\",\"rc_verify\":\"03506a7412a91a64cdcb3c4074fd1947\",\"rc_remark\":\"\\u6c34\\u7535\\u8d39\",\"rc_remark2\":\"\",\"rc_ip\":\"192.168.1.134\",\"rc_pic\":null}', '1');
INSERT INTO `fw_log` VALUES ('1509', '53', '13226269542', '9999', '代理商注册', '1535181999', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"13226269542\",\"dl_pwd\":\"ce51afbbf8c3da77e2a76379400545aa\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a5\",\"dl_contact\":\"\\u949f\\u742a5\",\"dl_tel\":\"21545632542\",\"dl_idcard\":\"440804199606164765\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535181999,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"13226269542\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"8562MEwWcg9mhjnhPtJWFgzHEHg7LDrMSjQrey74mdSF5uGMZrv8ejzurIX7GfGr\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1510', '995', 'kangli', '9999', '企业登录', '1535182042', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1511', '995', 'kangli', '9999', '企业登录', '1535188018', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1512', '32', 'test99', '9999', '经销商账号登录', '1535188054', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1513', '995', 'kangli', '9999', '企业登录', '1535188407', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1514', '54', '13226269524', '9999', '代理商注册', '1535188450', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"13226269524\",\"dl_pwd\":\"23d03addef1d6233425c6b3bc53c70db\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"z\",\"dl_contact\":\"z\",\"dl_tel\":\"45213245652\",\"dl_idcard\":\"440804199606160542\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535188450,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"13226269524\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"c9fdT61hBWxRaqPkBV7+JiRky6iTDaXe60s+upSRj8VPnSeXhfWsA0Z5Ng\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1515', '55', '13226265489', '9999', '代理商注册', '1535189263', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"13226265489\",\"dl_pwd\":\"68cea2d8b6426afddfb0f8d5495fb687\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"c\",\"dl_contact\":\"c\",\"dl_tel\":\"13822521420\",\"dl_idcard\":\"440804199606160230\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535189263,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"13226265489\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"f85dzNT76AXQqbEGnZreX+VLyQrSsxpbRD\\/UKSXJijpcLzBJq6lu05I73lU0ZAtJ\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1516', '55', '13226265489', '9999', '经销商账号登录', '1535189572', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1517', '995', 'kangli', '9999', '企业登录', '1535332293', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1518', '995', 'kangli', '9999', '删除经销商', '1535332354', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/40', '{\"dl_id\":\"40\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"test0120\",\"dl_pwd\":\"b2eb1b93a6c9e0ddb2e56b1cd5fa3359\",\"dl_number\":\"No:0000040\",\"dl_name\":\"\\u90b1\\u751f\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":\"8\",\"dl_sttype\":\"0\",\"dl_belong\":\"32\",\"dl_referee\":\"39\",\"dl_level\":\"2\",\"dl_contact\":\"\\u90b1\\u751f\",\"dl_tel\":\"13001200120\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"test0120\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":\"0\",\"dl_sheng\":\"31\",\"dl_shi\":\"3101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u4e0a\\u6d77 \\u9ec4\\u6d66\\u533a \",\"dl_address\":\"\\u4e0a\\u6d77\\u9ec4\\u6d66\\u533a\",\"dl_idcard\":\"110101199801013871\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":\"4\",\"dl_bankcard\":\"f0d9KeJg7dvP9xk+ApsouebvQpJew8SCuv+IO3c\\/6DNrDVoQjALeLL6TBjtL5KiS\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":\"1\",\"dl_startdate\":\"1510921108\",\"dl_enddate\":null,\"dl_addtime\":\"1510921108\",\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"0\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1519', '995', 'kangli', '9999', '删除经销商', '1535332545', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/51', '{\"dl_id\":\"51\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"13226269652\",\"dl_pwd\":\"dd9d62225e2e52d46eb76ebb1c341a8f\",\"dl_number\":\"No:0000051\",\"dl_name\":\"\\u949f\\u742a3\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":\"7\",\"dl_sttype\":\"0\",\"dl_belong\":\"0\",\"dl_referee\":\"32\",\"dl_level\":\"1\",\"dl_contact\":\"\\u949f\\u742a3\",\"dl_tel\":\"12412154232\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"13226269652\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":\"0\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_idcard\":\"440804199606160521\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"44b2gYfo1h5ThXSyHvYHgmE7lZ0LcIZEf33Ox\\/uc4pSFtRN0VzTilpEQ\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":\"1\",\"dl_startdate\":\"1535161860\",\"dl_enddate\":\"1566697860\",\"dl_addtime\":\"1535161807\",\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"1535161906\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1520', '995', 'kangli', '9999', '删除经销商', '1535332552', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/53', '{\"dl_id\":\"53\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"13226269542\",\"dl_pwd\":\"ce51afbbf8c3da77e2a76379400545aa\",\"dl_number\":\"No:0000053\",\"dl_name\":\"\\u949f\\u742a5\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":\"7\",\"dl_sttype\":\"0\",\"dl_belong\":\"0\",\"dl_referee\":\"32\",\"dl_level\":\"1\",\"dl_contact\":\"\\u949f\\u742a5\",\"dl_tel\":\"21545632542\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"13226269542\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":\"0\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_idcard\":\"440804199606164765\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"8562MEwWcg9mhjnhPtJWFgzHEHg7LDrMSjQrey74mdSF5uGMZrv8ejzurIX7GfGr\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":\"1\",\"dl_startdate\":\"1535182148\",\"dl_enddate\":\"1566718148\",\"dl_addtime\":\"1535181999\",\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"0\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1521', '995', 'kangli', '9999', '删除经销商', '1535332559', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/54', '{\"dl_id\":\"54\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"13226269524\",\"dl_pwd\":\"23d03addef1d6233425c6b3bc53c70db\",\"dl_number\":\"No:0000054\",\"dl_name\":\"z\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":\"7\",\"dl_sttype\":\"0\",\"dl_belong\":\"0\",\"dl_referee\":\"32\",\"dl_level\":\"1\",\"dl_contact\":\"z\",\"dl_tel\":\"45213245652\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"13226269524\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":\"0\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_idcard\":\"440804199606160542\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"c9fdT61hBWxRaqPkBV7+JiRky6iTDaXe60s+upSRj8VPnSeXhfWsA0Z5Ng\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":\"1\",\"dl_startdate\":\"1535188496\",\"dl_enddate\":\"1566724496\",\"dl_addtime\":\"1535188450\",\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"0\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1522', '995', 'kangli', '9999', '删除订单', '1535332666', '0.0.0.0', '/Kangli/Mp/Orders/xndeleteorder/od_id/64', '{\"od_id\":\"64\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201804211143189593\",\"od_total\":\"239.00\",\"od_addtime\":\"1524282198\",\"od_oddlid\":\"32\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u674e\\u751f\",\"od_addressid\":\"51\",\"od_sheng\":\"440000\",\"od_shi\":\"440100\",\"od_qu\":\"440104\",\"od_jie\":\"0\",\"od_address\":\"\\u5e7f\\u4e1c\\u7701\\u5e7f\\u5dde\\u5e02\\u8d8a\\u79c0\\u533a\\u5e9c\\u524d\\u8def1\\u53f7 \\u5e7f\\u5dde\\u5e02\\u653f\\u5e9c\",\"od_tel\":\"13999999999\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"0\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"1\",\"od_fugou\":\"1\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1523', '32', 'test99', '9999', '经销商账号登录', '1535332776', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1524', '56', '15875872797', '9999', '代理商注册', '1535333668', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872797\",\"dl_pwd\":\"c3e7eea30ae5f006689ff1f19ec78072\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a5\",\"dl_contact\":\"\\u949f\\u742a5\",\"dl_tel\":\"13822523907\",\"dl_idcard\":\"440804199606168888\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535333668,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872797\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"35dbV5RvRKewJ0jhwaNSIXi3DQmIQv9PZSj3l19ocNnZWbZPMgMJhYfXLAcqZg0\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1525', '57', '15875872798', '9999', '代理商注册', '1535334065', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872798\",\"dl_pwd\":\"0df958e02fcbfda304492226184956de\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a6\",\"dl_contact\":\"\\u949f\\u742a6\",\"dl_tel\":\"13822523908\",\"dl_idcard\":\"440804199606162222\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535334065,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"56\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872798\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"0cb3LZ0743fpeWU9diC3VP4YfgMdCCTPnSFBCEINJQt6L7xb3VZDnRpGig\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1526', '32', 'test99', '9999', '经销商账号登录', '1535334345', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1527', '995', 'kangli', '9999', '删除经销商', '1535334496', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/57', '{\"dl_id\":\"57\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"15875872798\",\"dl_pwd\":\"0df958e02fcbfda304492226184956de\",\"dl_number\":\"No:0000057\",\"dl_name\":\"\\u949f\\u742a6\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":\"7\",\"dl_sttype\":\"0\",\"dl_belong\":\"0\",\"dl_referee\":\"56\",\"dl_level\":\"1\",\"dl_contact\":\"\\u949f\\u742a6\",\"dl_tel\":\"13822523908\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"15875872798\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":\"0\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_idcard\":\"440804199606162222\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"0cb3LZ0743fpeWU9diC3VP4YfgMdCCTPnSFBCEINJQt6L7xb3VZDnRpGig\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":\"1\",\"dl_startdate\":\"1535334179\",\"dl_enddate\":\"1566870179\",\"dl_addtime\":\"1535334065\",\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"0\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1528', '58', '15875872798', '9999', '代理商注册', '1535334570', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872798\",\"dl_pwd\":\"0df958e02fcbfda304492226184956de\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a6\",\"dl_contact\":\"\\u949f\\u742a6\",\"dl_tel\":\"1322523908\",\"dl_idcard\":\"440804199606161111\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535334570,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"56\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872798\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"5282eV0ZXGXEdjmQoI9CzPYUrvjneJypFvj1N2WrcMi17PFqDF8+qh3YmVCT\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1529', '995', 'kangli', '9999', '删除经销商', '1535334752', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/58', '{\"dl_id\":\"58\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"15875872798\",\"dl_pwd\":\"0df958e02fcbfda304492226184956de\",\"dl_number\":\"No:0000058\",\"dl_name\":\"\\u949f\\u742a6\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":\"7\",\"dl_sttype\":\"0\",\"dl_belong\":\"0\",\"dl_referee\":\"56\",\"dl_level\":\"1\",\"dl_contact\":\"\\u949f\\u742a6\",\"dl_tel\":\"1322523908\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"15875872798\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":\"0\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_idcard\":\"440804199606161111\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"5282eV0ZXGXEdjmQoI9CzPYUrvjneJypFvj1N2WrcMi17PFqDF8+qh3YmVCT\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":\"1\",\"dl_startdate\":\"1535334637\",\"dl_enddate\":\"1566870637\",\"dl_addtime\":\"1535334570\",\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"0\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1530', '59', '15875872798', '9999', '代理商注册', '1535334889', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872798\",\"dl_pwd\":\"0df958e02fcbfda304492226184956de\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a6\",\"dl_contact\":\"\\u949f\\u742a6\",\"dl_tel\":\"13822523908\",\"dl_idcard\":\"440804199606161111\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535334889,\"dl_status\":0,\"dl_level\":\"2\",\"dl_type\":8,\"dl_sttype\":0,\"dl_belong\":\"32\",\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872798\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"0a44nDvrAr4322cISddjsOE9gMEOv1v6FjTSbLwktVHCRQL5yyLSZ2nKZrsZiii1\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1531', '60', '15875872711', '9999', '代理商注册', '1535335722', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872711\",\"dl_pwd\":\"f7a902fe3b94d01fff6883ccde856a5c\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a7\",\"dl_contact\":\"\\u949f\\u742a7\",\"dl_tel\":\"13822523909\",\"dl_idcard\":\"440804199606162223\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535335722,\"dl_status\":0,\"dl_level\":\"2\",\"dl_type\":8,\"dl_sttype\":0,\"dl_belong\":\"56\",\"dl_referee\":\"56\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872711\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"d4d32Oqn5y0rDu4hA\\/5U2RQSHHauioRzcMjtZJIqONElmv7C1yT8Q5t4r\\/Vg\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1532', '61', '15875872712', '9999', '代理商注册', '1535336255', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872712\",\"dl_pwd\":\"68bdc50558e32ec2585a27e111e48855\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a8\",\"dl_contact\":\"\\u949f\\u742a8\",\"dl_tel\":\"13822523910\",\"dl_idcard\":\"440804199606162224\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535336255,\"dl_status\":0,\"dl_level\":\"2\",\"dl_type\":8,\"dl_sttype\":0,\"dl_belong\":\"32\",\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872712\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"51d4aKoGdWl0Lg7YV\\/XICOOYYhF9Cx6w+K9RrpmP9XIKodMUvjCMyw\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1533', '995', 'kangli', '9999', '修改经销商级别', '1535337782', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":1,\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":\"6900.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1534', '995', 'kangli', '9999', '产品返利设置', '1535337918', '0.0.0.0', '/Kangli/Mp/Product/profanli_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":\"6900.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"41.00\",\"pfl_fanli2\":\"40.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"7\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u7701\\u4ee3\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"pfl_fanli1\":\"31.00\",\"pfl_fanli2\":\"30.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"7\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5e02\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"1500.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"pfl_fanli1\":\"21.00\",\"pfl_fanli2\":\"20.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"7\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u53bf\\u7ea7\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"900.00\",\"dlt_fanli2\":\"500.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"11.00\",\"pfl_fanli2\":\"10.00\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"7\"}]', '1');
INSERT INTO `fw_log` VALUES ('1535', '995', 'kangli', '9999', '产品返利设置', '1535338637', '0.0.0.0', '/Kangli/Mp/Product/profanli_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":\"6900.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"201\",\"pfl_fanli2\":\"200\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u7701\\u4ee3\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"pfl_fanli1\":\"191\",\"pfl_fanli2\":\"190\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5e02\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"1500.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"pfl_fanli1\":\"181\",\"pfl_fanli2\":\"180\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u53bf\\u7ea7\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"900.00\",\"dlt_fanli2\":\"500.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"pfl_fanli1\":\"171\",\"pfl_fanli2\":\"170\",\"pfl_fanli3\":0,\"pfl_fanli4\":0,\"pfl_fanli5\":0,\"pfl_fanli6\":0,\"pfl_fanli7\":0,\"pfl_fanli8\":0,\"pfl_fanli9\":0,\"pfl_fanli10\":0,\"pfl_maiduan\":0,\"pro_id\":\"5\"}]', '1');
INSERT INTO `fw_log` VALUES ('1536', '59', '15875872798', '9999', '经销商账号登录', '1535338735', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1537', '56', '15875872797', '9999', '经销商账号登录', '1535338808', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1538', '59', '15875872798', '9999', '经销商账号登录', '1535340254', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1539', '995', 'kangli', '9999', '删除经销商', '1535340378', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/59', '{\"dl_id\":\"59\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"15875872798\",\"dl_pwd\":\"0df958e02fcbfda304492226184956de\",\"dl_number\":\"No:0000059\",\"dl_name\":\"\\u949f\\u742a6\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":\"8\",\"dl_sttype\":\"0\",\"dl_belong\":\"32\",\"dl_referee\":\"32\",\"dl_level\":\"2\",\"dl_contact\":\"\\u949f\\u742a6\",\"dl_tel\":\"13822523908\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"15875872798\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":\"0\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_idcard\":\"440804199606161111\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"0a44nDvrAr4322cISddjsOE9gMEOv1v6FjTSbLwktVHCRQL5yyLSZ2nKZrsZiii1\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":\"1\",\"dl_startdate\":\"1535334939\",\"dl_enddate\":\"1566870939\",\"dl_addtime\":\"1535334889\",\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"1535340254\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1540', '62', '15875872798', '9999', '代理商注册', '1535340599', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872798\",\"dl_pwd\":\"87f4809412d27e84544f1756e9edb826\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a6\",\"dl_contact\":\"\\u949f\\u742a6\",\"dl_tel\":\"13822523911\",\"dl_idcard\":\"440804199606162225\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535340598,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"56\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872798\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"022dLukKIRoueS6yiRXxoiUAP+5H25I1RkMxtg0Upg1c3TEciX6GKR5ibRfTLL4\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1541', '63', '15875872799', '9999', '代理商注册', '1535341499', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872799\",\"dl_pwd\":\"1ce5904f71b458007c9a2f53bba56b80\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a9\",\"dl_contact\":\"\\u949f\\u742a9\",\"dl_tel\":\"13822523912\",\"dl_idcard\":\"440804199606162226\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535341499,\"dl_status\":0,\"dl_level\":\"3\",\"dl_type\":9,\"dl_sttype\":0,\"dl_belong\":\"61\",\"dl_referee\":\"61\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872799\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"0fe5wQ9ioWj4kP2001SSdjFY6INsdmCLIxva18ag6reBF+CMaZxgVsJ\\/16o9\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1542', '62', '15875872798', '9999', '经销商账号登录', '1535341875', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1543', '61', '15875872712', '9999', '经销商账号登录', '1535342187', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1544', '61', '15875872712', '9999', '经销商账号登录', '1535351966', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1545', '32', 'test99', '9999', '经销商账号登录', '1535352518', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1546', '995', 'kangli', '9999', '删除订单', '1535353619', '0.0.0.0', '/Kangli/Mp/Orders/xndeleteorder/od_id/90', '{\"od_id\":\"90\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201808271442187575\",\"od_total\":\"4780.00\",\"od_addtime\":\"1535352138\",\"od_oddlid\":\"61\",\"od_rcdlid\":\"32\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u949f\\u742a8\",\"od_addressid\":\"68\",\"od_sheng\":\"11\",\"od_shi\":\"1101\",\"od_qu\":\"0\",\"od_jie\":\"0\",\"od_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"od_tel\":\"13822523910\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"1\",\"od_fugou\":\"1\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1547', '62', '15875872798', '9999', '经销商账号登录', '1535354298', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1548', '32', 'test99', '9999', '经销商账号登录', '1535355094', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1549', '995', 'kangli', '9999', '删除订单', '1535357260', '0.0.0.0', '/Kangli/Mp/Orders/xndeleteorder/od_id/89', '{\"od_id\":\"89\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201808271205122550\",\"od_total\":\"100.00\",\"od_addtime\":\"1535342712\",\"od_oddlid\":\"62\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u949f\\u742a6\",\"od_addressid\":\"69\",\"od_sheng\":\"11\",\"od_shi\":\"1101\",\"od_qu\":\"0\",\"od_jie\":\"0\",\"od_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"od_tel\":\"13822523911\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"1\",\"od_fugou\":\"1\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1550', '995', 'kangli', '9999', '删除订单', '1535357274', '0.0.0.0', '/Kangli/Mp/Orders/xndeleteorder/od_id/88', '{\"od_id\":\"88\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201808271204344889\",\"od_total\":\"3000.00\",\"od_addtime\":\"1535342674\",\"od_oddlid\":\"45\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u5eb7\\u751f\",\"od_addressid\":\"54\",\"od_sheng\":\"11\",\"od_shi\":\"1101\",\"od_qu\":\"0\",\"od_jie\":\"0\",\"od_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"od_tel\":\"13901010101\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"1\",\"od_fugou\":\"1\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1551', '995', 'kangli', '9999', '删除订单', '1535358003', '0.0.0.0', '/Kangli/Mp/Orders/xndeleteorder/od_id/95', '{\"od_id\":\"95\",\"od_unitcode\":\"9999\",\"od_orderid\":\"201808271611263001\",\"od_total\":\"239.00\",\"od_addtime\":\"1535357486\",\"od_oddlid\":\"32\",\"od_rcdlid\":\"0\",\"od_belongship\":\"0\",\"od_paypic\":\"\",\"od_contact\":\"\\u5468\\u751f\",\"od_addressid\":\"52\",\"od_sheng\":\"440000\",\"od_shi\":\"440100\",\"od_qu\":\"440104\",\"od_jie\":\"0\",\"od_address\":\"\\u5e7f\\u4e1c\\u7701\\u5e7f\\u5dde\\u5e02\\u8d8a\\u79c0\\u533a\\u8d8a\\u534e\\u8def112 \\u73e0\\u6c5f\\u56fd\\u9645\\u5927\\u53a6\",\"od_tel\":\"13999999998\",\"od_express\":\"0\",\"od_expressnum\":\"\",\"od_expressdate\":\"0\",\"od_remark\":\"\",\"od_state\":\"9\",\"od_stead\":\"0\",\"od_virtualstock\":\"1\",\"od_fugou\":\"1\",\"od_expressfee\":\"0.00\",\"od_untotall\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1552', '995', 'kangli', '9999', '企业登录', '1535359647', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1553', '995', 'kangli', '9999', '处理提现', '1535361216', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"1\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"20000.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"994aXajhjlGPfUVW2lEkfIl28lEB513cuioU\\/foYXb2FUFmTeA\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1510908576\",\"rc_dealtime\":\"1535095974\",\"rc_state\":\"1\",\"rc_verify\":\"db514cd9798c0b599b69a59b2120b73a\",\"rc_remark\":\"\\u8986\\u76d6\",\"rc_remark2\":\"\",\"rc_ip\":\"127.0.0.1\",\"rc_pic\":\"3052\\/5a0d51b432af0468.jpeg\"}', '1');
INSERT INTO `fw_log` VALUES ('1554', '995', 'kangli', '9999', '处理提现', '1535361758', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"1\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"20000.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"994aXajhjlGPfUVW2lEkfIl28lEB513cuioU\\/foYXb2FUFmTeA\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1510908576\",\"rc_dealtime\":\"1535095974\",\"rc_state\":\"1\",\"rc_verify\":\"db514cd9798c0b599b69a59b2120b73a\",\"rc_remark\":\"\\u8986\\u76d6\\u800c\",\"rc_remark2\":\"\",\"rc_ip\":\"127.0.0.1\",\"rc_pic\":\"3052\\/5a0d51b432af0468.jpeg\"}', '1');
INSERT INTO `fw_log` VALUES ('1555', '995', 'kangli', '9999', '企业登录', '1535419318', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1556', '32', 'test99', '9999', '经销商账号登录', '1535428318', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1557', '995', 'kangli', '9999', '企业登录', '1535504151', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1558', '32', 'test99', '9999', '经销商账号登录', '1535505574', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1559', '32', 'test99', '9999', '经销商账号登录', '1535506151', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1560', '32', 'test99', '9999', '经销商账号登录', '1535507746', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1561', '61', '15875872712', '9999', '经销商账号登录', '1535510574', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1562', '32', 'test99', '9999', '经销商账号登录', '1535510784', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1563', '64', '15875872801', '9999', '代理商注册', '1535511657', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872801\",\"dl_pwd\":\"83b65cbec0d8deb5740e58b57aeee5a3\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a10\",\"dl_contact\":\"\\u949f\\u742a10\",\"dl_tel\":\"13822523913\",\"dl_idcard\":\"440804199606162227\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535511657,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872801\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"065dVUG1NyHxNHKxDQt3oscjb81XOHeV3WYfd3wfFpcDHnqJBY4dfEoeUv8F\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1564', '64', '15875872801', '9999', '经销商账号登录', '1535511734', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1565', '65', '15875872802', '9999', '代理商注册', '1535512090', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872802\",\"dl_pwd\":\"4100ae33da89f8a7554f645488d62be2\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a11\",\"dl_contact\":\"\\u949f\\u742a11\",\"dl_tel\":\"13822523914\",\"dl_idcard\":\"440804199606162228\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535512090,\"dl_status\":0,\"dl_level\":\"2\",\"dl_type\":8,\"dl_sttype\":0,\"dl_belong\":\"32\",\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872802\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"9001dMu4XqMXI\\/Lg6o2Fm4rJQy+HUj9w2H1t56lj4jiZ5eLZ0YlkrOmGhp670W37\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1566', '65', '15875872802', '9999', '经销商账号登录', '1535512168', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1567', '32', 'test99', '9999', '经销商账号登录', '1535512531', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1568', '995', 'kangli', '9999', '添加产品', '1535515250', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c14\",\"pro_number\":\"2123245\",\"pro_order\":0,\"pro_unitcode\":\"9999\",\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u4f46\\u5982\\u679c\\u6211\\u4e8c\\u54e5\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\\u4eba\\u633a\\u597d\",\"pro_addtime\":1535515250,\"pro_active\":1,\"pro_price\":\"500\",\"pro_stock\":0,\"pro_units\":\"\\u76d2\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0,\"pro_pic\":\"9999\\/1535515250_2586.jpg\"}', '1');
INSERT INTO `fw_log` VALUES ('1569', '995', 'kangli', '9999', '企业登录', '1535591115', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1570', '66', '15875872803', '9999', '代理商注册', '1535592894', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872803\",\"dl_pwd\":\"18ec4d2cd554269723eb7ce414c6fc83\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a12\",\"dl_contact\":\"\\u949f\\u742a12\",\"dl_tel\":\"13822523915\",\"dl_idcard\":\"440804199606162229\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535592894,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"32\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872803\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"3b9fXeaopJszMoU\\/NshqDQaSo+6AFQAyEZz3g8AVN97NjbTsHk24fR+Ky4ujND3n\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1571', '67', '15875872804', '9999', '代理商注册', '1535593432', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872804\",\"dl_pwd\":\"abb08acae2666d687d6340c74362125f\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a13\",\"dl_contact\":\"\\u949f\\u742a13\",\"dl_tel\":\"13822523916\",\"dl_idcard\":\"440804199606160030\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535593432,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"66\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872804\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"c125s58Dm2jtWN6LXy4pmreB\\/P9XYhyV4WEL47oNYs2mmcARzZirmmmbdAEZ\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1572', '68', '15875872805', '9999', '代理商注册', '1535597272', '0.0.0.0', '/Kangli/Kangli/Apply/index', '{\"dl_username\":\"15875872805\",\"dl_pwd\":\"8b516a861f4261e8f721bbb82a71b743\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a14\",\"dl_contact\":\"\\u949f\\u742a14\",\"dl_tel\":\"13822523917\",\"dl_idcard\":\"440804199606162231\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535597272,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":\"61\",\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"15875872805\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"1a34zw0mcGrpIiiIt\\/T990ACNe1mWF45e3\\/8sOFUMAnP3YJd+Rc3DutyT1ua\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1573', '32', 'test99', '9999', '经销商账号登录', '1535599288', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1574', '32', 'test99', '9999', '经销商账号登录', '1535601287', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1575', '32', 'test99', '9999', '经销商账号登录', '1535601296', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1576', '32', 'test99', '9999', '经销商账号登录', '1535601308', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1577', '995', 'kangli', '9999', '修改产品价格体系', '1535601440', '0.0.0.0', '/Kangli/Mp/Product/propriceedit_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":\"6900.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"300\",\"pro_id\":\"11\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u7701\\u4ee3\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"priprice\":\"400\",\"pro_id\":\"11\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5e02\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"1500.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"priprice\":\"500\",\"pro_id\":\"11\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u53bf\\u7ea7\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"900.00\",\"dlt_fanli2\":\"500.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"600\",\"pro_id\":\"11\"}]', '1');
INSERT INTO `fw_log` VALUES ('1578', '995', 'kangli', '9999', '企业登录', '1535677795', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1579', '32', 'test99', '9999', '经销商账号登录', '1535677841', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1580', '32', 'test99', '9999', '经销商账号登录', '1535677851', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1581', '32', 'test99', '9999', '经销商账号登录', '1535680139', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1582', '32', 'test99', '9999', '经销商账号登录', '1535937089', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1583', '995', 'kangli', '9999', '企业登录', '1535937099', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1584', '32', 'test99', '9999', '经销商账号登录', '1535955331', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1585', '69', '124512365489', '9999', '代理商注册', '1535959069', '0.0.0.0', '/Kangli/Kangli/Dealer/apply', '{\"dl_username\":\"124512365489\",\"dl_pwd\":\"ae6f9a1877f9021750c7d67d7c76d82c\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u4f4e\\u529f\\u8017\",\"dl_contact\":\"\\u4f4e\\u529f\\u8017\",\"dl_tel\":\"25123333333\",\"dl_idcard\":\"440804199606162256\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1535959069,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":32,\"dl_remark\":\"\",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_openid\":\"\",\"dl_weixin\":\"124512365489\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"1f01I7tWIX+Q6Wpl4XJjqjFiO\\/3bhvi1yCMRYvo2rglUC5U1escNQ4FLSAhGvDO\\/\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1586', '32', 'test99', '9999', '经销商账号登录', '1535963171', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1587', '995', 'kangli', '9999', '企业登录', '1536023433', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1588', '32', 'test99', '9999', '经销商账号登录', '1536024322', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1589', '995', 'kangli', '9999', '企业登录', '1536109834', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1590', '32', 'test99', '9999', '经销商账号登录', '1536109890', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1591', '63', '15875872799', '9999', '经销商账号登录', '1536129852', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1592', '32', 'test99', '9999', '经销商账号登录', '1536129952', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1593', '32', 'test99', '9999', '经销商账号登录', '1536130293', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1594', '63', '15875872799', '9999', '经销商账号登录', '1536130334', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1595', '32', 'test99', '9999', '经销商账号登录', '1536134956', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1596', '995', 'kangli', '9999', '删除经销商', '1536135095', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/69', '{\"dl_id\":\"69\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"124512365489\",\"dl_pwd\":\"ae6f9a1877f9021750c7d67d7c76d82c\",\"dl_number\":\"A0000069\",\"dl_name\":\"\\u4f4e\\u529f\\u8017\",\"dl_des\":null,\"dl_area\":null,\"dl_type\":\"7\",\"dl_sttype\":\"0\",\"dl_belong\":\"0\",\"dl_referee\":\"32\",\"dl_level\":\"1\",\"dl_contact\":\"\\u4f4e\\u529f\\u8017\",\"dl_tel\":\"25123333333\",\"dl_fax\":null,\"dl_email\":null,\"dl_weixin\":\"124512365489\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_qq\":null,\"dl_country\":\"0\",\"dl_sheng\":\"11\",\"dl_shi\":\"1101\",\"dl_qu\":\"0\",\"dl_qustr\":\"\\u5317\\u4eac \\u4e1c\\u57ce\\u533a \",\"dl_address\":\"\\u5317\\u4eac\\u4e1c\\u57ce\\u533a\",\"dl_idcard\":\"440804199606162256\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"1f01I7tWIX+Q6Wpl4XJjqjFiO\\/3bhvi1yCMRYvo2rglUC5U1escNQ4FLSAhGvDO\\/\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":null,\"dl_remark\":\"\",\"dl_status\":\"0\",\"dl_startdate\":null,\"dl_enddate\":null,\"dl_addtime\":\"1535959069\",\"dl_pic\":null,\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"0\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1597', '995', 'kangli', '9999', '处理提现', '1536136641', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"5\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"89326.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"907f3T1QD3cjAlWi+xhtjnpmpmY52HWP0+bH+ak2F+jUvPlSPdC1oUTH\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1536136544\",\"rc_dealtime\":\"0\",\"rc_state\":\"0\",\"rc_verify\":\"5f9404c96506d50931204723778439d2\",\"rc_remark\":\"\",\"rc_remark2\":null,\"rc_ip\":\"0.0.0.0\",\"rc_pic\":null}', '1');
INSERT INTO `fw_log` VALUES ('1598', '995', 'kangli', '9999', '处理提现', '1536136919', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"6\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"89326.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"ec57g37e26OPkuuAJKii\\/gP0c7yDWLyd7RX+oGN9uWVNuMxAMThjpytYFg\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1536136850\",\"rc_dealtime\":\"0\",\"rc_state\":\"0\",\"rc_verify\":\"dfab7c6ba330b77bcd4cd316b275696f\",\"rc_remark\":\"\",\"rc_remark2\":null,\"rc_ip\":\"0.0.0.0\",\"rc_pic\":null}', '1');
INSERT INTO `fw_log` VALUES ('1599', '995', 'kangli', '9999', '企业登录', '1536195785', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1600', '61', '15875872712', '9999', '经销商账号登录', '1536197394', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1601', '32', 'test99', '9999', '经销商账号登录', '1536197447', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1602', '995', 'kangli', null, '企业子用户入库', '1536220276', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"346456\",\"stor_pro\":11,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000101\",\"stor_date\":1536220276,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\\u98ce\\u683c\\u5316\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1603', '995', 'kangli', '9999', '删除入库记录', '1536220728', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/318', '{\"stor_id\":\"318\",\"stor_unitcode\":\"9999\",\"stor_number\":\"2000741245345\",\"stor_pro\":\"5\",\"stor_whid\":\"2\",\"stor_proqty\":\"20\",\"stor_barcode\":\"160000001\",\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_date\":\"1512092655\",\"stor_remark\":\"\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1604', '56', '15875872797', '9999', '经销商账号登录', '1536222618', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1605', '32', 'test99', '9999', '经销商账号登录', '1536222751', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1606', '995', 'kangli', '9999', '处理提现', '1536222875', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"7\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"56\",\"rc_sdlid\":\"0\",\"rc_money\":\"36164.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"dbb7tGZk2mWfvA7jkF6FK\\/PDKk9Fy9AeLYvBO0gJox8SsOLP6zCYzsM\",\"rc_name\":\"\\u949f\\u742a5\",\"rc_addtime\":\"1536222662\",\"rc_dealtime\":\"0\",\"rc_state\":\"0\",\"rc_verify\":\"b1171b9bef8dfaa07cd56ba9e0023221\",\"rc_remark\":\"\",\"rc_remark2\":null,\"rc_ip\":\"0.0.0.0\",\"rc_pic\":null}', '1');
INSERT INTO `fw_log` VALUES ('1607', '995', 'kangli', '9999', '删除经销商', '1536223856', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/47', '{\"dl_id\":\"47\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"kangli1\",\"dl_pwd\":\"c56d0e9a7ccec67b4ea131655038d604\",\"dl_number\":\"No:0000046\",\"dl_name\":\"\\u79ef\\u67812i\",\"dl_des\":\"\",\"dl_area\":\"\",\"dl_type\":\"7\",\"dl_sttype\":\"0\",\"dl_belong\":\"32\",\"dl_referee\":\"0\",\"dl_level\":\"1\",\"dl_contact\":\"13822523908\",\"dl_tel\":\"13822523965\",\"dl_fax\":\"\",\"dl_email\":\"\",\"dl_weixin\":\"13226269621\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":null,\"dl_wxcity\":null,\"dl_wxcountry\":null,\"dl_wxheadimg\":null,\"dl_qq\":\"\",\"dl_country\":\"0\",\"dl_sheng\":\"0\",\"dl_shi\":\"0\",\"dl_qu\":\"0\",\"dl_qustr\":null,\"dl_address\":\"\",\"dl_idcard\":\"440804199606160571\",\"dl_idcardpic\":\"9999\\/1534926742_8185.jpg\",\"dl_idcardpic2\":null,\"dl_bank\":\"0\",\"dl_bankcard\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":\"0\",\"dl_remark\":\"\\u597d\\u5065\\u5eb7\",\"dl_status\":\"1\",\"dl_startdate\":null,\"dl_enddate\":null,\"dl_addtime\":\"1534926742\",\"dl_pic\":\"\",\"dl_brand\":null,\"dl_brandlevel\":null,\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"0\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1608', '995', 'kangli', '9999', '删除经销商', '1536223863', '0.0.0.0', '/Kangli/Mp/Dealer/delete/dl_id/46', '{\"dl_id\":\"46\",\"dl_unitcode\":\"9999\",\"dl_openid\":\"\",\"dl_username\":\"kangli\",\"dl_pwd\":\"c56d0e9a7ccec67b4ea131655038d604\",\"dl_number\":\"45\",\"dl_name\":\"\\u79ef\\u6781\",\"dl_des\":\"\",\"dl_area\":\"\",\"dl_type\":\"7\",\"dl_sttype\":\"0\",\"dl_belong\":\"32\",\"dl_referee\":\"0\",\"dl_level\":\"1\",\"dl_contact\":\"13822523907\",\"dl_tel\":\"524215\",\"dl_fax\":\"\",\"dl_email\":\"\",\"dl_weixin\":\"13226269692\",\"dl_wxnickname\":\"\",\"dl_wxsex\":\"0\",\"dl_wxprovince\":null,\"dl_wxcity\":null,\"dl_wxcountry\":null,\"dl_wxheadimg\":null,\"dl_qq\":\"\",\"dl_country\":\"0\",\"dl_sheng\":\"0\",\"dl_shi\":\"0\",\"dl_qu\":\"0\",\"dl_qustr\":null,\"dl_address\":\"\",\"dl_idcard\":\"440804199606160570\",\"dl_idcardpic\":\"9999\\/1534923962_2417.jpg\",\"dl_idcardpic2\":null,\"dl_bank\":\"0\",\"dl_bankcard\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_tbsqpic\":null,\"dl_tblevel\":\"0\",\"dl_remark\":\"\",\"dl_status\":\"9\",\"dl_startdate\":null,\"dl_enddate\":null,\"dl_addtime\":\"1534923962\",\"dl_pic\":\"\",\"dl_brand\":null,\"dl_brandlevel\":null,\"dl_oddtime\":\"0\",\"dl_oddcount\":\"0\",\"dl_logintime\":\"0\",\"dl_fanli\":\"0.00\",\"dl_jifen\":\"0\",\"dl_lastflid\":\"0\",\"dl_flmodel\":\"0\",\"dl_deposit\":\"0.00\",\"dl_depositpic\":null,\"dl_paypic\":null,\"dl_stockpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1609', '32', 'test99', '9999', '经销商账号登录', '1536283150', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1610', '995', 'kangli', '9999', '企业登录', '1536285172', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1611', '995', 'kangli', '9999', '企业登录', '1536655742', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1612', '32', 'test99', '9999', '经销商账号登录', '1536656803', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1613', '995', 'kangli', '9999', '企业登录', '1536722251', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1614', '995', 'kangli', '9999', '企业登录', '1536738043', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1615', '995', 'kangli', '9999', '企业登录', '1536743114', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1616', '32', 'test99', '9999', '经销商账号登录', '1536801510', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1617', '32', 'test99', '9999', '经销商账号登录', '1536801685', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1618', '32', 'test99', '9999', '经销商账号登录', '1536802441', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1619', '32', 'test99', '9999', '经销商账号登录', '1536807490', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1620', '32', 'test99', '9999', '经销商账号登录', '1536808580', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1621', '32', 'test99', '9999', '经销商账号登录', '1536808747', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1622', '32', 'test99', '9999', '经销商账号登录', '1536889519', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1623', '995', 'kangli', '9999', '企业登录', '1536892428', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1624', '995', 'kangli', '9999', '企业登录', '1536892441', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1625', '32', 'test99', '9999', '经销商账号登录', '1537425662', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1626', '995', 'kangli', '9999', '企业登录', '1537432775', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1627', '995', 'kangli', '9999', '企业登录', '1537519339', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1628', '995', 'kangli', '9999', '企业登录', '1537925881', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1629', '995', 'kangli', '9999', '企业登录', '1537949044', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1630', '995', 'kangli', '9999', '企业登录', '1538010882', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1631', '995', 'kangli', null, '企业子用户入库', '1538017976', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"1600000102\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000102\",\"stor_date\":1538017976,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"1600000102\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1632', '995', 'kangli', null, '企业子用户入库', '1538017998', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"1600000103\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000103\",\"stor_date\":1538017998,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"1600000103\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1633', '995', 'kangli', '9999', '修改产品', '1538018030', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_id\":5,\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c11\",\"pro_number\":\"N0001\",\"pro_order\":0,\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u4f4e\\u70ed\\u91cf\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\",\"pro_price\":\"556.00\",\"pro_stock\":0,\"pro_units\":\"\\u7bb1\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0}', '1');
INSERT INTO `fw_log` VALUES ('1634', '995', 'kangli', '9999', '修改产品', '1538018059', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_id\":5,\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c12\",\"pro_number\":\"N0001\",\"pro_order\":0,\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u4f4e\\u70ed\\u91cf\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\",\"pro_price\":\"556.00\",\"pro_stock\":0,\"pro_units\":\"\\u7bb1\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0}', '1');
INSERT INTO `fw_log` VALUES ('1635', '995', 'kangli', '9999', '修改产品', '1538018072', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_id\":11,\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c11\",\"pro_number\":\"2123245\",\"pro_order\":0,\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u4f46\\u5982\\u679c\\u6211\\u4e8c\\u54e5\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\\u4eba\\u633a\\u597d\",\"pro_price\":\"500.00\",\"pro_stock\":0,\"pro_units\":\"\\u76d2\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0}', '1');
INSERT INTO `fw_log` VALUES ('1636', '995', 'kangli', '9999', '企业登录', '1538097840', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1637', '995', 'kangli', null, '企业子用户入库', '1538100150', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":11,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000105\",\"stor_date\":1538100150,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\\u4e8c\\u5154\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1638', '995', 'kangli', '9999', '删除入库记录', '1538100161', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/322', '{\"stor_id\":\"322\",\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":\"11\",\"stor_whid\":\"2\",\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000105\",\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_date\":\"1538100150\",\"stor_remark\":\"\\u4e8c\\u5154\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1639', '995', 'kangli', null, '企业子用户入库', '1538101483', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":11,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000010\",\"stor_date\":1538101483,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\\u4ed6\\u5df2\\u7ecf\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1640', '995', 'kangli', '9999', '删除入库记录', '1538101497', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/323', '{\"stor_id\":\"323\",\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":\"11\",\"stor_whid\":\"2\",\"stor_proqty\":\"100\",\"stor_barcode\":\"16000010\",\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_date\":\"1538101483\",\"stor_remark\":\"\\u4ed6\\u5df2\\u7ecf\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1641', '995', 'kangli', null, '企业子用户入库', '1538102853', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000104\",\"stor_date\":1538102853,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\\u5e7f\\u5927\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1642', '995', 'kangli', null, '企业子用户入库', '1538102951', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"41235345\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000010\",\"stor_date\":1538102951,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\\u554a\\u7684\\u98ce\\u683c\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1643', '995', 'kangli', null, '企业子用户入库', '1538103047', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000100\",\"stor_date\":1538103047,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\\u5916\\u8033\\u708e\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1644', '995', 'kangli', null, '企业子用户入库', '1538103912', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"1600000102\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"20\",\"stor_barcode\":\"150000001\",\"stor_date\":1538103912,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\\u585e\\u8089\\u4e5f\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1645', '995', 'kangli', '9999', '删除入库记录', '1538104307', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/324', '{\"stor_id\":\"324\",\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":\"7\",\"stor_whid\":\"2\",\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000104\",\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_date\":\"1538102853\",\"stor_remark\":\"\\u5e7f\\u5927\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1646', '995', 'kangli', '9999', '修改产品', '1538105024', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_id\":11,\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c1\",\"pro_number\":\"2123245\",\"pro_order\":0,\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u4f46\\u5982\\u679c\\u6211\\u4e8c\\u54e5\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\\u4eba\\u633a\\u597d\",\"pro_price\":\"500.00\",\"pro_stock\":0,\"pro_units\":\"\\u76d2\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0,\"0\":\"\\u767d\",\"1\":\"m\",\"2\":\"59\"}', '1');
INSERT INTO `fw_log` VALUES ('1647', '995', 'kangli', '9999', '删除入库记录', '1538105082', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/327', '{\"stor_id\":\"327\",\"stor_unitcode\":\"9999\",\"stor_number\":\"1600000102\",\"stor_pro\":\"7\",\"stor_whid\":\"2\",\"stor_proqty\":\"20\",\"stor_barcode\":\"150000001\",\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_date\":\"1538103912\",\"stor_remark\":\"\\u585e\\u8089\\u4e5f\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1648', '995', 'kangli', '9999', '删除入库记录', '1538105089', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/326', '{\"stor_id\":\"326\",\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":\"7\",\"stor_whid\":\"2\",\"stor_proqty\":\"100\",\"stor_barcode\":\"16000100\",\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_date\":\"1538103047\",\"stor_remark\":\"\\u5916\\u8033\\u708e\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1649', '995', 'kangli', '9999', '删除入库记录', '1538105095', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/325', '{\"stor_id\":\"325\",\"stor_unitcode\":\"9999\",\"stor_number\":\"41235345\",\"stor_pro\":\"7\",\"stor_whid\":\"2\",\"stor_proqty\":\"100\",\"stor_barcode\":\"16000010\",\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_date\":\"1538102951\",\"stor_remark\":\"\\u554a\\u7684\\u98ce\\u683c\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1650', '995', 'kangli', '9999', '删除入库记录', '1538105101', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/321', '{\"stor_id\":\"321\",\"stor_unitcode\":\"9999\",\"stor_number\":\"1600000103\",\"stor_pro\":\"7\",\"stor_whid\":\"2\",\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000103\",\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_date\":\"1538017998\",\"stor_remark\":\"1600000103\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1651', '995', 'kangli', '9999', '删除入库记录', '1538105107', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/320', '{\"stor_id\":\"320\",\"stor_unitcode\":\"9999\",\"stor_number\":\"1600000102\",\"stor_pro\":\"5\",\"stor_whid\":\"2\",\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000102\",\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_date\":\"1538017976\",\"stor_remark\":\"1600000102\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1652', '995', 'kangli', null, '企业子用户入库', '1538105204', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"123456\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000001\",\"stor_date\":1538105204,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1653', '995', 'kangli', '9999', '修改产品', '1538105397', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_id\":11,\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c11\",\"pro_number\":\"2123245\",\"pro_order\":0,\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u4f46\\u5982\\u679c\\u6211\\u4e8c\\u54e5\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\\u4eba\\u633a\\u597d\",\"pro_price\":\"500.00\",\"pro_stock\":0,\"pro_units\":\"\\u76d2\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0,\"0\":\"\\u767d\",\"1\":\"m\",\"2\":\"59\"}', '1');
INSERT INTO `fw_log` VALUES ('1654', '995', 'kangli', '9999', '删除产品', '1538105466', '0.0.0.0', '/Kangli/Mp/Product/delete/pro_id/11', '{\"pro_id\":\"11\",\"pro_unitcode\":\"9999\",\"pro_typeid\":\"3\",\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c11\",\"pro_number\":\"2123245\",\"pro_barcode\":\"\",\"pro_jftype\":\"1\",\"pro_jifen\":\"0\",\"pro_jfmax\":\"0\",\"pro_dljf\":\"0\",\"pro_pic\":\"9999\\/1535515250_2586.jpg\",\"pro_pic2\":null,\"pro_pic3\":null,\"pro_pic4\":null,\"pro_pic5\":null,\"pro_price\":\"500.00\",\"pro_stock\":\"0\",\"pro_units\":\"\\u76d2\",\"pro_dbiao\":\"0\",\"pro_zbiao\":\"0\",\"pro_xbiao\":\"0\",\"pro_desc\":\"\\u4f46\\u5982\\u679c\\u6211\\u4e8c\\u54e5\",\"pro_link\":\"\",\"pro_expirydate\":null,\"pro_remark\":\"\\u4eba\\u633a\\u597d\",\"pro_order\":\"0\",\"pro_active\":\"1\",\"pro_addtime\":\"1535515250\"}', '1');
INSERT INTO `fw_log` VALUES ('1655', '995', 'kangli', '9999', '修改产品', '1538105541', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_id\":7,\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c17\",\"pro_number\":\"N0007\",\"pro_order\":0,\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u4f4e\\u70ed\\u91cf\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\",\"pro_price\":\"556.00\",\"pro_stock\":0,\"pro_units\":\"\\u7bb1\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0,\"0\":\"\\u767d\",\"1\":\"ml\",\"2\":\"58\"}', '1');
INSERT INTO `fw_log` VALUES ('1656', '995', 'kangli', '9999', '修改产品', '1538105555', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_id\":5,\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c15\",\"pro_number\":\"N0001\",\"pro_order\":0,\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u4f4e\\u70ed\\u91cf\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\",\"pro_price\":\"556.00\",\"pro_stock\":0,\"pro_units\":\"\\u7bb1\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0}', '1');
INSERT INTO `fw_log` VALUES ('1657', '995', 'kangli', '9999', '添加产品', '1538105636', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c18\",\"pro_number\":\"N0008\",\"pro_order\":0,\"pro_unitcode\":\"9999\",\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u653e\\u5230\\u66f4\\u597d\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\",\"pro_addtime\":1538105636,\"pro_active\":1,\"pro_price\":\"1000\",\"pro_stock\":\"1000\",\"pro_units\":\"\\u76d2\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0,\"pro_pic\":\"9999\\/1538105636_1454.jpg\",\"pro_pic2\":\"9999\\/15381056362_2665.jpg\",\"0\":\"\\u767d\",\"1\":\"m\",\"2\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1658', '995', 'kangli', '9999', '修改产品', '1538105648', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_id\":12,\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c112\",\"pro_number\":\"N00012\",\"pro_order\":0,\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u653e\\u5230\\u66f4\\u597d\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\",\"pro_price\":\"1000.00\",\"pro_stock\":0,\"pro_units\":\"\\u76d2\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0,\"0\":\"\\u767d\",\"1\":\"m\",\"2\":\"60\"}', '1');
INSERT INTO `fw_log` VALUES ('1659', '32', 'test99', '9999', '经销商账号登录', '1538105724', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1660', '995', 'kangli', '9999', '删除入库记录', '1538106034', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/328', '{\"stor_id\":\"328\",\"stor_unitcode\":\"9999\",\"stor_number\":\"123456\",\"stor_pro\":\"7\",\"stor_whid\":\"2\",\"stor_proqty\":\"100\",\"stor_barcode\":\"16000001\",\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_date\":\"1538105204\",\"stor_remark\":\"\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1661', '995', 'kangli', null, '企业子用户入库', '1538106070', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"201809281137553051\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000001\",\"stor_date\":1538106070,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1662', '995', 'kangli', '9999', '删除入库记录', '1538117393', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/329', '{\"stor_id\":\"329\",\"stor_unitcode\":\"9999\",\"stor_number\":\"201809281137553051\",\"stor_pro\":\"5\",\"stor_whid\":\"2\",\"stor_proqty\":\"100\",\"stor_barcode\":\"16000001\",\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_date\":\"1538106070\",\"stor_remark\":\"\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1663', '995', 'kangli', null, '企业子用户入库', '1538117420', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000104\",\"stor_date\":1538117420,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1664', '995', 'kangli', '9999', '出货导入', '1538117683', '0.0.0.0', '/Kangli/Mp/Orders/odshipscanres_save', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201809281454069830\",\"ship_deliver\":0,\"ship_dealer\":\"32\",\"ship_pro\":\"5\",\"ship_odid\":126,\"ship_odblid\":null,\"ship_oddtid\":147,\"ship_whid\":2,\"ship_proqty\":\"10\",\"ship_barcode\":\"1600000104\",\"ship_date\":1538117683,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"16000001\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c15\",\"ship_cztype\":0,\"ship_czid\":\"995\",\"ship_czuser\":\"kangli\"}', '1');
INSERT INTO `fw_log` VALUES ('1665', '995', 'kangli', null, '企业子用户入库', '1538117820', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"41235345\",\"stor_pro\":12,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000105\",\"stor_date\":1538117820,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1666', '995', 'kangli', null, '企业子用户入库', '1538117871', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"346456\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000106\",\"stor_date\":1538117871,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1667', '995', 'kangli', null, '企业子用户入库', '1538118244', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"1600000103\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000107\",\"stor_date\":1538118244,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1668', '995', 'kangli', '9999', '出货导入', '1538118461', '0.0.0.0', '/Kangli/Mp/Orders/odshipscanres_save', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201809281502546954\",\"ship_deliver\":0,\"ship_dealer\":\"32\",\"ship_pro\":\"7\",\"ship_odid\":129,\"ship_odblid\":null,\"ship_oddtid\":150,\"ship_whid\":2,\"ship_proqty\":\"10\",\"ship_barcode\":\"1600000107\",\"ship_date\":1538118461,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"16000001\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c17\\u767dml\",\"ship_cztype\":0,\"ship_czid\":\"995\",\"ship_czuser\":\"kangli\"}', '1');
INSERT INTO `fw_log` VALUES ('1669', '995', 'kangli', null, '企业子用户入库', '1538118691', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"1600000103\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000108\",\"stor_date\":1538118691,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1670', '995', 'kangli', '9999', '出货导入', '1538118769', '0.0.0.0', '/Kangli/Mp/Orders/odshipscanres_save', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201809281511066311\",\"ship_deliver\":0,\"ship_dealer\":\"32\",\"ship_pro\":\"7\",\"ship_odid\":131,\"ship_odblid\":null,\"ship_oddtid\":152,\"ship_whid\":2,\"ship_proqty\":\"10\",\"ship_barcode\":\"1600000108\",\"ship_date\":1538118769,\"ship_ucode\":\"16000001\",\"ship_tcode\":\"16000001\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c17\\u767dml\",\"ship_cztype\":0,\"ship_czid\":\"995\",\"ship_czuser\":\"kangli\"}', '1');
INSERT INTO `fw_log` VALUES ('1671', '995', 'kangli', null, '企业子用户入库', '1538118871', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000109\",\"stor_date\":1538118871,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1672', '995', 'kangli', null, '企业子用户入库', '1538118898', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":7,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000110\",\"stor_date\":1538118898,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1673', '995', 'kangli', '9999', '删除入库记录', '1538118980', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/336', '{\"stor_id\":\"336\",\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":\"7\",\"stor_whid\":\"2\",\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000110\",\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_date\":\"1538118898\",\"stor_remark\":\"\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1674', '995', 'kangli', '9999', '处理提现', '1538120698', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"1\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"20000.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"994aXajhjlGPfUVW2lEkfIl28lEB513cuioU\\/foYXb2FUFmTeA\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1510908576\",\"rc_dealtime\":\"1535095974\",\"rc_state\":\"2\",\"rc_verify\":\"db514cd9798c0b599b69a59b2120b73a\",\"rc_remark\":\"\\u8986\\u76d6\\u800c\",\"rc_remark2\":\"\",\"rc_ip\":\"127.0.0.1\",\"rc_pic\":\"3052\\/5a0d51b432af0468.jpeg\"}', '1');
INSERT INTO `fw_log` VALUES ('1675', '995', 'kangli', '9999', '企业登录', '1538183662', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1676', '995', 'kangli', '9999', '删除出货记录', '1538186047', '0.0.0.0', '/Kangli/Mp/Shipment/delete/ship_id/66', '{\"ship_id\":\"66\",\"ship_unitcode\":\"9999\",\"ship_number\":\"201809281511066311\",\"ship_deliver\":\"0\",\"ship_dealer\":\"32\",\"ship_pro\":\"7\",\"ship_odid\":\"131\",\"ship_odblid\":null,\"ship_oddtid\":\"152\",\"ship_whid\":\"2\",\"ship_proqty\":\"10\",\"ship_barcode\":\"1600000108\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"16000001\",\"ship_date\":\"1538118769\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c17\\u767dml\",\"ship_cztype\":\"0\",\"ship_czid\":\"995\",\"ship_czuser\":\"kangli\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1677', '995', 'kangli', '9999', '删除入库记录', '1538196837', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/334', '{\"stor_id\":\"334\",\"stor_unitcode\":\"9999\",\"stor_number\":\"1600000103\",\"stor_pro\":\"7\",\"stor_whid\":\"2\",\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000108\",\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_date\":\"1538118691\",\"stor_remark\":\"\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"58\",\"stor_color\":\"\\u767d\",\"stor_size\":\"ml\"}', '1');
INSERT INTO `fw_log` VALUES ('1678', '995', 'kangli', '9999', '删除入库记录', '1538196843', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/335', '{\"stor_id\":\"335\",\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":\"7\",\"stor_whid\":\"2\",\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000109\",\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_date\":\"1538118871\",\"stor_remark\":\"\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1679', '32', 'test99', '9999', '经销商账号登录', '1538203392', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1680', '56', '15875872797', '9999', '经销商账号登录', '1538203506', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1681', '32', 'test99', '9999', '经销商账号登录', '1538203573', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1682', '61', '15875872712', '9999', '经销商账号登录', '1538203684', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1683', '32', 'test99', '9999', '经销商账号登录', '1538203766', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1684', '995', 'kangli', '9999', '添加子用户', '1538214429', '0.0.0.0', '/Kangli/Mp/Subuser/subuseradd_save', '{\"su_purview\":\"\",\"su_unitcode\":\"9999\",\"su_username\":\"zqzq\",\"su_pwd\":\"c56d0e9a7ccec67b4ea131655038d604\",\"su_name\":\"\\u949f\\u742a\",\"su_belong\":0,\"su_logintime\":0,\"su_status\":1}', '1');
INSERT INTO `fw_log` VALUES ('1685', '995', 'kangli', '9999', '企业登录', '1538270186', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1686', '32', 'test99', '9999', '经销商账号登录', '1538285932', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1687', '995', 'kangli', '9999', '企业登录', '1538961866', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1688', '32', 'test99', '9999', '经销商账号登录', '1538965285', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1689', '995', 'kangli', '9999', '企业登录', '1539413736', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1690', '32', 'test99', '9999', '经销商账号登录', '1539841366', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1691', '32', 'test99', '9999', '经销商账号登录', '1539855519', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1692', '995', 'test', '9999', '企业登录', '1540542787', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1693', '995', 'test', '9999', '手动增加余额：10000', '1540542855', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":0,\"bl_receiveid\":68,\"bl_money\":\"10000\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1540542855,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1694', '995', 'test', '9999', '手动增加预付款：20000', '1540542868', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":0,\"yfk_receiveid\":68,\"yfk_money\":\"20000\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1540542868,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1695', '995', 'test', '9999', '手动增加预付款：20000', '1540542911', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":0,\"yfk_receiveid\":49,\"yfk_money\":\"20000\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1540542911,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1696', '32', 'test', '9999', '经销商账号登录', '1540543263', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1697', '995', 'test', '9999', '企业登录', '1540544728', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1698', '32', 'test', '9999', '经销商账号登录', '1540545119', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1699', '32', 'test', '9999', '经销商账号登录', '1540603175', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1700', '995', 'test', '9999', '企业登录', '1540603449', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1701', '995', 'test', '9999', '修改产品价格体系', '1540606472', '0.0.0.0', '/Kangli/Mp/Product/propriceedit_save', '[{\"dlt_id\":\"7\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u603b\\u4ee3\",\"dlt_level\":\"1\",\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":\"6900.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"100\",\"pro_id\":\"12\"},{\"dlt_id\":\"8\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u7701\\u4ee3\",\"dlt_level\":\"2\",\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"2000.00\",\"priprice\":\"200\",\"pro_id\":\"12\"},{\"dlt_id\":\"9\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u5e02\\u4ee3\",\"dlt_level\":\"3\",\"dlt_fanli1\":\"1500.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"500.00\",\"priprice\":\"300\",\"pro_id\":\"12\"},{\"dlt_id\":\"10\",\"dlt_unitcode\":\"9999\",\"dlt_name\":\"\\u53bf\\u7ea7\",\"dlt_level\":\"4\",\"dlt_fanli1\":\"900.00\",\"dlt_fanli2\":\"500.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":\"0\",\"dlt_butie\":\"0.00\",\"priprice\":\"400\",\"pro_id\":\"12\"}]', '1');
INSERT INTO `fw_log` VALUES ('1702', '995', 'test', '9999', '企业登录', '1540610683', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1703', '995', 'test', '9999', '处理提现', '1540610709', '0.0.0.0', '/Kangli/Mp/Fanli/recashdeal_save', '{\"rc_id\":\"1\",\"rc_unitcode\":\"9999\",\"rc_dlid\":\"32\",\"rc_sdlid\":\"0\",\"rc_money\":\"20000.00\",\"rc_bank\":\"1\",\"rc_bankcard\":\"994aXajhjlGPfUVW2lEkfIl28lEB513cuioU\\/foYXb2FUFmTeA\",\"rc_name\":\"\\u674e\\u751f\",\"rc_addtime\":\"1510908576\",\"rc_dealtime\":\"1535095974\",\"rc_state\":\"1\",\"rc_verify\":\"db514cd9798c0b599b69a59b2120b73a\",\"rc_remark\":\"\\u8986\\u76d6\\u800c\",\"rc_remark2\":\"\",\"rc_ip\":\"127.0.0.1\",\"rc_pic\":\"3052\\/5a0d51b432af0468.jpeg\"}', '1');
INSERT INTO `fw_log` VALUES ('1704', '995', 'test', '9999', '企业登录', '1540610853', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1705', '995', 'test', '9999', '企业登录', '1540610960', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1706', '995', 'test', '9999', '手动增减积分', '1540622312', '0.0.0.0', '/Kangli/Mp/Dljf/changedjf_save', '{\"dljf_unitcode\":\"9999\",\"dljf_dlid\":\"68\",\"dljf_username\":\"15875872805\",\"dljf_type\":2,\"dljf_jf\":100,\"dljf_addtime\":1540622312,\"dljf_ip\":\"0.0.0.0\",\"dljf_actionuser\":\"test\",\"dljf_odid\":0,\"dljf_orderid\":\"\",\"dljf_odblid\":0,\"dljf_proid\":0,\"dljf_qty\":0,\"dljf_remark\":\"dfgdf\"}', '1');
INSERT INTO `fw_log` VALUES ('1707', '995', 'test', '9999', '手动增减积分', '1540622343', '0.0.0.0', '/Kangli/Mp/Dljf/changedjf_save', '{\"dljf_unitcode\":\"9999\",\"dljf_dlid\":\"68\",\"dljf_username\":\"15875872805\",\"dljf_type\":2,\"dljf_jf\":120,\"dljf_addtime\":1540622343,\"dljf_ip\":\"0.0.0.0\",\"dljf_actionuser\":\"test\",\"dljf_odid\":0,\"dljf_orderid\":\"\",\"dljf_odblid\":0,\"dljf_proid\":0,\"dljf_qty\":0,\"dljf_remark\":\"yhj\"}', '1');
INSERT INTO `fw_log` VALUES ('1708', '995', 'test', '9999', '手动增减积分', '1540622554', '0.0.0.0', '/Kangli/Mp/Dljf/changedjf_save', '{\"dljf_unitcode\":\"9999\",\"dljf_dlid\":\"67\",\"dljf_username\":\"15875872804\",\"dljf_type\":2,\"dljf_jf\":40,\"dljf_addtime\":1540622554,\"dljf_ip\":\"0.0.0.0\",\"dljf_actionuser\":\"test\",\"dljf_odid\":0,\"dljf_orderid\":\"\",\"dljf_odblid\":0,\"dljf_proid\":0,\"dljf_qty\":0,\"dljf_remark\":\"setyety\"}', '1');
INSERT INTO `fw_log` VALUES ('1709', '995', 'test', '9999', '手动增减积分', '1540622592', '0.0.0.0', '/Kangli/Mp/Dljf/changedjf_save', '{\"dljf_unitcode\":\"9999\",\"dljf_dlid\":\"66\",\"dljf_username\":\"15875872803\",\"dljf_type\":2,\"dljf_jf\":60,\"dljf_addtime\":1540622592,\"dljf_ip\":\"0.0.0.0\",\"dljf_actionuser\":\"test\",\"dljf_odid\":0,\"dljf_orderid\":\"\",\"dljf_odblid\":0,\"dljf_proid\":0,\"dljf_qty\":0,\"dljf_remark\":\"gfhjf\"}', '1');
INSERT INTO `fw_log` VALUES ('1710', '995', 'test', '9999', '企业登录', '1540631510', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1711', '995', 'test', '9999', '修改产品', '1540631625', '0.0.0.0', '/Kangli/Mp/Product/edit_save', '{\"pro_id\":7,\"pro_name\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c17\",\"pro_number\":\"N00012\",\"pro_order\":0,\"pro_typeid\":3,\"pro_jftype\":1,\"pro_jifen\":0,\"pro_jfmax\":0,\"pro_dljf\":0,\"pro_desc\":\"\\u4f4e\\u70ed\\u91cf\",\"pro_link\":\"\",\"pro_barcode\":\"\",\"pro_remark\":\"\",\"pro_price\":\"556.00\",\"pro_stock\":0,\"pro_units\":\"\\u7bb1\",\"pro_dbiao\":0,\"pro_zbiao\":0,\"pro_xbiao\":0,\"0\":\"\\u767d\",\"1\":\"ml\",\"2\":\"58\"}', '1');
INSERT INTO `fw_log` VALUES ('1712', '995', 'test', '9999', '企业登录', '1540631884', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1713', '995', 'test', '9999', '企业登录', '1540633508', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1714', '995', 'test', '9999', '企业登录', '1540775985', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1715', '995', 'test', null, '企业子用户入库', '1540778265', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"432355455\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":1,\"stor_barcode\":\"160000010101\",\"stor_date\":1540778265,\"stor_ucode\":\"16000001\",\"stor_tcode\":\"1600000101\",\"stor_remark\":\"ertyrty\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1716', '995', 'test', '9999', '删除入库记录', '1540778281', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/332', '{\"stor_id\":\"332\",\"stor_unitcode\":\"9999\",\"stor_number\":\"346456\",\"stor_pro\":\"5\",\"stor_whid\":\"2\",\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000106\",\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_date\":\"1538117871\",\"stor_remark\":\"\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1717', '995', 'test', '9999', '删除入库记录', '1540778287', '0.0.0.0', '/Kangli/Mp/Storage/delete/stor_id/331', '{\"stor_id\":\"331\",\"stor_unitcode\":\"9999\",\"stor_number\":\"41235345\",\"stor_pro\":\"12\",\"stor_whid\":\"2\",\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000105\",\"stor_ucode\":\"16000001\",\"stor_tcode\":\"16000001\",\"stor_date\":\"1538117820\",\"stor_remark\":\"\",\"stor_cztype\":\"1\",\"stor_czid\":\"995\",\"stor_czuser\":\"kangli\",\"stor_prodate\":\"0\",\"stor_batchnum\":\"0\",\"stor_isship\":\"0\",\"stor_attrid\":\"0\",\"stor_color\":\"0\",\"stor_size\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1718', '995', 'test', null, '企业子用户入库', '1540778414', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"54234\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000001\",\"stor_date\":1540778414,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"qwre\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1719', '995', 'test', null, '企业子用户入库', '1540780054', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"234524352\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000001\",\"stor_date\":1540780054,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"gdfgs\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1720', '995', 'test', null, '企业子用户入库', '1540780370', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"2352345\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000002\",\"stor_date\":1540780370,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"xcvx\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1721', '995', 'test', null, '企业子用户入库', '1540780490', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":\"10\",\"stor_barcode\":\"1600000204\",\"stor_date\":1540780490,\"stor_ucode\":\"16000002\",\"stor_tcode\":\"16000002\",\"stor_remark\":\"szdfg\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1722', '995', 'test', null, '企业子用户入库', '1540780534', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"21542514254\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000002\",\"stor_date\":1540780534,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"svd\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1723', '995', 'test', '9999', '删除出货记录', '1540781248', '0.0.0.0', '/Kangli/Mp/Shipment/delete/ship_id/65', '{\"ship_id\":\"65\",\"ship_unitcode\":\"9999\",\"ship_number\":\"201809281502546954\",\"ship_deliver\":\"0\",\"ship_dealer\":\"32\",\"ship_pro\":\"7\",\"ship_odid\":\"129\",\"ship_odblid\":null,\"ship_oddtid\":\"150\",\"ship_whid\":\"2\",\"ship_proqty\":\"10\",\"ship_barcode\":\"1600000107\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"16000001\",\"ship_date\":\"1538118461\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c17\\u767dml\",\"ship_cztype\":\"0\",\"ship_czid\":\"995\",\"ship_czuser\":\"kangli\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1724', '995', 'test', '9999', '删除出货记录', '1540781263', '0.0.0.0', '/Kangli/Mp/Shipment/delete/ship_id/64', '{\"ship_id\":\"64\",\"ship_unitcode\":\"9999\",\"ship_number\":\"201809281454069830\",\"ship_deliver\":\"0\",\"ship_dealer\":\"32\",\"ship_pro\":\"5\",\"ship_odid\":\"126\",\"ship_odblid\":null,\"ship_oddtid\":\"147\",\"ship_whid\":\"2\",\"ship_proqty\":\"10\",\"ship_barcode\":\"1600000104\",\"ship_ucode\":\"16000001\",\"ship_tcode\":\"16000001\",\"ship_date\":\"1538117683\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c15\",\"ship_cztype\":\"0\",\"ship_czid\":\"995\",\"ship_czuser\":\"kangli\",\"ship_prodate\":null,\"ship_batchnum\":null,\"ship_status\":\"0\"}', '1');
INSERT INTO `fw_log` VALUES ('1725', '32', 'test', '9999', '经销商账号登录', '1540781389', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1726', '995', 'test', '9999', '出货导入', '1540781584', '0.0.0.0', '/Kangli/Mp/Orders/odshipscanres_save', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201810291051335865\",\"ship_deliver\":0,\"ship_dealer\":\"32\",\"ship_pro\":\"5\",\"ship_odid\":141,\"ship_odblid\":null,\"ship_oddtid\":163,\"ship_whid\":2,\"ship_proqty\":100,\"ship_barcode\":\"16000002\",\"ship_date\":1540781584,\"ship_ucode\":\"\",\"ship_tcode\":\"\",\"ship_remark\":\"sdf\\u6d4b\\u8bd5\\u4ea7\\u54c15\",\"ship_cztype\":0,\"ship_czid\":\"995\",\"ship_czuser\":\"test\"}', '1');
INSERT INTO `fw_log` VALUES ('1727', '995', 'test', '9999', '添加经销商', '1540782043', '0.0.0.0', '/Kangli/Mp/Dealer/edit_save', '{\"dl_username\":\"z522402295\",\"dl_pwd\":\"66730c784751efc66db25382bd59bbbb\",\"dl_type\":8,\"dl_belong\":32,\"dl_level\":\"2\",\"dl_number\":\"No:0000043\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a\",\"dl_area\":\"\",\"dl_contact\":\"15875872791\",\"dl_tel\":\"15875872791\",\"dl_fax\":\"15875872791\",\"dl_address\":\"\\u5e7f\\u4e1c\\u7701\",\"dl_email\":\"522402295@qq.com\",\"dl_weixin\":\"15875872791\",\"dl_qq\":\"522402295\",\"dl_idcard\":\"440804199606160571\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_remark\":\"sdf\",\"dl_des\":\"\",\"dl_addtime\":1540782043,\"dl_status\":1,\"dl_openid\":\"\",\"dl_wxnickname\":\"\",\"dl_tblevel\":0,\"dl_referee\":0,\"dl_pic\":\"\",\"dl_idcardpic\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1728', '78', 'z522402295', '9999', '经销商账号登录', '1540782106', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1729', '32', 'test', '9999', '经销商账号登录', '1540782279', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1730', '78', 'z522402295', '9999', '经销商账号登录', '1540782420', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1731', '32', 'test', '9999', '经销商账号登录', '1540782448', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1732', '78', 'z522402295', '9999', '经销商账号登录', '1540782608', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1733', '32', 'test', '9999', '经销商账号登录', '1540782633', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1734', '32', 'test', '9999', '经销商出货', '1540782942', '0.0.0.0', '/Kangli/Kangli/Orders/odshipping/od_id/145/oddt_id/167/step/1', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201810291110263323\",\"ship_deliver\":\"32\",\"ship_dealer\":\"78\",\"ship_pro\":\"5\",\"ship_odid\":145,\"ship_oddtid\":167,\"ship_whid\":\"2\",\"ship_proqty\":\"10\",\"ship_barcode\":1600000204,\"ship_date\":1540782942,\"ship_ucode\":\"16000002\",\"ship_tcode\":\"16000002\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c15\",\"ship_cztype\":2,\"ship_czid\":\"32\",\"ship_czuser\":\"test\"}', '2');
INSERT INTO `fw_log` VALUES ('1735', '995', 'test', '9999', '添加子用户', '1540796430', '0.0.0.0', '/Kangli/Mp/Subuser/subuseradd_save', '{\"su_purview\":\"10000,10001,10002,10003,10004,10005,10008,10009,10010,90000,90001,90002,90003,90004,90005,20006,20007,13004,80003,80004\",\"su_unitcode\":\"9999\",\"su_username\":\"z522402294\",\"su_pwd\":\"66730c784751efc66db25382bd59bbbb\",\"su_name\":\"\\u949f\\u742a\",\"su_belong\":0,\"su_logintime\":0,\"su_status\":1}', '1');
INSERT INTO `fw_log` VALUES ('1736', '995', 'test', '9999', '删除子用户', '1540796443', '0.0.0.0', '/Kangli/Mp/Subuser/sudelete/su_id/4', '{\"su_id\":\"4\",\"su_unitcode\":\"9999\",\"su_username\":\"zqzq\",\"su_pwd\":\"c56d0e9a7ccec67b4ea131655038d604\",\"su_openid\":null,\"su_wxnickname\":null,\"su_wxsex\":\"0\",\"su_wxprovince\":null,\"su_wxcity\":null,\"su_wxcountry\":null,\"su_wxheadimg\":null,\"su_weixin\":null,\"su_name\":\"\\u949f\\u742a\",\"su_logintime\":\"0\",\"su_errlogintime\":null,\"su_errtimes\":null,\"su_remark\":null,\"su_status\":\"1\",\"su_belong\":\"0\",\"su_purview\":\"\"}', '1');
INSERT INTO `fw_log` VALUES ('1737', '995', 'test:z522402294', '9999', '企业子用户登录', '1540796512', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1738', '995', 'test', '9999', '企业登录', '1540797652', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1739', '995', 'test', '9999', '企业登录', '1540803065', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1740', '995', 'test', '9999', '企业登录', '1540862519', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1741', '995', 'test', null, '企业子用户入库', '1540867925', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"325235345\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000003\",\"stor_date\":1540867925,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1742', '32', 'test', '9999', '经销商账号登录', '1540868007', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1743', '995', 'test', '9999', '出货导入', '1540868143', '0.0.0.0', '/Kangli/Mp/Orders/odshipscanres_save', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201810301054497614\",\"ship_deliver\":0,\"ship_dealer\":\"32\",\"ship_pro\":\"5\",\"ship_odid\":147,\"ship_odblid\":null,\"ship_oddtid\":169,\"ship_whid\":2,\"ship_proqty\":100,\"ship_barcode\":\"16000003\",\"ship_date\":1540868143,\"ship_ucode\":\"\",\"ship_tcode\":\"\",\"ship_remark\":\"asdg\\u6d4b\\u8bd5\\u4ea7\\u54c15\",\"ship_cztype\":0,\"ship_czid\":\"995\",\"ship_czuser\":\"test\"}', '1');
INSERT INTO `fw_log` VALUES ('1744', '78', 'z522402295', '9999', '经销商账号登录', '1540868353', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1745', '43', '15875872792', '9999', '经销商账号登录', '1540868772', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1746', '995', 'test', '9999', '修改经销商级别', '1540868952', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u65d7\\u8230\\u5e97\",\"dlt_level\":1,\"dlt_fanli1\":\"10000.00\",\"dlt_fanli2\":\"7000.00\",\"dlt_fanli3\":\"6900.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1747', '995', 'test', '9999', '修改经销商级别', '1540868961', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u4f53\\u9a8c\\u5e97\",\"dlt_level\":2,\"dlt_fanli1\":\"6000.00\",\"dlt_fanli2\":\"2000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"2000.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1748', '995', 'test', '9999', '修改经销商级别', '1540868973', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u5de5\\u4f5c\\u5ba4\",\"dlt_level\":3,\"dlt_fanli1\":\"1500.00\",\"dlt_fanli2\":\"1000.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"500.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1749', '995', 'test', '9999', '修改经销商级别', '1540868983', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_name\":\"\\u5408\\u4f19\\u4eba\",\"dlt_level\":4,\"dlt_fanli1\":\"900.00\",\"dlt_fanli2\":\"500.00\",\"dlt_fanli3\":\"0.00\",\"dlt_fanli4\":\"0.00\",\"dlt_fanli5\":\"0.00\",\"dlt_fanli6\":\"0.00\",\"dlt_fanli7\":\"0.00\",\"dlt_fanli8\":\"0.00\",\"dlt_fanli9\":\"0.00\",\"dlt_fanli10\":\"0.00\",\"dlt_firstquota\":\"0.00\",\"dlt_minnum\":0,\"dlt_butie\":\"0.00\"}', '1');
INSERT INTO `fw_log` VALUES ('1750', '995', 'test', '9999', '添加经销商级别', '1540868995', '0.0.0.0', '/Kangli/Mp/Dealer/type_save', '{\"dlt_unitcode\":\"9999\",\"dlt_name\":\"vip\",\"dlt_level\":5,\"dlt_fanli1\":0,\"dlt_fanli2\":0,\"dlt_fanli3\":0,\"dlt_fanli4\":0,\"dlt_fanli5\":0,\"dlt_fanli6\":0,\"dlt_fanli7\":0,\"dlt_fanli8\":0,\"dlt_fanli9\":0,\"dlt_fanli10\":0,\"dlt_firstquota\":0,\"dlt_minnum\":0,\"dlt_butie\":0}', '1');
INSERT INTO `fw_log` VALUES ('1751', '78', 'z522402295', '9999', '经销商账号登录', '1540869054', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1752', '32', 'test', '9999', '经销商账号登录', '1540869102', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1753', '995', 'test', null, '企业子用户入库', '1540869313', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"325455\",\"stor_pro\":12,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000005\",\"stor_date\":1540869313,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\\u9aa8\\u7070\\u7ea7\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1754', '995', 'test', null, '企业子用户入库', '1540869568', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"234524355\",\"stor_pro\":12,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000006\",\"stor_date\":1540869568,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\\u4f4e\\u529f\\u8017\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1755', '995', 'test', null, '企业子用户入库', '1540869869', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"546435\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000007\",\"stor_date\":1540869869,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1756', '995', 'test', '9999', '出货导入', '1540869953', '0.0.0.0', '/Kangli/Mp/Orders/odshipscanres_save', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201810301125337147\",\"ship_deliver\":0,\"ship_dealer\":\"32\",\"ship_pro\":\"5\",\"ship_odid\":153,\"ship_odblid\":null,\"ship_oddtid\":175,\"ship_whid\":2,\"ship_proqty\":100,\"ship_barcode\":\"16000007\",\"ship_date\":1540869953,\"ship_ucode\":\"\",\"ship_tcode\":\"\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c15\",\"ship_cztype\":0,\"ship_czid\":\"995\",\"ship_czuser\":\"test\"}', '1');
INSERT INTO `fw_log` VALUES ('1757', '995', 'test', null, '企业子用户入库', '1540870334', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"345645\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000008\",\"stor_date\":1540870334,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1758', '995', 'test', '9999', '出货导入', '1540870403', '0.0.0.0', '/Kangli/Mp/Orders/odshipscanres_save', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201810301127599934\",\"ship_deliver\":0,\"ship_dealer\":\"78\",\"ship_pro\":\"5\",\"ship_odid\":155,\"ship_odblid\":null,\"ship_oddtid\":177,\"ship_whid\":2,\"ship_proqty\":100,\"ship_barcode\":\"16000008\",\"ship_date\":1540870403,\"ship_ucode\":\"\",\"ship_tcode\":\"\",\"ship_remark\":\"\\u6d4b\\u8bd5\\u4ea7\\u54c15\",\"ship_cztype\":0,\"ship_czid\":\"995\",\"ship_czuser\":\"test\"}', '1');
INSERT INTO `fw_log` VALUES ('1759', '995', 'test', null, '企业子用户入库', '1540884242', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"111111\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000009\",\"stor_date\":1540884242,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1760', '32', 'test', '9999', '经销商账号登录', '1540884265', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1761', '995', 'test', '9999', '出货扫描', '1540885328', '0.0.0.0', '/Kangli/Mp/Shipment/add_save', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201810301525106842\",\"ship_deliver\":0,\"ship_dealer\":32,\"ship_pro\":5,\"ship_whid\":2,\"ship_proqty\":100,\"ship_barcode\":\"16000009\",\"ship_date\":1540828800,\"ship_ucode\":\"\",\"ship_tcode\":\"\",\"ship_remark\":\"\\u7684\\u975e\\u5b98\\u65b9\\u7684\",\"ship_cztype\":0,\"ship_czid\":\"995\",\"ship_czuser\":\"test\"}', '1');
INSERT INTO `fw_log` VALUES ('1762', '995', 'test', null, '企业子用户入库', '1540885449', '0.0.0.0', '/Kangli/Mp/Storage/add_save', '{\"stor_unitcode\":\"9999\",\"stor_number\":\"32545255\",\"stor_pro\":5,\"stor_attrid\":0,\"stor_color\":0,\"stor_size\":0,\"stor_whid\":2,\"stor_proqty\":100,\"stor_barcode\":\"16000010\",\"stor_date\":1540885449,\"stor_ucode\":\"\",\"stor_tcode\":\"\",\"stor_remark\":\"\",\"stor_cztype\":1,\"stor_czid\":\"995\",\"stor_czuser\":\"test\",\"stor_prodate\":0,\"stor_batchnum\":0,\"stor_isship\":0}', '1');
INSERT INTO `fw_log` VALUES ('1763', '995', 'test', '9999', '出货扫描', '1540885466', '0.0.0.0', '/Kangli/Mp/Shipment/add_save', '{\"ship_unitcode\":\"9999\",\"ship_number\":\"201810301543135387\",\"ship_deliver\":0,\"ship_dealer\":32,\"ship_pro\":5,\"ship_whid\":2,\"ship_proqty\":100,\"ship_barcode\":\"16000010\",\"ship_date\":1540828800,\"ship_ucode\":\"\",\"ship_tcode\":\"\",\"ship_remark\":\"\",\"ship_cztype\":0,\"ship_czid\":\"995\",\"ship_czuser\":\"test\"}', '1');
INSERT INTO `fw_log` VALUES ('1764', '995', 'test', '9999', '企业登录', '1540949762', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1765', '32', 'test', '9999', '经销商账号登录', '1540949805', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1766', '32', 'test', '9999', '经销商账号登录', '1540950333', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1767', '79', '15875872791', '9999', '代理商注册', '1540950475', '0.0.0.0', '/Kangli/Kangli/Dealer/apply', '{\"dl_username\":\"15875872791\",\"dl_pwd\":\"587ccacd43c51cad35df059b107a9577\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a1\",\"dl_contact\":\"\\u949f\\u742a1\",\"dl_tel\":\"15875872791\",\"dl_idcard\":\"440804199606160571\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1540950475,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":32,\"dl_remark\":\"\",\"dl_address\":\"\\u5e7f\\u4e1c\\u5e7f\\u5dde\\u8354\\u6e7e\\u533a\",\"dl_sheng\":\"44\",\"dl_shi\":\"4401\",\"dl_qu\":\"440103\",\"dl_qustr\":\"\\u5e7f\\u4e1c \\u5e7f\\u5dde \\u8354\\u6e7e\\u533a\",\"dl_openid\":\"\",\"dl_weixin\":\"15875872791\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"b3d4RCuRO70KhvZpb8Nr4u9qVUpCiJ0lW4wpnuM4oBOIMdQ1jqZujEvvuA\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1768', '78', 'z522402295', '9999', '经销商账号登录', '1540950573', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1769', '80', '15875872792', '9999', '代理商注册', '1540950647', '0.0.0.0', '/Kangli/Kangli/Dealer/apply', '{\"dl_username\":\"15875872792\",\"dl_pwd\":\"1bde2478115e4e64b4f71e030dc33710\",\"dl_number\":\"\",\"dl_unitcode\":\"9999\",\"dl_name\":\"\\u949f\\u742a2\",\"dl_contact\":\"\\u949f\\u742a2\",\"dl_tel\":\"15875872792\",\"dl_idcard\":\"440804199606160572\",\"dl_idcardpic\":\"\",\"dl_idcardpic2\":\"\",\"dl_tbdian\":\"\",\"dl_tbzhanggui\":\"\",\"dl_addtime\":1540950647,\"dl_status\":0,\"dl_level\":\"1\",\"dl_type\":7,\"dl_sttype\":0,\"dl_belong\":0,\"dl_referee\":78,\"dl_remark\":\"\",\"dl_address\":\"\\u5e7f\\u4e1c\\u5e7f\\u5dde\\u8354\\u6e7e\\u533a\",\"dl_sheng\":\"44\",\"dl_shi\":\"4401\",\"dl_qu\":\"440103\",\"dl_qustr\":\"\\u5e7f\\u4e1c \\u5e7f\\u5dde \\u8354\\u6e7e\\u533a\",\"dl_openid\":\"\",\"dl_weixin\":\"15875872792\",\"dl_wxnickname\":\"\",\"dl_wxsex\":0,\"dl_wxprovince\":\"\",\"dl_wxcity\":\"\",\"dl_wxcountry\":\"\",\"dl_wxheadimg\":\"\",\"dl_brand\":\"\",\"dl_brandlevel\":\"\",\"dl_bank\":\"1\",\"dl_bankcard\":\"855fe2zbD\\/+UOTNkVM3Hbhy9ae88+oGBvye5i5eHhOivOvCWhV4vKzd\\/yJE7Im8\",\"dl_stockpic\":\"\"}', '2');
INSERT INTO `fw_log` VALUES ('1770', '995', 'test', '9999', '企业登录', '1541035159', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1771', '995', 'test', '9999', '企业登录', '1541123067', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1772', '995', 'test', '9999', '手动增加预付款：1000', '1541123145', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":0,\"yfk_receiveid\":32,\"yfk_money\":\"1000\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1541123145,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1773', '995', 'test', '9999', '手动增加余额：999', '1541123161', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":0,\"bl_receiveid\":32,\"bl_money\":\"999\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1541123161,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1774', '995', 'test', '9999', '企业登录', '1541130702', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1775', '995', 'test', '9999', '企业登录', '1541145028', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1776', '995', 'test', '9999', '手动增加预付款：65', '1541145056', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":0,\"yfk_receiveid\":32,\"yfk_money\":\"65\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1541145056,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1777', '995', 'test', '9999', '手动增加预付款：66', '1541145065', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":0,\"yfk_receiveid\":32,\"yfk_money\":\"66\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1541145065,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1778', '995', 'test', '9999', '手动增加余额：569', '1541145074', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":0,\"bl_receiveid\":32,\"bl_money\":\"569\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1541145074,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1779', '995', 'test', '9999', '手动减少余额：63', '1541145082', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":32,\"bl_receiveid\":0,\"bl_money\":\"63\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1541145082,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1780', '995', 'test', '9999', '手动减少余额：5', '1541145091', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":32,\"bl_receiveid\":0,\"bl_money\":\"5\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1541145091,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1781', '995', 'test', '9999', '手动增加预付款：1000', '1541145172', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":0,\"yfk_receiveid\":79,\"yfk_money\":\"1000\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1541145172,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1782', '995', 'test', '9999', '手动增加预付款：800', '1541145182', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":0,\"yfk_receiveid\":79,\"yfk_money\":\"800\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1541145182,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1783', '995', 'test', '9999', '手动减少预付款：20', '1541145192', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":79,\"yfk_receiveid\":0,\"yfk_money\":\"20\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1541145192,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1784', '995', 'test', '9999', '手动增加余额：6000', '1541145204', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":0,\"bl_receiveid\":79,\"bl_money\":\"6000\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1541145204,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1785', '995', 'test', '9999', '手动增加余额：3000', '1541145215', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":0,\"bl_receiveid\":79,\"bl_money\":\"3000\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1541145215,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1786', '995', 'test', '9999', '手动减少余额：2000', '1541145223', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":79,\"bl_receiveid\":0,\"bl_money\":\"2000\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1541145223,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1787', '995', 'test', '9999', '企业登录', '1541145917', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1788', '78', '15875872790', '9999', '经销商账号登录', '1541146410', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1789', '995', 'test', '9999', '企业登录', '1541207577', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1790', '995', 'test', '9999', '企业登录', '1541207586', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1791', '995', 'test', '9999', '手动增加预付款：100', '1541208698', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":0,\"yfk_receiveid\":80,\"yfk_money\":\"100\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1541208698,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1792', '995', 'test', '9999', '手动减少预付款：20', '1541208707', '0.0.0.0', '/Kangli/Mp/Capital/yufukuanadd_save', '{\"yfk_unitcode\":\"9999\",\"yfk_type\":1,\"yfk_sendid\":80,\"yfk_receiveid\":0,\"yfk_money\":\"20\",\"yfk_refedlid\":0,\"yfk_oddlid\":0,\"yfk_odid\":0,\"yfk_orderid\":\"\",\"yfk_odblid\":0,\"yfk_qty\":0,\"yfk_level\":0,\"yfk_addtime\":1541208707,\"yfk_remark\":\"test\",\"yfk_state\":1}', '1');
INSERT INTO `fw_log` VALUES ('1793', '995', 'test', '9999', '手动增加余额：200', '1541208717', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":0,\"bl_receiveid\":80,\"bl_money\":\"200\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1541208717,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1794', '995', 'test', '9999', '手动减少余额：10', '1541208728', '0.0.0.0', '/Kangli/Mp/Capital/yueadd_save', '{\"bl_unitcode\":\"9999\",\"bl_type\":1,\"bl_sendid\":80,\"bl_receiveid\":0,\"bl_money\":\"10\",\"bl_odid\":0,\"bl_orderid\":\"\",\"bl_odblid\":0,\"bl_addtime\":1541208728,\"bl_remark\":\"test\",\"bl_state\":1,\"bl_rcid\":0}', '1');
INSERT INTO `fw_log` VALUES ('1795', '32', 'test', '9999', '经销商账号登录', '1541232833', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1796', '995', 'test', '9999', '企业登录', '1541380274', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1797', '32', 'test', '9999', '经销商账号登录', '1541403882', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1798', '32', 'test', '9999', '经销商账号登录', '1541408834', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1799', '995', 'test', '9999', '企业登录', '1541408874', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1800', '78', '15875872790', '9999', '经销商账号登录', '1541408978', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1801', '32', 'test', '9999', '经销商账号登录', '1541409052', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1802', '995', 'test', '9999', '企业登录', '1541467253', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1803', '32', 'test', '9999', '经销商账号登录', '1541503263', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1804', '995', 'test', '9999', '企业登录', '1541554549', '0.0.0.0', '/Kangli/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1805', '32', 'test', '9999', '经销商账号登录', '1541557218', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1806', '32', 'test', '9999', '经销商账号登录', '1541557821', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1807', '32', 'test', '9999', '经销商账号登录', '1541573472', '0.0.0.0', '/Kangli/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1808', '32', 'test', '9999', '经销商账号登录', '1541641470', '127.0.0.1', '/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1809', '995', 'test', '9999', '企业登录', '1541641542', '127.0.0.1', '/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1810', '32', 'test', '9999', '经销商账号登录', '1541649962', '127.0.0.1', '/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1811', '32', 'test', '9999', '经销商账号登录', '1542161377', '127.0.0.1', '/Kangli/Dealer/login', '', '2');
INSERT INTO `fw_log` VALUES ('1812', '995', 'test', '9999', '企业登录', '1542431294', '127.0.0.1', '/Mp/Login/logining', '', '1');
INSERT INTO `fw_log` VALUES ('1813', '32', 'test', '9999', '经销商账号登录', '1542594204', '127.0.0.1', '/Kangli/Dealer/login', '', '2');

-- ----------------------------
-- Table structure for fw_orderbelong
-- ----------------------------
DROP TABLE IF EXISTS `fw_orderbelong`;
CREATE TABLE `fw_orderbelong` (
  `odbl_id` int(11) NOT NULL AUTO_INCREMENT,
  `odbl_unitcode` varchar(32) DEFAULT NULL,
  `odbl_odid` int(11) DEFAULT '0' COMMENT '对应订单id',
  `odbl_orderid` varchar(32) DEFAULT NULL,
  `odbl_total` decimal(10,2) DEFAULT '0.00' COMMENT '转上家的订单金额',
  `odbl_oddlid` int(11) DEFAULT '0' COMMENT '下单代理id',
  `odbl_rcdlid` int(11) DEFAULT '0' COMMENT '接单代理id',
  `odbl_paypic` varchar(32) DEFAULT NULL COMMENT '凭证图片',
  `odbl_remark` varchar(512) DEFAULT NULL COMMENT '备注',
  `odbl_addtime` int(11) DEFAULT '0' COMMENT '下单时间',
  `odbl_belongship` int(11) DEFAULT '0' COMMENT '是否转上家',
  `odbl_state` int(11) DEFAULT '0' COMMENT '订单状态',
  PRIMARY KEY (`odbl_id`),
  KEY `odbl_odid` (`odbl_odid`),
  KEY `odbl_oddlid` (`odbl_oddlid`),
  KEY `odbl_unitcode` (`odbl_unitcode`,`odbl_odid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='订单关系表';

-- ----------------------------
-- Records of fw_orderbelong
-- ----------------------------

-- ----------------------------
-- Table structure for fw_orderdetail
-- ----------------------------
DROP TABLE IF EXISTS `fw_orderdetail`;
CREATE TABLE `fw_orderdetail` (
  `oddt_id` int(11) NOT NULL AUTO_INCREMENT,
  `oddt_unitcode` varchar(32) DEFAULT NULL,
  `oddt_odid` int(11) DEFAULT '0' COMMENT '对应订单id',
  `oddt_orderid` varchar(32) DEFAULT NULL,
  `oddt_odblid` int(11) DEFAULT '0' COMMENT '订单关系的id',
  `oddt_proid` int(11) DEFAULT '0' COMMENT '产品id',
  `oddt_proname` varchar(64) DEFAULT NULL COMMENT '产品名称',
  `oddt_pronumber` varchar(32) DEFAULT NULL COMMENT '产品编号',
  `oddt_prounits` varchar(32) DEFAULT NULL COMMENT '产品单位',
  `oddt_prodbiao` int(11) DEFAULT '0' COMMENT '产品包装比例大标',
  `oddt_prozbiao` int(11) DEFAULT '0' COMMENT '产品包装比例中标',
  `oddt_proxbiao` int(11) DEFAULT '0' COMMENT '产品包装比例小标',
  `oddt_price` decimal(10,2) DEFAULT '0.00' COMMENT '原零售价格',
  `oddt_dlprice` decimal(10,2) DEFAULT '0.00' COMMENT '成交价格',
  `oddt_qty` int(11) DEFAULT '0' COMMENT '下单数量',
  `oddt_attrid` int(11) DEFAULT '0',
  `oddt_color` varchar(16) DEFAULT NULL,
  `oddt_size` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`oddt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=182 DEFAULT CHARSET=utf8 COMMENT='订单详细表';

-- ----------------------------
-- Records of fw_orderdetail
-- ----------------------------
INSERT INTO `fw_orderdetail` VALUES ('172', '9999', '150', '201810301119505681', '0', '12', '测试产品12', 'N00012', '盒', '0', '0', '0', '1000.00', '100.00', '100', '60', '白', 'm');
INSERT INTO `fw_orderdetail` VALUES ('173', '9999', '151', '201810301122324098', '0', '12', '测试产品12', 'N00012', '盒', '0', '0', '0', '1000.00', '100.00', '99', '60', '白', 'm');
INSERT INTO `fw_orderdetail` VALUES ('174', '9999', '152', '201810301125045593', '0', '5', '测试产品5', 'N0001', '箱', '0', '0', '0', '556.00', '239.00', '200', '0', '', '');
INSERT INTO `fw_orderdetail` VALUES ('175', '9999', '153', '201810301125337147', '0', '5', '测试产品5', 'N0001', '箱', '0', '0', '0', '556.00', '239.00', '100', '0', '', '');
INSERT INTO `fw_orderdetail` VALUES ('176', '9999', '154', '201810301127262407', '0', '5', '测试产品5', 'N0001', '箱', '0', '0', '0', '556.00', '239.00', '99', '0', '', '');
INSERT INTO `fw_orderdetail` VALUES ('177', '9999', '155', '201810301127599934', '0', '5', '测试产品5', 'N0001', '箱', '0', '0', '0', '556.00', '239.00', '100', '0', '', '');
INSERT INTO `fw_orderdetail` VALUES ('178', '9999', '156', '201810301524402705', '0', '5', '测试产品5', 'N0001', '箱', '0', '0', '0', '556.00', '239.00', '10000', '0', '', '');
INSERT INTO `fw_orderdetail` VALUES ('179', '9999', '157', '201810301525106842', '0', '5', '测试产品5', 'N0001', '箱', '0', '0', '0', '556.00', '239.00', '100', '0', '', '');
INSERT INTO `fw_orderdetail` VALUES ('180', '9999', '158', '201810301543135387', '0', '5', '测试产品5', 'N0001', '箱', '0', '0', '0', '556.00', '239.00', '100', '0', '', '');
INSERT INTO `fw_orderdetail` VALUES ('181', '9999', '159', '201811051709576810', '0', '5', '测试产品5', 'N0001', '箱', '0', '0', '0', '556.00', '239.00', '100', '0', '', '');

-- ----------------------------
-- Table structure for fw_orderlogs
-- ----------------------------
DROP TABLE IF EXISTS `fw_orderlogs`;
CREATE TABLE `fw_orderlogs` (
  `odlg_id` int(11) NOT NULL AUTO_INCREMENT,
  `odlg_unitcode` varchar(32) DEFAULT NULL,
  `odlg_odid` int(11) DEFAULT '0' COMMENT '对应订单id',
  `odlg_orderid` varchar(32) DEFAULT NULL COMMENT '对应订单号',
  `odlg_type` int(11) DEFAULT '0' COMMENT '0-公司操作 1-代理操作',
  `odlg_dlid` int(11) DEFAULT NULL COMMENT '操作id',
  `odlg_dlusername` varchar(32) DEFAULT NULL COMMENT '操作用户名',
  `odlg_dlname` varchar(32) DEFAULT NULL COMMENT '操作人',
  `odlg_action` varchar(64) DEFAULT NULL COMMENT '动作',
  `odlg_addtime` int(11) DEFAULT '0' COMMENT '操作时间',
  `odlg_link` varchar(256) DEFAULT NULL COMMENT '操作链接',
  `odlg_ip` varchar(32) DEFAULT NULL COMMENT '操作IP',
  PRIMARY KEY (`odlg_id`),
  KEY `odlg_unitcode` (`odlg_unitcode`)
) ENGINE=MyISAM AUTO_INCREMENT=387 DEFAULT CHARSET=utf8 COMMENT='订单操作日志';

-- ----------------------------
-- Records of fw_orderlogs
-- ----------------------------
INSERT INTO `fw_orderlogs` VALUES ('297', '9999', '123', '201809281435111878', '1', '32', 'test99', '李生', '创建订单', '1538116511', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('298', '9999', '123', '201809281435111878', '0', '995', 'kangli', 'kangli', '确认订单', '1538116526', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/123', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('299', '9999', '123', '201809281435111878', '0', '995', 'kangli', 'kangli', '完成订货', '1538116538', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('295', '9999', '122', '201809281137553051', '1', '32', 'test99', '李生', '创建订单', '1538105875', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('296', '9999', '122', '201809281137553051', '0', '995', 'kangli', 'kangli', '确认订单', '1538105886', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/122', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('300', '9999', '124', '201809281436082848', '1', '32', 'test99', '李生', '创建订单', '1538116568', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('301', '9999', '124', '201809281436082848', '0', '995', 'kangli', 'kangli', '确认订单', '1538116582', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/124', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('302', '9999', '125', '201809281452068679', '1', '32', 'test99', '李生', '创建订单', '1538117526', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('303', '9999', '125', '201809281452068679', '0', '995', 'kangli', 'kangli', '确认订单', '1538117536', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/125', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('304', '9999', '125', '201809281452068679', '0', '995', 'kangli', 'kangli', '完成订货', '1538117602', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('305', '9999', '126', '201809281454069830', '1', '32', 'test99', '李生', '创建订单', '1538117647', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('306', '9999', '126', '201809281454069830', '0', '995', 'kangli', 'kangli', '确认订单', '1538117659', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/126', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('307', '9999', '127', '201809281459575120', '1', '32', 'test99', '李生', '创建订单', '1538117997', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('308', '9999', '127', '201809281459575120', '0', '995', 'kangli', 'kangli', '确认订单', '1538118006', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/127', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('309', '9999', '127', '201809281459575120', '0', '995', 'kangli', 'kangli', '完成订货', '1538118017', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('310', '9999', '128', '201809281501333615', '1', '32', 'test99', '李生', '创建订单', '1538118093', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('311', '9999', '128', '201809281501333615', '0', '995', 'kangli', 'kangli', '确认订单', '1538118105', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/128', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('312', '9999', '128', '201809281501333615', '0', '995', 'kangli', 'kangli', '完成订货', '1538118116', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('313', '9999', '129', '201809281502546954', '1', '32', 'test99', '李生', '创建订单', '1538118174', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('314', '9999', '129', '201809281502546954', '0', '995', 'kangli', 'kangli', '确认订单', '1538118184', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/129', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('315', '9999', '130', '201809281509534793', '1', '32', 'test99', '李生', '创建订单', '1538118593', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('316', '9999', '130', '201809281509534793', '0', '995', 'kangli', 'kangli', '确认订单', '1538118604', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/130', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('317', '9999', '130', '201809281509534793', '0', '995', 'kangli', 'kangli', '完成订货', '1538118615', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('318', '9999', '131', '201809281511066311', '1', '32', 'test99', '李生', '创建订单', '1538118666', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('319', '9999', '131', '201809281511066311', '0', '995', 'kangli', 'kangli', '确认订单', '1538118709', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/131', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('320', '9999', '132', '201809291445389812', '1', '56', '15875872797', '钟琪5', '创建订单', '1538203538', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('321', '9999', '133', '201809291448272365', '1', '61', '15875872712', '钟琪8', '创建订单', '1538203707', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('322', '9999', '133', '201809291448272365', '1', '32', 'test99', '李生', '确认订单', '1538203784', '/Kangli/Kangli/Orders/canceldlorder/od_id/133/state/1/od_state/10', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('323', '9999', '134', '201809291453239843', '1', '61', '15875872712', '钟琪8', '创建订单', '1538204003', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('324', '9999', '135', '201809291454438622', '1', '61', '15875872712', '钟琪8', '创建订单', '1538204083', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('325', '9999', '134', '201809291453239843', '1', '32', 'test99', '李生', '确认订单', '1538204129', '/Kangli/Kangli/Orders/canceldlorder/od_id/134/state/1/od_state/10', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('326', '9999', '135', '201809291454438622', '1', '32', 'test99', '李生', '确认订单', '1538204139', '/Kangli/Kangli/Orders/canceldlorder/od_id/135/state/1/od_state/10', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('327', '9999', '131', '201809281511066311', '1', '32', 'test99', '李生', '确认收货', '1538204212', '/Kangli/Kangli/Orders/confirmreceipt/od_id/131/od_state/3/ly_status/1', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('328', '9999', '136', '201810261644004032', '1', '32', 'test', '李生', '创建订单', '1540543440', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('329', '9999', '136', '201810261644004032', '0', '995', 'test', 'test', '确认订单', '1540543454', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/136', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('330', '9999', '136', '201810261644004032', '0', '995', 'test', 'test', '完成订货', '1540543463', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('331', '9999', '137', '201810261644463052', '1', '32', 'test', '李生', '创建订单', '1540543486', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('332', '9999', '137', '201810261644463052', '0', '995', 'test', 'test', '确认订单', '1540543493', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/137', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('333', '9999', '138', '201810271014479154', '0', '995', 'test', 'test', '公司代订货(增减库存)', '1540606487', '/Kangli/Mp/Dlkucun/xnkcadd_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('334', '9999', '139', '201810271107459540', '1', '32', 'test', '李生', '创建订单', '1540609665', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('335', '9999', '139', '201810271107459540', '0', '995', 'test', 'test', '确认订单', '1540609694', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/139', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('336', '9999', '140', '201810291050151447', '1', '32', 'test', '李生', '创建订单', '1540781415', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('337', '9999', '140', '201810291050151447', '0', '995', 'test', 'test', '确认订单', '1540781434', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/140', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('338', '9999', '140', '201810291050151447', '0', '995', 'test', 'test', '完成订货', '1540781442', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('339', '9999', '141', '201810291051335865', '1', '32', 'test', '李生', '创建订单', '1540781493', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('340', '9999', '141', '201810291051335865', '0', '995', 'test', 'test', '确认订单', '1540781512', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/141', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('341', '9999', '142', '201810291103373518', '1', '78', 'z522402295', '钟琪', '创建订单', '1540782217', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('342', '9999', '142', '201810291103373518', '0', '995', 'test', 'test', '确认订单', '1540782228', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/142', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('343', '9999', '142', '201810291103373518', '0', '995', 'test', 'test', '完成订货', '1540782235', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('344', '9999', '143', '201810291104255150', '1', '78', 'z522402295', '钟琪', '创建订单', '1540782265', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('345', '9999', '143', '201810291104255150', '0', '995', 'test', 'test', '确认订单', '1540782372', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/143', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('346', '9999', '144', '201810291107198020', '1', '78', 'z522402295', '钟琪', '创建订单', '1540782439', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('347', '9999', '144', '201810291107198020', '1', '32', 'test', '李生', '确认订单', '1540782459', '/Kangli/Kangli/Orders/canceldlorder/od_id/144/state/1/od_state/10', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('348', '9999', '145', '201810291110263323', '1', '78', 'z522402295', '钟琪', '创建订单', '1540782626', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('349', '9999', '145', '201810291110263323', '1', '32', 'test', '李生', '确认订单', '1540782637', '/Kangli/Kangli/Orders/canceldlorder/od_id/145/state/1/od_state/10', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('350', '9999', '139', '201810271107459540', '0', '995', 'test', 'test', '取消订单', '1540783190', '/Kangli/Mp/Orders/cancelorder/state/9/od_id/139', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('351', '9999', '145', '201810291110263323', '1', '32', 'test', '李生', '完成发货', '1540783266', '/Kangli/Kangli/Orders/odfinishship', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('352', '9999', '146', '201810301053523752', '1', '32', 'test', '李生', '创建订单', '1540868032', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('353', '9999', '146', '201810301053523752', '0', '995', 'test', 'test', '确认订单', '1540868039', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/146', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('354', '9999', '146', '201810301053523752', '0', '995', 'test', 'test', '完成订货', '1540868047', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('355', '9999', '147', '201810301054497614', '1', '32', 'test', '李生', '创建订单', '1540868089', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('356', '9999', '147', '201810301054497614', '0', '995', 'test', 'test', '确认订单', '1540868124', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/147', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('357', '9999', '148', '201810301112048383', '1', '32', 'test', '李生', '创建订单', '1540869124', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('358', '9999', '148', '201810301112048383', '0', '995', 'test', 'test', '确认订单', '1540869163', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/148', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('359', '9999', '148', '201810301112048383', '0', '995', 'test', 'test', '完成订货', '1540869169', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('360', '9999', '149', '201810301115305220', '1', '32', 'test', '李生', '创建订单', '1540869330', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('361', '9999', '149', '201810301115305220', '0', '995', 'test', 'test', '确认订单', '1540869342', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/149', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('362', '9999', '149', '201810301115305220', '0', '995', 'test', 'test', '完成订货', '1540869347', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('363', '9999', '150', '201810301119505681', '1', '32', 'test', '李生', '创建订单', '1540869590', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('364', '9999', '150', '201810301119505681', '0', '995', 'test', 'test', '确认订单', '1540869610', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/150', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('365', '9999', '150', '201810301119505681', '0', '995', 'test', 'test', '完成订货', '1540869615', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('366', '9999', '151', '201810301122324098', '1', '32', 'test', '李生', '创建订单', '1540869752', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('367', '9999', '151', '201810301122324098', '0', '995', 'test', 'test', '确认订单', '1540869759', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/151', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('368', '9999', '152', '201810301125045593', '1', '32', 'test', '李生', '创建订单', '1540869904', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('369', '9999', '152', '201810301125045593', '0', '995', 'test', 'test', '确认订单', '1540869908', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/152', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('370', '9999', '152', '201810301125045593', '0', '995', 'test', 'test', '完成订货', '1540869915', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('371', '9999', '153', '201810301125337147', '1', '32', 'test', '李生', '创建订单', '1540869933', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('372', '9999', '153', '201810301125337147', '0', '995', 'test', 'test', '确认订单', '1540869937', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/153', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('373', '9999', '154', '201810301127262407', '1', '78', 'z522402295', '钟琪', '创建订单', '1540870046', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('374', '9999', '154', '201810301127262407', '0', '995', 'test', 'test', '确认订单', '1540870054', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/154', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('375', '9999', '154', '201810301127262407', '0', '995', 'test', 'test', '完成订货', '1540870059', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('376', '9999', '155', '201810301127599934', '1', '78', 'z522402295', '钟琪', '创建订单', '1540870079', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('377', '9999', '155', '201810301127599934', '0', '995', 'test', 'test', '确认订单', '1540870085', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/155', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('378', '9999', '156', '201810301524402705', '1', '32', 'test', '李生', '创建订单', '1540884281', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('379', '9999', '156', '201810301524402705', '0', '995', 'test', 'test', '确认订单', '1540884289', '/Kangli/Mp/Orders/xncancelorder/state/1/od_id/156', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('380', '9999', '156', '201810301524402705', '0', '995', 'test', 'test', '完成订货', '1540884295', '/Kangli/Mp/Orders/xnodfinishship_save', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('381', '9999', '157', '201810301525106842', '1', '32', 'test', '李生', '创建订单', '1540884310', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('382', '9999', '157', '201810301525106842', '0', '995', 'test', 'test', '确认订单', '1540884315', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/157', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('383', '9999', '158', '201810301543135387', '1', '32', 'test', '李生', '创建订单', '1540885393', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('384', '9999', '158', '201810301543135387', '0', '995', 'test', 'test', '确认订单', '1540885399', '/Kangli/Mp/Orders/cancelorder/state/1/od_id/158', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('385', '9999', '159', '201811051709576810', '1', '78', '15875872790', '钟琪', '创建订单', '1541408997', '/Kangli/Kangli/Orders/submitorders', '0.0.0.0');
INSERT INTO `fw_orderlogs` VALUES ('386', '9999', '159', '201811051709576810', '1', '32', 'test', '李生', '确认订单', '1541409059', '/Kangli/Kangli/Orders/canceldlorder/od_id/159/state/1/od_state/10', '0.0.0.0');

-- ----------------------------
-- Table structure for fw_orders
-- ----------------------------
DROP TABLE IF EXISTS `fw_orders`;
CREATE TABLE `fw_orders` (
  `od_id` int(11) NOT NULL AUTO_INCREMENT,
  `od_unitcode` varchar(32) DEFAULT NULL COMMENT '企业码',
  `od_orderid` varchar(32) DEFAULT NULL COMMENT '订单号',
  `od_total` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额',
  `od_addtime` int(11) DEFAULT '0' COMMENT '下单时间',
  `od_oddlid` int(11) DEFAULT '0' COMMENT '下单的代理',
  `od_rcdlid` int(11) NOT NULL DEFAULT '0' COMMENT '上级接单代理',
  `od_belongship` int(4) DEFAULT '0' COMMENT '是否转为上家',
  `od_paypic` varchar(64) NOT NULL COMMENT '支付凭证',
  `od_contact` varchar(32) DEFAULT NULL COMMENT '收件人',
  `od_addressid` int(11) DEFAULT '0' COMMENT '地址ID',
  `od_sheng` int(11) DEFAULT '0' COMMENT '省id',
  `od_shi` int(11) DEFAULT '0' COMMENT '市id',
  `od_qu` int(11) DEFAULT '0' COMMENT '区id',
  `od_jie` int(11) DEFAULT '0' COMMENT '街id',
  `od_address` varchar(64) DEFAULT NULL COMMENT '详细地址',
  `od_tel` varchar(32) DEFAULT NULL COMMENT '电话',
  `od_express` int(11) DEFAULT '0' COMMENT '快递id',
  `od_expressnum` varchar(64) DEFAULT NULL COMMENT '快递单号',
  `od_expressdate` int(11) DEFAULT '0' COMMENT '发货时间',
  `od_remark` varchar(512) DEFAULT NULL COMMENT '处理订单备注',
  `od_state` int(11) DEFAULT '0' COMMENT '订单状态',
  `od_stead` int(11) DEFAULT '0' COMMENT '是否代客户下单',
  `od_virtualstock` int(4) NOT NULL DEFAULT '0' COMMENT '是否虚拟库存',
  `od_fugou` int(4) NOT NULL DEFAULT '0' COMMENT '是否复购默认为1',
  `od_expressfee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递运费',
  `od_untotall` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额',
  PRIMARY KEY (`od_id`),
  KEY `od_unitcode` (`od_unitcode`),
  KEY `od_oddlid` (`od_oddlid`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of fw_orders
-- ----------------------------
INSERT INTO `fw_orders` VALUES ('150', '9999', '201810301119505681', '10000.00', '1540869590', '32', '0', '0', '', '周生', '52', '440000', '440100', '440104', '0', '广东省广州市越秀区越华路112 珠江国际大厦', '13999999998', '0', '', '0', '', '8', '0', '1', '1', '0.00', '0.00');
INSERT INTO `fw_orders` VALUES ('151', '9999', '201810301122324098', '9900.00', '1540869752', '32', '0', '0', '', '周生', '52', '440000', '440100', '440104', '0', '广东省广州市越秀区越华路112 珠江国际大厦', '13999999998', '0', '', '0', '', '1', '0', '0', '0', '0.00', '0.00');
INSERT INTO `fw_orders` VALUES ('152', '9999', '201810301125045593', '47800.00', '1540869904', '32', '0', '0', '', '周生', '52', '440000', '440100', '440104', '0', '广东省广州市越秀区越华路112 珠江国际大厦', '13999999998', '0', '', '0', '', '8', '0', '1', '1', '0.00', '0.00');
INSERT INTO `fw_orders` VALUES ('153', '9999', '201810301125337147', '23900.00', '1540869933', '32', '0', '0', '', '周生', '52', '440000', '440100', '440104', '0', '广东省广州市越秀区越华路112 珠江国际大厦', '13999999998', '17', '3545665567', '1540869963', '说的话', '3', '0', '0', '0', '0.00', '0.00');
INSERT INTO `fw_orders` VALUES ('154', '9999', '201810301127262407', '23661.00', '1540870046', '78', '32', '0', '', '钟琪', '77', '44', '4401', '440103', '0', '广东广州荔湾区', '15875872797', '0', '', '0', '', '8', '0', '1', '1', '0.00', '0.00');
INSERT INTO `fw_orders` VALUES ('155', '9999', '201810301127599934', '23422.00', '1540870079', '78', '0', '0', '', '钟琪', '77', '44', '4401', '440103', '0', '广东广州荔湾区', '15875872797', '17', '3524524', '1540870421', '', '3', '0', '0', '0', '0.00', '0.00');
INSERT INTO `fw_orders` VALUES ('156', '9999', '201810301524402705', '2390000.00', '1540884280', '32', '0', '0', '', '周生', '52', '440000', '440100', '440104', '0', '广东省广州市越秀区越华路112 珠江国际大厦', '13999999998', '0', '', '0', '', '8', '0', '1', '1', '0.00', '0.00');
INSERT INTO `fw_orders` VALUES ('157', '9999', '201810301525106842', '23900.00', '1540884310', '32', '0', '0', '', '周生', '52', '440000', '440100', '440104', '0', '广东省广州市越秀区越华路112 珠江国际大厦', '13999999998', '0', '', '0', '', '1', '0', '0', '0', '0.00', '0.00');
INSERT INTO `fw_orders` VALUES ('158', '9999', '201810301543135387', '23900.00', '1540885393', '32', '0', '0', '', '周生', '52', '440000', '440100', '440104', '0', '广东省广州市越秀区越华路112 珠江国际大厦', '13999999998', '0', '', '0', '', '1', '0', '0', '0', '0.00', '0.00');
INSERT INTO `fw_orders` VALUES ('159', '9999', '201811051709576810', '23900.00', '1541408997', '78', '32', '0', '', '钟琪', '77', '44', '4401', '440103', '0', '广东广州荔湾区', '15875872797', '0', '', '0', '', '1', '0', '1', '1', '0.00', '0.00');

-- ----------------------------
-- Table structure for fw_overdue
-- ----------------------------
DROP TABLE IF EXISTS `fw_overdue`;
CREATE TABLE `fw_overdue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitcode` varchar(32) DEFAULT NULL,
  `offbegin` int(11) DEFAULT NULL,
  `offend` int(11) DEFAULT NULL,
  `reason` varchar(256) DEFAULT NULL,
  `datetime` int(11) DEFAULT NULL,
  `operator` varchar(32) DEFAULT NULL,
  `type` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='防伪码分段作废 ';

-- ----------------------------
-- Records of fw_overdue
-- ----------------------------

-- ----------------------------
-- Table structure for fw_overduecode
-- ----------------------------
DROP TABLE IF EXISTS `fw_overduecode`;
CREATE TABLE `fw_overduecode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitcode` varchar(32) DEFAULT NULL,
  `fwcode` varchar(32) DEFAULT NULL,
  `addtime` int(11) DEFAULT '0',
  `operator` varchar(32) DEFAULT NULL,
  `type` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='防伪码作废';

-- ----------------------------
-- Records of fw_overduecode
-- ----------------------------

-- ----------------------------
-- Table structure for fw_payin
-- ----------------------------
DROP TABLE IF EXISTS `fw_payin`;
CREATE TABLE `fw_payin` (
  `pi_id` int(11) NOT NULL AUTO_INCREMENT,
  `pi_unitcode` varchar(32) DEFAULT NULL,
  `pi_dlid` int(11) DEFAULT '0' COMMENT '充值代理',
  `pi_money` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `pi_addtime` int(11) DEFAULT '0' COMMENT '充值时间',
  `pi_remark` varchar(256) DEFAULT NULL COMMENT '备注',
  `pi_pic` varchar(32) DEFAULT NULL COMMENT '凭证',
  `pi_dealtime` int(11) DEFAULT '0' COMMENT '处理时间',
  `pi_dealremark` varchar(256) DEFAULT NULL COMMENT '处理备注',
  `pi_state` int(11) DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`pi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='充值记录';

-- ----------------------------
-- Records of fw_payin
-- ----------------------------

-- ----------------------------
-- Table structure for fw_product
-- ----------------------------
DROP TABLE IF EXISTS `fw_product`;
CREATE TABLE `fw_product` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_unitcode` varchar(32) DEFAULT NULL,
  `pro_typeid` int(11) DEFAULT NULL,
  `pro_name` varchar(254) DEFAULT NULL,
  `pro_number` varchar(32) DEFAULT NULL,
  `pro_barcode` varchar(64) DEFAULT NULL,
  `pro_jftype` int(4) DEFAULT '0',
  `pro_jifen` int(11) DEFAULT '0',
  `pro_jfmax` int(11) DEFAULT '0',
  `pro_dljf` int(11) DEFAULT '0' COMMENT '代理获得积分',
  `pro_pic` varchar(64) DEFAULT NULL,
  `pro_pic2` varchar(64) DEFAULT NULL,
  `pro_pic3` varchar(64) DEFAULT NULL,
  `pro_pic4` varchar(64) DEFAULT NULL,
  `pro_pic5` varchar(64) DEFAULT NULL,
  `pro_price` decimal(10,2) DEFAULT NULL,
  `pro_stock` int(11) DEFAULT '0' COMMENT '库存',
  `pro_units` varchar(32) DEFAULT NULL COMMENT '产品单位',
  `pro_dbiao` int(11) DEFAULT '0' COMMENT '产品包装比例大标',
  `pro_zbiao` int(11) DEFAULT '0' COMMENT '产品包装比例中标',
  `pro_xbiao` int(11) DEFAULT '0' COMMENT '产品包装比例小标',
  `pro_desc` text,
  `pro_link` varchar(512) DEFAULT NULL,
  `pro_expirydate` varchar(32) DEFAULT NULL COMMENT '产品有效期',
  `pro_remark` varchar(512) DEFAULT NULL,
  `pro_order` int(11) NOT NULL COMMENT '产品排序编号',
  `pro_active` int(4) DEFAULT NULL,
  `pro_addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_product
-- ----------------------------
INSERT INTO `fw_product` VALUES ('5', '9999', '3', '测试产品5', 'N0001', '', '1', '0', '0', '0', '3052/1510556483_5913.jpg', '3052/15105617242_8141.jpg', '', '', '', '556.00', '0', '箱', '0', '0', '0', '低热量', '', null, '', '0', '1', '1510556483');
INSERT INTO `fw_product` VALUES ('7', '9999', '3', '测试产品7', 'N00012', '', '1', '0', '0', '0', '3052/1510556483_5913.jpg', '3052/15105617242_8141.jpg', '', '', '', '556.00', '0', '箱', '0', '0', '0', '低热量', '', null, '', '0', '1', '1510556483');
INSERT INTO `fw_product` VALUES ('12', '9999', '3', '测试产品12', 'N00012', '', '1', '0', '0', '0', '9999/1538105636_1454.jpg', '9999/15381056362_2665.jpg', null, null, null, '1000.00', '0', '盒', '0', '0', '0', '放到更好', '', null, '', '0', '1', '1538105636');

-- ----------------------------
-- Table structure for fw_profanli
-- ----------------------------
DROP TABLE IF EXISTS `fw_profanli`;
CREATE TABLE `fw_profanli` (
  `pfl_id` int(11) NOT NULL AUTO_INCREMENT,
  `pfl_unitcode` varchar(32) DEFAULT NULL,
  `pfl_proid` int(11) DEFAULT '0',
  `pfl_dltype` int(11) DEFAULT '0',
  `pfl_fanli1` decimal(10,2) DEFAULT '0.00' COMMENT '直推返利',
  `pfl_fanli2` decimal(10,2) DEFAULT '0.00' COMMENT '间推返利',
  `pfl_fanli3` decimal(10,2) DEFAULT '0.00' COMMENT '第三间推返利',
  `pfl_fanli4` decimal(10,2) DEFAULT '0.00' COMMENT '产品返利4',
  `pfl_fanli5` decimal(10,2) DEFAULT '0.00' COMMENT '产品返利5',
  `pfl_fanli6` decimal(10,2) DEFAULT '0.00' COMMENT '产品返利6',
  `pfl_fanli7` decimal(10,2) DEFAULT '0.00' COMMENT '产品返利7',
  `pfl_fanli8` decimal(10,2) DEFAULT '0.00' COMMENT '产品返利8',
  `pfl_fanli9` decimal(10,2) DEFAULT '0.00' COMMENT '产品返利9',
  `pfl_fanli10` decimal(10,2) DEFAULT '0.00' COMMENT '产品返利10',
  `pfl_maiduan` decimal(10,2) DEFAULT '0.00' COMMENT '买断返利',
  PRIMARY KEY (`pfl_id`),
  KEY `pri_unitcode` (`pfl_unitcode`),
  KEY `pfl_unitcode` (`pfl_unitcode`),
  KEY `pfl_proid` (`pfl_proid`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='产品返利设置';

-- ----------------------------
-- Records of fw_profanli
-- ----------------------------
INSERT INTO `fw_profanli` VALUES ('17', '9999', '5', '9', '181.00', '180.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `fw_profanli` VALUES ('18', '9999', '5', '10', '171.00', '170.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `fw_profanli` VALUES ('28', '9999', '7', '10', '11.00', '10.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `fw_profanli` VALUES ('27', '9999', '7', '9', '21.00', '20.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `fw_profanli` VALUES ('26', '9999', '7', '8', '31.00', '30.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `fw_profanli` VALUES ('25', '9999', '7', '7', '41.00', '40.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `fw_profanli` VALUES ('23', '9999', '5', '7', '201.00', '200.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `fw_profanli` VALUES ('24', '9999', '5', '8', '191.00', '190.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- ----------------------------
-- Table structure for fw_proprice
-- ----------------------------
DROP TABLE IF EXISTS `fw_proprice`;
CREATE TABLE `fw_proprice` (
  `pri_id` int(11) NOT NULL AUTO_INCREMENT,
  `pri_unitcode` varchar(32) DEFAULT NULL,
  `pri_proid` int(11) DEFAULT '0',
  `pri_dltype` int(11) DEFAULT '0',
  `pri_price` decimal(10,2) DEFAULT '0.00',
  `pri_minimum` int(11) DEFAULT '0' COMMENT '最低补货量',
  `pri_jifen` int(11) DEFAULT '0' COMMENT '产品积分',
  PRIMARY KEY (`pri_id`),
  KEY `pri_unitcode` (`pri_unitcode`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='产品价格体系';

-- ----------------------------
-- Records of fw_proprice
-- ----------------------------
INSERT INTO `fw_proprice` VALUES ('25', '9999', '5', '7', '239.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('26', '9999', '5', '8', '239.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('27', '9999', '5', '9', '259.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('28', '9999', '5', '10', '399.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('36', '9999', '7', '10', '400.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('35', '9999', '7', '9', '300.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('34', '9999', '7', '8', '200.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('33', '9999', '7', '7', '100.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('50', '9999', '12', '10', '400.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('49', '9999', '12', '9', '300.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('42', '9999', '5', '13', '500.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('41', '9999', '7', '13', '500.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('48', '9999', '12', '8', '200.00', '0', '0');
INSERT INTO `fw_proprice` VALUES ('47', '9999', '12', '7', '100.00', '0', '0');

-- ----------------------------
-- Table structure for fw_protype
-- ----------------------------
DROP TABLE IF EXISTS `fw_protype`;
CREATE TABLE `fw_protype` (
  `protype_id` int(11) NOT NULL AUTO_INCREMENT,
  `protype_unitcode` varchar(32) DEFAULT NULL,
  `protype_name` varchar(128) DEFAULT NULL,
  `protype_iswho` int(11) DEFAULT '0',
  `protype_order` int(11) DEFAULT '0',
  PRIMARY KEY (`protype_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_protype
-- ----------------------------
INSERT INTO `fw_protype` VALUES ('3', '9999', '素食全餐', '0', '3');

-- ----------------------------
-- Table structure for fw_qyinfo
-- ----------------------------
DROP TABLE IF EXISTS `fw_qyinfo`;
CREATE TABLE `fw_qyinfo` (
  `qy_id` int(11) NOT NULL AUTO_INCREMENT,
  `qy_username` varchar(64) DEFAULT NULL,
  `qy_pwd` varchar(64) DEFAULT NULL,
  `qy_code` varchar(32) DEFAULT NULL,
  `qy_openid` varchar(128) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '企业绑定的微信',
  `qy_name` varchar(64) DEFAULT NULL,
  `qy_address` varchar(64) DEFAULT NULL,
  `qy_tel` varchar(32) DEFAULT NULL,
  `qy_fax` varchar(32) DEFAULT NULL,
  `qy_email` varchar(64) DEFAULT NULL,
  `qy_contact` varchar(32) DEFAULT NULL,
  `qy_addtime` int(11) DEFAULT NULL,
  `qy_active` int(4) DEFAULT '0',
  `qy_purview` text,
  `qy_fwkey` varchar(128) DEFAULT NULL,
  `qy_fwsecret` varchar(128) DEFAULT NULL,
  `qy_querytimes` int(11) DEFAULT '0',
  `qy_relation` varchar(64) DEFAULT NULL,
  `qy_remark` text,
  `qy_pic` varchar(64) DEFAULT NULL,
  `qy_folder` varchar(64) DEFAULT NULL,
  `qy_logintime` int(11) DEFAULT '0',
  `qy_errtimes` int(4) DEFAULT '0',
  `qy_fchpwd` varchar(64) DEFAULT NULL COMMENT '防窜货查询密码',
  `qy_admindir` int(11) DEFAULT '0' COMMENT '选择管理目录',
  PRIMARY KEY (`qy_id`)
) ENGINE=MyISAM AUTO_INCREMENT=997 DEFAULT CHARSET=utf8 COMMENT='企业基本信息';

-- ----------------------------
-- Records of fw_qyinfo
-- ----------------------------
INSERT INTO `fw_qyinfo` VALUES ('995', 'test', '66730c784751efc66db25382bd59bbbb', '9999', '', '康利科技', '', '-', '', '', '-', '1440734214', '1', '10000,10001,10002,10003,10004,10005,10008,10009,10010,10011,10012,10013,90000,90001,90002,90003,90004,90005,11000,11001,11002,20000,20001,20002,20003,20004,20005,20006,20007,16000,16001,16002,16003,16004,16005,16006,16007,16008,16009,17001,30000,30001,30002,30003,30004,30005,30006,30007,30008,13000,13001,13002,13003,13004,13005,13006,13007,13008,13010,14000,14001,14002,14003,14004,14005,18000,18001,18002,18003,18004,18005,18006,18007,15000,15001,15002,15003,15004,70000,70001,70010,70011,70012,70006,70007,70009,70013,70015,70018,80000,80001,80002,80003,80004,20013,100000,100001', '649beSeQOYDEVvZkFFwKS9mNeJuVhzIvsIKHKGRx0Au6', '7fd27e62f3c85cc089c1f8ba27d2168d156dd9565b10ab8da8a23039c67fe5c3', '600', '9999|9998', '', '', 'kangli', '1542431294', '0', 'd5961a2f50e5b5422fb6effaf0769fea', '1');

-- ----------------------------
-- Table structure for fw_qysubuser
-- ----------------------------
DROP TABLE IF EXISTS `fw_qysubuser`;
CREATE TABLE `fw_qysubuser` (
  `su_id` int(11) NOT NULL AUTO_INCREMENT,
  `su_unitcode` varchar(32) DEFAULT NULL,
  `su_username` varchar(64) DEFAULT NULL,
  `su_pwd` varchar(64) DEFAULT NULL,
  `su_openid` varchar(64) DEFAULT NULL,
  `su_wxnickname` varchar(128) DEFAULT NULL,
  `su_wxsex` int(4) DEFAULT '0',
  `su_wxprovince` varchar(32) DEFAULT NULL,
  `su_wxcity` varchar(32) DEFAULT NULL,
  `su_wxcountry` varchar(32) DEFAULT NULL,
  `su_wxheadimg` varchar(512) DEFAULT NULL,
  `su_weixin` varchar(32) DEFAULT NULL,
  `su_name` varchar(64) DEFAULT NULL,
  `su_logintime` int(11) DEFAULT NULL,
  `su_errlogintime` int(11) DEFAULT NULL,
  `su_errtimes` int(4) DEFAULT NULL COMMENT '登录错误次数 连续5次错误 锁20分钟钟',
  `su_remark` varchar(512) DEFAULT NULL,
  `su_status` int(4) DEFAULT NULL,
  `su_belong` int(11) NOT NULL DEFAULT '0' COMMENT '子用户所属 0-公司 大于0代理id',
  `su_purview` varchar(512) DEFAULT NULL COMMENT ' 权限',
  PRIMARY KEY (`su_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='企业子管理用户表 子用户发货 app发货';

-- ----------------------------
-- Records of fw_qysubuser
-- ----------------------------
INSERT INTO `fw_qysubuser` VALUES ('5', '9999', 'z522402294', '66730c784751efc66db25382bd59bbbb', null, null, '0', null, null, null, null, null, '钟琪', '1540796512', '1540796512', '0', null, '1', '0', '10000,10001,10002,10003,10004,10005,10008,10009,10010,90000,90001,90002,90003,90004,90005,20006,20007,13004,80003,80004');

-- ----------------------------
-- Table structure for fw_recash
-- ----------------------------
DROP TABLE IF EXISTS `fw_recash`;
CREATE TABLE `fw_recash` (
  `rc_id` int(11) NOT NULL AUTO_INCREMENT,
  `rc_unitcode` varchar(32) DEFAULT NULL COMMENT '企业号',
  `rc_dlid` int(11) DEFAULT '0' COMMENT '提现代理id',
  `rc_sdlid` int(11) DEFAULT '0' COMMENT '发佣金的id 默认为公司',
  `rc_money` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `rc_bank` int(11) DEFAULT '0' COMMENT '提现方式',
  `rc_bankcard` varchar(64) DEFAULT NULL COMMENT '提现账号 加密',
  `rc_name` varchar(32) DEFAULT NULL COMMENT '账号对应名称',
  `rc_addtime` int(11) DEFAULT '0' COMMENT '申请时间',
  `rc_dealtime` int(11) DEFAULT '0' COMMENT '处理时间',
  `rc_state` int(11) DEFAULT '0' COMMENT '处理状态',
  `rc_verify` varchar(64) DEFAULT NULL COMMENT '验证串',
  `rc_remark` varchar(256) DEFAULT NULL COMMENT '处理备注',
  `rc_remark2` varchar(256) DEFAULT NULL COMMENT '处理备注(仅内部看)',
  `rc_ip` varchar(64) DEFAULT NULL,
  `rc_pic` varchar(32) DEFAULT NULL COMMENT '凭证',
  PRIMARY KEY (`rc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='返利提现记录';

-- ----------------------------
-- Records of fw_recash
-- ----------------------------
INSERT INTO `fw_recash` VALUES ('1', '9999', '32', '0', '20000.00', '1', '994aXajhjlGPfUVW2lEkfIl28lEB513cuioU/foYXb2FUFmTeA', '李生', '1510908576', '1535095974', '2', 'db514cd9798c0b599b69a59b2120b73a', '覆盖而', '', '127.0.0.1', '3052/5a0d51b432af0468.jpeg');
INSERT INTO `fw_recash` VALUES ('2', '9999', '35', '34', '125.00', '3', '5423hYhsZ0mY9ozR0/W8IVabztrQ1BulcVu+oLuzo6u6wuE0GKe3s17j', '罗生', '1510909242', '1510915370', '1', 'a657540608a54c12559949fe7c8c1b08', '已处理', '', '127.0.0.1', '3052/5a0ebd278f750952.jpeg');
INSERT INTO `fw_recash` VALUES ('3', '9999', '32', '0', '1550.00', '1', '6993IqVXHebht5i+FzydRnAEpA4ao+wRJ2n90H7pOPyXVMxhp35ULl1iRUwGsudj', '李生', '1526638345', '1535095950', '1', '03506a7412a91a64cdcb3c4074fd1947', '水电费', '', '192.168.1.134', null);
INSERT INTO `fw_recash` VALUES ('4', '9999', '38', '32', '6000.00', '5', 'e7950VVwGvu93vhAOF6HGCoJSpkXbiLPEXYunv0X04nRpYke6+ubOuNR', '蔡生', '1526639732', '1526712199', '0', '880e24837eb9f582cfb38d30066dcc6e', '处理成功', null, '192.168.1.134', '9999/5affc78312818.png');
INSERT INTO `fw_recash` VALUES ('5', '9999', '32', '0', '89326.00', '1', '907f3T1QD3cjAlWi+xhtjnpmpmY52HWP0+bH+ak2F+jUvPlSPdC1oUTH', '李生', '1536136544', '1536136641', '1', '5f9404c96506d50931204723778439d2', '同一天', '', '0.0.0.0', null);
INSERT INTO `fw_recash` VALUES ('6', '9999', '32', '0', '89326.00', '1', 'ec57g37e26OPkuuAJKii/gP0c7yDWLyd7RX+oGN9uWVNuMxAMThjpytYFg', '李生', '1536136850', '1536136919', '1', 'dfab7c6ba330b77bcd4cd316b275696f', '②', '', '0.0.0.0', null);
INSERT INTO `fw_recash` VALUES ('7', '9999', '56', '0', '36164.00', '1', 'dbb7tGZk2mWfvA7jkF6FK/PDKk9Fy9AeLYvBO0gJox8SsOLP6zCYzsM', '钟琪5', '1536222662', '1536222875', '1', 'b1171b9bef8dfaa07cd56ba9e0023221', '二兔', '', '0.0.0.0', null);

-- ----------------------------
-- Table structure for fw_retchaibox
-- ----------------------------
DROP TABLE IF EXISTS `fw_retchaibox`;
CREATE TABLE `fw_retchaibox` (
  `chai_id` int(11) NOT NULL AUTO_INCREMENT,
  `chai_unitcode` varchar(32) DEFAULT NULL,
  `chai_deliver` int(11) DEFAULT '0' COMMENT '退货者',
  `chai_addtime` int(11) DEFAULT NULL,
  `chai_barcode` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`chai_id`),
  KEY `chai_unitcode` (`chai_unitcode`),
  KEY `chai_unitcode_2` (`chai_unitcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='退换拆箱记录';

-- ----------------------------
-- Records of fw_retchaibox
-- ----------------------------

-- ----------------------------
-- Table structure for fw_returnable
-- ----------------------------
DROP TABLE IF EXISTS `fw_returnable`;
CREATE TABLE `fw_returnable` (
  `ret_id` int(11) NOT NULL AUTO_INCREMENT,
  `ret_unitcode` varchar(32) DEFAULT NULL,
  `ret_number` varchar(32) DEFAULT NULL,
  `ret_deliver` int(11) DEFAULT '0' COMMENT '退货者',
  `ret_dealer` int(11) DEFAULT '0' COMMENT '退货接收者',
  `ret_pro` int(11) DEFAULT NULL,
  `ret_odid` int(11) DEFAULT '0' COMMENT '对应订单ID',
  `ret_odblid` int(11) DEFAULT '0' COMMENT '订单关系id',
  `ret_proqty` int(11) DEFAULT NULL,
  `ret_barcode` varchar(32) DEFAULT NULL,
  `ret_ucode` varchar(32) DEFAULT NULL,
  `ret_tcode` varchar(32) DEFAULT NULL,
  `ret_date` int(11) DEFAULT NULL,
  `ret_remark` varchar(256) DEFAULT NULL COMMENT '申请退换备注',
  `ret_type` int(4) DEFAULT '0' COMMENT '退换货类型 1-换货 2-退货',
  `ret_dealremark` varchar(256) DEFAULT NULL COMMENT '处理备注',
  `ret_status` int(11) DEFAULT '0' COMMENT '状态 默认0-新 1-同意退换 2-不同意',
  PRIMARY KEY (`ret_id`),
  KEY `ship_unitcode` (`ret_unitcode`),
  KEY `ship_barcode` (`ret_barcode`),
  KEY `ret_unitcode` (`ret_unitcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='退换货处理';

-- ----------------------------
-- Records of fw_returnable
-- ----------------------------

-- ----------------------------
-- Table structure for fw_salemonfanlirate
-- ----------------------------
DROP TABLE IF EXISTS `fw_salemonfanlirate`;
CREATE TABLE `fw_salemonfanlirate` (
  `smfr_id` int(11) NOT NULL AUTO_INCREMENT,
  `smfr_unitcode` varchar(32) DEFAULT NULL,
  `smfr_dltype` int(11) DEFAULT '0' COMMENT '代理级别',
  `smfr_minsale` decimal(10,2) DEFAULT '0.00' COMMENT '最小业绩',
  `smfr_maxsale` decimal(10,2) DEFAULT '0.00' COMMENT '最大业绩',
  `smfr_saleunit` int(11) DEFAULT '0' COMMENT '业绩计算单位',
  `smfr_fanlirate` decimal(10,2) DEFAULT '0.00' COMMENT '返利',
  `smfr_fanlieval` int(11) DEFAULT '0' COMMENT '奖金计算方式',
  `smfr_countdate` int(11) DEFAULT '0' COMMENT '业绩计算时间',
  `smfr_remark` varchar(265) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`smfr_id`),
  KEY `smfr_unitcode` (`smfr_unitcode`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='按业绩销售奖设置';

-- ----------------------------
-- Records of fw_salemonfanlirate
-- ----------------------------
INSERT INTO `fw_salemonfanlirate` VALUES ('11', '9999', '8', '0.00', '99999999.00', '1', '0.05', '2', '1', '');
INSERT INTO `fw_salemonfanlirate` VALUES ('12', '9999', '9', '1000.00', '99999999.00', '2', '5.00', '2', '1', '');
INSERT INTO `fw_salemonfanlirate` VALUES ('13', '9999', '7', '0.00', '99999999.00', '1', '0.05', '2', '2', '');
INSERT INTO `fw_salemonfanlirate` VALUES ('14', '9999', '8', '50000.00', '100000.00', '2', '150000.00', '1', '2', '');
INSERT INTO `fw_salemonfanlirate` VALUES ('15', '9999', '8', '100000.00', '200000.00', '2', '400000.00', '1', '2', '');
INSERT INTO `fw_salemonfanlirate` VALUES ('16', '9999', '8', '200000.00', '400000.00', '2', '1000000.00', '1', '2', '');
INSERT INTO `fw_salemonfanlirate` VALUES ('17', '9999', '8', '400000.00', '800000.00', '2', '2400000.00', '1', '2', '');
INSERT INTO `fw_salemonfanlirate` VALUES ('18', '9999', '8', '800000.00', '99999999.00', '2', '5600000.00', '1', '2', '');

-- ----------------------------
-- Table structure for fw_salemonthly
-- ----------------------------
DROP TABLE IF EXISTS `fw_salemonthly`;
CREATE TABLE `fw_salemonthly` (
  `sm_id` int(11) NOT NULL AUTO_INCREMENT,
  `sm_unitcode` varchar(32) DEFAULT NULL,
  `sm_dlid` int(11) DEFAULT '0' COMMENT '收方代理',
  `sm_senddlid` int(11) DEFAULT '0' COMMENT '发方代理',
  `sm_mysale` decimal(10,2) DEFAULT '0.00' COMMENT '我的业绩',
  `sm_teamsale` decimal(10,2) DEFAULT '0.00' COMMENT '团队业绩',
  `sm_reward` decimal(10,2) DEFAULT '0.00' COMMENT '奖金',
  `sm_date` int(11) DEFAULT '0' COMMENT '计算月份',
  `sm_flid` int(11) DEFAULT '0' COMMENT '对应返利表id',
  `sm_addtime` int(11) DEFAULT '0' COMMENT '添加时间',
  `sm_state` int(11) DEFAULT '0' COMMENT '状态备用',
  `sm_remark` varchar(256) DEFAULT NULL COMMENT '备注',
  `sm_type` int(4) NOT NULL DEFAULT '0' COMMENT '团队类型',
  `sm_yjtype` int(4) NOT NULL DEFAULT '0' COMMENT '业绩类型0月1年2总',
  PRIMARY KEY (`sm_id`),
  KEY `sm_unitcode` (`sm_unitcode`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='按月销量奖励返利(如：卡一西)';

-- ----------------------------
-- Records of fw_salemonthly
-- ----------------------------

-- ----------------------------
-- Table structure for fw_salesreward
-- ----------------------------
DROP TABLE IF EXISTS `fw_salesreward`;
CREATE TABLE `fw_salesreward` (
  `sr_id` int(11) NOT NULL AUTO_INCREMENT,
  `sr_unitcode` varchar(32) DEFAULT NULL,
  `sr_salesvolume` int(11) DEFAULT NULL COMMENT '销量',
  `sr_unitreward` decimal(10,2) DEFAULT '0.00' COMMENT '每1销量单位奖励多少',
  `sr_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `sr_addtime` int(11) NOT NULL DEFAULT '0' COMMENT '申请时间',
  `sr_dlid` int(11) NOT NULL DEFAULT '0' COMMENT '接受奖励的代理id',
  `sr_senddlid` int(11) DEFAULT '0' COMMENT '发放奖励id 0-公司',
  `sr_flid` int(11) DEFAULT '0' COMMENT '对应返利详细里面的id',
  `sr_state` int(11) DEFAULT '1' COMMENT '状态，默认1-有效- 0-无效 与返利乡详细里状态相关',
  PRIMARY KEY (`sr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='销售累计奖励(瑧善)';

-- ----------------------------
-- Records of fw_salesreward
-- ----------------------------

-- ----------------------------
-- Table structure for fw_sellrecord
-- ----------------------------
DROP TABLE IF EXISTS `fw_sellrecord`;
CREATE TABLE `fw_sellrecord` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `unitcode` varchar(4) DEFAULT NULL,
  `sellcount` int(11) DEFAULT NULL COMMENT '理论发行数',
  `mybegin` int(11) DEFAULT NULL,
  `txttype` tinyint(4) DEFAULT NULL,
  `selldatetime` datetime DEFAULT NULL,
  `operator` varchar(30) DEFAULT NULL,
  `endflag` varchar(10) DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  `snyn` tinyint(4) DEFAULT NULL,
  `snbegin` varchar(30) DEFAULT NULL,
  `snend` varchar(30) DEFAULT NULL,
  `upyn` varchar(1) DEFAULT NULL,
  `voice01` varchar(250) DEFAULT NULL,
  `renote` varchar(200) DEFAULT NULL,
  `remark` varchar(300) DEFAULT NULL,
  `lot_no` varchar(50) DEFAULT NULL,
  `pr_date` datetime DEFAULT NULL,
  `ex_date` datetime DEFAULT NULL,
  `exdays` int(11) DEFAULT NULL,
  `mqty` decimal(18,0) DEFAULT NULL COMMENT '实际发行数',
  `packtype` varchar(50) DEFAULT NULL,
  `pdqty` int(11) DEFAULT NULL,
  `pzqty` int(11) DEFAULT NULL,
  `pxqty` int(11) DEFAULT NULL,
  `sntype` varchar(50) DEFAULT NULL,
  `dsnf` varchar(50) DEFAULT NULL,
  `dsnt` varchar(50) DEFAULT NULL,
  `zsnf` varchar(50) DEFAULT NULL,
  `zsnt` varchar(50) DEFAULT NULL,
  `sbqty` decimal(18,0) DEFAULT NULL,
  `sxqty` int(11) DEFAULT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=2667 DEFAULT CHARSET=utf8 COMMENT='生码发行记录';

-- ----------------------------
-- Records of fw_sellrecord
-- ----------------------------
INSERT INTO `fw_sellrecord` VALUES ('1935', '9999', '100000', '1', '0', '2015-08-26 00:00:00', '', '', '', '0', '150000001', '150005000', 'N', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '100000', '2-大小包装', '1', '0', '20', '4-双码流水号2', '', '', '', '', '0', '20');
INSERT INTO `fw_sellrecord` VALUES ('2666', '9999', '10000', '100001', '0', '2016-07-21 00:00:00', '', '', '', '0', '16000001', '16000100', 'N', '', '', '大中小包装测试', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '10000', '3-大中小包装', '1', '10', '10', '4-双码流水号2', '', '', '', '', '0', '10');

-- ----------------------------
-- Table structure for fw_session
-- ----------------------------
DROP TABLE IF EXISTS `fw_session`;
CREATE TABLE `fw_session` (
  `session_id` varchar(255) NOT NULL,
  `session_expire` int(11) NOT NULL,
  `session_data` blob,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_session
-- ----------------------------
INSERT INTO `fw_session` VALUES ('99mu2au2dgnngtnhadiohgdtc4', '1541625004', '');

-- ----------------------------
-- Table structure for fw_sharelinks
-- ----------------------------
DROP TABLE IF EXISTS `fw_sharelinks`;
CREATE TABLE `fw_sharelinks` (
  `sl_id` int(11) NOT NULL AUTO_INCREMENT,
  `sl_unitcode` varchar(32) DEFAULT NULL,
  `sl_brid` int(11) DEFAULT NULL,
  `sl_dealerid` int(11) DEFAULT NULL,
  `sl_level` int(11) DEFAULT '0',
  `sl_endtime` int(11) DEFAULT NULL,
  `sl_views` int(11) DEFAULT NULL,
  `sl_applynum` int(11) DEFAULT NULL,
  PRIMARY KEY (`sl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COMMENT='代理邀请链接';

-- ----------------------------
-- Records of fw_sharelinks
-- ----------------------------
INSERT INTO `fw_sharelinks` VALUES ('72', '9999', '0', '32', '7', '1541441539', '0', '0');
INSERT INTO `fw_sharelinks` VALUES ('68', '9999', '0', null, '7', '1540986330', '0', '0');
INSERT INTO `fw_sharelinks` VALUES ('71', '9999', '0', '32', '7', '1541439889', '0', '0');

-- ----------------------------
-- Table structure for fw_shipment
-- ----------------------------
DROP TABLE IF EXISTS `fw_shipment`;
CREATE TABLE `fw_shipment` (
  `ship_id` int(11) NOT NULL AUTO_INCREMENT,
  `ship_unitcode` varchar(32) DEFAULT NULL,
  `ship_number` varchar(32) DEFAULT NULL,
  `ship_deliver` int(11) DEFAULT '0' COMMENT '出货提供者',
  `ship_dealer` int(11) DEFAULT '0' COMMENT '出货接收者',
  `ship_pro` int(11) DEFAULT NULL,
  `ship_odid` int(11) DEFAULT '0' COMMENT '对应订单ID',
  `ship_odblid` int(11) DEFAULT '0' COMMENT '订单关系id',
  `ship_oddtid` int(11) DEFAULT '0' COMMENT '订单详细id',
  `ship_whid` int(11) DEFAULT NULL COMMENT '出货仓库',
  `ship_proqty` int(11) DEFAULT NULL,
  `ship_barcode` varchar(32) DEFAULT NULL,
  `ship_ucode` varchar(32) DEFAULT NULL,
  `ship_tcode` varchar(32) DEFAULT NULL,
  `ship_date` int(11) DEFAULT NULL,
  `ship_remark` text,
  `ship_cztype` int(4) DEFAULT '0' COMMENT '操作者类型 0-企业主主账户  1-企业子管理用户 2-经销商',
  `ship_czid` int(11) DEFAULT '0' COMMENT '操作者ID',
  `ship_czuser` varchar(64) DEFAULT NULL,
  `ship_prodate` varchar(32) DEFAULT NULL COMMENT '产品生产日期',
  `ship_batchnum` varchar(32) DEFAULT NULL COMMENT '生产批号',
  `ship_status` int(11) DEFAULT '0' COMMENT '出货状态 默认0-正常 2-禁用',
  PRIMARY KEY (`ship_id`),
  KEY `ship_unitcode` (`ship_unitcode`),
  KEY `ship_barcode` (`ship_barcode`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_shipment
-- ----------------------------
INSERT INTO `fw_shipment` VALUES ('70', '9999', '201810301125337147', '0', '32', '5', '153', null, '175', '2', '100', '16000007', '', '', '1540869953', '测试产品5', '0', '995', 'test', null, null, '0');
INSERT INTO `fw_shipment` VALUES ('71', '9999', '201810301127599934', '0', '78', '5', '155', null, '177', '2', '100', '16000008', '', '', '1540870403', '测试产品5', '0', '995', 'test', null, null, '0');
INSERT INTO `fw_shipment` VALUES ('72', '9999', '201810301525106842', '0', '32', '5', '0', '0', '0', '2', '100', '16000009', '', '', '1540828800', '的非官方的', '0', '995', 'test', null, null, '0');
INSERT INTO `fw_shipment` VALUES ('73', '9999', '201810301543135387', '0', '32', '5', '0', '0', '0', '2', '100', '16000010', '', '', '1540828800', '', '0', '995', 'test', null, null, '0');

-- ----------------------------
-- Table structure for fw_shopcart
-- ----------------------------
DROP TABLE IF EXISTS `fw_shopcart`;
CREATE TABLE `fw_shopcart` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sc_unitcode` varchar(32) DEFAULT NULL,
  `sc_dlid` int(11) DEFAULT '0',
  `sc_proid` int(11) DEFAULT '0',
  `sc_attrid` int(11) DEFAULT '0',
  `sc_color` varchar(16) DEFAULT NULL,
  `sc_size` varchar(16) DEFAULT NULL,
  `sc_qty` int(11) DEFAULT '0',
  `sc_addtime` int(11) DEFAULT '0',
  `sc_status` int(11) NOT NULL DEFAULT '0' COMMENT '购物车的状态',
  `sc_istrail` int(4) DEFAULT '0' COMMENT '是否是测试产品',
  `sc_virtualstock` int(4) NOT NULL DEFAULT '0' COMMENT '是否是虚库存',
  PRIMARY KEY (`sc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=utf8 COMMENT='购物车';

-- ----------------------------
-- Records of fw_shopcart
-- ----------------------------
INSERT INTO `fw_shopcart` VALUES ('116', '9999', '38', '5', '0', '', '', '1', '1526866108', '0', '0', '1');
INSERT INTO `fw_shopcart` VALUES ('149', '9999', '64', '5', '0', '', '', '1', '1535511936', '0', '0', '1');
INSERT INTO `fw_shopcart` VALUES ('225', '9999', '43', '5', '0', '', '', '1', '1540868809', '0', '0', '0');
INSERT INTO `fw_shopcart` VALUES ('224', '9999', '43', '5', '0', '', '', '2', '1540868780', '0', '0', '1');

-- ----------------------------
-- Table structure for fw_sip
-- ----------------------------
DROP TABLE IF EXISTS `fw_sip`;
CREATE TABLE `fw_sip` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_ip` varchar(64) DEFAULT NULL,
  `s_maxfid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_sip
-- ----------------------------

-- ----------------------------
-- Table structure for fw_snmm
-- ----------------------------
DROP TABLE IF EXISTS `fw_snmm`;
CREATE TABLE `fw_snmm` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `unitcode` varchar(4) DEFAULT NULL,
  `address` int(11) DEFAULT NULL,
  `codea` varchar(32) DEFAULT NULL,
  `codeb` varchar(32) DEFAULT NULL,
  `codec` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_snmm
-- ----------------------------

-- ----------------------------
-- Table structure for fw_storage
-- ----------------------------
DROP TABLE IF EXISTS `fw_storage`;
CREATE TABLE `fw_storage` (
  `stor_id` int(11) NOT NULL AUTO_INCREMENT,
  `stor_unitcode` varchar(32) DEFAULT NULL,
  `stor_number` varchar(32) DEFAULT NULL COMMENT '入库单号',
  `stor_pro` int(11) DEFAULT '0' COMMENT '入库产品id',
  `stor_whid` int(11) DEFAULT NULL COMMENT '入库仓库',
  `stor_proqty` int(11) DEFAULT '0' COMMENT '入库产品数量',
  `stor_barcode` varchar(32) DEFAULT NULL COMMENT '条码',
  `stor_ucode` varchar(32) DEFAULT NULL COMMENT '大标',
  `stor_tcode` varchar(32) DEFAULT NULL COMMENT '中标',
  `stor_date` int(11) DEFAULT NULL COMMENT '入库时间',
  `stor_remark` text,
  `stor_cztype` int(4) DEFAULT '0' COMMENT '操作者类型 0-企业主主账户  1-企业子管理用户 2-经销商',
  `stor_czid` int(11) DEFAULT '0' COMMENT '操作者ID',
  `stor_czuser` varchar(64) DEFAULT NULL,
  `stor_prodate` varchar(32) DEFAULT NULL COMMENT '产品生产日期',
  `stor_batchnum` varchar(32) DEFAULT NULL COMMENT '生产批号',
  `stor_isship` int(11) NOT NULL DEFAULT '0' COMMENT '是否已出货',
  `stor_attrid` int(11) NOT NULL COMMENT '产品颜色尺码ID',
  `stor_color` varchar(32) NOT NULL COMMENT '产品颜色',
  `stor_size` varchar(32) NOT NULL COMMENT '产品尺码',
  PRIMARY KEY (`stor_id`),
  KEY `ship_unitcode` (`stor_unitcode`),
  KEY `ship_barcode` (`stor_barcode`)
) ENGINE=MyISAM AUTO_INCREMENT=350 DEFAULT CHARSET=utf8 COMMENT='产品入库';

-- ----------------------------
-- Records of fw_storage
-- ----------------------------
INSERT INTO `fw_storage` VALUES ('345', '9999', '234524355', '12', '2', '100', '16000006', '', '', '1540869568', '低功耗', '1', '995', 'test', '0', '0', '0', '0', '0', '0');
INSERT INTO `fw_storage` VALUES ('346', '9999', '546435', '5', '2', '100', '16000007', '', '', '1540869869', '', '1', '995', 'test', '0', '0', '0', '0', '0', '0');
INSERT INTO `fw_storage` VALUES ('347', '9999', '345645', '5', '2', '100', '16000008', '', '', '1540870334', '', '1', '995', 'test', '0', '0', '0', '0', '0', '0');
INSERT INTO `fw_storage` VALUES ('348', '9999', '111111', '5', '2', '100', '16000009', '', '', '1540884242', '', '1', '995', 'test', '0', '0', '0', '0', '0', '0');
INSERT INTO `fw_storage` VALUES ('349', '9999', '32545255', '5', '2', '100', '16000010', '', '', '1540885449', '', '1', '995', 'test', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for fw_storchaibox
-- ----------------------------
DROP TABLE IF EXISTS `fw_storchaibox`;
CREATE TABLE `fw_storchaibox` (
  `chai_id` int(11) NOT NULL AUTO_INCREMENT,
  `chai_unitcode` varchar(32) DEFAULT NULL,
  `chai_addtime` int(11) DEFAULT NULL,
  `chai_barcode` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`chai_id`),
  KEY `chai_unitcode` (`chai_unitcode`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='产品入库拆箱记录';

-- ----------------------------
-- Records of fw_storchaibox
-- ----------------------------
INSERT INTO `fw_storchaibox` VALUES ('15', null, '1540780490', '16000002');

-- ----------------------------
-- Table structure for fw_sysadmin
-- ----------------------------
DROP TABLE IF EXISTS `fw_sysadmin`;
CREATE TABLE `fw_sysadmin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(30) DEFAULT NULL,
  `admin_pwd` varchar(64) DEFAULT NULL,
  `admin_truename` varchar(20) DEFAULT NULL,
  `admin_email` varchar(64) DEFAULT NULL,
  `admin_tel` varchar(64) DEFAULT NULL,
  `admin_des` varchar(250) DEFAULT NULL,
  `admin_purview` text,
  `admin_addtime` int(11) DEFAULT NULL,
  `admin_logintime` int(11) DEFAULT '0',
  `admin_errtimes` int(4) DEFAULT '0',
  `admin_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_sysadmin
-- ----------------------------

-- ----------------------------
-- Table structure for fw_tellist
-- ----------------------------
DROP TABLE IF EXISTS `fw_tellist`;
CREATE TABLE `fw_tellist` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL DEFAULT '0',
  `unitcode` varchar(10) DEFAULT NULL,
  `fwcode` varchar(200) DEFAULT NULL,
  `querystatu` varchar(10) DEFAULT NULL,
  `querydate` datetime DEFAULT NULL,
  `callerid` varchar(64) DEFAULT NULL,
  `calltime` int(11) DEFAULT '0',
  `remark` varchar(64) DEFAULT NULL,
  `chid` varchar(10) DEFAULT NULL,
  `upyn` varchar(10) DEFAULT NULL,
  `qutype` varchar(1) DEFAULT NULL,
  `remess` varchar(150) DEFAULT NULL,
  `k` decimal(18,0) DEFAULT '0',
  `jfqty` decimal(18,2) DEFAULT '0.00',
  `cu_name` varchar(50) DEFAULT NULL,
  `loca` varchar(30) DEFAULT NULL,
  `man_no` varchar(20) DEFAULT NULL,
  `snno` varchar(30) DEFAULT NULL,
  `sloca` varchar(30) DEFAULT NULL,
  `fcresult` varchar(50) DEFAULT NULL,
  `yun` int(4) DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `unitcode` (`unitcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_tellist
-- ----------------------------

-- ----------------------------
-- Table structure for fw_templist
-- ----------------------------
DROP TABLE IF EXISTS `fw_templist`;
CREATE TABLE `fw_templist` (
  `tmp_fid` int(11) NOT NULL AUTO_INCREMENT,
  `tmp_unitcode` varchar(32) DEFAULT NULL,
  `tmp_code` varchar(32) DEFAULT NULL,
  `tmp_state` int(4) DEFAULT '0',
  `tmp_ip` varchar(32) DEFAULT NULL,
  `tmp_addtime` int(11) DEFAULT NULL,
  `tmp_remark` varchar(512) DEFAULT NULL,
  `tmp_referer` varchar(512) DEFAULT NULL,
  `tmp_clr` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`tmp_fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fw_templist
-- ----------------------------

-- ----------------------------
-- Table structure for fw_warehouse
-- ----------------------------
DROP TABLE IF EXISTS `fw_warehouse`;
CREATE TABLE `fw_warehouse` (
  `wh_id` int(11) NOT NULL AUTO_INCREMENT,
  `wh_unitcode` varchar(32) DEFAULT NULL,
  `wh_munber` varchar(64) DEFAULT NULL COMMENT '仓库编号',
  `wh_name` varchar(64) DEFAULT NULL COMMENT '仓库名称',
  `wh_address` varchar(64) DEFAULT NULL COMMENT '仓库场所地址',
  `wh_director` varchar(64) DEFAULT NULL COMMENT '仓库管理员',
  `wh_remark` text COMMENT '备注',
  PRIMARY KEY (`wh_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='仓库管理';

-- ----------------------------
-- Records of fw_warehouse
-- ----------------------------
INSERT INTO `fw_warehouse` VALUES ('2', '9999', 'P001', '康利科技', '', '', '');

-- ----------------------------
-- Table structure for fw_yifuattr
-- ----------------------------
DROP TABLE IF EXISTS `fw_yifuattr`;
CREATE TABLE `fw_yifuattr` (
  `attr_id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_unitcode` varchar(32) DEFAULT NULL,
  `attr_proid` int(11) DEFAULT '0',
  `attr_color` varchar(16) DEFAULT NULL,
  `attr_size` varchar(16) NOT NULL,
  `attr_stock` int(11) NOT NULL DEFAULT '0',
  `attr_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COMMENT='产品服装属性';

-- ----------------------------
-- Records of fw_yifuattr
-- ----------------------------
INSERT INTO `fw_yifuattr` VALUES ('63', '9999', '12', '黑', 'l', '0', '0.00');
INSERT INTO `fw_yifuattr` VALUES ('60', '9999', '12', '白', 'm', '0', '0.00');
INSERT INTO `fw_yifuattr` VALUES ('58', '9999', '7', '白', 'ml', '0', '0.00');

-- ----------------------------
-- Table structure for fw_yufukuan
-- ----------------------------
DROP TABLE IF EXISTS `fw_yufukuan`;
CREATE TABLE `fw_yufukuan` (
  `yfk_id` int(11) NOT NULL AUTO_INCREMENT,
  `yfk_unitcode` varchar(32) DEFAULT NULL COMMENT '企业码',
  `yfk_type` int(11) DEFAULT '0' COMMENT '预付款类型',
  `yfk_sendid` int(11) DEFAULT '0' COMMENT '发款方id',
  `yfk_receiveid` int(11) DEFAULT '0' COMMENT '收款方id',
  `yfk_money` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `yfk_refedlid` int(11) DEFAULT '0' COMMENT '推荐返利时被推荐人的id',
  `yfk_oddlid` int(11) DEFAULT '0' COMMENT '订单返利中下单人id',
  `yfk_odid` int(11) DEFAULT '0' COMMENT '订单返利中订单id',
  `yfk_orderid` varchar(32) DEFAULT NULL COMMENT '订单返利中订单号',
  `yfk_odblid` int(11) DEFAULT '0' COMMENT '订单返利中订单关系id',
  `yfk_proid` int(11) DEFAULT '0' COMMENT '订单返利中产品id',
  `yfk_qty` int(11) DEFAULT '0' COMMENT '订单返利中产品数量',
  `yfk_level` int(11) DEFAULT '0' COMMENT '返利中的层次',
  `yfk_addtime` int(11) DEFAULT '0' COMMENT '时间',
  `yfk_remark` varchar(256) DEFAULT NULL COMMENT '简单说明',
  `yfk_state` int(11) DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`yfk_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='预付款明细表';

-- ----------------------------
-- Records of fw_yufukuan
-- ----------------------------
INSERT INTO `fw_yufukuan` VALUES ('6', '9999', '1', '0', '79', '1000.00', '0', '0', '0', '', '0', '0', '0', '0', '1541145172', 'test', '1');
INSERT INTO `fw_yufukuan` VALUES ('7', '9999', '1', '0', '79', '800.00', '0', '0', '0', '', '0', '0', '0', '0', '1541145182', 'test', '1');
INSERT INTO `fw_yufukuan` VALUES ('8', '9999', '1', '79', '0', '20.00', '0', '0', '0', '', '0', '0', '0', '0', '1541145192', 'test', '1');
INSERT INTO `fw_yufukuan` VALUES ('9', '9999', '1', '0', '80', '100.00', '0', '0', '0', '', '0', '0', '0', '0', '1541208698', 'test', '1');
INSERT INTO `fw_yufukuan` VALUES ('10', '9999', '1', '80', '0', '20.00', '0', '0', '0', '', '0', '0', '0', '0', '1541208707', 'test', '1');
