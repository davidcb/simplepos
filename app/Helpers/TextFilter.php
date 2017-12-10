<?php

	if (!function_exists('textFilter')) {
		function textFilter($elements, $field, $text = null) {
			if ($text) {
				$elements = $elements->filter(function($element) use ($text, $field) {
					if (
						preg_match('/(.*)' . $text . '(.*)/i', $element->{$field})
					) {
						return true;
					} else {
						return false;
					}
				});
			}

			return $elements;
		}
	}
