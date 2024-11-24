<form class="form-inline" ic-target="#result" ic-get-from="{{ route('admin.bill.search') }}" id="frm">
	@csrf
    <div class="form-group">
        <input type="text" name="bill_id" size="15" class="form-control input-sm" value="" placeholder="Bill Number" >
    </div>

    <div class="form-group">
        <input type="text" name="applicant_id" size="15" class="form-control input-sm" value="" placeholder="Applicant ID" >
    </div>
    <div class="form-group">
        <input type="text" name="bkash_trx_id" size="15" class="form-control input-sm" value="" placeholder="bKash TrxID" >
    </div>
    <div class="form-group">
        <input type="text" name="rocket_payment_id" size="15" class="form-control input-sm" value="" placeholder="Rocket Payment ID" >
    </div>

    <div class="form-group">
        {{Form::select('payment_purpose', [''=>'purpose']+$purposes ,'' , ['class'=>'form-control input-sm'])}}
    </div>

    <div class="form-group">
        {{Form::select('payment_status', [''=>'Status']+$status ,'' , ['class'=>'form-control input-sm'])}}
    </div>

    <div class="form-group">
        <button type="submit" name="search"  class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button>
    </div>
</form>
