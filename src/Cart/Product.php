<?php namespace Cart;

class Product {
	private $name;
	private $price;

	public function __construct($name='', $price='') {
		$this->name = $name;
		$this->price = $price;
	}

	// functions set
	public function setName($name) {
		$this->name = (is_integer($name))? (int) $name: (string) $name;
	}
	public function setPrice($price) {
		if(!is_numeric($price)) die(sprintf('is not a numeric value %s', $price));
		$this->price = $price;
	}
	// functions get
	public function getName() {
		return $this->name;
	}
	public function getPrice() {
		return $this->price;
	}

	public function __get($name) {
		$method = 'get'.ucfirst($name);

		//retourner à l'extérieur la valeur de la methode
		if(method_exists($this, $method)) {
			return $this->$method();
		}
	}

	public function __set($name, $value) {
		$method = 'set'.ucfirst($name);

		if(method_exists($this, $method))
			$this->$method($value);
	}
}
