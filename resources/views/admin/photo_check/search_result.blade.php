@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <style>
        .rejected {
            border: 2px solid red;
        }

        .accepted {
            border: 2px solid green;
        }

    </style>
    <div class="panel panel-default">
        <div class="panel-body">
            {{--            <legend><i class="fa fa-check-square"></i> Photo Check</legend>--}}

            <div class="row">
                <div class="col-sm-10">
                    <h4><i class="fa fa-check-square"></i> Photo Check</h4>
                </div>
                <div class="col-sm-2 text-right">
                    <a class="btn btn-primary btn-md" href="{{route('admin.photo_check.index')}}"><i
                            class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
            <hr>
            <p class="alert alert-warning">[AP = Accept Photo, RP = Reject Photo, AS = Accept Selfie, RS= Reject
                Selfie]</p>
            <div class="row">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">


                @foreach ($data as $d)
                    <div class="col-sm-6 col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">

                                    <a target="_blank" href="{{route('admin.student.show',$d->id)}}"> ID: {{$d->id}}</a>
                                    <span><a class="pull-right btn btn-xs btn-primary show-photo"
                                             data-photo="{{url('storage/uploads/'.$d->photo)}}"
                                             data-selfie="{{url('storage/uploads/'.$d->selfie)}}"
                                             href="#"> <i class="fa fa-search"></i> </a></span>
                                </h3>

                            </div>
                            <div class="panel-body text-center">
                                <img src="{{url('storage/uploads/'.$d->photo)}}"
                                     @class(['img-responsive',
                                            'img-thumbnail',
                                            'rejected' => $d->photo_status == 'R',
                                            'accepted' => $d->photo_status == 'A'
                                            ]) width="120" alt="Photo">


                                <img src="{{url('storage/uploads/'.$d->selfie)}}"
                                     @class(['img-responsive',
                                            'img-thumbnail',
                                            'rejected' => $d->selfie_status == 'R',
                                            'accepted' => $d->selfie_status == 'A'
                                            ]) width="120" alt="Selfie">
                            </div>
                            <div class="panel-footer text-center">
                                <div style="display: flex; width: 100%;  align-content: space-between">
                                    <div style="flex-basis: 100%;">
                                        <a class="btn btn-success btn-xs"
                                           ic-replace-target=true
                                           ic-include='#_token'
                                           ic-post-to="{{ route('admin.photo_check.setStatus',[$d->id,'AP']) }}">
                                            <i class="fa fa-check-circle"></i> AP
                                        </a>

                                        <a class="btn btn-danger btn-xs"
                                           ic-replace-target=true
                                           ic-include='#_token'
                                           ic-confirm='Are you sure?'
                                           ic-post-to="{{ route('admin.photo_check.setStatus',[$d->id,'RP']) }}"
                                           role="button">
                                            <i class="fa fa-times-circle"></i> RP
                                        </a>
                                    </div>

                                    <div style="flex-basis: 100%;">

                                        <a class="btn btn-success btn-xs"
                                           ic-replace-target=true
                                           ic-include='#_token'
                                           ic-post-to="{{ route('admin.photo_check.setStatus',[$d->id,'AS']) }}">
                                            <i class="fa fa-check-circle"></i> AS
                                        </a>

                                        <a class="btn btn-danger btn-xs"
                                           ic-replace-target=true
                                           ic-include='#_token'
                                           ic-confirm='Are you sure?'
                                           ic-post-to="{{ route('admin.photo_check.setStatus',[$d->id,'RS']) }}">
                                            <i class="fa fa-times-circle"></i> RS
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="photo-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body text-center">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}

    <script>
        $(document).ready(function () {
            $(document).on('click', '.show-photo', function (event) {
                event.preventDefault();
                var photo = $(this).data('photo');
                var selfie = $(this).data('selfie');
                var modal = $('#photo-modal');
                modal.find('.modal-title').text('Photo');

                modal.find('.modal-body').html('<img src="' + photo + '" class="img-responsive img-thumbnail" width="48%" alt="Photo"> <img src="' + selfie + '" class="img-responsive img-thumbnail " width="48%" alt="Selfie">');
                modal.modal('show');
            });
        });
    </script>

@stop
