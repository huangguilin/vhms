<?php
session_start();
header("Content-Type: text/html; charset=gbk");
echo "[<a href='http://".$_SESSION["name"].".kanglesoft.com:81/' target=_blank>�ռ����</a>]<br>";
echo "�û���:".$_SESSION["name"]."<br>";
echo "��Ŀ¼:".$_SESSION["doc_root"]."<br>";
echo "�ռ�����:".$_SESSION["templete"]."<br>";
echo "ftp������:".$_SESSION["name"].".kanglesoft.com �˿�:21<br>";
?>
<pre>
�ռ�ע������:
1.���ϴ��ļ���www��Ŀ¼��

</pre>
