<?php

	if (!function_exists('valueFilter')) {
		function valueFilter($elements, $field, $value = null) {
			if ($value) {
				$elements = $elements->filter(function($element) use ($value, $field) {
					if ($value == $element->{$field}) {
						return true;
					} else {
						return false;
					}
				});
			}

			return $elements;
		}
	}
