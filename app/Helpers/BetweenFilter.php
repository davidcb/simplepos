<?php

	if (!function_exists('betweenFilter')) {
		function betweenFilter($elements, $field, $minValue = null, $maxValue = null) {
			if ($minValue || $maxValue) {
				$elements = $elements->filter(function($element) use ($minValue, $maxValue, $field) {
					if ($minValue && $maxValue) {
						if ($element->{$field} >= $minValue && $element->{$field} <= $maxValue) {
							return true;
						} else {
							return false;
						}
					} elseif ($minValue) {
						if ($element->{$field} >= $minValue) {
							return true;
						} else {
							return false;
						}
					} else {
						if ($element->{$field} <= $maxValue) {
							return true;
						} else {
							return false;
						}
					}
				});
			}

			return $elements;
		}
	}
