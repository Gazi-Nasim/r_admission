<h4 class="text-danger"><i class="fa fa-asterisk"></i> Payment Response</h4>

@if($rocketResponse)

    <table class="table table-condensed table-bordered">
        @foreach ($rocketResponse as $key=>$value)
            <tr>
                <th>{{$key}}</th>
                <td>{{$value}}</td>
            <tr>
        @endforeach
        @if ($rocketResponse->status_code ==1)
            <tr>
                <td colspan="2" class="text-right">
                    @include('admin.bill.bill_pay_form_rocket')
                </td>
            </tr>
        @endif
    </table>

    {{--    @endforeach--}}

@else
    <div class="alert alert-danger">
        <strong> Invalid Transaction</strong>
    </div>
@endif
