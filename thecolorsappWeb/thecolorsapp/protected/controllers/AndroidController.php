<?php

class AndroidController extends Controller
{
	protected function build_insert_sql($table, $jsonArr){
		$res = 'insert into '.$table;
		$params = '';
		$val = '';
		$comma = '';
		foreach ($jsonArr as $key => $value) {
			$params .= $comma.$key;
			$val .= $comma."'".$value."'";
			$comma = ', ';
		}
		
		$res .= '('.$params.') values('.$val.');';
		return $res;
	}
	protected function build_update_sql($table, $jsonArr, $where){
		$res = 'update '.$table . ' SET ';
		$params = '';
		$comma = '';
		foreach ($jsonArr as $key => $value) {
			$params .= $comma.$key."='".$value."'";
			$comma = ', ';
		}
		
		$res .= $params .' WHERE ' . $where;
		return $res;
	}
	protected function build_delete_sql($table, $where){
		return 'delete from '.$table . ' where ' . $where;
	}
	protected function build_find_sql($table, $where){
		return 'select * from '.$table . ' where ' . $where;
	}
	//======================================
	
	public function actionInsert(){
		$table = $_POST['table'];
		$jsonArr = json_decode( $_POST['json'] );
		$dbconn = Yii::app()->db;
		$command = $this->build_insert_sql($table, $jsonArr);
		$rowCount = $dbconn->createCommand($command)->execute();
		print(json_encode(array('rowCount' => $rowCount)));		
	}
	public function actionUpdate(){
		$table = $_POST['table'];
		$jsonArr = json_decode( $_POST['json'] );
		$where = $_POST['where'];
		
		$dbconn = Yii::app()->db;
		$command = $this->build_update_sql($table, $jsonArr, $where);
		$rowCount = $dbconn->createCommand($command)->execute();
		print(json_encode(array('rowCount' => $rowCount)));		
	}
	public function actionDelete(){
		$table = $_POST['table'];
		$where = $_POST['where'];
		
		$dbconn = Yii::app()->db;
		$command = $this->build_delete_sql($table, $where);
		$rowCount = $dbconn->createCommand($command)->execute();
		print(json_encode(array('rowCount' => $rowCount)));		
	}
	public function actionFind(){
		$table = $_POST['table'];
		$where = $_POST['where'];
		
		$dbconn = Yii::app()->db;
		$command = $this->build_find_sql($table, $where);
		$queryResult = $dbconn->createCommand($command)->queryAll();
		$res = array();
		foreach ($queryResult as $row) {
			$sub=array();
			foreach ($row as $key => $value) {
				$sub[$key] = $value;
			}
			array_push($res, $sub);
		}		
		print json_encode($res);
	}
	public function actionGetImage(){
		$image = new Imagick('/1/nancyfbPP.jpg');
		echo $image;
	}
		
}