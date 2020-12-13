<?php

namespace AR7;

use AR7\StorableInterface;

/**
 * A set of objects with the same class, unique by a given identifier
 */
interface SetInterface
{
	/** 
	 * @var string - the fully qualified type of items it will store 
	 * 
	 * @throws ReflectionException - if the given type is not an existing interface, trait or class
	 */
	public function __construct(string $type);

	/** 
	 * @return StorableInterface[] 
	 */
	public function getAll(): array;

	/** 
	 * @param StorableInterface - the item to store 
	 * 
	 * @return self
	 */
	public function store(StorableInterface $item): self;

	/**
	 * @param StorableInterface - the item to check for storage
	 * 
	 * @return boolean - true if the item is stored, false otherwise
	 */
	public function contains(StorableInterface $item): bool;
}