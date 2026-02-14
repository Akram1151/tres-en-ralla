@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="card shadow-lg p-4" style="max-width: 420px; width: 100%; background: #fff9f2; border-radius: 1.2rem;">
            <h1 class="mb-4 text-center fw-bold" style="letter-spacing:1px; color:#d2691e;">Nova partida de Tres en Ratlla</h1>
            <form method="POST" action="{{ route('games.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Jugador <span class="text-danger">X</span>:</label>
                    <input type="text" name="player_x" class="form-control form-control-lg border-2 border-danger-subtle rounded-pill" placeholder="Nom jugador X" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Jugador <span class="text-primary">O</span>:</label>
                    <input type="text" name="player_o" class="form-control form-control-lg border-2 border-primary-subtle rounded-pill" placeholder="Nom jugador O" required>
                </div>
                <button type="submit" class="btn btn-success w-100 py-2 rounded-pill fw-bold shadow-sm" style="font-size:1.2em;">Començar partida</button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('games.index') }}" class="btn btn-link text-decoration-none">&larr; Tornar a la llista</a>
            </div>
        </div>
    </div>
@endsection
