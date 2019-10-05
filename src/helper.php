<?php

function is_json($string) {
	// if string is an array, return
	if (is_array($string)) {
		return false;
	}
	
	json_decode($string);

	if (json_last_error() === JSON_ERROR_NONE) {
    	return true;
	} else {
		return false;
	}

	return null;
}

