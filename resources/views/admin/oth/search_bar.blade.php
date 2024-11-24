<form class="form-inline" ic-target="#result" ic-get-from="{{ route('admin.oth.search') }}" id="frm">
    @csrf
    <div class="form-group">
        <input type="text" name="name" size="20" class="form-control input-sm" value="" placeholder="name">
    </div>
    <div class="form-group">
        <input type="text" name="hsc_roll" size="10" class="form-control input-sm" value="" placeholder="Hsc Roll">
    </div>
    <div class="form-group">
        <input type="text" name="mobile_no" size="10" class="form-control input-sm" value="" placeholder="mobile no">
    </div>
    <div class="form-group">
        {{ Form::select('status', $status , null, array('class' => 'form-control input-sm') ) }}
    </div>

    <div class="form-group">
        {{ Form::select('page_size', $pageSize , null, array('class' => 'form-control input-sm') ) }}
    </div>

    <div class="form-group">
        <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
    </div>
</form>
