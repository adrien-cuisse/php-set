<?php

namespace AR7\Sets;

/**
 * Typehint for storable items
 */
interface StorableInterface
{
	/** @return string - the identifier for the item */
	public function getIdentifier(): string;
}