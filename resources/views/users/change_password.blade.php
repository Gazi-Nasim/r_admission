@extends('layouts.master_admin', array('page_title'=>'Change Password', 'page_header'=>'Password', 'user'=> $user))

@section('body-content')

    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-edit"></i> Change Password</legend>

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
            @endif


            <div class="col-sm-10 well">

                {{Form::open( array('route'=>'user.postUpdatePassword', 'class'=>'form-horizontal password-form', 'role'=>'form') )}}

                <div class="form-group">
                    {{ Form::label('current_password', 'Current Password', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-4">
                        {{ Form::password('current_password',  array('class' => 'form-control')) }}
                        {{ $errors->first('current_password') }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('new_password', 'New Password', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-4">
                        {{ Form::password('new_password' ,array('class' => 'form-control')) }}
                        {{ $errors->first('new_password') }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('new_password_confirmation', 'Retype Password', array('class' => 'control-label col-sm-3')) }}
                    <div class="col-sm-4">
                        {{ Form::password('new_password_confirmation',  array('class' => 'form-control')) }}
                        {{ $errors->first('new_password_confirmation') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-3">
                        {{ Form::submit('Update', array( 'class'=>'btn btn-primary' )) }}
                        <a href="{{URL::route('user.dashboard')}}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
                {{Form::close()}}


            </div>

        </div>
    </div>

@stop


@section('css-extra')
    {{--{{HTML::style('assets/plugins/alertify/themes/alertify.core.css')}}
    {{HTML::style('assets/plugins/alertify/themes/alertify.default.css')}}--}}
@stop

@section('script-extra')

    {{--{{HTML::script('assets/plugins/alertify/lib/alertify.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {

            $(document).on('submit', '.password-form', function (event) {
                event.preventDefault();

                $.ajax({
                    url: '{{ route('user.update_password') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                })
                    .done(function (data) {

                        // reset error divs appearence
                        $('.form-group').each(function (index, el) {
                            // console.log(el);
                            $(el).removeClass('has-error').addClass('has-success');
                            $(el).find('.help-block').remove();

                        });

                        if (!data.success) {

                            var errors = data.errors;

                            console.log(errors);

                            $.each(errors, function (index, val) {
                                if (val.length != 0) {
                                    $('#' + index).parent().parent().addClass('has-error');
                                    $('#' + index).after('<span id="helpBlock" class="help-block">' + val + '</span>');
                                }
                            });

                        } else // update successfull
                        {

                            alertify.success('Password Updated');
                        }

                    })
                    .fail(function () {
                        console.log("error");
                    })
                    .always(function () {
                        // console.log("complete");
                    });


            });


        });

    </script>--}}

@stop
