<form class="form-inline" ic-target="#result" ic-get-from="{{ route('admin.photo_check.getPhotos') }}">
	@csrf
    <div class="form-group">
        {{ Form::select('hsc_board', $hsc_board , null, array('class' => 'form-control') ) }}
        <div class="checkbox">
            <label>
                {{ Form::checkbox('exclude_missing', '1', false, array('class' => 'form-control'))}} Exclude Missing

            </label>
        </div>

    </div>

    <div class="form-group">
        <button type="submit" name="search"  class="btn btn-primary"><i class="fa fa-search"></i> Search
            <i class="ic-indicator fa fa-spinner fa-spin" style="display: none"></i>
        </button>
    </div>
</form>

