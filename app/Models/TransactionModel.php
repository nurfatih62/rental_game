<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id',
        'game_id',
        'rental_date',
        'return_date',
        'actual_return_date',
        'total_days',
        'total_price',
        'status',
        'notes'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getTransactionsWithDetails($userId = null)
    {
        $builder = $this->db->table('transactions t');
        $builder->select('t.*, u.username, u.email, u.phone, g.title as game_title, g.platform, g.image, g.genre');
        $builder->join('users u', 'u.id = t.user_id');
        $builder->join('games g', 'g.id = t.game_id');
        $builder->orderBy('t.created_at', 'DESC');

        if ($userId !== null) {
            $builder->where('t.user_id', $userId);
        }

        return $builder->get()->getResultArray();
    }
}