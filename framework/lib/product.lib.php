<?php
/**
 *
 * 产品抽象类
 * 一种产品类型
 * @author Administrator
 *
 */
abstract class Product
{
	/**
	 * 计算金额
	 * @param $price 每年的价格
	 * @param $month 月份
	 */
	public function caculatePrice($price,$month)
	{
		if($this->isYears($month)){
			return $price*$month/12;
		}
		$price=$price/12;
		$price*=$month;
		if ($month==1) {
			//	$price*=1.5;
		}
		return $price;
	}
	/**
	 *
	 * 得到代理价格,
	 * @return false 失败
	 * @param int $agent_id
	 * @param int $prouct_type
	 * @param int $product_id
	 * @param int $price 最终用户价
	 */
	private function getAgentPrice($agent_id,$product_type,$product_id,$price)
	{
		$arr['agent_id'] = $agent_id;
		$arr['product_type'] = $product_type;
		$arr['product_id'] = $product_id;
		$agentinfo=daocall('agentprice','getAgentprice',array($arr));
		$agent_price = intval($agentinfo[0]['price']);
		if ($agent_price<=0 && $agent_price!=$price) {
			trigger_error('代理价格没有设置，请联系管理员');
			return false;
		}
		return $agent_price;
	}
	/*
	 * 判断月份是否为整年
	 */
	public function isYears($month)
	{
		return $month/12*12==$month;
	}
	/**
	 *
	 * 续费操作
	 * @param $username
	 * @param $susername
	 * @param $month
	 */
	public function renew($username,$susername,$month)
	{
		global $default_db;
		$suser = $this->getSuser($susername);
		if(!$suser || $suser['username']!=$username){
			trigger_error('不是你的产品哦');
			return false;
		}
		$info = $this->getInfo($suser['product_id']);
		if(!$info){
			trigger_error('产品错误');
			return false;
		}
		if ($month > 0) {
			if($info['month_flag'] != 0 && !$this->isYears($month)){
				trigger_error('该产品不支持月付');
				return false;
			}
		}
//		if($month<=0){
//			trigger_error('月份错误');
//			return false;
//		}
		$mem = $susername." 续费 ".$month." 个月";//扣费备注

		//处理代理价格，如果有代理，按代理价格扣费，否则按正常价格
		$userinfo = daocall('user','getUser',array($username));
		if ($userinfo['agent_id'] > 0) {
			$price = $this->getAgentPrice($userinfo['agent_id'],intval($info['product_type']),$suser['product_id'],$info['price']);
			if ($price===false) {
				echo "该产品代理价格未设置，请联系管理员";
				return false;
			}
			$price = $this->caculatePrice($price,$month);
			$mem.="(agent)";
		} else {
			$price = $this->caculatePrice($info['price'],$month);
		}

		if($price<0){
			trigger_error('价格错误');
			return false;
		}
		daocall('product','open_db');
		if($default_db==null){
			trigger_error('没有连接数据库');
			return false;
		}
		/*
		 * 开始事务
		 */
		if(!$default_db->beginTransaction()){
			trigger_error('开始事务失败');
			return false;
		}
		//echo "haha";
		
		if($price>0 && !apicall('money','decMoney', array($username,$price,$mem))){
			$default_db->rollBack();
			trigger_error('余额不足,所需金额:'.($price/100));
			return false;
		}
		if(!$this->addMonth($susername,$month)){
			$default_db->rollBack();
			trigger_error('续费产品出错');
			return false;
		}
		if($default_db->commit()){
			$this->resync($username,$suser,$info);
			//续费后是否开通空间
			if (daocall('setting','get',array('set_renew'))==1) {
				$suser['status'] = 0;
			}
			$attr['try_is'] = 0;
			daocall('vhost','updateVhost',array($susername,$attr));
			return true;
		}
		return false;
	}
	/**
	 * 产品升级扣费
	 * Enter description here ...
	 * @param $username
	 * @param $susername
	 * @param $new_product_id
	 */
	public function upgrade($username,$susername,$new_product_id)
	{
		//产品升级操作
		global $default_db;
		
		$suser = $this->getSuser($susername);
		if(!$suser || $suser['username']!=$username){
			trigger_error('不是你的产品哦');
			return false;
		}
		$info = $this->getInfo($suser['product_id']);
		if(!$info){
			trigger_error('产品错误');
			return false;
		}
		
		$ninfo = $this->getInfo($new_product_id);
		$mem =$susername."从".$info['name']." 升级至 ".$ninfo['name'];//扣费备注
		
		//计算差价
		//处理代理，如果有代理，按代理的价格来扣费，否则按正常价格
		$userinfo = daocall('user','getUser',array($username));
		if ($userinfo['agent_id'] > 0) {
			$old_agent_price = $this->getAgentPrice($userinfo['agent_id'],intval($info['product_type']),$suser['product_id'],$info['price']);
			if ($old_agent_price===false) {
				return false;
			}
			$new_agent_price = $this->getAgentPrice($userinfo['agent_id'],intval($info['product_type']),$new_product_id,$ninfo['price']);
			if ($new_agent_price===false) {
				echo "该产品代理价格未设置，请联系管理员";
				return false;
			}
			$diff_price = $new_agent_price - $old_agent_price;
			$mem.="(agent)";
		} else {
			$diff_price = $ninfo['price'] - $info['price'];
		}

		if ($diff_price<0) {
			trigger_error('升级产品价格错误,请联系管理员');
			return false;
		}
		$expire_time = strtotime($suser['expire_time']);
		$month = ($expire_time - time())/(30*24*3600);
		//die("expire_time=".$suser['expire_time']." ".$expire_time." month=".$month);
		$price = $this->caculatePrice($diff_price,$month);
		
		if($price<0){
			trigger_error('价格错误');
			return false;
		}
		daocall('product','open_db');
		if($default_db==null){
			trigger_error('没有连接数据库');
			return false;
		}
		
		/*
		 * 开始事务
		 */
		if(!$default_db->beginTransaction()){
			trigger_error('开始事务失败');
			return false;
		}

		if($price>0 && !apicall('money','decMoney', array($username,$price,$mem))){
			$default_db->rollBack();
			trigger_error('余额不足,所需金额:'.($price/100));
			return false;
		}
		if(!$this->changeProduct($susername,$ninfo)){
			$default_db->rollBack();
			trigger_error('续费产品出错');
			return false;
		}
		if($default_db->commit()){
			$this->resync($username,$suser,$info,$ninfo);
			return true;
		}
		return false;
	}
	/**
	 * 购买产品
	 * @param $user 用户名
	 * @param $product_id 产品ID
	 * @param $suser 产品参数
	 */
	public function sell($username,$product_id,$suser)
	{
		global $default_db;
		
		if(!$this->checkParam($username, $suser)){
			return false;
		}
		
		$month = $suser['month'];
		if ($month < 0) {
			$product_info = daocall('vhostproduct','getProduct',array($product_id));
			if ($product_info['try_on'] == 0) {
				trigger_error('该产品不支持试用');
				return false;
			}
		}
		$info = $this->getInfo($product_id);
		
		if(!$info){
			trigger_error('产品错误');
			return false;
		}
		if($info['pause_flag']!=0){
			trigger_error('该产品不能购买');
			return false;
		}
		if ($month > 0){
			if($info['month_flag']!=0 && !$this->isYears($month)){
				trigger_error('该产品不支持月付');
				return false;
			}
		}
//		if($month<=0){
//			trigger_error('月份错误');
//			return false;
//		}
		
		//更改模板
		if($suser['subtemplete']) {
			$info['subtemplete'] = $suser['subtemplete'];
		}
		if ($month > 0) {
			$mem = "购买 ".$suser['name']." ".$month." 个月";
		}else{
			$mem = "试用 ".$suser['name'];
		}
		//处理代理，如果有代理，按代理的价格来扣费，否则按正常价格
		$userinfo = daocall('user','getUser',array($username));
		if ($userinfo['agent_id'] > 0) {
			$price = $this->getAgentPrice($userinfo['agent_id'],intval($info['product_type']),$product_id,$info['price']);
			if ($price===false) {
				echo "该产品代理价格未设置，请联系管理员";
				return false;
			}
			$price = $this->caculatePrice($price,$month);
			$mem.="(agent)";
		}else{
			$price = $this->caculatePrice($info['price'],$month);
		}
		if ($month > 0) {
			if($price < 0){
				trigger_error('价格错误');
				return false;
			}
		}
		if($default_db==null){
			return false;
		}
		
		/*
		 * 开始事务
		 */
		if(!$default_db->beginTransaction()){
			return false;
		}
		if ($month > 0) {
			if($price > 0 && !apicall('money','decMoney', array($username,$price,$mem))){
				$default_db->rollBack();
				trigger_error('余额不足,所需金额:'.($price/100));
				return false;
			}
		}
		if(!$this->create($username,$suser,$info)){
			$default_db->rollBack();
			trigger_error('开通产品出错');
			return false;
		}
		if($default_db->commit()){
			$this->sync($username,$suser,$info);
			if ($month < 0) {
				$attr['try_is'] = 1;
				daocall('vhost','updateVhost',array($suser['name'],$attr));//将空间改为试用类型
				daocall('moneyout','add',array($suser['name'],0,$mem));
			}
			return true;
		}
		return false;
	}
	/**
	 * 得到产品信息
	 * @param $product_id 产品ID
	 */
	abstract public function getInfo($product_id,$susername = null);
	/**
	 * 给付产品,这一步只插入数据库
	 * @param  $user
	 * @param  $product_id
	 * @param  $month
	 * @param  $param
	 * @param  $params
	 */
	abstract protected function create($username,&$suser=array(),$product_info=array());
	/**
	 *
	 * 更新用户数据
	 * @param $susername  用户名
	 * @param $month      月份
	 * @param $product_id 新产品ID,如果是0，则不更新
	 */
	abstract protected function addMonth($susername,$month);
	/**
	 *
	 * 更改产品类型
	 * @param $susername
	 * @param $product_id
	 */
	abstract protected function changeProduct($susername,$product_id);
	/**
	 * 同步产品到磁盘或者远程
	 * @param  $user
	 * @param  $param
	 */
	abstract public function sync($username,$suser,$product_info);
	abstract protected function resync($username,$suser,$oproduct,$nproduct=null);
	abstract public function getSuser($susername);
	abstract public function checkParam($username,$suser);
}
?>