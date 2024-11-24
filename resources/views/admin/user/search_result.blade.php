@if (count($users))
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>User Name</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Last Accessed</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        @foreach ($users as $user)
            <tr>
                <td>{{$user->username}}</td>
                <td>{{$user->fullname}}</td>
                <td>{{$user->roles->first()->name}}</td>
                <td>{{$user->updated_at}}</td>
                <td>
                    @if ($user->username!='admin')
                        <a
                            class="btn btn-xs btn-danger"
                            ic-post-to="{{route('admin.user.delete')}}"
                            ic-include="#id{{$user->id}},#_token"
                            ic-target="closest tr"
                            ic-replace-target="true"
                            ic-confirm="Are you sure?" role="button"><i class="fa fa-times"></i> Delete</a>
                        <input type="hidden" name="user_id" id="id{{$user->id}}" value="{{$user->id}}">
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    <div class="text-center">
        {{$users->links('admin.pagination',['target'=>'#result'])}}
    </div>
@else
    <div class="alert alert-danger">
        <strong> No INfo </strong>
    </div>
@endif
