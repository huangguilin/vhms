<?php
include_once("./connect.php");
include_once("./utils.php");
header("Content-Type: text/html; charset=gbk");
$user = $_REQUEST["name"];
if(!ereg($right_user_name,$user)){
	die("�û����д���!(��Сд��Ӣ����ĸ��������ɣ�������3-16λ)");
}
if(check_exsit_user($user)){
	echo "<font color=red>�û���:".$user."�Ѿ�������ע����!</font>";
}else{
	echo "<font color=blue>�û���:".$user."����ע�ᣡ</font>";
}
?>
