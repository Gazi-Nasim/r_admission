@if ($applications)
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th>Admission Roll</th>
                <th>Name</th>
                <th>Mother's Name</th>
                <th>Father's Name</th>
                <th>Applicant ID</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($applications as $application)
                <tr>
                    <td>{{$application->unit}} - {{$application->admission_roll}}</td>
                    <td>{!! str_ireplace( request('name'),'<u class="text-primary"><b>'.strtoupper(request('name')).'</b></u>', $application->name)!!}</td>
                    <td>{!! str_ireplace( request('mname'),'<u class="text-primary"><b>'.strtoupper(request('mname')).'</b></u>', $application->mname)!!}</td>
                    <td>{!! str_ireplace( request('fname'),'<u class="text-primary"><b>'.strtoupper(request('fname')).'</b></u>', $application->fname)!!}</td>
                    <td>{{$application->applicant_id}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    @if ($applications->count() >= 50)
        <div class="alert alert-warning">
            <strong>Warning!</strong>
            Only first 50 applications matching your search criteria are shown.
        </div>
    @endif




    {{--<div class="col-lg-5">
        @if ($application->unit =='A')
            @include('admin.admit_card_search.unit_a_result')
        @elseif($application->unit =='B')
            @include('admin.admit_card_search.unit_b_result')
        @elseif($application->unit =='C')
            @include('admin.admit_card_search.unit_c_result')
        @endif
    </div>--}}

@else
    <div class="alert alert-danger col-lg-12">
        <strong> Application Not Found / Seat location not in current center </strong>
    </div>
@endif
