<table class="table table-striped" id="week-{{$week}}">
    <thead>
    <tr>
        <th class="border-0" scope="row"></th>
        <th class="border-0" scope="row"></th>
        <th class="border-0" scope="row"></th>
    </tr>
    </thead>
    <tbody>
    <tr class="bg-dark">
        <td class="text-white text-center" colspan="3">
            <h5>{{weeks($week)}} week</h5>
        </td>
    </tr>
    @foreach($weekMatches as $match)
        <tr>
            <td class="text-center col-3 align-middle">
                <img width="32" src="{{$match->homeTeam->image_path}}" alt="{{$match->homeTeam->name}}" />
                {{$match->homeTeam->name}}
            </td>
            <td class="text-center col-1 align-middle">{{$match->home_team_goal}} &#8212; {{$match->away_team_goal}}</td>
            <td class="text-center col-3 align-middle">
                <img width="32" src="{{$match->awayTeam->image_path}}" alt="{{$match->awayTeam->name}}" />
                {{$match->awayTeam->name}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
