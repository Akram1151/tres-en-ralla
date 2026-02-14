@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="card shadow-lg p-4" style="background: #f7faff; border-radius: 1.2rem; min-width: 340px;">
            <h1 class="mb-3 text-center fw-bold" style="letter-spacing:1px; color:#1e88e5;">
                <span class="text-danger">{{ $game->player_x }} (X)</span>
                <span class="mx-2">vs</span>
                <span class="text-primary">{{ $game->player_o }} (O)</span>
            </h1>
            <div class="mb-3 text-center">
                <strong>Torn:</strong> <span class="{{ $game->turn === 'X' ? 'text-danger' : 'text-primary' }}">{{ $game->turn }}</span>
                @if($game->winner)
                    <div class="alert alert-success mt-2"><strong>Guanyador:</strong> {{ $game->winner }}</div>
                @elseif($game->is_draw)
                    <div class="alert alert-secondary mt-2"><strong>Empat!</strong></div>
                @endif
            </div>
            <form id="moveForm" class="d-flex justify-content-center">
                <table id="gameBoard" class="table table-bordered text-center align-middle shadow-sm" style="width: 240px; background: #fff; border-radius: 1rem; overflow: hidden;">
                    <tbody>
                    @for($row = 0; $row < 3; $row++)
                        <tr>
                        @for($col = 0; $col < 3; $col++)
                            @php $cell = $row * 3 + $col; @endphp
                            <td style="width: 80px; height: 80px;">
                                @if($game->board[$cell])
                                    <span class="display-4 fw-bold {{ $game->board[$cell] === 'X' ? 'text-danger' : 'text-primary' }}">{{ $game->board[$cell] }}</span>
                                @elseif(!$game->winner && !$game->is_draw)
                                    <button type="button" data-cell="{{ $cell }}" class="btn btn-outline-dark w-100 h-100 rounded-0 cell-btn" style="font-size:2em;">-</button>
                                @else
                                    -
                                @endif
                            </td>
                        @endfor
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const board = document.getElementById('gameBoard');
                    const gameId = {{ $game->id }};
                    board.addEventListener('click', function(e) {
                        if (e.target.classList.contains('cell-btn')) {
                            const cell = e.target.getAttribute('data-cell');
                            fetch(`/api/games/${gameId}`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ cell })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    updateBoard(data);
                                }
                            });
                        }
                    });

                    function updateBoard(data) {
                        // Actualitza el tauler i la info sense recarregar
                        for (let i = 0; i < 9; i++) {
                            const btn = board.querySelector(`button[data-cell="${i}"]`);
                            if (btn) {
                                if (data.board[i]) {
                                    btn.outerHTML = `<span class="display-4 fw-bold ${data.board[i] === 'X' ? 'text-danger' : 'text-primary'}">${data.board[i]}</span>`;
                                }
                            }
                        }
                        // Actualitza torn, guanyador, empat
                        document.querySelectorAll('.alert').forEach(el => el.remove());
                        const turnSpan = document.querySelector('strong + span');
                        if (turnSpan) {
                            turnSpan.textContent = data.turn;
                            turnSpan.className = data.turn === 'X' ? 'text-danger' : 'text-primary';
                        }
                        if (data.winner) {
                            const infoDiv = document.querySelector('.mb-3.text-center');
                            infoDiv.insertAdjacentHTML('beforeend', `<div class="alert alert-success mt-2"><strong>Guanyador:</strong> ${data.winner}</div>`);
                        } else if (data.is_draw) {
                            const infoDiv = document.querySelector('.mb-3.text-center');
                            infoDiv.insertAdjacentHTML('beforeend', `<div class="alert alert-secondary mt-2"><strong>Empat!</strong></div>`);
                        }
                        // Desactiva botons si partida acabada
                        if (data.winner || data.is_draw) {
                            board.querySelectorAll('button.cell-btn').forEach(btn => btn.disabled = true);
                        }
                    }
                });
            </script>
            <div class="text-center mt-3">
                <a href="{{ route('games.index') }}" class="btn btn-link text-decoration-none">&larr; Tornar a la llista</a>
            </div>
        </div>
    </div>
@endsection
