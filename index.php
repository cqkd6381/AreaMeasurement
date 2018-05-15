<?php
	namespace app;
	require 'GeoUtils.php';
	require 'Polygon.php';
	require 'Point.php';
	//多边形
	$data = [
		new Point(117.305442,31.876569),
		new Point(117.305298,31.848109),
     	new Point(117.315647,31.865039),
     	new Point(117.318809,31.849213),
     	new Point(117.324558,31.864671),
     	new Point(117.329732,31.851667),
     	new Point(117.331457,31.877795),
	];
	$polygon = new Polygon($data);
	// echo "<pre>";var_dump($polygon->getPath());exit;
	// $polygon_arr = $polygon->getPath();

	// $point = new Point(117.282445,31.853507);//左1
	// $point = new Point(117.306879,31.854243);//左2,5
	// $point = new Point(117.319096,31.856574);//左3,3
	// $point = new Point(117.328439,31.85866);//左4,1
	// $point = new Point(117.337494,31.860868);//左5
	$point = new Point(117.305442,31.876569);//点1
	// var_dump($point);
	//位置点
	$GeoUtils = new GeoUtils();
	$res = $GeoUtils->isPointInPolygon($point,$polygon);
	var_dump($res);

