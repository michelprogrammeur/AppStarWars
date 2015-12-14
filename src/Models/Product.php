<?php namespace Models;

class Product extends Model {
    protected $table = 'products';
    protected $order = 'published_at'; // petit astuce pour ordonné par ordre de date inverse
    protected $orderDirection = 'ASC';
    protected $limit = 10;

    public function productId($product_id)
    {
        $sql = sprintf('SELECT * FROM %s WHERE id=%d', $this->table, (int)$product_id);
        $stmt = $this->pdo->query($sql);
        if(!$stmt) return false;
        return $stmt->fetchAll();
    }
}