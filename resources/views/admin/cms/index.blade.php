@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-pagelines"></i> CMS</legend>

            <table class="table table-striped">
                <tr>
                    <th>Content Block</th>
                    <th>Draft Copy</th>
                    <th>Last Updated</th>
                    <th>Action</th>
                </tr>
                @foreach($contents as $content)
                    <tr>
                        <td>{{$content->name}}</td>
                        <td>{{($content->draft_published) ? '-':'Yes'}}</td>
                        <td>{{$content->updated_at?->diffForHumans() ?? '-'}}</td>
                        <td>
                            <a href="{{route('admin.cms.edit', $content->id)}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                        </td>
                    </tr>
                @endforeach



            </table>




        </div>
    </div>

@endsection
