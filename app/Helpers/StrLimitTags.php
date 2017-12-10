<?php

	if (!function_exists('strLimitTags')) {
		function strLimitTags($string, $limit, $end='...') {
			$with_html_count = strlen($string);
			$without_html_count = strlen(strip_tags($string));
			$html_tags_length = $with_html_count - $without_html_count;

			return str_limit($string, $limit + $html_tags_length, $end);
		}
	}
