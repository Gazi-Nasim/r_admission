<span>
    TrxID:{{$bkashResponse?->trxID ?? 'N/A' }} | T: {{$bkashResponse?->transactionStatus}} | V: {{$bkashResponse?->verificationStatus}}
</span>

@if($bkashResponse?->merchantInvoice==$paymentLog->bill_id && $bkashResponse?->transactionStatus=='Completed' )
    <form style="display: inline-block" ic-post-to='{{route('admin.bill.updatePaymentId')}}'>
        @csrf
        <input type="hidden" name="paymentId" value="{{$paymentLog->id}}">
        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger btn-md"> <i class="fa fa-update"></i> Update</button>
    </form>
@endif
