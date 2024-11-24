@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-pagelines"></i> {{$pageContent->name}}</legend>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i> {{session('success')}}
                </div>
            @endif
            @if($pageContent->draft_published != 1)
                <form class="text-right" method="post" action="{{route('admin.cms.publish', $pageContent->id)}}">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Publish</button>
                </form>
            @endif
            <hr>
            <form method="post" action="{{route('admin.cms.update',$pageContent->id)}}">
                @csrf
                <textarea id="summernote" name="code">{{$pageContent->content_draft}}</textarea>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                <a href="{{route('admin.cms.index')}}" class="btn btn-danger"><i class="fa fa-times-circle"></i> Back</a>

            </form>

        </div>
    </div>

@endsection


@section('script-extra')

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height:500,
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });
        });
    </script>

@endsection

@section('css-extra')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
