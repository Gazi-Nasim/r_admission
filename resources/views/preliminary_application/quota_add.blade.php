@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">

            {{-- Message --}}
            @if (session()->has('other-message'))
                <div class="alert alert-danger">
                    <strong><i class="fa fa-exclamation-circle"></i> {{session('other-message')}}</strong>
                </div>
            @endif
            {{-- quotas --}}
            <legend><i class="fa fa-credit-card"></i> কোটা সংক্রান্ত তথ্য</legend>
            {{-- quota list --}}
            <div class="row">
                <div class="col-sm-12">

                    <div class="alert alert-info">
                        <p style="line-height:1.3em">আপনি যদি <b>{{$selectedQuota }}</b> কোটার জন্য বিবেচিত হতে চান, তবে
                            সংশ্লিষ্ট কাগজপত্রের স্ক্যান কপি (সর্বোচ্চ ২ মেগাবাইট) একটি মাত্র JPG/PDF ফাইলের
                            মাধ্যমে আপলোড করে <span class="label label-primary"><i class="fa fa-save"></i> Update</span>
                            এ ক্লিক করে কোটার তথ্য আপডেট করুন।
                        </p>
                    </div>

                    @if($selectedQuota =='FFQ')
                        <div class="alert alert-warning">
                            <p style="line-height: 1.3em"><i class="fa fa-asterisk"></i> FFQ-এর ক্ষেত্রে সংশ্লিষ্ট
                                মুক্তিযোদ্ধার সনদপত্র এবং প্রার্থীর সাথে সম্পর্ক
                                প্রমাণের প্রয়োজনীয় জন্ম সনদপত্র (সমূহ) একটি PDF ফাইলের মাধ্যমে আপলোড করতে হবে।
                                অন্যান্য কোটার ক্ষেত্রে
                                প্রয়োজনীয় প্রমাণপত্র আপলোড করতে হবে।</p>
                            <br>
                            <p class="alert alert-danger"> সংগৃহীত সকল কাগজপত্র সংরক্ষণ করা হবে। পরীক্ষা পরবর্তী সময়ে
                                কোটার সংশ্লিষ্ট
                                মূল
                                কাগজপত্র উপস্থাপনে ব্যর্থ হলে সকল প্রকার ভর্তির সুযোগ বাতিল করা হবে।</p>
                        </div>
                    @endif
                </div>
            </div>

            <h4 class="">Upload Document For <b> {{$quotas[$selectedQuota]}}</b> Quota</h4>
            <hr>
            <form class="form-horizontal" method="post" action="{{route('preliminary.postSaveQuota')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="quota" value="{{$selectedQuota}}">
                <div class="form-group @if($errors->has('ffq_type')) has-error @endif">
                    <label for="inputEmail3" class="col-sm-4 control-label">Choose A Document</label>
                    <div class="col-sm-8">
                        <input type="file" name="quota_photo"/>
                        @error('quota_photo')
                        <b class="text-danger">{{$message}}</b>
                        @enderror
                    </div>
                </div>
                @if($selectedQuota =='FFQ')

                <div class="form-group @if($errors->has('ffq_type')) has-error @endif">
                    <label for="inputPassword3" class="col-sm-4 control-label">Quota Type</label>
                    <div class="col-sm-8">
                        <div class="radio">
                            <label>
                                <input type="radio" name="ffq_type" id="blankRadio1" value="FFQ-C" @if(old('ffq_type')=='FFQ-C') checked @endif >
                                Child of Freedom Fighter
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="ffq_type" id="blankRadio1" value="FFQ-G" @if(old('ffq_type')=='FFQ-G') checked @endif  >
                                Grand Child of Freedom Fighter
                            </label>
                        </div>
                        @error('ffq_type')
                        <b class="text-danger">{{$message}}</b>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Freedom Fighter Number</label>
                    <div class="col-sm-8">
                        <input type="text"  name="ffq_number" value="{{old('ffq_number')}}" class="form-control" placeholder="Freedom Fighter Number">
                    </div>
                </div>
                @endif
                @if($selectedQuota =='WQ')
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Salary ID</label>
                        <div class="col-sm-8">
                            <input type="text" name="wq_salary_id" value="{{old('wq_salary_id')}}" class="form-control" placeholder="Salary ID">
                        </div>
                    </div>
                @endif
                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <p class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                            <a class="btn btn-danger" href="{{ route('preliminary.getQuotaIndex') }}"><i
                                    class="fa fa-times-circle"></i> Cancel</a>
                        </p>
                    </div>
                </div>
            </form>

        </div>
    </div>{{-- panel-default --}}
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

