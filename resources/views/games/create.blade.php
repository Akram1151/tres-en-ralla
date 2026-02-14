@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Nova partida de Tres en Ratlla</h1>
    <form method="POST" action="{{ route('games.store') }}" class="card p-4 shadow-sm mb-3" style="max-width: 400px;">
        @csrf
        <div class="mb-3">
            <label class="form-label">Jugador <span class="text-danger">X</span>:</label>
            <input type="text" name="player_x" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jugador <span class="text-primary">O</span>:</label>
            <input type="text" name="player_o" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Començar partida</button>
    </form>
    <a href="{{ route('games.index') }}" class="btn btn-link">Tornar a la llista</a>
@endsection
