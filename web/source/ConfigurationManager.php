<?php

/**
 * Gets global configuration values.
 * 
 * TODO fix ineffecient implementation?
 * @author awknaust
 *
 */
class ConfigurationManager{

	private static $configLocation = '../config.ini';
	
	
	public function getBackendLocation(){
		return $this->getConfigValue("viskoBackendURL");	
	}
	
	private function getConfigValue($key){
		$config_arr = parse_ini_file(
				__DIR__ . '/'. ConfigurationManager::$configLocation, 
				false
		);
		
		return $config_arr[$key];
	}
	
}