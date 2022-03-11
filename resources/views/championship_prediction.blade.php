<table class="table table-striped table-sm">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Team</th>
        <th scope="col">Percentage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($predictions as $prediction)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>
                <img width="16" src="{{$prediction->get('team')->image_path}}" alt="{{$prediction->get('team')->name}}" />
                {{$prediction->get('team')->name}}
            </td>

            <td>
                {{$prediction->get('percentage')}}%
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
