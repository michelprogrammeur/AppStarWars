<?php namespace Cart;

class Cart {
	private $storage = null;

	public function __construct($storage)
	{
		$this->storage = $storage;
	}

	public function buy($product, $quantity) {
		$quantity = abs((int) $quantity);
			
		$this->storage->setValue($product->name, $product->price * $quantity);

		return $this;
	}

	public function restore($product) {

		$this->storage->restore($product->name);
		return $this;
	}

	public function total() {
		return $this->storage->total();
	}

	public function reset() {
		$this->storage->reset();
	}

	public function all() {
		return $this->storage->all();
	}
}
