<form class="form-inline" ic-target="#result" ic-get-from="{{ route('admin.user.search') }}">
    @csrf
    <div class="form-group">
        <input type="text"  name="username" class="form-control" value="" placeholder="User Name" >
    </div>
    <div class="form-group">
        {{ Form::select('role', [""=>'Role']+$roles , null, array('class' => 'form-control') ) }}
    </div>

    <div class="form-group">
        <button type="submit" name="search"  class="btn btn-primary"><i class="fa fa-search"></i> </button>
    </div>
</form>
