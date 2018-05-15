<?php
namespace app;
use Point;
class Polygon{
	private $polygon = [];

	/*初始化*/
	public function __construct(Array $data)
	{
		foreach ($data as $value) {
			if($value instanceof \app\Point){
				$this->polygon[] = $value;
			}
		}
	}

	/*设置点 */
	public function setPoint($num,Point $point)
	{
		$this->polygon[$num] = $point;
	}

	/*获取点 */
	public function getPoint($num)
	{
		return $this->polygon[$num];
	}

	/*获取多边形点*/
	public function getPath()
	{
		return $this->polygon;
	}
}