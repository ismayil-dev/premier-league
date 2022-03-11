@php $nextWeek = \App\Models\Standing::nextWeek(); @endphp
<table class="table table-striped table-sm" id="standings-table" data-update-url="{{route('standings.fetch')}}">
    <input type="hidden" id="nextWeek" value="{{$nextWeek}}" data-action-url="{{route('matches.simulate_week', ['week' => $nextWeek])}}"/>
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Team</th>
        <th class="text-center" scope="col">Played</th>
        <th class="text-center" scope="col">Won</th>
        <th class="text-center" scope="col">Drawn</th>
        <th class="text-center" scope="col">Lost</th>
        <th class="text-center" scope="col">GF</th>
        <th class="text-center" scope="col">GA</th>
        <th class="text-center" scope="col">GD</th>
        <th class="text-center" scope="col">Score</th>
    </tr>
    </thead>
    <tbody>
    @foreach($standings as $standing)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>
                <img width="16" src="{{$standing->team->image_path}}" alt="{{$standing->team->name}}" />
                {{$standing->team->name}}
            </td>
            <td class="text-center">{{$standing->played}}</td>
            <td class="text-center">{{$standing->won}}</td>
            <td class="text-center">{{$standing->drawn}}</td>
            <td class="text-center">{{$standing->lost}}</td>
            <td class="text-center">{{$standing->goal_for}}</td>
            <td class="text-center">{{$standing->goal_against}}</td>
            <td class="text-center">{{$standing->goal_difference}}</td>
            <td class="text-center">{{$standing->score}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
