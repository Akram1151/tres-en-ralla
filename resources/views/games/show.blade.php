@extends('layouts.app')

@section('content')
    <h1>Partida: {{ $game->player_x }} (X) vs {{ $game->player_o }} (O)</h1>
    <div>
        <strong>Torn:</strong> {{ $game->turn }}
        @if($game->winner)
            <div><strong>Guanyador:</strong> {{ $game->winner }}</div>
        @elseif($game->is_draw)
            <div><strong>Empat!</strong></div>
        @endif
    </div>
    <form method="POST" action="{{ route('games.update', $game) }}">
        @csrf
        @method('PATCH')
        <table style="border-collapse: collapse;">
            <tbody>
            @for($row = 0; $row < 3; $row++)
                <tr>
                @for($col = 0; $col < 3; $col++)
                    @php $cell = $row * 3 + $col; @endphp
                    <td style="width: 50px; height: 50px; text-align: center; border: 1px solid #000;">
                        @if($game->board[$cell])
                            <span style="font-size: 2em;">{{ $game->board[$cell] }}</span>
                        @elseif(!$game->winner && !$game->is_draw)
                            <button name="cell" value="{{ $cell }}" style="width:100%;height:100%;font-size:2em;">-</button>
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
    <a href="{{ route('games.index') }}">Tornar a la llista</a>
@endsection
