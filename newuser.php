<?php
include_once("./connect.php");
include_once("./whm.php");
include_once("./utils.php");
function make_user_doc_root($user)
{
        return "/home/ftp/".$user[0]."/".$user;
}
$user = $_REQUEST["name"];
if(check_exsit_user($user)){
	die("���û��Ѿ�ע����");
}
$passwd = md5($_REQUEST["passwd"]);
$templete = $_REQUEST["type"];
$doc_root = make_user_doc_root($user);
$sql = "insert into users (name,passwd,doc_root,templete) values ('".$user."','".$passwd."','".$doc_root."','".$templete."')";
mysql_query($sql,$cn);
$rs = mysql_fetch_array(mysql_query("select uid,gid from users where name='".$user."'"));
/*
����whm����ʼ���û�����
*/
$call = new WhmCall("init_vh".$templete);
$call->addParam("name",$user);
$call->addParam("doc_root",$doc_root);
$call->addParam("uid",$rs["uid"]);
$call->addParam("gid",$rs["gid"]);
$whm->call($call);
echo "ע��ɹ�.<a href='index.php'>�������¼����</a>";
?>
