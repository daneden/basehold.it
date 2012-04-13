<?php
/**
 * Simple Stats Class
 * @author Michael Wright	@MichaelW90
 */

class Stats {

	/**
	 * @var string
	 */
	private $_file = 'baselineStats.store';
	
	/**
	 * @var string
	 */
	private $_path = '';
 
 	/**
 	 * construct()
 	 */
	public function __construct(){
		$this -> _path = $_SERVER['DOCUMENT_ROOT'] . '/../' . $this -> _file;

		$createCheck = $this -> checkCreate();
		if($createCheck !== TRUE)
			var_dump($createCheck);
	}

	/**
	 * store()
	 * @param array $tore
	 * @return boolean|string
	 */
	public function store($store){
		$result = $this -> getStats();
		if($result === FALSE){
			return 'Error getting stats';
		}else{
			$result = $result;
		}
		$result['total']++;
		
		foreach($store as $key => $item){
			if(!isset($result[$key][$item])){
				$result[$key][$item] = 0;
			}
			$result[$key][$item]++;
		}

		$this -> putStats($result);

		return TRUE;
	}

	/**
	 * checkCreate()
	 * @return boolean | string
	 */
	private function checkCreate(){
		$template = array(
			'total' => 0
		);
		if(!file_exists($this -> _path)){
			if(!$this -> putStats($template)){
				return 'Error calling file_put_contents()';
			}
		}else if(!$result = $this -> getStats(false)){
			if($result == ''){
				return $this -> putStats($template);
			}
		}
		return TRUE;
	}

	/**
	 * getStats()
	 * @param boolean $unserialize
	 * @return array|string
	 */
	public function getStats($unserialize = true){
		if(!$result = file_get_contents($this -> _path)){
			return FALSE;
		}
		if($unserialize)
			return unserialize($result);
		else
			return $result;
	}

	/**
	 * putStats()
	 * @param array $array
	 * @return boolean
	 */
	private function putStats($array){
		$array = serialize($array);
		if(!$result = @file_put_contents($this -> _path, $array)){
			return FALSE;
		}
		return TRUE;
	}

}


