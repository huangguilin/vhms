<?php
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', 'localhost');
define('UC_DBUSER', 'root');
define('UC_DBPW', 'iamkyj99');
define('UC_DBNAME', 'ucenter');
define('UC_DBCHARSET', 'gbk');
define('UC_DBTABLEPRE', '`ucenter`.ucenter_');
define('UC_DBCONNECT', '0');
define('UC_KEY', '4e29eukzU4AsyfUWCgmQ3hHCSfMp3Vi3HPSM8Pk');
define('UC_API', 'http://127.0.0.98/uc_server');
define('UC_CHARSET', 'gbk');
define('UC_IP', '');
define('UC_APPID', '3');
define('UC_PPP', '20');


/*
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', 'localhost');
define('UC_DBUSER', 'root');
define('UC_DBPW', 'iamkyj99');
define('UC_DBNAME', 'ucenter');
define('UC_DBCHARSET', 'gbk');
define('UC_DBTABLEPRE', '`ucenter`.ucenter_');
define('UC_DBCONNECT', '0');
define('UC_KEY', '63886pbisyhaVADWsKWOb9tZEbqn4NgDXMH6RdA');
define('UC_API', 'http://127.0.0.98/uc_server');
define('UC_CHARSET', 'gbk');
define('UC_IP', '');
define('UC_APPID', '2');
define('UC_PPP', '20');
*/



			// ��ǰӦ�õ� ID

$dbhost = 'localhost';		// ���ݿ������
$dbuser = 'root';			// ���ݿ��û���
$dbpw = 'iamkyj99';			// ���ݿ�����
$dbname = 'ucenter';			// ���ݿ���
$pconnect = 0;				// ���ݿ�־����� 0=�ر�, 1=��
$tablepre = 'ucenter_';   	// ����ǰ׺, ͬһ���ݿⰲװ�����̳���޸Ĵ˴�
$dbcharset = 'gbk';			// MySQL �ַ���, ��ѡ 'gbk', 'big5', 'utf8', 'latin1', ����Ϊ������̳�ַ����趨
							//ͬ����¼ Cookie ����
$cookiedomain = ''; 		// cookie ������
$cookiepath = '/';			// cookie ����·��