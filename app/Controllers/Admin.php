<?php

namespace App\Controllers;

use App\Models\GameModel;
use App\Models\UserModel;
use App\Models\TransactionModel;

class Admin extends BaseController
{
    protected $gameModel;
    protected $userModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->gameModel        = new GameModel();
        $this->userModel        = new UserModel();
        $this->transactionModel = new TransactionModel();
    }

    public function dashboard()
    {
        $db = \Config\Database::connect();

        $data = [
            'title'             => 'Admin Dashboard',
            'totalGames'        => $this->gameModel->countAll(),
            'totalUsers'        => $this->userModel->where('role', 'user')->countAllResults(),
            'gamesAvailable'    => $this->gameModel->where('status', 'tersedia')->countAllResults(),
            'gamesRented'       => $this->gameModel->where('status', 'disewa')->countAllResults(),
            'totalTransactions' => $this->transactionModel->countAll(),
            'ongoingRentals'    => $this->transactionModel->where('status', 'ongoing')->countAllResults(),
            'recentTransactions'=> $this->transactionModel->getTransactionsWithDetails(),
            'totalRevenue'      => $db->table('transactions')->selectSum('total_price')->get()->getRow()->total_price ?? 0,
        ];

        return view('admin/dashboard', $data);
    }

    public function games()
    {
        $data = [
            'title' => 'Kelola Game',
            'games' => $this->gameModel->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('admin/games', $data);
    }

    public function createGame()
    {
        return view('admin/game_form', [
            'title'  => 'Tambah Game Baru',
            'game'   => null,
            'action' => '/admin/games/store',
        ]);
    }

    public function storeGame()
    {
        $rules = [
            'title'         => 'required|max_length[200]',
            'genre'         => 'required',
            'platform'      => 'required',
            'price_per_day' => 'required|numeric|greater_than[0]',
            'stock'         => 'required|integer|greater_than[0]',
            'description'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'         => $this->request->getPost('title'),
            'genre'         => $this->request->getPost('genre'),
            'platform'      => $this->request->getPost('platform'),
            'price_per_day' => $this->request->getPost('price_per_day'),
            'stock'         => $this->request->getPost('stock'),
            'description'   => $this->request->getPost('description'),
            'status'        => 'tersedia',
        ];

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/games', $newName);
            $data['image'] = $newName;
        }

        $this->gameModel->save($data);
        session()->setFlashdata('success', 'Game berhasil ditambahkan!');
        return redirect()->to('/admin/games');
    }

    public function editGame($id)
    {
        $game = $this->gameModel->find($id);
        if (!$game) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Game tidak ditemukan');
        }

        return view('admin/game_form', [
            'title'  => 'Edit Game',
            'game'   => $game,
            'action' => '/admin/games/update/' . $id,
        ]);
    }

    public function updateGame($id)
    {
        $game = $this->gameModel->find($id);
        if (!$game) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Game tidak ditemukan');
        }

        $rules = [
            'title'         => 'required|max_length[200]',
            'genre'         => 'required',
            'platform'      => 'required',
            'price_per_day' => 'required|numeric|greater_than[0]',
            'stock'         => 'required|integer|greater_than_equal_to[0]',
            'description'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'         => $this->request->getPost('title'),
            'genre'         => $this->request->getPost('genre'),
            'platform'      => $this->request->getPost('platform'),
            'price_per_day' => $this->request->getPost('price_per_day'),
            'stock'         => $this->request->getPost('stock'),
            'description'   => $this->request->getPost('description'),
        ];

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            if ($game['image'] && file_exists('uploads/games/' . $game['image'])) {
                unlink('uploads/games/' . $game['image']);
            }
            $newName = $image->getRandomName();
            $image->move('uploads/games', $newName);
            $data['image'] = $newName;
        }

        $this->gameModel->update($id, $data);
        session()->setFlashdata('success', 'Game berhasil diperbarui!');
        return redirect()->to('/admin/games');
    }

    public function deleteGame($id)
    {
        $game = $this->gameModel->find($id);
        if (!$game) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Game tidak ditemukan');
        }

        $activeRentals = $this->transactionModel
            ->where('game_id', $id)
            ->where('status', 'ongoing')
            ->countAllResults();

        if ($activeRentals > 0) {
            session()->setFlashdata('error', 'Game sedang disewa dan tidak bisa dihapus!');
            return redirect()->to('/admin/games');
        }

        if ($game['image'] && file_exists('uploads/games/' . $game['image'])) {
            unlink('uploads/games/' . $game['image']);
        }

        $this->gameModel->delete($id);
        session()->setFlashdata('success', 'Game berhasil dihapus!');
        return redirect()->to('/admin/games');
    }

    public function users()
    {
        return view('admin/users', [
            'title' => 'Kelola User',
            'users' => $this->userModel->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function deleteUser($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        if ($user['id'] == session()->get('user_id')) {
            session()->setFlashdata('error', 'Tidak bisa menghapus akun sendiri!');
            return redirect()->to('/admin/users');
        }

        $this->userModel->delete($id);
        session()->setFlashdata('success', 'User berhasil dihapus!');
        return redirect()->to('/admin/users');
    }

    public function transactions()
    {
        return view('admin/transactions', [
            'title'        => 'Kelola Transaksi',
            'transactions' => $this->transactionModel->getTransactionsWithDetails(),
        ]);
    }

    public function returnGame($transactionId)
    {
        $transaction = $this->transactionModel->find($transactionId);
        if (!$transaction) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaksi tidak ditemukan');
        }

        if ($transaction['status'] !== 'ongoing') {
            session()->setFlashdata('error', 'Transaksi sudah selesai!');
            return redirect()->to('/admin/transactions');
        }

        $this->transactionModel->update($transactionId, [
            'status'             => 'returned',
            'actual_return_date' => date('Y-m-d'),
        ]);

        $game = $this->gameModel->find($transaction['game_id']);
        if ($game) {
            $this->gameModel->update($transaction['game_id'], [
                'status' => 'tersedia',
                'stock'  => $game['stock'] + 1,
            ]);
        }

        session()->setFlashdata('success', 'Game berhasil dikembalikan!');
        return redirect()->to('/admin/transactions');
    }
}