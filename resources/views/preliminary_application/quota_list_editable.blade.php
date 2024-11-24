<div class="alert alert-info">
    <h5 style="line-height:1.3em">আপনি যদি কোটার জন্য বিবেচিত হতে চান, তবে যে কোটায় আবেদন করতে চান
        তার পাশে টিক চিহ্ন দিন ও সংশ্লিষ্ট কাগজপত্রের স্ক্যান কপি (সর্বোচ্চ ২ মেগাবাইট) একটি মাত্র JPG/PDF ফাইলের
        মাধ্যমে আপলোড করে <span class="label label-primary"><i class="fa fa-save"></i> Save Quota Information</span> এ
        ক্লিক করে কোটার তথ্য আপডেট করুন।

        @if( !session()->missing('inputs.units') )
            <br><br>

            কোটায় আবেদন না করতে চাইলে <span class="label label-primary"> Skip This Step  <i
                    class="fa fa-long-arrow-right"></i></span>
            এ ক্লিক দিয়ে পরবর্তী পেজে যান।
        @endif
    </h5>
</div>

<div class="alert alert-warning">
    <h5>
        <p style="line-height: 1.3em"><i class="fa fa-asterisk"></i> FFQ-এর ক্ষেত্রে সংশ্লিষ্ট মুক্তিযোদ্ধার সনদপত্র এবং প্রার্থীর সাথে সম্পর্ক
            প্রমাণের প্রয়োজনীয় জন্ম সনদপত্র (সমূহ) একটি PDF ফাইলের মাধ্যমে আপলোড করতে হবে। অন্যান্য কোটার ক্ষেত্রে
            প্রয়োজনীয় প্রমাণপত্র আপলোড করতে হবে।</p>
        <br>
        <p class="alert alert-danger"> সংগৃহীত সকল কাগজপত্র সংরক্ষণ করা হবে। পরীক্ষা পরবর্তী সময়ে কোটার সংশ্লিষ্ট
            মূল
            কাগজপত্র উপস্থাপনে ব্যর্থ হলে সকল প্রকার ভর্তির সুযোগ বাতিল করা হবে।</p>
    </h5>
</div>

@if (Session::has('quota-error-message'))
    <div class="alert alert-danger">
        <strong><i class="fa fa-exclamation-circle"></i> {{session('quota-error-message')}}</strong>
    </div>
@endif


<table class="table table-hover">
    <tbody>
    @foreach ($quotas as $key=>$value)
        <tr>
            <td>
                <label>
                    @if (Session::has('inputs.quota'))
                        {{Form::checkbox('quota', $key, in_array($key, session('inputs.quota',[])), ['id'=>$key])}}
                    @else
                        {{Form::checkbox('quota', $key, in_array($key, session('inputs.quota',[])), ['id'=>$key])}}
                    @endif
                    <input
                        type="hidden"
                        name="quota_name"
                        value="{{$key}}"
                        id="{{$key}}"
                        ic-trigger-from="#{{$key}}"
                        ic-post-to="{{route('preliminary.postSelectQuota')}}"
                        ic-target="#upload-form-{{$key}}"
                        ic-trigger-on='click'
                        ic-global-include="#_token"
                        ic-include='#{{$key}}'
                    />
                    {{$value}} ({{$key}})
                </label>
                @if ($key == 'FFQ')
                    <p class="bg-info"
                       style="margin-left: 20px;padding-left:10px; @if(!session('inputs.quota.FFQ') ) display: none @endif"
                       id="quota-ffq">
                        <label>
                            {{Form::radio('ffq_type', 'FFQ-C', session('inputs.ffq_type')=='FFQ-C',['id'=>'ffq_type1','ic-post-to'=>route('preliminary.postFFQ')])}}
                            Child of Freedom fighter
                        </label><br>
                        <label>
                            {{Form::radio('ffq_type', 'FFQ-G', session('inputs.ffq_type')=='FFQ-G', ['id'=>'ffq_type2','ic-post-to'=>route('preliminary.postFFQ')])}}
                            Grand Child of Freedom fighter
                        </label><br>
                        <label>
                            Freedom fighter Number
                            <input type="number" name="ffq_number" id="ffq_number" value="{{session('inputs.ffq_number')}}" ic-post-to={{route('preliminary.postFFQ')}}>
                        </label>
                    </p>
                @endif

                @if ($key == 'WQ')
                    <p class="bg-info"
                       style="margin-left: 20px;padding-left:10px; @if(!session('inputs.quota.WQ') ) display: none @endif"
                       id="quota-wq">
                        <label>
                            Salary ID
                            <input type="number" name="wq_salary_id" id="wq_salary_id" value="{{session('inputs.wq_salary_id')}}"  ic-post-to={{route('preliminary.postWQ')}}>
                        </label>
                    </p>
                @endif

            </td>
            <td class="text-rig/ht" id="upload-form-{{$key}}" width="25%">

                @if(Session::has('inputs.quota.'.$key))
                    @include('preliminary_application.quota_upload_form', ['quota' => $key])
                @endif

            </td>

            <td id="result-{{$key}}">
                @if($student->{$key.'_photo'} != NULL)

                    <a href="{{ asset('storage/uploads/'.$student->{$key.'_photo'}) }}" target="_blank">
                        @if(substr($student->{$key.'_photo'}, -3)=='pdf' )
                            <i class="fa fa-5x fa-file-text-o"></i>
                        @else
                            {{ Html::image(Storage::url('public/uploads/'.$student->{$key.'_photo'}), 'Photo', ['class'=>'img-responsive img-thumbnail', 'width'=>80]) }}
                        @endif
                    </a>
                @elseif(Session::has('inputs.quota_photo.'.$key))

                    <a href="{{ Storage::url('uploads/bill-photos/'.Session::get('inputs.quota_photo.'.$key)) }}"
                       target="_blank">
                        @if (substr(Session::get('inputs.quota_photo.'.$key),-3)=='pdf')
                            <i class="fa fa-5x fa-file-text-o"></i>
                        @else
                            {{ Html::image(Storage::url('uploads/bill-photos/'.Session::get('inputs.quota_photo.'.$key)), 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>80)) }}
                        @endif
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<hr>
@if( session('authorize_this_session', 0))
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            {{Form::open(['route'=>'preliminary.postQuotaAndOtherInfo','id'=>'form'])}}
            {{-- <input type="hidden" name="mobile_no" value="{{$student->mobile_no}}"> --}}
            <p class="text-right">
                <button class="btn btn-primary btn-block"><i class="fa fa-save"></i> @if($student->hasQuota())
                        Update
                    @else
                        Save
                    @endif Quota Information
                </button>
            </p>
            {{Form::close()}}
        </div>
    </div>
@endif

