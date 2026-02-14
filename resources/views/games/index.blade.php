@extends('layouts.app')

@section('content')
    <h1>Llista de partides</h1>
    <a href="{{ route('games.create') }}">Nova partida</a>
    <ul>
        @foreach($games as $game)
            <li>
                <a href="{{ route('games.show', $game) }}">
                    {{ $game->player_x }} vs {{ $game->player_o }}
                    @if($game->winner)
                        - Guanyador: {{ $game->winner }}
                    @elseif($game->is_draw)
                        - Empat
                    @else
                        - En joc
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
@endsection
