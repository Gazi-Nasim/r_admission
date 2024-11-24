<h4 class="text-danger"><i class="fa fa-asterisk"></i> Bkash Response</h4>

@if($bkashResponse)

    <table class="table table-condensed table-bordered">
        @foreach ($bkashResponse as $key=>$value)
            <tr>
                <th>{{$key}}</th>
                <td>{{$value}}</td>
            <tr>
        @endforeach

        @php
            $payment_date = from_bkash_date($bkashResponse?->paymentCreateTime);
            $diff= now()->diffInMinutes($payment_date);
            echo 60-$diff. ' Minutes remaining to pay';
        @endphp

        @if (!empty($bkashResponse?->paymentExecuteTime) && auth()->user()->hasRole('Admin')   )
            @php
                $payment_date = from_bkash_date($bkashResponse?->paymentCreateTime);
                $diff= now()->diffInMinutes($payment_date);
            @endphp
            @if ($bkashResponse->trxID)
                <tr>
                    <td colspan="2" class="text-right">
                        @include('admin.bill.bill_pay_form_bkash')
                    </td>
                </tr>
            @endif
        @endif
    </table>

    {{--    @endforeach--}}

@else
    <div class="alert alert-danger">
        <strong> Invalid Transaction</strong>
    </div>
@endif
