<?php
needRole('admin');
class MailControl extends control
{
	public function send()
	{
		$subject = $_REQUEST['mail_subject'];
		$body = $_REQUEST['mail_body'];
		if ($_REQUEST['address']) {
			$address = explode(',', $_REQUEST['address']);
			
		}else{
			$address = daocall('user','getAllMail',array());
		}
		if (count($address) < 0 ) {
			echo "nothing address need Send<br>";
			return false;
		}
		if (!apicall('mail','sendMail',array($address,$subject,$body))) {
			exit("发送失败");
		}
		die("发送成功");
	}
	public function sendMailFrom()
	{
		return $this->_tpl->fetch('mail/send.html');
	}
	public function getTemplete()
	{
		$templete = $_REQUEST['templete'];
		$setting = daocall('setting','getAll2',array());
		$resutl['subject'] = $setting[$templete."_subject"];
		$resutl['body'] = $setting[$templete."_body"];
		return json_decode($resutl);
		
	}
	public function mailFrom()
	{
		$mail_body = "尊敬的{{user}}客户: 您在本网购买的{{vhost}}产品还有七天到期，为了不影响您的产品使用，请及时续费.";
		$mail_subject = "尊敬的{{user}}客户: 您在本网购买的{{vhost}}产品还有七天到期";
		$this->_tpl->assign('mail_body',$mail_body);
		$this->_tpl->assign('mail_subject',$mail_subject);
		$setting = daocall('setting','getAll2',array());
		$this->_tpl->assign('setting',$setting);
		return $this->_tpl->fetch('mail/index.html');
	}
	public function setMail()
	{
		if ($_REQUEST['mail_username']) {
			daocall('setting','add',array('mail_username',$_REQUEST['mail_username']));
		}
		if ($_REQUEST['mail_host']) {
			daocall('setting','add',array('mail_host',$_REQUEST['mail_host']));
		}
		if ($_REQUEST['mail_port']) {
			daocall('setting','add',array('mail_port',$_REQUEST['mail_port']));
		}
		if ($_REQUEST['mail_secure']) {
			daocall('setting','add',array('mail_secure',$_REQUEST['mail_secure']));
		}
		if ($_REQUEST['mail_passwd']) {
			daocall('setting','add',array('mail_passwd',$_REQUEST['mail_passwd']));
		}
		if ($_REQUEST['mail_from']) {
			daocall('setting','add',array('mail_from',$_REQUEST['mail_from']));
		}
		if ($_REQUEST['mail_fromname']) {
			daocall('setting','add',array('mail_fromname',$_REQUEST['mail_fromname']));
		}
		if ($_REQUEST['mail_smtp']) {
			daocall('setting','add',array('mail_smtp',$_REQUEST['mail_smtp']));
		}
		if ($_REQUEST['mail_subject']) {
			daocall('setting','add',array('mail_subject',$_REQUEST['mail_subject']));
			daocall('setting','add',array('mail_body',$_REQUEST['mail_body']));
		}
		return $this->mailFrom();
	}
	public function test()
	{
		apicall('mail','sendExMail',array());
	}
	
}
?>