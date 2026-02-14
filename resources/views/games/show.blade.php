@extends('layouts.app')

@section('content')
    <h1 class="mb-3">Partida: <span class="text-danger">{{ $game->player_x }} (X)</span> vs <span class="text-primary">{{ $game->player_o }} (O)</span></h1>
    <div class="mb-3">
        <strong>Torn:</strong> <span class="{{ $game->turn === 'X' ? 'text-danger' : 'text-primary' }}">{{ $game->turn }}</span>
        @if($game->winner)
            <div class="alert alert-success mt-2"><strong>Guanyador:</strong> {{ $game->winner }}</div>
        @elseif($game->is_draw)
            <div class="alert alert-secondary mt-2"><strong>Empat!</strong></div>
        @endif
    </div>
    <form method="POST" action="{{ route('games.update', $game) }}">
        @csrf
        @method('PATCH')
        <table class="table table-bordered text-center align-middle" style="width: 220px;">
            <tbody>
            @for($row = 0; $row < 3; $row++)
                <tr>
                @for($col = 0; $col < 3; $col++)
                    @php $cell = $row * 3 + $col; @endphp
                    <td style="width: 70px; height: 70px;">
                        @if($game->board[$cell])
                            <span class="display-4 fw-bold {{ $game->board[$cell] === 'X' ? 'text-danger' : 'text-primary' }}">{{ $game->board[$cell] }}</span>
                        @elseif(!$game->winner && !$game->is_draw)
                            <button name="cell" value="{{ $cell }}" class="btn btn-outline-dark w-100 h-100" style="font-size:2em;">-</button>
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
    <a href="{{ route('games.index') }}" class="btn btn-link">Tornar a la llista</a>
@endsection
