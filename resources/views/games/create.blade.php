@extends('layouts.app')

@section('content')
    <h1>Nova partida de Tres en Ratlla</h1>
    <form method="POST" action="{{ route('games.store') }}">
        @csrf
        <label>Jugador X: <input type="text" name="player_x" required></label><br>
        <label>Jugador O: <input type="text" name="player_o" required></label><br>
        <button type="submit">Començar partida</button>
    </form>
    <a href="{{ route('games.index') }}">Tornar a la llista</a>
@endsection
