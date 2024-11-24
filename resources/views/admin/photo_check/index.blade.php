@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-check-square"></i> Photo Check</legend>

            {{-- result --}}
            <div class="row">
                <div class="col-sm-12" id="result">
                    <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>Board</th>
                            <th>Total</th>
                            <th>Checked</th>
                            <th>Remaining</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($total_photos as $board=>$photos)
                            <tr>
                                <td>{{$board}}</td>
                                <td>{{$photos}}</td>
                                @if (array_key_exists($board,$checked_photo))
                                    <td>{{$checked_photo[$board]}}</td>
                                    <td>{{$photos - $checked_photo[$board]}}</td>
                                @else
                                    <td>0</td>
                                    <td>{{$photos}}</td>
                                @endif
                                <td class="text-center">
                                    <a href="{{route('admin.photo_check.getPhotos', str_replace('/','-',$board))}}" class="btn btn-primary btn-xs">
                                        Check <i class="fa fa-arrow-circle-right"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        <?php
                        $total     = array_sum(array_values($total_photos));
                        $checked   = array_sum(array_values($checked_photo));
                        $remaining = $total-$checked;
                        ?>
                        <tr class="bg-info">
                            <th>Total</th>
                            <th>{{$total}}</th>
                            <th>{{$checked}}</th>
                            <th>{{$remaining}}</th>
                            <th></th>
                        </tr>
                        </tbody>
                    </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

