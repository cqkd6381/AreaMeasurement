<?php
namespace app;
use Point;
use Polygon;
class GeoUtils{
	/**
	 *判断点是否多边形内
	 * @param {Point} point 点对象
	 * @param {Polyline} polygon 多边形对象
	 * @return {Boolean} 点在多边形内返回true,否则返回false
	 */
	public function isPointInPolygon(\app\Point $point, \app\Polygon $polygon)
	{
		// 检测类型
		
		// 首先判断点是否在多边形的外包矩形内，如果在，则进一步判断，否则返回false
		// $polygonBounds = $polygon->getBounds();
		// if(!$this->isPointInRect($point,$polygonBounds)){
		// 	return false;
		// }

		$pts = $polygon->getPath();//获取多边形点

		$N = count($pts);
		$boundOrVertex = true;//如果点位于多边形的顶点或边上，也算做点在多边形内，直接返回true
		$intersectCount = 0;//cross points count of x 
		$precision = 2e-10; //浮点类型计算时候与0比较时候的容差
		$p = $point;

		$p1 = $pts[0];//左顶点
		for ($i=1; $i < $N; ++$i) { 
			if($p->equals($p1)){
				echo "在顶点上<br>";
				return $boundOrVertex;//p在顶点上
			}
			$p2 = $pts[$i % $N];//右顶点
			//画一条纬度相同的线，该线和多边形相交于若干点，将点和相交线的两个端点逐一判断
			//1.如果点的纬度(lat上下)，小于最小的或大于最大的，不想交
			if($p->lat < $this->mathMin($p1->lat,$p2->lat) || $p->lat > $this->mathMax($p1->lat,$p2->lat)){
				$p1 = $p2;
				echo "continue<br>";
				continue;
			}
			//2.如果点的纬度(lat上下)，在线的两个端点的纬度之间，继续...
			if($p->lat > $this->mathMin($p1->lat,$p2->lat) && $p->lat < $this->mathMax($p1->lat,$p2->lat)){
				//2.如果点的经度(lat上下)，小于较大的经度，继续...
				if($p->lng <= $this->mathMax($p1->lng, $p2->lng)){
					if($p1->lat == $p2->lat && $p->lng >= $this->mathMin($p1->lng, $p2->lng)){
						echo "顶点上<br>";
						return $boundOrVertex;
					}

					if($p1->lng == $p2->lng){//ray is vertical
						if($p1->lng == $p->lng){//overlies on a vertical ray
	                        return $boundOrVertex;
	                    }else{//before ray
	                    	echo "++++1<br>";
	                        ++$intersectCount;
	                    } 
					}else{//cross point on the left side   
						$xinters = ($p->lat - $p1->lat) * ($p2->lng - $p1->lng) / ($p2->lat - $p1->lat) + $p1->lng;//cross point of lng                        
	                    if(abs($p->lng - $xinters) < $precision){//overlies on a ray
	                        return $boundOrVertex;
	                    }
	                    
	                    if($p->lng < $xinters){//before ray
	                    	echo "++++2<br>";
	                        ++$intersectCount;
	                    }
					}
				}
			//2.如果点的纬度(lat上下)，不在线的两个端点的纬度之间，继续...
			}else{
				if($p->lat == $p2->lat && $p->lng <= $p2->lng){//p crossing over p2                    
	                $p3 = $pts[($i+1) % $N]; //next vertex                    
	                if($p->lat >= $this->mathMin($p1->lat, $p3->lat) && $p->lat <= $this->mathMax($p1->lat, $p3->lat)){//p.lat lies between p1.lat & p3.lat
	                    ++$intersectCount;
	                    echo "++++3<br>";
	                }else{
	                    $intersectCount += 2;
	                }
	            }
			}
			$p1 = $p2;
		}
		echo $intersectCount."<br>";
		if($intersectCount % 2 == 0){//偶数在多边形外
            return false;
        } else { //奇数在多边形内
            return true;
        } 
	}

	/**
     * 判断点是否在矩形内
     * @param {Point} point 点对象
     * @param {Bounds} bounds 矩形边界对象
     * @returns {Boolean} 点在矩形内返回true,否则返回false
     */
	public function isPointInRect($point,$bounds)
	{
		$sw = $bounds->getSouthWest(); //西南脚点
        $ne = $bounds->getNorthEast(); //东北脚点
        return ($point->lng >= $sw->lng && $point->lng <= $ne->lng && $point->lat >= $sw->lat && $point->lat <= $ne->lat);
	}

	/**
	 *获取两个数中较大的数
	 */
	private function mathMax($m1,$m2)
	{
		if($m1 >= $m2){
			return $m1;
		}
		return $m2;
	}

	/**
	 *获取两个数中较小的数
	 */
	private function mathMin($m1,$m2)
	{
		if($m1 <= $m2){
			return $m1;
		}
		return $m2;
	}
}