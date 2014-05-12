<?php

/**
 * 
 * Name avoids a ridiculous conflict with another class.
 * TODO refactor with namespacing?
 * @author awknaust
 *
 */
interface JsonCerializable {

	/**
	 * Convert this Object to its JSON representation
	 */
	public function toJson();
}