-- MySQL dump 10.13  Distrib 5.6.37, for Linux (x86_64)
--
-- Host: localhost    Database: shop
-- ------------------------------------------------------
-- Server version	5.6.37-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `mobile` char(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (6,'刘德华','13854786523','北京市  北京城区  丰台区阿三大法师打发斯蒂芬',2),(7,'张学友','13984568542','内蒙古自治区  鄂尔多斯市  杭锦旗阿斯顿发送到发',2),(8,'囧','15588608866','辽宁省  鞍山市  台安县去途中',1);
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat`
--

DROP TABLE IF EXISTS `cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL,
  `cat_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cat_img` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_show` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat`
--

LOCK TABLES `cat` WRITE;
/*!40000 ALTER TABLE `cat` DISABLE KEYS */;
INSERT INTO `cat` VALUES (1,0,'手机','/storage/category/bc\\91231321a92a7a6a6db99fa7db8f37.png',1),(7,0,'厨具','/storage/category/01\\c7232eb931fa3dd40f8b4946bd27fa.jpg',1),(8,7,'电饭锅','/storage/category/2b\\edd18255c4efcfc4a9982ce33671be.jpg',1),(9,0,'服装','/storage/category/f6\\655e2bed6b7bea027fb69a3c11a27c.jpg',1),(10,9,'女装','/storage/category/84\\f9e13fa3a6093990bf3de4e2da74a0.jpg',1),(11,1,'华为','/storage/category/b4\\a403d9874ed426bd5210a2f42c33f0.jpg',1);
/*!40000 ALTER TABLE `cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `code`
--

DROP TABLE IF EXISTS `code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL,
  `code` char(4) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code`
--

LOCK TABLES `code` WRITE;
/*!40000 ALTER TABLE `code` DISABLE KEYS */;
INSERT INTO `code` VALUES (1,'15588608866','1094','61.160.206.71',1594110316),(2,'15275245301','9513','61.160.206.71',1594110989),(3,'15275245301','3782','61.160.206.118',1594112227),(4,'15588608866','4754','183.213.75.204',1594797526),(5,'15588608866','3555','183.213.75.204',1594973555),(6,'15588608866','9929','183.213.75.125',1596529264);
/*!40000 ALTER TABLE `code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `content` varchar(100) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,3,'很好 不错 物美价廉',1596529447);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `express`
--

DROP TABLE IF EXISTS `express`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `exp_no` varchar(50) NOT NULL,
  `exp_com` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `express`
--

LOCK TABLES `express` WRITE;
/*!40000 ALTER TABLE `express` DISABLE KEYS */;
INSERT INTO `express` VALUES (1,1,'12312312312','yd');
/*!40000 ALTER TABLE `express` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `goods_img` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `goods_price` decimal(8,2) NOT NULL,
  `is_show` tinyint(4) NOT NULL,
  `goods_introduce` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (2,'纤伊寻雪纺连衣裙女2020春夏新款韩版碎花裙子时尚V领很仙的小个子连衣裙 白花色 L','/storage/goods/f6/655e2bed6b7bea027fb69a3c11a27c.jpg',8,0.01,1,'  <p>商品详情</p><p><img src=\"/storage/goods/ed\\e51d8a0f3fad9ddea11880e2903ab1.jpg\" style=\"max-width:100%;\"></p><p><img src=\"/storage/goods/9e\\3a9cb6f37f31b35076c1bb6cfab249.jpg\" style=\"max-width:100%;\"></p>'),(3,'法国KJ蕾丝聚拢文胸套装刺绣薄款无钢圈插片式调整型小胸内衣舒适透气文胸 聚拢虾粉色1 75B=34B(配内裤)','/storage/goods/84\\f9e13fa3a6093990bf3de4e2da74a0.jpg',8,0.01,1,' <p>商品详情</p><p><img src=\"/storage/goods/13\\2ad82b0d415a8dcab51e525925212a.jpg\" style=\"max-width:100%;\"></p><p><img src=\"/storage/goods/80\\a81fa79b6a0f0f84ba705cb31aa32d.jpg\" style=\"max-width:100%;\"></p><p><br></p>'),(4,'浪莎打底袜 120D天鹅绒收腹提臀美腿显瘦加档连裤袜 1双 肤色 120D收腹提臀','/storage/goods/f6\\655e2bed6b7bea027fb69a3c11a27c.jpg',10,56.00,1,'<p>商品详情</p><p><img src=\"/storage/goods/63\\ebb026ad52963f53e0ae851d6e42f7.jpg\" style=\"max-width:100%;\"></p><p><img src=\"/storage/goods/ed\\e51d8a0f3fad9ddea11880e2903ab1.jpg\" style=\"max-width:100%;\"></p>'),(5,'纤伊寻雪纺连衣裙女2020春夏新款韩版碎花裙子时尚V领很仙的小个子连衣裙 白花色 L','/storage/goods/84\\f9e13fa3a6093990bf3de4e2da74a0.jpg',10,89.00,1,'<p>商品详情</p><p><img src=\"/storage/goods/80\\a81fa79b6a0f0f84ba705cb31aa32d.jpg\" style=\"max-width:100%;\"></p><p><img src=\"/storage/goods/9e\\3a9cb6f37f31b35076c1bb6cfab249.jpg\" style=\"max-width:100%;\"></p>'),(6,'Redmi 8 5000mAh大电量 大字体大音量大内存 3D四曲面机身 AI双摄 骁龙八核处理器 AI人脸解锁 3GB+32GB 碳岩灰 游戏智能手机 小米','/storage/goods/b4\\a403d9874ed426bd5210a2f42c33f0.jpg',11,789.00,1,'<p>商品详情</p><p><img src=\"/storage/goods/63\\ebb026ad52963f53e0ae851d6e42f7.jpg\" style=\"max-width:100%;\"></p><p><img src=\"/storage/goods/f7\\b1f9e85e6b945be48e174f9260b909.jpg\" style=\"max-width:100%;\"></p>'),(7,'OUHEN轻奢品牌女装 小个子印花连衣裙女2020夏季新款遮肚减龄气质时尚收腰显瘦短款裙子 白色黑花 160/M','/storage/goods/84\\f9e13fa3a6093990bf3de4e2da74a0.jpg',10,56.00,1,'<p>商品详情</p><p><img src=\"/storage/goods/ed\\e51d8a0f3fad9ddea11880e2903ab1.jpg\" style=\"max-width:100%;\"></p><p><img src=\"/storage/goods/6f\\9c4f90bae503b687b9776fd2170e93.jpg\" style=\"max-width:100%;\"></p>'),(8,'浪莎打底袜 120D天鹅绒收腹提臀美腿显瘦加档连裤袜 1双 肤色 120D收腹提臀','/storage/goods/84\\f9e13fa3a6093990bf3de4e2da74a0.jpg',10,345.00,1,'<p>商品详情</p><p><img src=\"/storage/goods/13\\2ad82b0d415a8dcab51e525925212a.jpg\" style=\"max-width:100%;\"></p><p><img src=\"/storage/goods/6f\\9c4f90bae503b687b9776fd2170e93.jpg\" style=\"max-width:100%;\"></p>'),(9,'绣球花盆栽室内外阳台绿植花卉绣球花苗庭院地栽植物变色无尽夏重瓣八仙花苗四季种植循环开花耐寒幸运花 无尽夏 2年苗','/storage/goods/b4\\a403d9874ed426bd5210a2f42c33f0.jpg',11,89.00,1,'<p>商品详情</p><p><img src=\"/storage/goods/ed\\e51d8a0f3fad9ddea11880e2903ab1.jpg\" style=\"max-width:100%;\"></p><p><img src=\"/storage/goods/63\\ebb026ad52963f53e0ae851d6e42f7.jpg\" style=\"max-width:100%;\"></p>'),(10,'浪莎打底袜 120D天鹅绒收腹提臀美腿显瘦加档连裤袜 1双 肤色 120D收腹提臀','/storage/goods/84\\f9e13fa3a6093990bf3de4e2da74a0.jpg',11,899.00,1,'<p>商品详情</p><p><img src=\"/storage/goods/ed\\e51d8a0f3fad9ddea11880e2903ab1.jpg\" style=\"max-width:100%;\"></p><p><img src=\"/storage/goods/9e\\3a9cb6f37f31b35076c1bb6cfab249.jpg\" style=\"max-width:100%;\"></p>');
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` char(13) NOT NULL,
  `trade_no` varchar(100) DEFAULT NULL,
  `goods_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `addr_id` int(11) NOT NULL,
  `goods_price` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `is_pay` tinyint(4) DEFAULT '0',
  `is_exp` tinyint(4) DEFAULT '0',
  `is_rec` tinyint(4) DEFAULT '0',
  `is_comment` tinyint(4) DEFAULT '0',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'1596529307510','2020080422001455971430312468',3,1,8,0.01,1,0.01,1,1,1,1,1596529307);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swiper`
--

DROP TABLE IF EXISTS `swiper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swiper` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `swiper_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `img_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `swiper_order` int(11) NOT NULL,
  `is_show` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swiper`
--

LOCK TABLES `swiper` WRITE;
/*!40000 ALTER TABLE `swiper` DISABLE KEYS */;
INSERT INTO `swiper` VALUES (3,'空调促销','/storage/swiper/d3\\99a0533e2e96aec0f0c489b5979858.jpg',23,1),(5,'手机','/storage/swiper/50\\3b4d3cff4c75444ab8480048c14e95.jpg',34,1);
/*!40000 ALTER TABLE `swiper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL,
  `is_frozen` tinyint(4) NOT NULL,
  `login_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'15588608866',1,1596529273);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-04 16:36:32
