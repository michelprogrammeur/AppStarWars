<?php namespace Models;

class History extends Model
{
    protected $table = 'histories';
    protected $fillable = ['quantity', 'customer_id', 'product_id', 'price', 'total', 'commanded_at'];
}