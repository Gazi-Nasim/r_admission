{{-- student data --}}
<style>
    .rejected {
        border: 2px solid red;
    }

    .accepted {
        border: 2px solid green;
    }
</style>

<div class="row">
    <div class="col-sm-2">{{-- image block --}}
        @if ($student->photo)
        <img id="img" src="{{Storage::url('uploads/'.$student->photo)}}?{{rand()}}" width="200"
            @class(['img-responsive', 'img-thumbnail' , 'center-block' , 'rejected'=> $student->photo_status == 'R',
        'accepted' => $student->photo_status == 'A'
        ])
        alt="Image">
        @elseif(session()->has('inputs.tmp_photo'))
        <img id="img"
            src="{{Storage::url('uploads/bill-photos/'.Session::get('inputs.tmp_photo'))}}"
            width="200" @class(['img-responsive', 'img-thumbnail' , 'center-block' , 'rejected'=> $student->selfie_status == 'R',
        'accepted' => $student->selfie_status == 'A'
        ])
        alt="Image">
        @else
        <img id="img" src="{{url('assets/img/no_image.jpg')}}" width="200"
            class="img-responsive img-thumbnail center-block" alt="Image">
        @endif
        @if($student->photo_status == 'R')
        <p class="text-center blink_me"> <span class="label label-danger"> Photo Rejected</span></p>

        @elseif($student->photo_status == 'A')
        <p class="text-center"> <span class="label label-success">Photo OK</span></p>
        @endif

    </div>
    <div class="col-sm-2">{{-- selfie block --}}
        @if ($student->selfie)
        <img id="img" src="{{Storage::url('uploads/'.$student->selfie)}}?{{rand()}}" height="200"
            @class(['img-responsive', 'img-thumbnail' , 'center-block' , 'rejected'=> $student->selfie_status == 'R',
        'accepted' => $student->selfie_status == 'A'
        ])
        alt="Selfie">
        <br>
        @else
        <img id="img" src="{{url('assets/img/Selfie.jpg')}}" width="200"
            class="img-responsive img-thumbnail center-block" alt="Image">
        @endif

        @if($student->selfie_status == 'R')
        <p class="text-center blink_me"> <span class="label label-danger"> Selfie Rejected</span></p>
        @elseif($student->selfie_status == 'A')
        <p class="text-center"> <span class="label label-success"> Selfie OK</span></p>
        @endif
    </div>
    <div class="col-sm-8">{{-- student info --}}
        <div class="table-responsive">
            <table class="table table-bordered  table-condensed">

                <tr class="bg-success">
                    <th width="30%" colspan="2">Applicant ID</th>
                    <td colspan="5">{{$student->id}}</td>
                </tr>
                <tr class="bg-success">
                    <th colspan="2">Applicant's Name</th>
                    <td colspan="5">{{$student->NAME}}</td>
                </tr>
                <tr class="bg-success">
                    <th colspan="2">Father's Name</th>
                    <td colspan="5">{{$student->FNAME}}</td>
                </tr>
                <tr class="bg-success">
                    <th colspan="2">Mother's Name</th>
                    <td colspan="5">{{$student->MNAME}}</td>
                </tr>

                <tr>
                    <td colspan="7"></td>
                </tr>
                {{-- heading --}}
                <tr class="bg-warning">
                    <th>Exam</th>
                    <th>Roll</th>
                    <th>Board</th>
                    <th>Year</th>
                    <th>Group</th>
                    <th>CGPA</th>
                    <th>Result</th>
                </tr>
                {{-- hsc data --}}
                <tr>
                    <td>HSC/Equiv.</td>
                    <td>{{$student->HSC_ROLL_NO}}</td>
                    <td>{{$student->HSC_BOARD_NAME}}</td>
                    <td>{{$student->HSC_PASS_YEAR}}</td>
                    <td>{{$student->HSC_GROUP}}</td>
                    <td>
                        {{!empty($student->HSC_GPA) ? number_format($student->HSC_GPA,2) : '-'}}

                    </td>
                    <td @if($student->HSC_RESULT=='FAIL') class="text-danger" @endif>{{$student->HSC_RESULT}}</td>
                </tr>
                {{-- ssc data --}}
                <tr>
                    <td>SSC/Equiv.</td>
                    <td>{{$student->SSC_ROLL_NO}}</td>
                    <td>{{$student->SSC_BOARD_NAME}}</td>
                    <td>{{$student->SSC_PASS_YEAR}}</td>
                    <td>{{$student->SSC_GROUP}}</td>
                    <td>
                        {{!empty($student->SSC_GPA) ? number_format($student->SSC_GPA,2) : '-'}}
                    </td>
                    <td @if($student->SSC_RESULT=='FAIL') class="text-danger" @endif>{{$student->SSC_RESULT}}</td>
                </tr>
                
                <tr>
                    <td colspan="7"></td>
                </tr>
                <tr class="bg-warning">
                    <th colspan="2">Zone Choices</th>
                    <td colspan="5">
                        @foreach ($zoneChoices as $choice)
                        <p class="label label-primary">{{$choice->choice_priority}}. {{$choice->zone->name}}</p>
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>{{-- student data --}}