<?php 

class db{

	protected $dbhost = 'localhost';
	protected $dbuser = 'mak';
	protected $dbpass = '8Xs7@D7d3#83qzBR';
	protected $db = 'mak';

	public $lastInsert;
	
	private $error_db = 'DB error';
	private $error_param = 'Parameter error';
	protected  $debug = false;
	
	private $sqlQuery;

	public function __construct($dbhost,$dbuser,$dbpass,$db,$names='utf8',$debug=false){
		
		if($dbhost != ''){
			$this->dbhost = $dbhost;
		}
		if($dbuser != ''){
			$this->dbuser = $dbuser;
		}
		if($dbpass != ''){
			$this->dbpass = $dbpass;
		}
		if($db != ''){
			$this->db = $db;
		}
		
		if($names == ''){
			$names = 'utf8';
		}
		
		$this->debug = $debug;
		
		$this->mysql = mysqli_init();
        if(!$this->mysql->real_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->db)){
        	return FALSE;
        }
        
        $this->query("SET NAMES '".$names."'");
	} 

	public function query($sql){
		
		$this->sqlQuery = $this->mysql->query($sql);
		$this->insertId();
		
		if($this->debug){
			echo __CLASS__ . " -> " . __FUNCTION__ . " : " . $sql . "<br />";
		}
		
		if($this->sqlQuery){			
			return $this->sqlQuery;
		}else{
			//return FALSE;
			 return $this->getSqlError();
		}
	}

	public function results($query='',$params){
		if(!is_array($params)){
			//return $this->error_param;
			$params = explode(",",$params);
		}
			
		$results = array();
		$results['count'] = 0;
	
		if($query != ''){
			$this->sqlQuery = $query;
		}
		
		foreach($params as $k => $v){

			if(strpos($v," AS ") !== false){
				$pos = strpos($v," AS ")+ 4 ;
				$params[$k] = substr($v,$pos);
			}
		
		}
	
		while ($row = $this->sqlQuery->fetch_object()) {
			foreach($params as $k){
				$results[$results['count']][$k] = $row->$k;
			}
			$results['count']++;
		}
		return $results;
		
	}
	
	protected function insertId(){
		$this->lastInsert = $this->mysql->insert_id;
	}
	
	protected function num_rows(){
		return $this->sqlQuery->num_rows;
	}
	
	public function getInsertId(){
		return $this->lastInsert;
	}
	
	protected function success(){
		if($this->mysql->affected_rows>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function real_escape_string($string){
		return $this->mysql->real_escape_string($string);
	}
	
	protected function select($table,$col,$cond='',$join=''){
	
		$col = str_replace("\n","",$col);
		$col = explode(",",$col);
		
		if(!is_array($cond)){
			$cond = array($cond);
		}
		
		if(!is_array($join) && $join != ''){
			return false;
		}
		
		if(isset($cond['limit'])){
			$limit = $cond['limit'];
			unset($cond['limit']);
		}
		
		if(isset($cond['orderby'])){
			$order = $cond['orderby'];
			unset($cond['orderby']);
		}
		
		$sql = "SELECT DISTINCT ";
		
		foreach($col as $key => $val){
			$sql .= $this->mysql->real_escape_string($val).',';
		}
		$sql = substr($sql,0,-1);
		$sql .= " FROM ".$table;
	
		if($join != ''){
			foreach($join as $key => $value){
				if(!isset($join[$key]['type'])){
					$join[$key]['type'] = 'INNER JOIN';
				}
				$sql .= " ".$join[$key]['type'];
				$sql .= " ".$join[$key]['table'];
				$sql .= " ON ".$join[$key]['value'];
			}
		}
		
		$c = '';
		
		if($cond != ''){
			foreach($cond as $key => $val){
				if(is_array($cond[$key])){
					$c .= ' '.(isset($cond[$key]['and_or']) ? $cond[$key]['and_or'] : 'AND').' '.$key." ".$cond[$key]['rel']." '".$cond[$key]['val']."'";
				}else{
					if($val != ''){
						$c .= " AND ".$key."='".$val."'";
					}
				}
			}
		}
		
		$rep = 0;
		
		$c = preg_replace('/ AND /',' WHERE ',$c,1,$rep);
		
		if($rep == 0){
			$c = preg_replace('/ OR /',' WHERE ',$c,1);
		}
		
		$sql .= $c;
		
		if(isset($order)){
			$sql .= " ORDER BY ".$order;
		}
		
		if(isset($limit)){
			$sql .= " LIMIT ".(int)$limit;
		}
		
		if($this->debug){
			echo __CLASS__ . " -> " . __FUNCTION__ . " : " . $sql . "<br />";
		}
		
		return $sql;
	}
	
	protected function insert($table,$col_val){
		
		if(!is_array($col_val)){
			return FALSE;
		}
		
		$sql = "INSERT INTO ";
		$sql .= $table;
		
		$c = " (";
		$v = "(";
		
		foreach($col_val as $key => $val){
			$c .= $this->mysql->real_escape_string($key).',';
			$v .= "'".$this->mysql->real_escape_string($val)."',";
		}

		$c = substr($c,0,-1).")";
		$v = substr($v,0,-1).")";
		
		$sql = $sql . $c . " VALUES " . $v;
		
		if($this->debug){
			echo __CLASS__ . " -> " . __FUNCTION__ . " : " . $sql . "<br />";
		}
		
		return $sql;
	
	}
	
	protected function update($table,$col_val,$cond=''){
	
		if(!is_array($col_val) || (!is_array($cond) && $cond != '')){
			return FALSE;
		}
		
		$sql = "UPDATE ";
		$sql .= $table;
		$sql .= " SET ";
		
		foreach($col_val as $key => $val){
			$sql .= $this->mysql->real_escape_string($key)."='".$this->mysql->real_escape_string($val)."',";
		}

		$sql = substr($sql,0,-1);
		
		if($cond != ''){
			foreach($cond as $k => $v){
				$sql .= " AND ".$k."='".$v."'";
			}
		}
		
		$sql = preg_replace('/ AND /',' WHERE ',$sql,1);
		
		if($this->debug){
			echo __CLASS__ . " -> " . __FUNCTION__ . " : " . $sql . "<br />";
		}
		
		return $sql;
	
	
	}
	
	protected function delete($table,$cond=''){
	
		$sql = "DELETE FROM " . $table;
	
		if($cond != ''){
			foreach($cond as $k => $v){
				$sql .= " AND ".$k."='".$v."'";
			}
		}
		
		$sql = preg_replace('/ AND /',' WHERE ',$sql,1);
		
		if($this->debug){
			echo __CLASS__ . " -> " . __FUNCTION__ . " : " . $sql . "<br />";
		}
		
		return $sql;
	
	}
	
	protected function commit(){
		
		$this->mysql->query('COMMIT');
		
	}
	
	protected function rollback(){
		
		$this->mysql->query('ROLLBACK');
		
	}

	protected function begin(){
		
		$this->mysql->query('BEGIN');
		
	}
	
	public function close(){
		$this->mysql->close();
	}
	
	public function normalizeString($string){
	
    	$before = array(" ","ö","ü","ó","ő","ú","ű","á","í","é","ő","ű",":","%","/","(",")");
    	$after = array("_","o","u","o","o","u","u","a","i","e","o","u","","","","","");
    	$string = trim($string);
    	$string = str_replace($before,$after,strtolower($string));
    	return $string;
	
	}

	public function getSqlError(){
		return $this->mysql->errno;
	}

	public function sql_select($table,$col,$cond='',$join=''){
	
		$sql = $this->select($table,$col,$cond,$join);
		
		$q = $this->query($sql);
		
		$a = $this->results($q,$col);
		
		return $a;
	
	}
	
	public function sql_insert($table,$col_val){
	
		$sql = $this->insert($table,$col_val);
		
		$q = $this->query($sql);
				
		$a = $this->success();
		
		return $a;
	
	}
	 
	public function sql_update($table,$col_val,$cond=''){
	
		$sql = $this->update($table,$col_val,$cond);
		
		$q = $this->query($sql);
				
		$a = $this->success();
		
		return $a;
	
	}
	
	public function sql_delete($table,$cond=''){
	
		$sql = $this->delete($table,$cond);
		
		$q = $this->query($sql);
				
		$a = $this->success();
		
		return $a;
	
	}
	
}

?>