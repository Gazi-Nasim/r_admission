<form class="form-inline" ic-target="#result" ic-get-from="{{ route('admin.student.search') }}" id="frm">
	@csrf
    <div class="form-group">
		<input type="text" name="applicant_id" size="10" class="form-control input-sm" value="" placeholder="Applicant ID" >
	</div>
<div class="form-group">
		<input type="text" name="mobile_no" size="11" class="form-control input-sm" value="" placeholder="Mobile No" >
	</div>
	<div class="form-group">
		<input type="text" name="hsc_roll" size="10" class="form-control input-sm" value="" placeholder="HSC Roll" >
	</div>
	<div class="form-group">
		{{ Form::select('hsc_board', array(""=>'HSC Board')+$hsc_board , null, array('class' => 'form-control input-sm') ) }}
	</div>
	<div class="form-group">
		{{ Form::select('hsc_year', array(""=>'HSC Year')+$hsc_year , null, array('class' => 'form-control input-sm') ) }}
	</div>
	<div class="form-group">
		<input type="text" name="ssc_roll" size="10" class="form-control input-sm" value="" placeholder="SSC Roll" >
	</div>
	<div class="form-group">
		{{ Form::select('ssc_board', array(""=>'SSC Board')+$ssc_board , null, array('class' => 'form-control input-sm') ) }}
	</div>
	<div class="form-group">
		{{ Form::select('ssc_year', array(""=>'SSC Year')+$ssc_year , null, array('class' => 'form-control input-sm') ) }}
	</div>

	<div class="form-group">
		<button type="submit" name="search"  class="btn btn-sm btn-primary"><i class="fa fa-search"></i> </button>
	</div>
</form>
