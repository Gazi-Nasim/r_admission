@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-pencil"></i> Provide your SSC/Equivalent and HSC/Equivalent information</legend>
            <div class="alert alert-info">
                <strong>HSC/ সমমান এবং SSC/ সমমান পরীক্ষা সংক্রান্ত প্রয়োজনীয় তথ্য সঠিক ভাবে প্রদান করতে হবে।
                    কারিগরি বোর্ডের শিক্ষার্থীরা শিক্ষা বোর্ডের স্থলে প্রযোজ্য ক্ষেত্রে Technical-Vocational/BM/DCOM
                    এবং GCE, BFA ও ডিপ্লোমা ইন ইঞ্জিনিয়ারিং এর শিক্ষার্থীরা HSC/সমমান বোর্ডের স্থলে Others (GCE-A Level/Diploma/BFA) সিলেক্ট করবে ।</strong>
            </div>
            {{--<pre>
                {{print_r(session()->all())}}
            </pre>--}}

            {{-- FORM start --}}
            {{-- <form action="" method="POST" class="form-horizontal well"> --}}
            {{Form::open( ['route' => ['student.postLogin'], 'class'=>'form-horizontal well' ])}}

            {{-- row1 --}}
            <div class="row">
                {{-- HSC --}}
                <div class="col-sm-6">
                    <div class="form-group @if ($errors->has('hsc_roll')) has-error @endif">
                        <label for="hsc_roll" class="control-label col-sm-5">HSC/Equiv. Roll</label>
                        <div class="col-sm-7">
                            {{ Form::text('hsc_roll', old('hsc_roll'), array('class' => 'form-control','placeholder'=>"HSC Roll", 'autocomplete'=>'on')) }}
                            {!! $errors->first('hsc_roll','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('hsc_board')) has-error @endif">
                        <label for="hsc_board" class="control-label col-sm-5">HSC/Equiv. Board</label>
                        <div class="col-sm-7">
                            {{ Form::select('hsc_board', array(""=>'Please Select')+$hsc_board , old('hsc_board'), array('class' => 'form-control') ) }}
                            {!! $errors->first('hsc_board','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('hsc_year')) has-error @endif">
                        <label for="hsc_year" class="control-label col-sm-5">HSC/Equiv. Passing Year</label>
                        <div class="col-sm-7">
                            {{ Form::select('hsc_year', array(""=>'Please Select')+$hsc_year , old('hsc_year'), array('class' => 'form-control') ) }}
                            {!! $errors->first('hsc_year','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>{{-- /HSC --}}

                {{-- SSC --}}
                <div class="col-sm-6">
                    <div class="form-group @if ($errors->has('ssc_roll')) has-error @endif">
                        <label for="ssc_roll" class="control-label col-sm-5">SSC/Equiv. Roll</label>
                        <div class="col-sm-7">
                            {{ Form::text('ssc_roll', old('ssc_roll'), array('class' => 'form-control','placeholder'=>"SSC Roll", 'autocomplete'=>'on')) }}
                            {!! $errors->first('ssc_roll','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('ssc_board')) has-error @endif">
                        <label for="ssc_board" class="control-label col-sm-5">SSC/Equiv. Board</label>
                        <div class="col-sm-7">
                            {{ Form::select('ssc_board', array(""=>'Please Select')+$ssc_board , old('ssc_board'), array('class' => 'form-control') ) }}
                            {!! $errors->first('ssc_board','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('ssc_year')) has-error @endif">
                        <label for="ssc_year" class="control-label col-sm-5">SSC/Equiv. Passing Year</label>
                        <div class="col-sm-7">
                            {{ Form::select('ssc_year', array(""=>'Please Select')+$ssc_year , old('ssc_year'), array('class' => 'form-control') ) }}
                            {!! $errors->first('ssc_year','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>{{-- /SSC --}}
            </div>{{-- row1 --}}

            {{-- row 2 --}}
            <div class="row">
                <div class="col-sm-12">

                    <div class="panel panel-warning ">
                        <div class="panel-body bg-warning">
                            <h4>নিচের ছবিতে প্রদর্শিত ইংরেজী লেখাটি পাশের টেক্সটবক্সে হুবহু লিখুন। </h4>
                        </div>
                    </div>
                    {{-- <h4 class="bg-warning text-center">Enter the text shown in the image into the  next field. Please note: there is no blank spaces between characters and they are all UPPERCASE. </h4><br> --}}
                    <div class="form-group  @if ($errors->has('captcha')) has-error @endif">
                        <label for="input-id" class="control-label col-sm-4">&nbsp; </label>
                        <div class="col-sm-4 text-right">
                            <img src="{{captcha_src('flat')}}"
                                 class="img-responsive img-thumbnail class image-right"
                                 alt="Please enable image in your browser"/>
                        </div>
                        <div class="col-sm-4">
                            {{ Form::text('captcha', old('captcha'), array('class' => 'form-control', 'autocomplete'=>'off' , 'placeholder'=>'Enter captcha here')) }}
                            {!! $errors->first('captcha','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <hr>


            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="input-id" class="control-label col-sm-4"></label>
                        <div class="col-sm-8 text-right">
                            {{Form::button('Submit <i class="fa fa-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-primary'))}}
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('script-extra')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
