<form ic-post-to="{{route('admin.bill.postAdminBillPayment')}}" class="form">
    @csrf
    <input type="hidden" name="bill_id" value="{{$bill->id}}">
    <input type="hidden" name="bkash_trx_id" value="{{$bkashResponse?->trxID}}">
    <input type="hidden" name="payment_method" value="B">
    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-md"> <i class="fa fa-edit"></i> Update Bill</button>
</form>
