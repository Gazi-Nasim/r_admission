@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-mobile"></i> Mobile No. Review</legend>

            <p>
                <a href="{{ route('admin.mobile-change.index') }}" class="btn btn-primary"><i
                        class="fa fa-arrow-left"></i>
                    Back</a>
            </p>
            {{-- row 1 --}}
            <div class="row">
                <div class="col-sm-8">


                    {{--                @if (Session::has('message'))--}}
                    {{--                    @if (Session::get('message.error'))--}}
                    {{--                        <div class="alert alert-danger">--}}
                    {{--                            <strong> {{Session::get('message.msg')}} </strong>--}}
                    {{--                        </div>--}}
                    {{--                    @else--}}
                    {{--                        <div class="alert alert-success">--}}
                    {{--                            <strong> {{Session::get('message.msg')}} </strong>--}}
                    {{--                        </div>--}}
                    {{--                    @endif--}}
                    {{--                @endif--}}

                    @if (Session::has('message'))
                        <div class="alert alert-success">
                            <strong> {{Session::get('message')}} </strong>
                        </div>
                    @endif


                    @if (count((array)$mobile_change))
                        <table class="table table-bordered  table-condensed">
                            <tr class="bg-success">
                                <th width="30%" colspan="2">Applicant ID</th>
                                <td colspan="5">{{$mobile_change->applicant->id}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th width="30%" colspan="2">Applicant's Name</th>
                                <td colspan="5">{{$mobile_change->applicant->NAME}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Father's Name</th>
                                <td colspan="5">{{$mobile_change->applicant->FNAME}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Mother's Name</th>
                                <td colspan="5">{{$mobile_change->applicant->MNAME}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Date of Birth</th>
                                <td colspan="5">{{$mobile_change->applicant->dob}}</td>
                            </tr>
                            <tr class="bg-success">
                                <th colspan="2">Gender</th>
                                <td colspan="5">{{$mobile_change->applicant->SEX}}</td>
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
                                <th>Reg. No</th>
                            </tr>
                            {{-- hsc data --}}
                            <tr>
                                <td>HSC/Equiv.</td>
                                <td>{{$mobile_change->applicant->HSC_ROLL_NO}}</td>
                                <td>{{$mobile_change->applicant->HSC_BOARD_NAME}}</td>
                                <td>{{$mobile_change->applicant->HSC_PASS_YEAR}}</td>
                                <td>{{$mobile_change->applicant->HSC_GROUP}}</td>
                                <td>{{number_format($mobile_change->applicant->HSC_GPA,2)}}</td>
                                <td>{{$mobile_change->applicant->HSC_REGNO}}</td>
                            </tr>
                            {{-- ssc data --}}
                            <tr>
                                <td>SSC/Equiv.</td>
                                <td>{{$mobile_change->applicant->SSC_ROLL_NO}}</td>
                                <td>{{$mobile_change->applicant->SSC_BOARD_NAME}}</td>
                                <td>{{$mobile_change->applicant->SSC_PASS_YEAR}}</td>
                                <td>{{$mobile_change->applicant->SSC_GROUP}}</td>
                                <td>{{number_format($mobile_change->applicant->SSC_GPA,2)}}</td>
                                <td>{{$mobile_change->applicant->ssc_regi}}</td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <tr class="bg-danger">
                                <th colspan="2">No. Of Previous Changes</th>
                                <td colspan="5" class="text-danger">
                                    <strong>{{$mobile_change_count}}</strong>
                                </td>
                            </tr>

                            <tr class="bg-warning">
                                <th colspan="2">Old Mobile No</th>
                                <td colspan="5" class="text-danger"><strong>{{$mobile_change->old_mobile_no}}</strong>
                                </td>
                            </tr>

                            <tr class="bg-warning">
                                <th colspan="2">New Mobile No</th>
                                <td colspan="5" class="tebg-warning"><strong>{{$mobile_change->new_mobile_no}}</strong>
                                </td>
                            </tr>

                            <tr class="bg-warning">
                                <th colspan="2">Reason</th>
                                <td colspan="5">{{$mobile_change->reason}}</td>
                            </tr>

                            <tr class="bg-warning">
                                <th colspan="2">Status</th>
                                <td colspan="5">{{$mobile_change->status}}</td>
                            </tr>

                        </table>

                        <hr>
                        <div class="alert alert-info">
                            <p><b>Comment</b></p>
                            {{$mobile_change->comment}}
                        </div>

                        @if ( empty($mobile_change->status) || Auth::user()->hasRole('Admin'))
                            {{Form::open( array('route'=>'admin.mobile-change.updateStatus', 'id'=>'form1' ) )}}


                            <p @if ($errors->has('comment')) class="bg-danger" @endif>
                                <textarea name="comment" id="input" class="form-control" rows="3"
                                          placeholder="Comment"></textarea>
                            {!! $errors->first('comment','<span class="help-block">:message</span>') !!}
                            <div class="checkbox">
                                {{--                                <label>--}}
                                <input type="hidden" name="send_sms" value="1">
                                {{--                                </label>--}}
                            </div>
                            </p>
                            <p>
                                <button type="submit" name="status" value="R"
                                        class="al btn btn-danger"><i class="fa fa-times"></i> Reject
                                </button>
                                <button type="submit" name="status" value="A"
                                        class="al btn btn-success"><i class="fa fa-check"></i> Accept
                                </button>
                                {{Form::hidden('id', $mobile_change->id)}}
                            </p>

                            {{ Form::close()}}
                        @endif

                    @else
                        {{-- false expr --}}
                    @endif
                </div>

                <div class="col-sm-4">
                    <p class="text-center well well-sm">

                        <a href="{{Storage::url('public/uploads/mobile-change/'.$mobile_change->doc1)}}" target="_blank">

                            @if (strpos($mobile_change->doc1, '.pdf') !== false)
                                {{ Html::image('assets/img/pdf-icon-gray.png', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>250)) }}
                                <br>
                            @else
                                {{ Html::image(Storage::url('public/uploads/mobile-change/'.$mobile_change->doc1), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>150)) }}
                            @endif

                        </a>
                        Photo ID<br><br>

                        <img src="{{Storage::url('public/uploads/'.$mobile_change->applicant->photo)}}" width="150"  class="img-responsive img-thumbnail center-block">

                        {{--                    <a href="{{URL::asset('/uploads/mobile-change/'.$mobile_change->doc2)}}" target="_blank">--}}
                        {{--                        {{ Html::image('uploads/mobile-change/'.$mobile_change->doc2, 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>150)) }}--}}
                        {{--                    </a>--}}
                        {{--                    SSC Transcript--}}
                    </p>
                </div>


            </div>


        </div>
    </div>
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js') }}
    <script type="text/javascript">
        $(document).ready(function () {
            $('.datepicker').datetimepicker({
                format: "YYYY-MM-DD HH:mm",
                autoclose: true,
                todayHighlight: true,
                sideBySide: true,
                inline: true,
            });

        });
    </script>
@stop


@section('css-extra')
    {{Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.css')}}
@stop

