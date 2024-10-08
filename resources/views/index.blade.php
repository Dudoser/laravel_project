@extends('templates.main_template')

@section('title-block')
    main page
@endsection

@section('content')

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <h1>Main page</h1>

    @auth
        <a href="{{ route('special.page', ['token' => auth()->user()->userToken->token])  }}">go to special page</a>
    @endauth

@endsection
