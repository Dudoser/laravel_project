@extends('templates.main_template')

@section('content')
    <h1>Page A</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <h2>Your token: {{ auth()->user()->userToken->token ?? 'No active token' }}</h2>
    <h2>Actions with a token :</h2>
    <form action="{{ route('token.generate') }}" method="POST">
        @csrf
        <button type="submit">Generate new token</button>
    </form>

    <form action="{{ route('token.deactivate') }}" method="POST">
        @csrf
        <button type="submit">Deactivate token</button>
    </form>

    <form action="{{ route('token.lucky') }}" method="POST">
        @csrf
        <button type="submit">I'm feeling lucky</button>
    </form>

    <a href="{{ route('token.history') }}">History</a>
@endsection
