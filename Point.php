<?php
namespace app;
class Point{
	public $lng;
	public $lat;

	/*初始化*/
	public function __construct($lng=117.181196,$lat=31.81406)
	{
		$this->lng = $lng;
		$this->lat = $lat;
	}

	// /*设置私有属性 */
	// public function __set($name,$value)
	// {
	// 	$this->$name = $value;
	// }

	// /*获取私有属性 */
	// public function __get($name)
	// {
	// 	return $this->$name;
	// }

	/*比较两个点是否一样*/
	public function equals(Point $p)
	{
		if($p->lng == $this->lng && $p->lat == $this->lat){
			return true;
		}
		return false;
	}
}