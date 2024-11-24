@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">

            <legend><i class="fa fa-credit-card"></i> Registration Form for Unit-{{$subjectOption->unit}}</legend>

            <table class="table table-condensed table-bordered">
                <tbody>
                <tr>
                    <th width="15%">Exam Roll</th>
                    <td>{{$subjectOption->unit}}{{$subjectOption->admission_roll}}</td>
                    <th width="15%">Exam Score</th>
                    <td>{{$subjectOption->exam_score}}</td>
                    <th width="15%">Merit Position</th>
                    <td>{{$subjectOption->position}}</td>
                </tr>
                <tr>
                    <th>Student ID</th>
                    <td>Not Assigned</td>
                    <th>Registration No.</th>
                    <td>Not Assigned</td>
                    <th>Category</th>
                    <td>{{$subjectOption->unit}}-{{$subjectOption->exam_group_no}}</td>
                </tr>
                </tbody>
            </table>

            @if (Session::has('message'))
                <div class="alert alert-danger">
                    <strong><i class="fa fa-exclamation-circle"></i> {{Session::get('message')}}</strong>
                </div>
            @endif

            <legend class="text-primary"><i class="fa fa-user"></i> Personal Information</legend>
            @if (isset($student_details))
                {{Form::model($student_details, ['route'=>'hons_admission.postAdmissionFormSave','class'=>"form-horizontal"])}}
            @else
                <form action={{ route('hons_admission.postAdmissionFormSave') }} method="POST" class="form-horizontal" role="form">
            @endif

                    {{csrf_field()}}
                    <input type="hidden" name="applicant_id" value="{{$student->id}}">
                    <input type="hidden" name="subject_option_id" value="{{$subjectOption->id}}">
                    {{-- name --}}
                    <div class="form-group">
                        <label for="name" class="control-label col-sm-3">Name of Student</label>
                        <div class="col-sm-8" style="padding-top:8px">
                            {{$student->NAME}}
                        </div>
                    </div>

                    {{-- mobile_no --}}
                    <div class="form-group">
                        {{ Form::label('mobile_no', 'Mobile No.', array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-8" style="padding-top:8px">
                            {{ $student->mobile_no}}
                        </div>
                    </div>

                    {{-- mother_name --}}
                    <div class="form-group">
                        {{ Form::label('father_name', "Mother's Name", array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-8" style="padding-top:8px">
                            {{ $student->MNAME}}
                        </div>
                    </div>
                    {{-- father_name --}}
                    <div class="form-group">
                        {{ Form::label('father_name', "Father's Name", array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-8" style="padding-top:8px">
                            {{ $student->FNAME}}
                        </div>
                    </div>

                    <hr>

                    {{-- guardian_name --}}
                    <div class="form-group @if ($errors->has('guardian_name')) has-error @endif">
                        <label for="guardian_name" class="control-label col-sm-3">Guardian's Name <br><small class="text-info">In absence of parent</small></label>
                        <div class="col-sm-8" style="padding-top: 8px">
                            {{ Form::text('guardian_name', old('guardian_name') ,['class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('guardian_name') }}</span>
                        </div>
                    </div>

                    {{-- guardian_relation --}}
                    <div class="form-group @if ($errors->has('guardian_relation')) has-error @endif">
                        {{ Form::label('guardian_relation', "Guardian's Relation", array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-4">
                            {{ Form::text('guardian_relation', old('guardian_relation') ,['class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('guardian_relation') }}</span>
                        </div>
                    </div>
                    <hr>

                    {{-- dob --}}
                    <div class="form-group">
                        <div @if ($errors->has('dob')) class="has-error" @endif>
                            {{ Form::label('dob', 'Date of Birth', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-3">
                                {{ Form::text('dob', old('dob') ,['class' => 'form-control','id'=>'dob', 'placeholder'=>'dd-mm-yyyy']) }}
                                <span class="help-block">{{ $errors->first('dob') }}</span>
                            </div>
                        </div>

                        <div @if ($errors->has('birth_place')) class="has-error" @endif>
                            {{-- place of birth --}}
                            {{ Form::label('birth_place', 'Place of Birth', array('class' => 'control-label col-sm-2')) }}
                            <div class="col-sm-3">
                                {{ Form::select('birth_place', [""=>'Please Select']+$districts, old('birth_place') ,['rows'=>'3', 'class' => 'form-control' ]) }}
                                <span class="help-block">{{ $errors->first('birth_place') }}</span>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">

                        {{-- gender --}}
                        <div  @if ($errors->has('gender')) class="has-error" @endif>
                            {{ Form::label('gender', 'Gender', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-4">
                                @foreach ($gender as $value=>$label)
                                    <label class="radio-inline">
                                        {{ Form::radio('gender', $value, old('gender')==$value) }}  {{$label}}
                                    </label>
                                @endforeach
                                <span class="help-block">{{ $errors->first('gender') }}</span>
                            </div>
                        </div>

                        {{-- religion --}}
                        <div  @if ($errors->has('religion')) class="has-error" @endif>
                            {{ Form::label('religion', 'Religion', array('class' => 'control-label col-sm-1')) }}
                            <div class="col-sm-3">
                                {{ Form::text('religion', old('religion') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('religion') }}</span>
                            </div>
                        </div>


                    </div>


                    <div class="form-group">

                        {{-- blood_group --}}
                        <div  @if ($errors->has('blood_group')) class="has-error" @endif>
                            {{ Form::label('blood_group', 'Blood Group', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-3">
                                {{ Form::text('blood_group', old('blood_group') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('blood_group') }}</span>
                            </div>
                        </div>

                        {{-- height --}}
                        <div  @if ($errors->has('height')) class="has-error" @endif>
                            {{ Form::label('height', 'Height(in inch)', array('class' => 'control-label col-sm-2')) }}
                            <div class="col-sm-3">
                                {{ Form::text('height', old('height') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('height') }}</span>
                            </div>
                        </div>
                    </div>


                    {{-- birth_reg_no --}}
                    <div class="form-group @if ($errors->has('birth_reg_no')) has-error @endif">
                        {{ Form::label('birth_reg_no', 'Birth Reg. No.', array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-8">
                            {{ Form::text('birth_reg_no', old('birth_reg_no') ,['class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('birth_reg_no') }}</span>
                        </div>
                    </div>

                    {{-- nid_no --}}
                    <div class="form-group @if ($errors->has('nid_no')) has-error @endif">
                        {{ Form::label('nid_no', 'NID No.', array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-8">
                            {{ Form::text('nid_no', old('nid_no') ,['class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('nid_no') }}</span>
                        </div>
                    </div>


                    {{-- passport_no --}}
                    <div class="form-group @if ($errors->has('passport_no')) has-error @endif">
                        {{ Form::label('passport_no', 'Passport No.', array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-8">
                            {{ Form::text('passport_no', old('passport_no') ,['class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('passport_no') }}</span>
                        </div>
                    </div>



                    {{-- nationality --}}
                    <div class="form-group">
                        <div  @if ($errors->has('nationality')) class="has-error" @endif>
                            {{ Form::label('nationality', 'Nationality', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-3">
                                {{ Form::text('nationality', old('nationality') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('nationality') }}</span>
                            </div>
                        </div>

                        {{-- email --}}
                        <div  @if ($errors->has('email')) class="has-error" @endif>
                            {{ Form::label('email', 'E-mail', array('class' => 'control-label col-sm-2')) }}
                            <div class="col-sm-3">
                                {{ Form::text('email', old('email') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                    </div>


                    <br>
                    <legend class="text-primary"><i class="fa fa-home"></i> Permanent Address</legend>

                    {{-- permanent_address --}}
                    <div class="form-group @if ($errors->has('permanent_address')) has-error @endif">
                        <label for="permanent_address" class="control-label col-sm-3">Address <br><small class="text-info">(Example: House #, Rode #, Village)</small></label>
                        <div class="col-sm-8">
                            {{ Form::textarea('permanent_address', old('permanent_address') ,['rows'=>'3', 'class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('permanent_address') }}</span>
                        </div>
                    </div>


                    <div class="form-group">
                        {{-- ps_upazila --}}
                        <div  @if ($errors->has('permanent_ps_upazila')) class="has-error" @endif>
                            {{ Form::label('permanent_ps_upazila', 'Thana/Upazila', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-3">
                                {{ Form::text('permanent_ps_upazila', old('permanent_ps_upazila') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('permanent_ps_upazila') }}</span>
                            </div>
                        </div>

                        {{-- permanent_post_office --}}
                        <div  @if ($errors->has('permanent_post_office')) class="has-error" @endif>
                            {{ Form::label('permanent_post_office', 'Post Office', array('class' => 'control-label col-sm-2')) }}
                            <div class="col-sm-3">
                                {{ Form::text('permanent_post_office', old('permanent_post_office') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('permanent_post_office') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- permanent_district --}}
                    <div class="form-group @if ($errors->has('permanent_district')) has-error @endif">
                        {{-- {{ Form::label('permanent_district', 'permanent_district', array('class' => 'control-label col-sm-3')) }} --}}
                        <label for="permanent_district" class="control-label col-sm-3">District <i id="model-ind" class="fa fa-refresh fa-spin" style="display: none"></i></label>

                        <div class="col-sm-8">
                            {{ Form::select('permanent_district', [""=>'Please Select']+$districts ,old('permanent_district') ,['rows'=>'3', 'class' => 'form-control', 'id'=>'permanent_district','ic-indicator'=>'#model-ind2' ])  }}
                            <span class="help-block">{{ $errors->first('permanent_district') }}</span>
                        </div>
                    </div>



                    <br>
                    <legend class="text-primary"><i class="fa fa-home"></i> Current Address</legend>

                    {{-- current_address --}}
                    <div class="form-group @if ($errors->has('current_address')) has-error @endif">
                        <label for="current_address" class="control-label col-sm-3">Address <br><small class="text-info">(Example: House #, Rode #, Village)</small></label>
                        <div class="col-sm-8">
                            {{ Form::textarea('current_address', old('current_address') ,['rows'=>'3', 'class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('current_address') }}</span>
                        </div>
                    </div>


                    <div class="form-group">
                        {{-- ps_upazila --}}
                        <div  @if ($errors->has('current_ps_upazila')) class="has-error" @endif>
                            {{ Form::label('current_ps_upazila', 'Thana/Upazila', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-3">
                                {{ Form::text('current_ps_upazila', old('current_ps_upazila') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('current_ps_upazila') }}</span>
                            </div>
                        </div>

                        {{-- current_post_office --}}
                        <div  @if ($errors->has('current_post_office')) class="has-error" @endif>
                            {{ Form::label('current_post_office', 'Post Office', array('class' => 'control-label col-sm-2')) }}
                            <div class="col-sm-3">
                                {{ Form::text('current_post_office', old('current_post_office') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('current_post_office') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- current_district --}}
                    <div class="form-group @if ($errors->has('current_district')) has-error @endif">
                        {{-- {{ Form::label('current_district', 'current_district', array('class' => 'control-label col-sm-3')) }} --}}
                        <label for="current_district" class="control-label col-sm-3">District <i id="model-ind" class="fa fa-refresh fa-spin" style="display: none"></i></label>

                        <div class="col-sm-8">
                            {{ Form::select('current_district', [""=>'Please Select']+$districts ,old('current_district') ,['rows'=>'3', 'class' => 'form-control', 'id'=>'current_district','ic-indicator'=>'#model-ind2' ])  }}
                            <span class="help-block">{{ $errors->first('current_district') }}</span>
                        </div>
                    </div>


                    <br>
                    <legend class="text-primary"><i class="fa fa-exclamation-circle"></i> Emergency Contact</legend>
                    {{-- emergency_name --}}
                    <div class="form-group @if ($errors->has('emergency_name')) has-error @endif">
                        <label for="emergency_name" class="control-label col-sm-3">Emergency Contact Person Name</label>
                        <div class="col-sm-8" style="padding-top: 8px">
                            {{ Form::text('emergency_name', old('emergency_name') ,['class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('emergency_name') }}</span>
                        </div>
                    </div>

                    {{-- emergency_relation --}}
                    <div class="form-group">
                        <div  @if ($errors->has('emergency_relation')) class="has-error" @endif>
                            {{ Form::label('emergency_relation', "Relation", array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-3">
                                {{ Form::text('emergency_relation', old('emergency_relation') ,['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('emergency_relation') }}</span>
                            </div>
                        </div>

                        {{-- emergency_contact --}}
                        <div  @if ($errors->has('emergency_contact')) class="has-error" @endif>
                            {{ Form::label('emergency_contact', "Contact No.", array('class' => 'control-label col-sm-2')) }}
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">+88</div>
                                    {{ Form::text('emergency_contact', old('emergency_contact') ,['class' => 'form-control']) }}
                                </div>
                                <span class="help-block">{{ $errors->first('emergency_contact') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- emergency_address --}}
                    <div class="form-group @if ($errors->has('emergency_address')) has-error @endif">
                        <label for="emergency_address" class="control-label col-sm-3">Full Address</label>
                        <div class="col-sm-8">
                            {{ Form::textarea('emergency_address', old('emergency_address') ,['rows'=>'3', 'class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('emergency_address') }}</span>
                        </div>
                    </div>


                    <br>
                    <legend class="text-primary"><i class="fa fa-book"></i> Previous Academic Info</legend>
                    {{-- ssc_institute --}}
                    <div class="form-group @if ($errors->has('ssc_institute')) has-error @endif">
                        {{ Form::label('ssc_institute', "SSC Institute Name", array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-8">
                            {{ Form::text('ssc_institute', old('ssc_institute') ,['class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('ssc_institute') }}</span>
                        </div>
                    </div>

                    {{-- hsc_institute --}}
                    <div class="form-group @if ($errors->has('hsc_institute')) has-error @endif">
                        {{ Form::label('hsc_institute', "HSC Institute Name", array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-8">
                            {{ Form::text('hsc_institute', old('hsc_institute') ,['class' => 'form-control']) }}
                            <span class="help-block">{{ $errors->first('hsc_institute') }}</span>
                        </div>
                    </div>

                    <hr>

                    {{-- submit --}}
                    <div class="form-group @if ($errors->has('submit')) has-error @endif">
                        {{ Form::label('submit', " ", array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-8 text-right">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>

                {{Form::close()}}


        </div>
    </div>{{-- panel-default --}}
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
    {{ Html::script('assets/plugins/datepicker2/js/bootstrap-datepicker.js') }}


    <script type="text/javascript">
        $(document).ready(function() {
            format = {
                format: "dd-mm-yyyy",
                startView: "decade",
                autoclose:true
            };

            $('#dob').datepicker(format);
            console.log('called')

        });

    </script>
@stop

@section('css-extra')
    {{ Html::style('assets/plugins/datepicker2/css/datepicker.css') }}
@endsection
