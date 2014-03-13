<?php
/**
 * 
 * @author awknaust
 *
 */
interface JsonDeserializable{
	/**
	 * Create this object from a object-sytle json_decoded representation.
	 *
	 * @param Object $jsonObj A json_decoded object representing this type.
	 */
	public function fromJson($jsonObj);
}