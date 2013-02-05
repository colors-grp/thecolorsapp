<?php

class UtilityController extends Controller
{
	//array = (1,A), (2, B), (3,C) then  dimention#0 is {1,2,3}, dim#1 is {A,B,C}
	public static function get_kth_dimention(&$array, $k){
		$res = array();
		foreach ($array as $record) {
			array_push($res, $record[$k]);
		}
		return $res;
	}
	public static function siteUrl()
	{
		return "http://colors-studios.com/thecolorsapp/";
	}
			
}