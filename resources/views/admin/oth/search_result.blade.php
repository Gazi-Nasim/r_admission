@if (count($applicants))
    <table class="table table-striped table-condensed">
        <thead>
        <tr>
            <th>NAME</th>
            <th>MOBILE</th>
            <th>HSC_ROLL</th>
            <th>HSC_YEAR</th>
            <th>HSC_BOARD</th>
            <th>HSC_GPA</th>
            <th>SSC_GPA</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($applicants as $applicant)
            <tr>
                <td>{{$applicant->NAME}}</td>
                <td>{{$applicant->mobile_no}}</td>
                <td>{{$applicant->HSC_ROLL_NO}}</td>
                <td>{{$applicant->HSC_PASS_YEAR}}</td>
                <td>{{$applicant->HSC_BOARD_NAME}}</td>
                <td>{{$applicant->HSC_GPA}}</td>
                <td>{{$applicant->SSC_GPA}}</td>
                <td><a class="btn btn-default btn-xs" href="{{ route('admin.oth.show', $applicant) }}" role="button"> <i
                            class="fa fa-search"></i> Details</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-center">

        {{$applicants->links('admin.pagination',['target'=>'#result'])}}
    </div>

@else
    <div class="alert alert-danger">
        <strong> No Result </strong>
    </div>
@endif
