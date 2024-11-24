<form class="form-inline" ic-target="#result" ic-get-from="{{ route('admin.photo_review.search') }}" id="frm">
    <div class="form-group">
        <input type="text" name="applicant_id"  class="form-control input-sm" value="" placeholder="Applicant ID" >
    </div>

    <div class="form-group">
        <input type="text" name="bill_id"  class="form-control input-sm" value="" placeholder="Bill No." >
    </div>

    <div class="form-group">
        <div class="input-group">
            <input type="text" name="app_date"  class="form-control input-sm datepicker" value="" placeholder="Application Date" >
            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::select('bill_status', $payment_status , null, array('class' => 'form-control input-sm') ) }}
    </div>
    <div class="form-group">
        {{ Form::select('photo_status', $photo_status , null, array('class' => 'form-control input-sm') ) }}
    </div>
    <div class="form-group">
        <button type="submit" name="search"  class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Submit</button>
    </div>
</form>
