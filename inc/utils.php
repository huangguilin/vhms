<?php
$right_user_name="^[a-z0-9]{3,12}$";
function check_exsit_user($user)//���$user�Ƿ����ע��
{
	global $cn;
	$bad_user=array("test","www","bbs");
	for($i=0;$i<count($bad_user);$i++){
		if($bad_user[$i]==$user){
			return true;//	die("ע����󣬸��û����Ѳ���ˡ�<a href='javascript:history.go(-1)'>����</a>");
		}
	}
	$sql="select 1 from users where name='".$user."'";
	if(@mysql_fetch_array(@mysql_query($sql,$cn))){
		return true;
	}
	return false;
}
?>
