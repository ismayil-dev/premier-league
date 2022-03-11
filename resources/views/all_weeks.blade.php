@foreach($matches as $week => $weekMatches)
    @include('week_match', compact('weekMatches', 'week'))
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-success" onclick="simulateWeek('{{$week}}', this)" data-action-url="{{route('matches.simulate_week', $week)}}">Play {{weeks($week)}} week
            </button>
        </div>
    </div>
@endforeach
