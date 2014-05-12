<?php

/**
 * This class wraps json_encode and json_decode to set important options for communication
 */
class JsonTransformer {
	static $ENCODE_FLAGS = JSON_PRETTY_PRINT;
	static $DECODE_FLAGS = 0;

	public function encode($obj) {
		return json_encode ( $obj, self::$ENCODE_FLAGS );
	}

	public function decode($json) {
		return json_decode ( $json, self::$DECODE_FLAGS );
	}
}