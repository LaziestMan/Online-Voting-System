<?php

/**
 * ORM Module class definition
 */
class ORM {

	public $db;
	protected $dbName;

	/**
     * Method connects to MySQL database
     * @param string $servername
     * @param string $username
     * @param string $password
     * @param string $db
     */
	public function connect($servername, $username, $password, $db) {

		$this->dbName = $db;
		// Create connection
		$this->db = new mysqli($servername, $username, $password, $db);

		// Check connection
		if ($this->db->connect_error) {
		    die("Connection failed: " . $this->db->connect_error);
		}
	}

	
	public function select($cols, $tbl, $cond) {

		$query = "SELECT ".$cols." FROM ".$tbl;

		if($cond!='') {
			$query = $query." WHERE ";
			$remain = '';
		$col_count = count($cond);

		for($i=0;$i<$col_count;$i++) {

			if(($this->even($i)==true) && is_array($cond[$i])) {
				
				foreach($cond[$i] as $key => $value) {
	 				foreach($cond[$i][$key] as $key1 => $value1) {
	 					switch ($key1) {
	 						case '$equal':
	 							if(is_string($value1)) {
	 								$remain = $remain.$key." = '".$value1."'";	
	 							} else {
	 								$remain = $remain.$key." = ".$value1;
	 							}
	 							
	 							break;
	 						case '$gt':
	 							if(is_string($value1)) {
	 								$remain = $remain.$key." > '".$value1."'";	
	 							} else {
	 								$remain = $remain.$key." > ".$value1;
	 							}
	 							break;
	 						case '$lt':
	 							if(is_string($value1)) {
	 								$remain = $remain.$key." < '".$value1."'";	
	 							} else {
	 								$remain = $remain.$key." < ".$value1;
	 							}
	 							break;
	 						case '$gte':
	 							if(is_string($value1)) {
	 								$remain = $remain.$key." >= '".$value1."'";	
	 							} else {
	 								$remain = $remain.$key." >= ".$value1;
	 							}
	 							break;
	 						case '$lte':
	 							if(is_string($value1)) {
	 								$remain = $remain.$key." <= '".$value1."'";	
	 							} else {
	 								$remain = $remain.$key." <= ".$value1;
	 							}
	 							break;
	 						case '$nte':
	 							if(is_string($value1)) {
	 								$remain = $remain.$key." != '".$value1."'";	
	 							} else {
	 								$remain = $remain.$key." != ".$value1;
	 							}
	 							break;
	 						default:
	 							throw new Exception('Specify a correct condition');
	 							break;
	 					}
			 		}

 				}

			}
			elseif(($this->even($i)==false) && is_string($cond[$i])) {
				$remain = $remain.' '.strtoupper($cond[$i]).' ';
			}
		}

		$query = $query.$remain;
		}

		// Now select form the db with the generated ORM
		$result = $this->db->query($query);
		$feed = array();
		if ($result->num_rows > 0) {
    	// output data of each row
		    while($row = $result->fetch_assoc()) {
	        	array_push($feed, $row);
			}
		} else {
		    $feed = NULL;
		}

		return $feed;
	}

	public function even($num) {
		$num = $num/2;
		if(!is_float($num)) {
			return true;
		} else {
			return false;
		}
	}

	public function insert($tbl, $cols, $vals) {
		$query = "INSERT INTO ".$tbl." (";
		$cols_len = count($cols);
		for($i=0;$i<$cols_len;$i++) {
			if($i==$cols_len-1) {
				$query = $query.$cols[$i];	
			} else {
				$query = $query.$cols[$i].", ";
			}
		}
		$query = $query.") VALUES (";
		$vals_len = count($vals);
		for($i=0;$i<$vals_len;$i++) {

			if($i==$vals_len-1) {
				if(is_string($vals[$i])) {
					$query = $query."'".$vals[$i]."'";
				}  else {
					$query = $query.$vals[$i];
				}
			} else {
				if(is_string($vals[$i])) {
					$query = $query."'".$vals[$i]."', ";
				}  else {
					$query = $query.$vals[$i].", ";
				}
			}
			
		}
		$query = $query.")";

		if ($this->db->query($query) === TRUE) {
    		return TRUE;
		} else {
			throw new Exception($this->db->error);
		    return FALSE;
		}
	}
}


//$GLOBALS['app']->_ORM->where('users', 'uid, email, victor', array('uid'=>array('$gt'=>1), 'password'=>array('$equal'=>'victor')));
// array(array('uid'=>array('$gt'=>1)), 'and', array('uid'=>array('$gt'=>1))