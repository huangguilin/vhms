<?php
session_start();
header("Content-Type: text/html; charset=gbk");
?>
���:<?php echo $_SESSION["name"];?>
<br><br>
<table>
<tr><td><a href='main.php' target='mainFrame'>��Ϣ</a></td></tr>
<tr><td><a href='domain.php' target='mainFrame'>������</a></td></tr>
<tr><td><a href='changepassword.php' target='mainFrame'>�޸�����</a></td></tr>
<tr><td><a href='logout.php' target='_top'>�˳�</a></td></tr>
</table>
