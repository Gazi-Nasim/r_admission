@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-dashboard"></i> GCE Informations</legend>

            {{-- row 1 --}}
            <div class="row">
                <div class="col-sm-8">

                    <p>
                        <a href="{{ route('admin.oth.index') }}" class="btn btn-primary"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong> <i class="fa fa-exclamation-circle"></i> Please check for error</strong>
                        </div>
                    @endif

                    @if (session()->has('message'))
                        @if (session('message.error'))
                            <div class="alert alert-danger">
                                <strong> {{session('message.msg')}} </strong>
                            </div>
                        @else
                            <div class="alert alert-success">
                                <strong> {{session('message.msg')}} </strong>
                            </div>
                        @endif
                    @endif

                    @if ($applicant)
                        <table class="table table-bordered  table-condensed">
                            <tr class="bg-success">
                                <th width="30%" colspan="2">Applicant's Name</th>
                                <td colspan="5">{{$applicant->NAME}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Father's Name</th>
                                <td colspan="5">{{$applicant->FNAME}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Mother's Name</th>
                                <td colspan="5">{{$applicant->MNAME}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Date of Birth</th>
                                <td colspan="5">{{$applicant->dob}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Gender</th>
                                <td colspan="5">{{$applicant->sex}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Mobile No</th>
                                <td colspan="5">{{$applicant->mobile_no}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Status</th>
                                <td colspan="5">{{$applicant->status}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">RU_HSC_GROUP</th>
                                <td colspan="5">{{$applicant->RU_HSC_GROUP}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">OTH BOARD</th>
                                <td colspan="5">{{$applicant->oth_board}}</td>
                            </tr>
                            <tr>
                                <th colspan="2">Eligible</th>
                                <td colspan="5">
                                    @foreach ($units_eligible as $key=>$value)
                                        @if ($value > 0)
                                            <span class="badge">{{$key}}</span>
                                        @endif
                                    @endforeach
                                </td>
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
                                <th>GPA</th>
                                <th>Result</th>
                            </tr>
                            {{-- hsc data --}}
                            <tr>
                                <td>HSC/Equiv.</td>
                                <td>{{$applicant->HSC_ROLL_NO}}</td>
                                <td>{{$applicant->HSC_BOARD_NAME}}</td>
                                <td>{{$applicant->HSC_PASS_YEAR}}</td>
                                <td>{{$applicant->HSC_GROUP}}</td>
                                <td>{{number_format($applicant->HSC_GPA,2)}}</td>
                                <td @if($applicant->HSC_RESULT=='FAIL') class="text-danger" @endif>{{$applicant->HSC_RESULT}}</td>
                            </tr>
                            {{-- ssc data --}}
                            <tr>
                                <td>SSC/Equiv.</td>
                                <td>{{$applicant->SSC_ROLL_NO}}</td>
                                <td>{{$applicant->SSC_BOARD_NAME}}</td>
                                <td>{{$applicant->SSC_PASS_YEAR}}</td>
                                <td>{{$applicant->SSC_GROUP}}</td>
                                <td>{{number_format($applicant->SSC_GPA,2)}}</td>
                                <td @if($applicant->SSC_RESULT=='FAIL') class="text-danger" @endif>{{$applicant->SSC_RESULT}}</td>
                            </tr>
                        </table>

                        <div class="alert alert-info">
                            <p><b>Comment</b></p>
                            {{$applicant->comment}}
                        </div>

                        @if ( empty($applicant->status) || auth()->user()->hasRole('Admin'))
                            {{Form::open( ['route'=>'admin.oth.updateStatus', 'id'=>'form1' ] )}}

                            {{-- eligibility --}}
                            <p @if ($errors->has('units_eligible')) class="bg-danger" @endif>
                                <label class="control-label">
                                    Elegible for :
                                </label>

                                @foreach ($units as $unit)
                                    <label class="checkbox-inline">
                                        {{Form::checkbox('units_eligible[]', $unit, in_array($unit, array_keys(old('units_eligible', []),$units)))}} {{$unit}}
                                    </label>
                                @endforeach
                                {!! $errors->first('units_eligible','<span class="help-block">:message</span>') !!}
                            </p>

                            {{-- ru_hsc_group --}}
                            <p @if ($errors->has('ru_hsc_group')) class="bg-danger" @endif>
                                <label class="control-label">
                                    RU HSC GROUP :
                                </label>

                                <label
                                    class="radio-inline">{{ Form::radio('ru_hsc_group', 'S', old('ru_hsc_group')=='S') }}
                                    Science</label>
                                <label
                                    class="radio-inline">{{ Form::radio('ru_hsc_group', 'H', old('ru_hsc_group')=='H') }}
                                    Humanities</label>
                                <label
                                    class="radio-inline">{{ Form::radio('ru_hsc_group', 'C', old('ru_hsc_group')=='C') }}
                                    Commerce</label>
                                {!! $errors->first('ru_hsc_group','<span class="help-block">:message</span>') !!}
                            </p>

                            {{-- oth_board --}}
                            <p @if ($errors->has('oth_board')) class="bg-danger" @endif>
                                <label class="control-label">
                                    OTH Board :
                                </label>

                                <label
                                    class="radio-inline">{{ Form::radio('oth_board', 'GCE',old('oth_board')=='GCE') }}
                                    GCE</label>
                                <label
                                    class="radio-inline">{{ Form::radio('oth_board', 'BFA',old('oth_board')=='BFA') }}
                                    BFA</label>
                                <label
                                    class="radio-inline">{{ Form::radio('oth_board', 'DIP',old('oth_board')=='DIP') }}
                                    Diploma</label>
                                {!! $errors->first('oth_board','<span class="help-block">:message</span>') !!}
                            </p>

                            <p @if ($errors->has('comment')) class="bg-danger" @endif>
                                <textarea name="comment" id="input" class="form-control" rows="3"
                                          placeholder="Comment"></textarea>
                            {!! $errors->first('comment','<span class="help-block">:message</span>') !!}
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="send_sms" value="1">
                                    Send SMS
                                </label>
                            </div>
                            </p>
                            <p>
                                <button type="submit" name="status" value="R" onclick="return confirm('Are you sure?')"
                                        class="al btn btn-danger"><i class="fa fa-times"></i> Rejaet
                                </button>
                                <button type="submit" name="status" value="A" onclick="return confirm('Are you sure?')"
                                        class="al btn btn-success"><i class="fa fa-check"></i> Accept
                                </button>

                                {{Form::hidden('id', $applicant->id)}}
                                {{Form::hidden('u', 'op')}}
                            </p>

                            {{ Form::close()}}
                        @endif

                    @else
                        {{-- false expr --}}
                    @endif
                </div>

                <div class="col-sm-4">
                    <p class="text-center">

                        <a href="{{Storage::url('public/uploads/oth/'.$applicant->photo_hsc)}}" target="_blank">
                            {{ Html::image(Storage::url('public/uploads/oth/'.$applicant->photo_hsc), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>150)) }}
                        </a>
                        HSC Transcript<br><br>

                        <a href="{{Storage::url('public/uploads/oth/').$applicant->photo_ssc}}" target="_blank">
                            {{ Html::image(Storage::url('public/uploads/oth/'.$applicant->photo_ssc), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>150)) }}
                        </a>
                        SSC Transcript
                    </p>
                </div>


            </div>

        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-0.4.10.js') }}
@stop

