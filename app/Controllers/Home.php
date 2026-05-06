<?php

namespace App\Controllers;

use App\Models\GameModel;

class Home extends BaseController
{
    public function index()
    {
        $gameModel = new GameModel();

        $data = [
            'title'      => 'Beranda - Rental Game',
            'games'      => $gameModel->where('status', 'tersedia')->orderBy('created_at', 'DESC')->findAll(6),
            'totalGames' => $gameModel->countAll(),
        ];

        return view('home', $data);
    }
}