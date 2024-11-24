@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-inbox"></i> Log Viewer</legend>
            {{-- search bar --}}
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="70%">File</th>
                            <th>Size</th>
                            <th width="20%">View</th>
                        </tr>
                        </thead>
                        @foreach ($files as $file)
                            <tbody>
                            <tr>
                                <td>{{$file->getFilename()}}</td>
                                <td>{{number_format($file->getSize()/(1024*1024), 2,'.',',')}} Mb</td>
                                <td>
                                    <a href="{{ route('admin.log.download',$file->getFilename()) }}"><i class="fa fa-download"></i> Download</a>
                                    @if( Auth::user()->id == 1 )
                                        | <a href="{{ route('admin.log.view',$file->getFilename()) }}"><i class="fa fa-search"></i> View</a>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

