@if ($status =='A')
    <form id="form" ic-post-to='{{ route('unit-office.postChangeStatus') }}' method="POST" class="form-horizontal"
          ic-target='#form' role="form">
        <p class="text-danger"><i class="fa fa-warning"></i> Do you Really want to Approve the application?</p>
        @else
            <form id="form" ic-replace-target='true' ic-post-to='{{ route('unit-office.postChangeStatus') }}'
                  method="POST" class="form-horizontal" ic-target='#form' role="form">
                <p class="text-danger"><i class="fa fa-warning"></i> আবেদন বাতিলের কারন উল্লেখ করুন</p>
                @endif

                {{csrf_field()}}
                <input type="hidden" name="subject_option_id" value="{{$subjectOption->id}}">
                <input type="hidden" name="status" value="{{$status}}">

                @if ($status =='R')
                    {{-- reject reason --}}
                    <div class="form-group">
                        <div @if ($errors->has('reject_reason')||$errors->has('unit')) class="has-error" @endif>
                            {{ Form::label('reject_reason', 'Reason', array('class' => 'control-label col-sm-3')) }}
                            <div class="col-sm-9">
                                @foreach ($reject_reasons as $value=>$label)
                                    <div class="radio">
                                        <label>
                                            {{ Form::radio('reject_reason', $value, old('reject_reason',Session::get('old.reject_reason', ''))==$value) }}
                                            {{$label}}
                                            @if($value=='UM')
                                                {{ Form::text('unit', old('unit',Session::get('old.unit', '')),['size'=>'5','maxlength'=>'1', 'style'=>'text-transform:uppercase' ]) }}
                                            @endif
                                        </label>

                                    </div>
                                @endforeach
                                <span
                                    class="help-block">{!! $errors->first('reject_reason','<b>:message</b>') !!}</span>
                                <span class="help-block">{!!  $errors->first('unit','<b>:message</b>')  !!}</span>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> No
                    </button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Yes</button>
                </div>
            </form>
