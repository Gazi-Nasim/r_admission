<div class="alert alert-info">
    <strong><i class="fa fa-exclamation-circle"></i> কোটার তথ্য পরিবর্তন করতে "Update Quota" তে ক্লিক করে কোটার তথ্য
        আপডেট করুন।
    </strong>
    <span class="pull-right">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="route" name="route" value="{{route('preliminary.getQuotaAndOtherInfo')}}">

        <a class="btn btn-danger btn-xs" data-toggle="modal" href='#modal-id'><i class="fa fa-lock"></i> Update Quota</a>

        {{--modal--}}
        @include('preliminary_application.verification_popup')


    </span>
</div>


<table class="table table-hover ">
    <tbody>
    @foreach ($quotas as $key=>$value)
        <tr>
            <td>
                @if ($student->{$key.'_photo'} != null)
                    <i class="fa fa-check-square-o"></i>
                @else
                    <i class="fa fa-square-o"></i>
                @endif
                {{$value}} ({{$key}})

                @if ($key == 'FFQ')
                    <p class="bg-info"
                       style="margin-left: 20px; @if(!$student->{$key.'_photo'}!=null ) display: none @endif"
                       id="quota-ffq">

                        @if ( $student->FFQ_type == 'FFQ-C' )
                            <i class="fa fa-dot-circle-o"></i> Child of Freedom fighter
                        @else
                            <i class="fa fa-circle-o"></i> Child of Freedom fighter
                        @endif
                        <br>
                        @if ( $student->FFQ_type == 'FFQ-G' )
                            <i class="fa fa-dot-circle-o"></i> Grand Child of Freedom fighter Child
                        @else
                            <i class="fa fa-circle-o"></i> Grand Child of Freedom fighter Child
                        @endif

                    </p>
                @endif
            </td>
            <td class="text-rig/ht" id="upload-form-{{$key}}" width="25%"></td>
            <td id="result-{{$key}}">
                @if($student->{$key.'_photo'} != NULL)
                    <a href="{{ asset('storage/uploads/'.$student->{$key.'_photo'}) }}" target="_blank">
                        @if(substr($student->{$key.'_photo'}, -3)=='pdf' )
                            <i class="fa fa-5x fa-file-text"></i>
                        @else
                            {{ Html::image('storage/uploads/'.$student->{$key.'_photo'}, 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>80)) }}
                        @endif
                    </a>
                @endif
                {{--                @elseif(session()->has('inputs.quota_photo.'.$key))--}}
                {{--                    <a href="{{ asset('storage/uploads/bill-photos/'.session('inputs.quota_photo.'.$key)) }}"--}}
                {{--                       target="_blank">--}}
                {{--                        @if (substr(session('inputs.quota_photo.'.$key),-3)=='pdf')--}}
                {{--                            <i class="fa fa-3x fa-file-pdf-o"></i>asd--}}
                {{--                        @else--}}
                {{--                            {{ Html::image('storage/uploads/bill-photos/'.session('inputs.quota_photo.'.$key), 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>80)) }}--}}
                {{--                        @endif--}}
                {{--                    </a>--}}
                {{--                @endif--}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{--@include('pre_application.popup',['title'=>'আপনার মোবাইল নম্বর নিশ্চিত করুন'])--}}
