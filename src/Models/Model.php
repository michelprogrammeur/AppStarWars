<?php namespace Models;

class Model {
	use \DebugTrait;
	protected $pdo = null;
	protected $table = '';
	private $where = [];
	private $select = '';
	protected $order = 'id';
	protected $orderDirection = 'DESC';
	protected $limit =10;


	public function __construct() {
		if(!class_exists('\Connect')) throw new \RuntimeException("class Connect doesn't exists");
			$this->pdo = \Connect::$pdo;
	}

	public function __set($name, $value) {
		$method = 'set'.ucfirst(strtolower($name));
		if(method_exists($this, $method))
			$this->$method($value);
	}
	// select(['title', 'status'])
	public function select($args='*') {
		// todo alméliorer les bugs utilisateurs
		if($args=='*'){
			$this->select = $args;

			return $this;
		}else if(is_array($args)){
			$this->select = implode(',', $args);

			return $this;
		}
		else {
			die('method select args invalid');
		}
	}

	public function where($field, $operator, $value) {
		$operators=['=', '>', '<', '!=', '<>', '>=', '<='];

		// in_array(selecteur, tableau)
		if (!in_array($operator, $operators)) {
			die(sprintf('invalid SQL operator, %s', $operator));
		}

		if (!is_numeric($value)) {
			$value = $this->pdo->quote($value);
		}

		$this->where[] = "`$field` $operator $value";
		return $this;
	}

	public function get() {
		// todo $where...
		$where = $this->buildWhere();

		// CLEAN les variable de classe pour la prochaine requête
		$this->where = [];

		$select = $this->select;
		$this->select='';

		$sql = sprintf('SELECT %s FROM %s WHERE %s ORDER BY %s %s LIMIT 0, %s',
			$select,
			$this->table,
			$where,
			$this->order,
			$this->orderDirection,
		    $this->limit
		);

		$this->debug($sql);
		return $this->pdo->query($sql);
	}

	public function count() {
		$where = $this->buildWhere();

		$this->where = [];
		
		$sql = sprintf('SELECT count(*) FROM %s WHERE %s',
			$this->table,
			$where
		);

		$res = $this->pdo->query($sql);

		return $res->fetchColumn();
	}

	public function create($data) {
		$fields=[];
		$values=[];

		foreach ($data as $f => $v) {
			$v = (is_numeric($v))? $v : $this->pdo->quote($v);

			if(!in_array($f, $this->fillable)) continue;
				$values[]=$v;
				$fields[]=$f;
		}

		$fields = '(`'.implode('`, `', $fields).'`)';
		$values = '('.implode(',', $values).')';

		$sql = sprintf('INSERT INTO %s %s VALUES %s',
			$this->table,
			$fields,
			$values
		);

		$this->debug($sql);

		return $this->pdo->query($sql);
		// INSERT INTO $table ($fields) VALUES ($values)
	}

	private function buildWhere() {
		$where = ' 1=1 ';

		if(!empty($this->where)) {
			$where .= ' AND '. implode(' AND ', $this->where);
		}

		return $where;
	}

	public function all($args='*') {
		$stmt = $this->select($args)->get();

		if(!$stmt) return false;

		return $stmt->fetchAll();
	}
	/**
	 * [find description]
	 * @param  [type] $id   [description]
	 * @param  string $args [description]
	 * @return [type]       [description]
	 */
	public function find($id, $args='*') {
		$stmt = $this->select($args)->where('id', '=', $id)->get();

		if(!$stmt) return false;

		return $stmt->fetch();
	}

}
