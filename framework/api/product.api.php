<?php

class ProductAPI extends API
{
	public function __construct()
	{
		load_lib('pub:product');
		parent::__construct();
	}
	/**
	 * 析构函数 **/
	public function __destruct()
	{
		parent::__destruct();
	}
	protected function getVhostProducts(&$products)
	{
		$products[]=array('name'=>'--虚拟主机产品--','type'=>'','id'=>0);
		$data = daocall('vhostproduct', 'getSellProducts', null);
		for($i=0;$i<count($data);$i++){
			$products[] = array('name'=>$data[$i]['name'],'type'=>'vhost','id'=>$data[$i]['id']);
		}		
	}
	/**
	 * @deprecated 请使用product.lib.php接口
	 * @param unknown_type $id
	 */
	public function getVhostProduct($id)
	{
		load_conf('pub:vhostproduct');
		$vproducts = $GLOBALS['vhostproduct_cfg'][$id];
		if(is_array($vproducts)){
			return $vproducts;
		}
		return false;
	}
	/**
	 * @deprecated 未来，请使用product.lib.php接口
	 */
	public function flushVhostProduct()
	{
		$products = daocall('vhostproduct','getProducts',array(0));
		return apicall('utils','writeConfig',array($products,'id','vhostproduct'));
	}
	public function getProductList()
	{
		return daocall('vhostproduct','getProductList',array());
	}
	public function getProducts()
	{
			$products = array();
			$this->getVhostProducts($products);
			return $products;
	}
	/**
	 * 依据$product_type产生一个Product类
	 */
	public function newProduct($product_type)
	{
		$className = $product_type.'Product';
		$lib = 'pub:'.$className;
		load_lib($lib);
		$className[0] = strtoupper($className[0]);
		return new $className;
	}
}
?>