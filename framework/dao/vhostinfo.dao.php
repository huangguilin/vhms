<?php
class VhostinfoDAO extends DAO
{
	public function __construct()
	{
		parent::__construct();
		$this->MAP_ARR 	= array(
			"user" => 'user',
			'type'=> 'type',
			"name" => 'name',
			"value"=> 'value'
			);
			$this->MAP_TYPE = array(
			'type'=>FIELD_TYPE_INT
			);
			$this->_TABLE = DBPRE . 'vhost_info';
	}
	public function findDomain($domain)
	{
		$where = $this->getFieldValue2('name',$domain)." AND ".$this->getFieldValue2('type', 0);
		return $this->getData2(array('name'),$where);
	}
	public function delInfo($user,$name,$type,$value)
	{
		$where = $this->getFieldValue2('user',$user);
		$where.=' AND '.$this->getFieldValue2('type', 0);
		$where.=' AND '.$this->getFieldValue2('name', $name);
		if($value!=null){
			$where.=' AND '.$this->getFieldValue2('value', $value);
		}
		return $this->delData($where);
	}
	public function addInfo($user,$name,$type,$value)
	{
		return $this->insertData(array('user'=>$user,'name'=>$name,'type'=>$type,'value'=>$value));
	}
	public function getInfo($name)
	{
		$where = $this->getFieldValue2('user',$name);
		return $this->getData2(array('name','type','value'),$where);
	}
	public function getDomain($name)
	{
		$where = $this->getFieldValue2('user',$name)." AND ".$this->getFieldValue2('type', 0);
		return $this->getData2(array('name','value'),$where);
	}
	public function delDomain($name,$domain)
	{
		$where = $this->getFieldValue2('user',$name)." AND ".$this->getFieldValue2('type', 0);
		$where.=' AND ';
		$where.= $this->getFieldValue2('name', $domain);
		return $this->delData($where);
	}
	public function getLoadInfoSql()
	{
		$sql = "SELECT ".$this->MAP_ARR['type'].",".$this->MAP_ARR['name'].",".$this->MAP_ARR['value']." FROM ".$this->_TABLE." WHERE ".$this->MAP_ARR['user']."='%s'";
		return $sql;
	}
}
?>