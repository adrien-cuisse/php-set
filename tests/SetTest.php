<?php

namespace AR7\Tests;

use AR7\Sets\Set;
use AR7\Sets\StorableInterface;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
	/** @var StorableInterface - typed item that will be stored */
	private StorableInterface $storable1;

	/** @var StorableInterface - an item with different type that will be stored */
	private StorableInterface $storable2;

	/** @var Set - the instance to test */
	private Set $set;

	public function setUp(): void
	{
		$this->storable1 = new class implements StorableInterface {
			final public function getIdentifier(): string
			{
				return 'foo';
			}
		};
		$this->storable2 = new class implements StorableInterface {
			final public function getIdentifier(): string
			{
				return 'bar';
			}
		};
	}

	/** @test */
	public function is_empty_by_default()
	{
		// given a base set
		$this->set = new Set(TestCase::class);

		// when nothing is added

		// then size should be zero
		$this->assertCount(0, $this->set->getAll());
	}

	/** @test */
	public function item_is_stored()
	{
		// given a set with specified type
		$this->set = new Set(get_class($this->storable1));

		// when adding an item with matching type
		$this->set->store($this->storable1);

		// then item should be stored
		$this->assertCount(1, $this->set->getAll());
	}

	/** @test */
	public function duplicate_items_are_not_stored()
	{
		// given a set with specified type
		$this->set = new Set(get_class($this->storable1));

		// when adding several items with the same identifier
		$this->set->store($this->storable1);
		$this->set->store($this->storable1);

		// then only one of them should be stored
		$this->assertCount(1, $this->set->getAll());
	}

	/** @test */
	public function rejects_invalid_types()
	{
		// given a set with specified type
		$this->set = new Set(get_class($this->storable1));

		// when adding an item with invalid type
		$this->set->store($this->storable2);

		// then it shouldn't be added
		$this->assertCount(0, $this->set->getAll());
	}

	/** @test */
	public function works_with_interface_typings()
	{
		// given a set with interface typehint
		$this->set = new Set(StorableInterface::class);

		// when adding items implementing the interface
		$this->set->store($this->storable1);
		$this->set->store($this->storable2);

		// then they should all be stored
		$this->assertCount(2, $this->set->getAll());
	}
}