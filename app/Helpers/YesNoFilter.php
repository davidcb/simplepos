<?php

	if (!function_exists('yesNoFilter')) {
		function yesNoFilter($elements, $field, $value = null) {
			if ($value) {
				$elements = $elements->filter(function($element) use ($value, $field) {
					if (($value == 1 && $element->{$field}) || ($value == 2 && !$element->{$field}) || !$value) {
						return true;
					} else {
						return false;
					}
				});
			}

			return $elements;
		}
	}
