@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-file-text"></i> {{$file}}.log</legend>
            {{-- search bar --}}
            <div class="row">
                <div class="col-sm-12 full-height">
                    <textarea name="myTextArea" id="myTextArea">{{$content}}</textarea>
                </div>
            </div>
        </div>
    </div>

@stop


@section('script-extra')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.js" integrity="sha256-dPTL2a+npIonoK5i0Tyes0txCMUWZBf8cfKRfACRotc=" crossorigin="anonymous"></script>
    <script>
        var editor = CodeMirror.fromTextArea(myTextArea, {
            lineNumbers: true,
            lineWrapping: true,
            smartIndent: true,
            readOnly:true,
            theme: 'cobalt'
        });

        editor.setSize(null, 800);
    </script>
@endsection

@section('css-extra')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.css" integrity="sha256-vZ3SaLOjnKO/gGvcUWegySoDU6ff33CS5i9ot8J9Czk=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/theme/cobalt.css" integrity="sha256-Os0qLNmu+uyjtBpFHiZAhADg2Vi46EWtS81e31/5AeA=" crossorigin="anonymous" />
@endsection

