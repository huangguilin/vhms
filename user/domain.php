<?php
include("./check_login.php");
include("./connect.php");
$domain=$_REQUEST["domain"];
$sql = "select domain,dir from domain where name='".$_SESSION["name"]."'";

?>
<table><tr><td>
<form action='do.php?action=add' method='post'>
����:<input name='domain' value=''>Ŀ¼:<input name='dir' value='www'>
<input type=submit value='����'>
</form>
</td></tr></table>

<table><tr><td>����</td><td>����</td><td>Ŀ¼</td></tr>
<?php
//echo $sql."<br>";
$result = mysql_query($sql,$cn);
while($rs=mysql_fetch_array($result)){
?>
<tr><td>[<a href='edit.php?domain=<?php echo $rs["domain"];?>'>�޸�</a>] [<a href='do.php?action=del&domain=<?php echo $rs["domain"];?>'>ɾ��</a>]</td>
<td><?php echo $rs["domain"];?></td>
<td><?php echo $rs["dir"];?></td>
</tr>
<?php
}
?>
