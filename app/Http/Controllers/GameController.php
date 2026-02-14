<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Mostrar la llista de partides
    public function index()
    {
        $games = Game::latest()->get();
        return view('games.index', compact('games'));
    }

    // Mostrar formulari per crear una nova partida
    public function create()
    {
        return view('games.create');
    }

    // Crear una nova partida
    public function store(Request $request)
    {
        $data = $request->validate([
            'player_x' => 'required|string',
            'player_o' => 'required|string',
        ]);
        $game = Game::create([
            'player_x' => $data['player_x'],
            'player_o' => $data['player_o'],
            'board' => array_fill(0, 9, null),
            'turn' => 'X',
            'winner' => null,
            'is_draw' => false,
        ]);
        return redirect()->route('games.show', $game);
    }

    // Mostrar una partida i la vista de joc
    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    // Actualitzar l'estat de la partida (fer un moviment)
    public function update(Request $request, Game $game)
    {
        $data = $request->validate([
            'cell' => 'required|integer|min:0|max:8',
        ]);
        $board = $game->board;
        if ($board[$data['cell']] === null && $game->winner === null && !$game->is_draw) {
            $board[$data['cell']] = $game->turn;
            $winner = $this->checkWinner($board);
            $is_draw = !$winner && !in_array(null, $board, true);
            $game->update([
                'board' => $board,
                'turn' => $game->turn === 'X' ? 'O' : 'X',
                'winner' => $winner,
                'is_draw' => $is_draw,
            ]);
        }
        return redirect()->route('games.show', $game);
    }

    // Comprovar si hi ha guanyador
    private function checkWinner($board)
    {
        $lines = [
            [0,1,2],[3,4,5],[6,7,8], // files
            [0,3,6],[1,4,7],[2,5,8], // columnes
            [0,4,8],[2,4,6] // diagonals
        ];
        foreach ($lines as $line) {
            [$a, $b, $c] = $line;
            if ($board[$a] && $board[$a] === $board[$b] && $board[$a] === $board[$c]) {
                return $board[$a];
            }
        }
        return null;
    }

    // API: Actualitzar estat de la partida via AJAX
    public function apiUpdate(Request $request, Game $game)
    {
        $data = $request->validate([
            'cell' => 'required|integer|min:0|max:8',
        ]);
        $board = $game->board;
        $moveMade = false;
        if ($board[$data['cell']] === null && $game->winner === null && !$game->is_draw) {
            $board[$data['cell']] = $game->turn;
            $winner = $this->checkWinner($board);
            $is_draw = !$winner && !in_array(null, $board, true);
            $game->update([
                'board' => $board,
                'turn' => $game->turn === 'X' ? 'O' : 'X',
                'winner' => $winner,
                'is_draw' => $is_draw,
            ]);
            $moveMade = true;
        }
        $game->refresh();
        return response()->json([
            'success' => $moveMade,
            'board' => $game->board,
            'turn' => $game->turn,
            'winner' => $game->winner,
            'is_draw' => $game->is_draw,
        ]);
    }
}
