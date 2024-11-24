@if ($data && $data->count() > 0)

    <table id="result_table" class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>ID</th>
            <th width="20%">NAME</th>
            <th width="15%">HSC ROLL(BOARD)</th>
            <th>Description</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{$d->id}}</td>
                <td>{{$d->NAME}}</td>
                <td><b>{{$d->HSC_ROLL_NO}}</b> <span class="text-primary"> [ {{ $d->HSC_BOARD_NAME}} ]</span></td>
                <td>
                    {{$d->message}}
                    <br>
                    <span class="label label-default">{{$d->created_at->diffForHumans()}}</span>
                </td>
                <td>{{$d->status}}</td>
                <td><a class="btn btn-default btn-xs" href="{{ route('admin.complainbox.show',$d) }}" target="_blank" role="button"> <i class="fa fa-search"></i> Details</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-center">
        {{$data->links('admin.pagination',['target'=>'#result'])}}
    </div>
@else
    <div class="alert alert-danger">
        <strong> No Info </strong>
    </div>
@endif
