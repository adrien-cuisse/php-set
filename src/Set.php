<?php

namespace AR7\Sets;

use AR7\Sets\SetInterface;
use AR7\Sets\StorableInterface;

/** @see SetInterface */
final class Set implements SetInterface
{
	/** @var string - the type of stored items */
	private string $type;

	/** @var bool - is an interface used as type for the items ? */
	private bool $interfaceTyping = false;

	/** @var StorableInterface[] - the stored items */
	private array $items = [];

	/** @see SetInterface */
	final public function __construct(string $type)
	{
		$subject = new \ReflectionClass($type);
	
		if ($subject->isInterface()) {
			$this->interfaceTyping = true;
		}

		$this->type = $type;
	}

	/** @see SetInterface */
	final public function getAll(): array
	{
		return $this->items;
	}

	/** @see SetInterface */
	final public function store(StorableInterface $item): self
	{
		if ($this->isCompatibleWith($item) && $this->doesNotContain($item)) {		
			$this->items[] = $item;
		}

		return $this;
	}

	/** @see SetInterface */
	public function contains(StorableInterface $item): bool
	{
		foreach ($this->items as $stored) {
			if ($stored->getIdentifier() === $item->getIdentifier()) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param StorableInterface - the item to check for storage
	 * 
	 * @return boolean - false if the item is stored, true otherwise
	 */
	private function doesNotContain(StorableInterface $item): bool
	{
		return false === $this->contains($item);
	}

	/**
	 * @param StorableInterface - the item to check for compatiblity
	 * 
	 * @return boolean - true if the given item has valid type
	 */
	final private function isCompatibleWith(StorableInterface $item): bool
	{
		$itemClass = new \ReflectionClass($item);
		
		if ($this->interfaceTyping) {
			return $itemClass->implementsInterface($this->type);
		}

		return $this->type === get_class($item);
	}
}