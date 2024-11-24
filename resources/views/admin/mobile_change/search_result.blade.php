@if (count($mobile_changes) )
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>APP. ID</th>
            <th>NAME</th>
            <th>Reason</th>
            <th>Date</th>
            <th>Checked by</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($mobile_changes as $mobile_change)
            <tr>
                <td>{{$mobile_change->applicant->id}}</td>
                <td>{{$mobile_change->applicant->NAME}}</td>
                <td>{{Str::limit($mobile_change->reason,125)}}</td>
                <td>{{$mobile_change->created_at->diffForHumans()}}</td>
                @if($mobile_change->user_checked)
                    <td>{{$mobile_change->user_checked->fullname}}</td>
                @else
                    <td>&nbsp;</td>
                @endif
                <td>{{$mobile_change->status}}</td>
                <td>
                    <a href="{{ route('admin.mobile-change.show',$mobile_change->id) }}" class="label label-info">		View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <div class="text-center">
        {{$mobile_changes->links('admin.pagination',['target'=>'#result'])}}
    </div>

@else
    <div class="alert alert-info">
        <strong><i class="fa fa-info-circle"></i> No data found</strong>
    </div>
@endif
