<?php
header("Content-Type: text/html; charset=gbk");
?>
<script language='javascript'>
function checkform()
{

	if(document.regform.name.value==""){
		alert("�û���û��д");
		return;
	}
	if(document.regform.passwd.value!=document.regform.passwd2.value){
		alert("�������벻һ��!");
		return;
	}
	document.regform.submit();

}
function show(url) 
{ 
	window.open(url,'','height=100,width=250,resize=no,scrollbars=no,toolsbar=no,top=200,left=200');
}
function check_user()
{
	show('check_user.php?name='+document.regform.name.value);
}
</script>
<form action='newuser.php' method='post' name='regform'>
�û���:<input type=text name='name'> <input type=button onclick="check_user()" value="����û���"><br>
����: <input type='password' name='passwd'><br>
ȷ������:<input type='password' name='passwd2'><br>
�ռ�����:<select name='type'>
<?php
include("./config.php");
reset($space_type);
while (list($name, $val) = each($space_type)) {
	echo "<option value='".$val."'>".$name."</option>\n";
}
?>
</select>
<input type="button"  onclick=checkform() value="ȷ��"> 
</form>
