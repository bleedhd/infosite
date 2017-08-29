<?php

field::$methods['responsive'] = function($field, $imageStyle = NULL, $data = [])
{
	$field->value = responsive($field->toFile(), $imageStyle, $data);
	return $field;
};

field::$methods['replace'] = function ($field, $parameters) {
	$field->value = preg_replace_callback('/\$\(([^)]+)\)/', function ($matches) use ($parameters) {
		return a::get($parameters, $matches[1], '');
	}, $field->value);

	return $field;
};
