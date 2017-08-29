<?php

namespace GetUtils;


use A;


class Attributes
{
	private $attributes;

	public function __construct(array $attrArray = [])
	{
		$this->attributes = $attrArray;
	}

	public function getAttributes()
	{
		return $this->attributes;
	}

	public function toHtml()
	{
		$buffer = [];
		array_walk($this->attributes, function (&$item, $key) use (&$buffer) {
			$buffer[] = $key . '="' . (is_array($item) ? implode(' ', array_filter($item)) : $item) . '"';
		});

		return implode(' ', $buffer);
	}

	public function merge($attributes)
	{
		if ($attributes instanceof Attributes) {
			$attributes = $attributes->getAttributes();
		}

		foreach ($attributes as $key => $value) {
			if (a::get($this->attributes, $key) === NULL) {
				$this->attributes[$key] = $value;
			} else if (is_array($this->attributes[$key])) {
				if (is_array($value)) {
					$this->attributes[$key] = array_merge($this->attributes[$key], $value);
				} else {
					$this->attributes[$key][] = $value;
				}
			}
		}

		return $this;
	}
}
