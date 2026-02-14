@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Llista de partides</h1>
        <a href="{{ route('games.create') }}" class="btn btn-primary">Nova partida</a>
    </div>
    <ul class="list-group">
        @forelse($games as $game)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('games.show', $game) }}" class="fw-bold text-decoration-none">
                    {{ $game->player_x }} <span class="text-danger">(X)</span> vs {{ $game->player_o }} <span class="text-primary">(O)</span>
                </a>
                <span>
                    @if($game->winner)
                        <span class="badge bg-success">Guanyador: {{ $game->winner }}</span>
                    @elseif($game->is_draw)
                        <span class="badge bg-secondary">Empat</span>
                    @else
                        <span class="badge bg-warning text-dark">En joc</span>
                    @endif
                </span>
            </li>
        @empty
            <li class="list-group-item">Encara no hi ha cap partida.</li>
        @endforelse
    </ul>
@endsection
