@extends('layouts.app')

@section('content')

    <div class="row mt-5">
        <div class="col-12 text-center">
            <h1>Premier League</h1>
        </div>

        <div class="col-12">
            @include('standing', compact('standings'))
        </div>
        <input type="hidden" id="lastWeek" value="{{$lastWeek}}">
    </div>

    <div class="row">
        <div class="col-3">
            @if(\App\Models\Standing::nextWeek() <= $lastWeek)
                <div id="play-action-buttons">
                    <button class="btn btn-primary" onclick="simulateAll(this)" data-action-url="{{route('matches.simulate_all')}}">Play all weeks</button>
                    <button class="btn btn-primary" onclick="simulateNextWeek()">Play next week</button>
                </div>
            @endif
        </div>
        <div class="col-5 text-right">
            <button class="btn btn-danger" onclick="resetAll(this)" data-action-url="{{route('matches.reset', ['all' => 1])}}">Reset all</button>
            <button class="btn btn-danger" onclick="resetAll(this)" data-action-url="{{route('matches.reset')}}">Reset (only standings & matches)</button>
        </div>
    </div>

    <div class="row">
        <div class="col-8" id="all-weeks" data-refresh-url="{{route('matches.fetch_all')}}">
            @include('all_weeks', compact('matches'))
        </div>

        <div class="col-4" id="predictions-table" data-action-url="{{route('standings.fetch_predictions')}}">
            @include('championship_prediction', compact('standings'))
        </div>
    </div>

@endsection

@push('page-script')
    <script src="{{asset('js/script.min.js')}}"></script>
@endpush
