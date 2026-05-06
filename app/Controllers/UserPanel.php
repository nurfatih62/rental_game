<?php

namespace App\Controllers;

use App\Models\GameModel;
use App\Models\TransactionModel;

class UserPanel extends BaseController
{
    protected $gameModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->gameModel        = new GameModel();
        $this->transactionModel = new TransactionModel();
    }

    public function dashboard()
    {
        $userId = session()->get('user_id');

        $data = [
            'title'          => 'Dashboard',
            'activeRentals'  => $this->transactionModel->where('user_id', $userId)->where('status', 'ongoing')->countAllResults(),
            'totalRentals'   => $this->transactionModel->where('user_id', $userId)->countAllResults(),
            'transactions'   => $this->transactionModel->getTransactionsWithDetails($userId),
            'availableGames' => $this->gameModel->where('status', 'tersedia')->countAllResults(),
        ];

        return view('user/dashboard', $data);
    }

    public function games()
    {
        $search = $this->request->getGet('search');
        $genre  = $this->request->getGet('genre');

        $builder = $this->gameModel->where('status', 'tersedia');

        if ($search) {
            $builder->groupStart()
                    ->like('title', $search)
                    ->orLike('description', $search)
                    ->groupEnd();
        }

        if ($genre) {
            $builder->where('genre', $genre);
        }

        $db = \Config\Database::connect();
        $genres = $db->table('games')->select('genre')->distinct()->orderBy('genre', 'ASC')->get()->getResultArray();

        $data = [
            'title'         => 'Katalog Game',
            'games'         => $builder->orderBy('title', 'ASC')->findAll(),
            'genres'        => array_column($genres, 'genre'),
            'search'        => $search,
            'selectedGenre' => $genre,
        ];

        return view('user/games', $data);
    }

    public function rent($gameId)
    {
        $game = $this->gameModel->find($gameId);

        if (!$game || $game['status'] !== 'tersedia' || $game['stock'] < 1) {
            session()->setFlashdata('error', 'Game tidak tersedia!');
            return redirect()->to('/user/games');
        }

        return view('user/rent', [
            'title' => 'Sewa Game',
            'game'  => $game,
        ]);
    }

    public function rentProcess($gameId)
    {
        $game = $this->gameModel->find($gameId);

        if (!$game || $game['status'] !== 'tersedia' || $game['stock'] < 1) {
            session()->setFlashdata('error', 'Game tidak tersedia!');
            return redirect()->to('/user/games');
        }

        $rules = [
            'total_days' => 'required|integer|greater_than[0]|less_than_equal_to[30]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $totalDays  = (int) $this->request->getPost('total_days');
        $totalPrice = $totalDays * $game['price_per_day'];
        $rentalDate = date('Y-m-d');
        $returnDate = date('Y-m-d', strtotime("+{$totalDays} days"));

        $this->transactionModel->save([
            'user_id'     => session()->get('user_id'),
            'game_id'     => $gameId,
            'rental_date' => $rentalDate,
            'return_date' => $returnDate,
            'total_days'  => $totalDays,
            'total_price' => $totalPrice,
            'status'      => 'ongoing',
        ]);

        $newStock = $game['stock'] - 1;
        $updateData = ['stock' => $newStock];
        if ($newStock <= 0) {
            $updateData['status'] = 'disewa';
        }
        $this->gameModel->update($gameId, $updateData);

        session()->setFlashdata('success',
            'Berhasil menyewa "' . $game['title'] . '" selama ' . $totalDays . ' hari. Total: Rp ' . number_format($totalPrice, 0, ',', '.')
        );

        return redirect()->to('/user/transactions');
    }

    public function transactions()
    {
        $userId = session()->get('user_id');

        return view('user/transactions', [
            'title'        => 'Riwayat Transaksi',
            'transactions' => $this->transactionModel->getTransactionsWithDetails($userId),
        ]);
    }
}