<?php
include("./check_login.php");
include("./connect.php");
$domain=$_REQUEST["domain"];
$sql = "select dir from domain where domain='".$domain."' and name='".$_SESSION["name"]."'";
$rs = mysql_fetch_array(mysql_query($sql,$cn));
if(!$rs){
	die("û�и�����:".$domain);
}
?>
�޸�����:<?php echo $domain;?>
<form action='do.php?action=edit&domain=<?php echo $domain;?>' method='post'>
Ŀ¼:<input name='dir' value='<?php echo $rs["dir"];?>'>
<input type=submit value='�޸�'>
</form>
