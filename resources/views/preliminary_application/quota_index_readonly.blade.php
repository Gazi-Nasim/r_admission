@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">


            {{-- quotas --}}
            <legend><i class="fa fa-font"></i> কোটা সংক্রান্ত তথ্য</legend>
            {{-- quota list --}}
            <div class="row">
                <div class="col-sm-12">

                    <div class="alert alert-danger">
                        <p style="line-height:1.3em">কোটার তথ্য আপডেট করতে নিচের "Unlock Quota Update" তে ক্লিক করুন।

                        </p>
                    </div>
                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" id="route" name="route" value="{{route('preliminary.getQuotaIndex')}}">
                    @include('preliminary_application.verification_popup')
                    <p>
                        <a class="btn btn-danger" data-toggle="modal" href='#modal-id'><i class="fa fa-lock"></i> Unlock Quota Update</a>
                    </p>

                    <table class="table table-hover table-striped table-bordered table-condensed" disabled>
                        <thead>
                        <tr>
                            <th>Quota</th>
                            <th  colspan="3" class="text-center">Action</th>

                        </tr>
                        </thead>
                        <tbody>



                        @foreach ($quotas as $key=>$value)
                            @if($key!='BKSP')
                            <tr>
                                <td width="60%">{{$value}} ({{$key}})</td>
                                <td width="5%">
                                    @if ($student->{$key.'_photo'} != null)
                                    <a class="btn btn-default btn-xs disabled" href="#"><i class="fa fa-edit"></i> Update Quota</a>
                                    @else
                                    <a class="btn btn-default btn-xs disabled" href=""><i class="fa fa-plus-square"></i> Add Quota</a>
                                    @endif
                                </td>
                                <td width="20%">
                                    @if ($student->{$key.'_photo'} != null)
                                        <a class="btn btn-success btn-xs" target="_blank" href="{{Storage::url('public/uploads/'.$student->{$key.'_photo'})}}"><i class="fa fa-search"></i>View</a>
                                        <a  onclick="return confirm('Are you sure')"  class="btn btn-danger btn-xs disabled" href="#"><i class="fa fa-times-circle"></i> Delete</a>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @else
                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-info">
                                            আপনার যদি BKSP এর সার্টিফিকেট থাকে তবে  সার্টিফিকেট আপলোড করুন। BKSP এর সার্টিফিকেট শুধুমাত্র Physical Education এর জন্য প্রয়োজন।
                                        </div>

                                        <div class="text-center">
                                            {{--Add/Update Button--}}
                                            @if ($student->{$key.'_photo'} != null)
                                                <a class="btn btn-primary disabled" href="{{route('preliminary.getAddQuota',$key)}}"><i class="fa fa-edit"></i> Update BKSP Certificate</a>
                                            @else
                                                <a class="btn btn-primary disabled" href="{{route('preliminary.getAddQuota',$key)}}"><i class="fa fa-plus-square"></i> Add BKSP Certificate</a>
                                            @endif

                                            {{--Delete button--}}
                                            @if ($student->{$key.'_photo'} != null)
                                                <a class="btn btn-success" target="_blank" href="{{Storage::url('public/uploads/'.$student->{$key.'_photo'})}}"><i class="fa fa-search"></i>View</a>
                                                <a  onclick="return confirm('Are you sure')"  class="btn btn-danger disabled" href="#"><i class="fa fa-times-circle"></i> Delete</a>
                                            @endif


                                        </div>
                                        <br>
                                    </td>
                                </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>



{{--                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">--}}
{{--                    @if(session('authorize_this_session',0))--}}
{{--                        @include('preliminary_application.quota_list_editable', ['student' => $student, 'quotas'=>$quotas])--}}
{{--                    @else--}}
{{--                        @include('preliminary_application.quota_list_readonly', ['student' => $student, 'quotas'=>$quotas])--}}
{{--                    @endif--}}

                </div>
            </div>
            {{-- Submit  --}}
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    {{-- <input type="hidden" name="mobile_no" value="{{$student->mobile_no}}"> --}}
                    <p class="text-right">
                        <a class="btn btn-danger" href="{{ route('student.getDashboard') }}"><i
                                class="fa fa-home"></i> Back</a>
                        @if( !session()->missing('inputs.units') )
                            <a class="btn btn-primary" href="{{ route('preliminary.getConfirmation') }}">
                                Next <i class="fa fa-long-arrow-right"></i> </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>{{-- panel-default --}}
@stop

@section('css-extra')
    <style type="text/css">
        .fileinput-button {
            position: relative;
            overflow: hidden;
        }

        .fileinput-item {
            position: absolute;
            font-size: 50px;
            opacity: 0;
            right: 0;
            top: 0;

        }
    </style>
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#FFQ').click(function () {
                $('#quota-ffq').toggle();
                $('#ffq_type1').prop('checked', false);
                $('#ffq_type2').prop('checked', false);
                $('#ffq_number').prop('value', '');

            });

            $('#WQ').click(function () {
                $('#quota-wq').toggle();
                $('#wq_salary_id').prop('value', '');
                // trigger enter key pressed

            });


            $('#form').submit(function (event) {
                if ($('#FFQ').prop('checked')) {

                    console.log()

                    if (!$('#ffq_type1').prop('checked') && !$('#ffq_type2').prop('checked')) {
                        alert('Please select FFQ quota type')
                        return false
                    }
                }
            });
        });

    </script>

@stop
