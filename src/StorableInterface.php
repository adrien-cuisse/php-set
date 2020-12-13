<?php

namespace AR7;

interface StorableInterface
{
	/** @return string - the identifier for the item */
	public function getIdentifier(): string;
}