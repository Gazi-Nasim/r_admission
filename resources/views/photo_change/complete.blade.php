@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
<div class="panel panel-default">
	<div class="panel-body">

		@if (session('photo_change_success','0')==1)
			<blockquote class="alert-success">
				<strong> <i class="fa fa-check-circle"></i> ফটো পরিবর্তনের জন্য আপনার একটি বিল প্রস্তুত করা হয়েছে। বিল সংক্রান্ত তথ্য নিচে প্রদত্ত</strong>
			</blockquote>

			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-striped">

                        <tr>
                            <th>Payment Purpose</th>
                            <td>Photo Change</td>
                        </tr>
                        <tr>
                            <th width="25%">Applicant's Name</th>
                            <td>{{$student->NAME}}</td>
                        </tr>
						<tr>
							<th>Bill Number</th>
							<td><b>{{$bill->id}}</b></td>
						</tr>
						<tr>
							<th>Bill Amount</th>
							<td><b>Tk. {{$bill->amount}}</b></td>
						</tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <div class="alert alert-warning lead">
                                    আপনার ফটো পরিবর্তনের আবেদন নিশ্চিত করার জন্য নিচের Pay Online বাটনে ক্লিক করে বিল পরিশোধ করুন।
                                </div>

                                <form style="display: inline-block" class="form-inline" method="post" action="{{ route('rocket.pay') }}">
                                    @csrf
                                    <input type="hidden" name="bill_id" id="bill_id" value="{{$bill->id}}">
                                    <button type="submit" class="btn btn-sm btn-purple"><i class="fa fa-money"></i>
                                        Pay Online
                                    </button>
                                </form>

                                <a class="btn btn-sm btn-success"
                                   href="{{ route('preliminary.getDownloadBill',$bill) }}" role="button">
                                    <i class="fa fa-download"></i> Download Acknowledgement Slip
                                </a>
                                <br>
                            </td>
                        </tr>
					</table>


                    <br>
				</div>
		</div>

			<div class="panel panel-success">
				<div class="panel-body">
					<h4>
						বিল পরিশোধের ২৪ ঘন্টার মধ্যে আপনার প্রদত্ত তথ্য যাচাই করার পর ফটো পরিবর্তন করা হবে ও আপনার মোবাইল নম্বরে যোগাযোগ করা হবে।
					</h4>
					<br>
					<div class="alert alert-danger">
					<p>
						<i class="fa fa-asterisk"></i> নির্ধারিত সময়ের মধ্যে ফটো পরিবর্তন না হলে হেল্পলাইনে যোগাযোগ করুন।
					</p>
					</div>
				</div>
			</div>
			<p class="text-center"><a class="btn btn-success" href="{{ route('site.home') }}"><i class="fa fa-home"></i> Back to Home Page</a></p>
		@else
			<blockquote class="alert-success">
				<strong> <i class="fa fa-check"></i> Internal server error. Please try after some times</strong>
			</blockquote>
		@endif


	</div>
</div>
@stop
