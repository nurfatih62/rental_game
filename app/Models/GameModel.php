<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $table            = 'games';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'title',
        'genre',
        'platform',
        'price_per_day',
        'stock',
        'status',
        'image',
        'description'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}