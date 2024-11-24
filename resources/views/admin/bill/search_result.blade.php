@if ($data && $data->count() > 0)

    <table id="result_table" class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>id</th>
            <th>Applicant</th>
            <th>Amount</th>
            <th>Units</th>
            <th>Quota</th>
            <th>Paid By</th>
            <th>Purpose</th>
            <th>Status</th>
            <th>Created</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{$d->id}}</td>
                <td>{{$d->applicant_id}}</td>
                <td>{{$d->amount}}</td>
                <td>{{$d->units}}</td>
                <td>{{$d->quota}}</td>
                <td>
                    @if(Str::of($d->payment_method)->upper()->startsWith('B'))
                        <label class="label bg-pink">bKash</label>
                    @elseif(Str::of($d->payment_method)->upper()->startsWith('R'))
                        <label class="label bg-purple">Rocket</label>
                    @endif
                </td>
                <td>{{$d->payment_purpose}}</td>
                <td>{{$d->payment_status}}</td>
                <td>{{$d->created_at}}</td>
                <td>
                    <a  target="_blank" href="{{ route('admin.bill.showDetails', $d) }}" ><i class="fa fa-info-circle"></i> View</a> |
                    <a href="{{ route('admin.student.show', $d->applicant_id) }}" target="_blank"><i class="fa fa-user"></i> Details</a>
                </td>
                <td>
                    <a href="{{route('admin.bill.getDownloadBill',$d)}}" target="_blank"><i class="fa fa-download"></i> DL</a>
                </td>
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
