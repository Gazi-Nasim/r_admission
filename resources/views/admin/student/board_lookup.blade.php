<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> Board Data</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed table-striped">
            <input type="hidden" name="student_id" id="student_id" value="{{$student->id}}">
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <tr>
                <th class="bg-success">Name</th>
                <td>
                    {{$data['info']["Name"]}}
                    <input type="hidden" name="name" id="name" value="{{$data['info']["Name"]}}">
                    | <a class="label label-primary" ic-post-to='{{route('admin.student.updateFromBoard')}}'
                         ic-include="#_token,#student_id,#name">Update</a>
                </td>
            </tr>
            <tr>
                <th class="bg-success">Father's Name</th>
                <td>
                    {{$data['info']["Father's Name"]}}
                    <input type="hidden" name="fname" id="fname" value="{{$data['info']["Father's Name"]}}">
                    | <a class="label label-primary" ic-post-to='{{route('admin.student.updateFromBoard')}}'
                         ic-include="#_token,#student_id,#fname">Update</a>
                </td>
            </tr>
            <tr>
                <th class="bg-success">Mother's Name</th>
                <td>
                    {{$data['info']["Mother's Name"]}}
                    <input type="hidden" name="mname" id="mname" value="{{$data['info']["Mother's Name"]}}">
                    | <a class="label label-primary" ic-post-to='{{route('admin.student.updateFromBoard')}}'
                         ic-include="#_token,#student_id,#mname">Update</a>
                </td>
            </tr>
            <tr>
                <th class="bg-success">Date of Birth</th>
                <td>{{$data['info']["Date of Birth"]}}</td>
            </tr>
            <tr>
                <th class="bg-success">Institute</th>
                <td>{{$data['info']["Institute"]}}</td>
            </tr>
            <tr>
                <th class="bg-success">Roll No</th>
                <td>{{$data['info']["Roll No"]}}</td>
            </tr>
            <tr>
                <th class="bg-success">Board</th>
                <td>{{$data['info']["Board"]}}</td>
            </tr>
            <tr>
                <th class="bg-success">Group</th>
                <td>{{$data['info']["Group"]??$data['info']["Trade"]}}</td>
            </tr>
            <tr>
                <th class="bg-success">Type</th>
                <td>{{$data['info']["Type"]}}</td>
            </tr>
            <tr>
                <th class="bg-success">Result</th>
                <td>{{$data['info']["Result"]}}</td>
            </tr>
            <tr>
                <th class="bg-success">GPA</th>
                <td>{{$data['info']["GPA"]}}</td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed table-striped">
            <tbody>
            @foreach ($data['result'] as $result)
                <tr>
                    <td>{{$result['Code']}}</td>
                    <td>{{$result['Subject']}}</td>
                    <td>{{$result['Grade']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>



