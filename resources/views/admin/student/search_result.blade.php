@if ($data && $data->count() > 0)

    <table id="result_table" class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>ID</th>
            <th>HSC_ROLL</th>
            <th>NAME</th>
            <th>HSC_BOARD</th>
            <th>HSC_YEAR</th>
            <th>SSC_ROLL</th>
            <th>HSC_GPA</th>
            <th>Mobile</th>
            <th>OTP</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{$d->id}}</td>
                <td>{{$d->HSC_ROLL_NO}}</td>
                <td>{{$d->NAME}}</td>
                <td>{{$d->HSC_BOARD_NAME}}</td>
                <td>{{$d->HSC_PASS_YEAR}}</td>
                <td>{{$d->SSC_ROLL_NO}}</td>
                <td>{{$d->HSC_GPA}}</td>
                <td>{{$d->mobile_no}}</td>
                <td>{{$d->mobile_varification_code}}</td>
                <td>{{$d->password}}</td>
                <td><a href="{{ route('admin.student.show', array($d->id)) }}"><i class="fa fa-search"></i>
                        Details</a></td>
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
