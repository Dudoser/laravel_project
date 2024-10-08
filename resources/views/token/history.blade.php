@extends('templates.main_template')

@section('content')

    <h1>History of results | count: {{ $countRows  }}</h1>

    <ul>
        @foreach($history as $entry)
            <li>
                Random number: {{ $entry->random_number }},
                Result: @if($entry->result) Win @else Lose @endif ,
                Win sum: {{ $entry->win_amount }}
            </li>
        @endforeach
    </ul>

    <a href="{{ URL::previous() }}">back</a>
@endsection
