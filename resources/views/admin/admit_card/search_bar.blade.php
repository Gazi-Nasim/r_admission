<form class="form-inline" ic-target="#result" ic-post-to="{{ route('admin.admitCard.search') }}">
	@csrf
{{--    <div class="form-group">--}}
{{--		{{ Form::select('unit', array(""=>'Unit')+$unit , null, array('class' => 'form-control') ) }}--}}
{{--	</div>--}}
	<div class="form-group">
		<input type="text"  name="admission_roll" class="form-control" value="" maxlength="6" size="14" placeholder="Admission Roll" >
	</div>

    <div class="form-group">
        <input type="text"  name="applicant_id" class="form-control" value="" size="14" placeholder="Applicant ID" >
    </div>

    <div class="form-group">
        <input type="text"  name="name" class="form-control" value="" placeholder="Name" >
    </div>

    <div class="form-group">
        <input type="text"  name="mname" class="form-control" value="" placeholder="Mother's Name" >
    </div>

    <div class="form-group">
        <input type="text"  name="fname" class="form-control" value="" placeholder="Father's Name" >
    </div>

	<div class="form-group">
		<button type="submit" name="search"  class="btn btn-primary"><i class="fa fa-search"></i> Search </button>
	</div>
    <div class="form-group">
        <button type="reset"   class="btn btn-danger"><i class="fa fa-times"></i> Reset </button>
    </div>
</form>
