<?php

$POST_FORBID = array("DIR","DIR_INC");

foreach ($_POST as $post_key => $post_value) {
	if (in_array($post_key, $POST_FORBID)) {
		unset($_POST[$post_key]);
	} else {
		if (!is_array($post_value)) {
			$_POST[$post_key] = convert_to_string($post_value);
		}
	}
}

extract($_POST);

?>