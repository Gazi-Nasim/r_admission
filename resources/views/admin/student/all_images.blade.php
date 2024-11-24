@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend>
                <i class="fa fa-users"></i> Student Photos
                <a href="{{ route('admin.student.show',$student) }}" class="btn btn-xs btn-default pull-right" role="button"><i
                            class="fa fa-arrow-left"></i> Back</a>
            </legend>
            <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
            <div class="row">
                <div class="col-sm-12" style="display: flex; flex-flow: row wrap; gap: 10px;">
                @foreach($images as $image)
                    <div>
                        <img src="{{\Storage::url($image)}}" width="180" class="img-responsive img-thumbnail"
                         @if(str_contains($image,$student->photo))
                             style="border:5px solid #ff0000;"
                        @endif
                        >
                        <p class="text-center label label-info" style="display: block">
                            @php
                                $timestamp = str_replace('_photo','',$image);
                                $timestamp = explode('-',$timestamp)[1];
                                $timestamp = explode('.',$timestamp)[0];
                                $date = date('d-m-Y, h:i:s A',$timestamp);
                            @endphp
                            {{$date}}
                        </p>
                        <input type="hidden" name="photo" id="photo{{$loop->iteration}}" value="{{$image}}">
                        <a class="btn btn-primary " ic-replace-target="true" style="display: block"
                           ic-post-to="{{ route('admin.student.postRestoreImage', $student) }}"
                           ic-confirm="Are you sure?"
                           ic-include="#_token,#photo{{$loop->iteration}}"
                           role="button"><i class="fa fa-refresh"></i>
                            restore </a>
                    </div>
                @endforeach
                </div>

            </div>
            <br>
            <legend><i class="fa fa-users"></i> Student Selfies</legend>
            <div class="row">
                <div class="col-sm-12" style="display: flex; flex-flow: row wrap; gap: 10px;">
                @foreach($selfies as $image)
                    <div>
                        <img src="{{\Storage::url($image)}}" width="180" class="img-responsive img-thumbnail"
                         @if(str_contains($image,$student->selfie))
                             style="border:5px solid #ff0000"
                        @endif
                        >
                        <p class="text-center label label-info" style="display: block">
                            @php
                                $timestamp = explode('_selfie_',$image)[1];
                                $timestamp = explode('.',$timestamp)[0];
                                $date = date('d-m-Y, h:i:s A',$timestamp);
                            @endphp
                            {{$date}}
                        </p>
                        <input type="hidden" name="selfie" id="selfie{{$loop->iteration}}" value="{{$image}}">
                        <a class="btn btn-primary " ic-replace-target="true" style="display: block"
                           ic-post-to="{{ route('admin.student.postRestoreImage', $student) }}"
                           ic-confirm="Are you sure?"
                           ic-include="#_token,#selfie{{$loop->iteration}}"
                           role="button"><i class="fa fa-refresh"></i>
                            Restore</a>
                    </div>
                  @endforeach
                </div>
            </div>

            <br>
            <legend><i class="fa fa-users"></i> Suspected</legend>
            <div class="row">
                <div class="col-sm-12" style="display: flex; flex-flow: row wrap; gap: 10px;">
                    @foreach($suspected_selfie as $image)
                        <div>
                            <img src="{{\Storage::url($image)}}" width="180" class="img-responsive img-thumbnail"
                                 @if(str_contains($image,$student->suspect_photo))
                                     style="border:5px solid #ff0000"
                                @endif
                            >
                            <p class="text-center label label-info" style="display: block">
                                @php
                                    $timestamp = explode('_suspect_',$image)[1];
                                    $timestamp = explode('.',$timestamp)[0];
                                    $date = date('d-m-Y, h:i:s A',$timestamp);
                                @endphp
                                {{$date}}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
