-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- ����: localhost
-- ��������: 2010 �� 12 �� 20 �� 21:19
-- �������汾: 5.0.77
-- PHP �汾: 5.1.6
-- 
-- ���ݿ�: `kangle`
-- 

-- --------------------------------------------------------

-- 
-- ��Ľṹ `admin_users`
-- 

CREATE TABLE `admin_users` (
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `last_login` varchar(255) default NULL,
  `last_ip` varchar(255) default NULL,
  `rights` int(11) NOT NULL default '0',
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='����Ա�б�';

-- --------------------------------------------------------

-- 
-- ��Ľṹ `domain`
-- 

CREATE TABLE `domain` (
  `name` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL default '/',
  UNIQUE KEY `domain` (`domain`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- ��Ľṹ `nodes`
-- 

CREATE TABLE `nodes` (
  `name` varchar(32) NOT NULL,
  `host` varchar(64) NOT NULL,
  `port` int(11) NOT NULL,
  `user` varchar(32) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `db_user` varchar(255) default NULL,
  `db_passwd` varchar(255) default NULL,
  `state` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='������';

-- --------------------------------------------------------

-- 
-- ��Ľṹ `shopping_cart`
-- 

CREATE TABLE `shopping_cart` (
  `id` bigint(20) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `product_type` tinyint(4) NOT NULL,
  `state` tinyint(4) NOT NULL default '0',
  `price` int(11) NOT NULL,
  `param` varchar(255) NOT NULL,
  `mem` text NOT NULL,
  `month` int(11) NOT NULL,
  `add_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='���ﳵ' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- ��Ľṹ `users`
-- 

CREATE TABLE `users` (
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `email` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `money` int(11) NOT NULL default '0',
  `id` varchar(255) default NULL,
  `regtime` datetime NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='�û��б�';

-- --------------------------------------------------------

-- 
-- ��Ľṹ `vhost`
-- 

CREATE TABLE `vhost` (
  `name` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `doc_root` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL auto_increment,
  `gid` varchar(32) NOT NULL default '1100',
  `templete` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `state` tinyint(4) NOT NULL default '0',
  `node` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `name` (`name`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='����������' AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

-- 
-- ��Ľṹ `vhost_product`
-- 

CREATE TABLE `vhost_product` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `describe` text,
  `templete` varchar(32) NOT NULL,
  `web_quota` bigint(11) NOT NULL,
  `db_type` tinyint(4) NOT NULL default '1',
  `db_quota` bigint(20) NOT NULL default '0',
  `price` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL default '0',
  `node` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='��Ʒ�б�' AUTO_INCREMENT=8 ;
