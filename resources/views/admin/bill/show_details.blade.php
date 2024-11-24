@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
<div class="panel panel-default">
	<div class="panel-body">
		<legend><i class="fa fa-users"></i> Bill Details</legend>
		<p>
			<a href="#" onclick="window.close();" class="btn btn-danger"><i class="fa fa-times-circle"></i> Close</a>
		</p>

		@if ($bill)
			<div class="row">
{{--				 <pre>--}}
{{--					{{ print_r($student_data)}}--}}
{{--				</pre>--}}
				<div class="col-lg-6">{{-- student info --}}
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <th>Bill ID</th>
                            <td>
                                {{$bill->id}}
                                @role('Admin')

                                        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                        {{--<a class="btn btn-pink btn-xs"
                                           ic-target="#result"
                                           ic-include='#_token'
                                           ic-post-to="{{ route('admin.bill.postBkashQuery',$bill) }}"
                                            style="float:right"
                                        >
                                            <i class="fa fa-search"></i> Check bKash
                                        </a>--}}
                                        <a class="btn btn-purple btn-xs"
                                           ic-target="#result"
                                           ic-include='#_token'
                                           ic-post-to="{{ route('admin.bill.postRocketQuery',$bill) }}"
                                           style="float:right; margin-right: 5px"
                                        >
                                            <i class="fa fa-search"></i> Check  Payment
                                        </a>
                                @endrole
                            </td>
                        </tr>
                        <tr>
                            <th>applicant_id</th>
                            <td>{{$bill->applicant_id}}</td>
                        </tr>
                        <tr>
                            <th>applicant_name</th>
                            <td>{{$bill?->student?->NAME}}</td>
                        </tr>
                        <tr>
                            <th>amount</th>
                            <td>{{$bill->amount}}</td>
                        </tr>
                        <tr class="bg-info">
                            <th>payment_status</th>
                            <td>{{$bill->payment_status}}</td>
                        </tr>
                        <tr class="bg-info">
                            <th>payment_method</th>
                            <td>{{$bill->payment_method}}</td>
                        </tr>
                        <tr>
                            <th>units</th>
                            <td>{{$bill->units}}</td>
                        </tr>
                        <tr>
                            <th>mobile_no</th>
                            <td>{{$bill->mobile_no}}</td>
                        </tr>
                        <tr>
                            <th>created_at</th>
                            <td>{{$bill->created_at}}</td>
                        </tr>
                        <tr>
                            <th>updated_at</th>
                            <td>{{$bill->updated_at}}</td>
                        </tr>
                        <tr>
                            <th>payment_purpose</th>
                            <td>{{$bill->payment_purpose}}</td>
                        </tr>
                        <tr class="bg-danger">
                            <th>bkash_payment_id</th>
                            <td>
                                {{$bill->bkash_payment_id}}
                            </td>
                        </tr>
                        <tr class="bg-danger">
                            <th>bkash_trx_id</th>
                            <td>
                                {{$bill->trx_id}}
                            </td>
                        </tr>
                        <tr class="bg-info">
                            <th>rocket_payment_id</th>
                            <td>
                                {{$bill->rocket_payment_id}}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <a class="btn btn-purple btn-sm" href="{{ route('admin.bill.viewPaymentLog', [$bill,'R']) }}" ><i class="fa fa-list-alt"></i> Payment Log</a>
                                {{--<a class="btn btn-pink btn-sm" href="{{ route('admin.bill.viewPaymentLog',[$bill,'B']) }}" ><i class="fa fa-list-alt"></i> bKash Log</a>--}}
                                </div>
                            </td>
                        </tr>
                    </table>

                    <p class="text-right">
                        <a class="btn btn-danger" href="{{ route('admin.bill.index') }}" ><i class="fa fa-arrow-left"></i> Back</a>
                        @role('Admin')
                        <a class="btn btn-primary" href="{{ route('admin.bill.edit', $bill) }}" ><i class="fa fa-edit"></i> Edit</a>
                        @endrole
                    </p>
				</div>

                <div class="col-lg-6" id="result">
                </div>

                </div>

			</div>{{-- student data --}}
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

