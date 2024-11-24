@extends('layouts.master_admin', array('page_title'=>'GST | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-users"></i> Bill Details</legend>

            @if ($bill)
                <p>
                    <a href="{{ route('admin.bill.showDetails',$bill) }}" class="btn btn-primary"><i
                            class="fa fa-arrow-left"></i> Back</a>
                </p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped">
                            <tr>
                                <th>Id</th>
                                <th>Bill Id</th>
                                <th>Payment Id</th>
                                <th>Payment Method</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th width="30%">Response</th>
                            </tr>
                            @foreach($paymentLogs as $paymentLog)
                                <tr>
                                    <td>{{$paymentLog->id}}</td>
                                    <td>{{$paymentLog->bill_id}}</td>
                                    <td>{{$paymentLog->payment_id}}</td>
                                    <td>{{$paymentLog->payment_method}}</td>
                                    <td>{{$paymentLog->created_at}}</td>
                                    <td>{{$paymentLog->updated_at}}</td>
                                    @if($paymentLog->payment_method=='R')
                                        <td
                                            ic-get-from='{{route('admin.bill.getRocketPaymentInfo',$paymentLog->id)}}'
                                            ic-trigger-on='load' ic-indicator='#indicator{{$paymentLog->id}}'
                                        >
                                            <i id="indicator{{$paymentLog->id}}" class="fa fa-spinner fa-spin" style="display:none"></i>
                                        </td>
                                    @elseif($paymentLog->payment_method=='B')
                                        <td
                                            ic-get-from='{{route('admin.bill.getBkashPaymentInfo',$paymentLog->id)}}'
                                            ic-trigger-on='load' ic-indicator='#indicator{{$paymentLog->id}}'
                                        >
                                            <i id="indicator{{$paymentLog->id}}" class="fa fa-spinner fa-spin" style="display:none"></i>
                                        </td>

                                    @endif
                                </tr>
                            @endforeach

                        </table>


                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <strong><i class="fa fa-info-circle"></i> No data found</strong>
                </div>
            @endif
        </div>
    </div>
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

