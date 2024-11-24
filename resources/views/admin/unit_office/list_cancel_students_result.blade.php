@if (count($data))


    <table id="result_table" class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>

            <th>Exam Roll</th>
            <th>Group</th>
            <th>Subject</th>
            <th>Name</th>
            <th>Position</th>
            <th>Office Status</th>
            <th>Bill No</th>
            <th>Bill Status</th>
            <th width="15%">Approval</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{$d->unit}}-{{$d->admission_roll}}</td>
                <td>{{$d->unit}}-{{$d->exam_group_no}}</td>
                <td>{{$d->admission_subject->name}}</td>
                <td>{{$d->student->NAME}}</td>
                <td>{{$d->position}}</td>
                <td>
                    @if ($d->office_status==1)
                        Approved
                    @elseif($d->office_status==0)
                        Pending
                    @elseif($d->office_status==-1)
                        Canceled
                    @endif
                </td>
                <td>{{$d->bill_id}}</td>
                <td>
                    @if ($d->bill_status==1)
                        Paid
                    @else
                        Unpaid
                    @endif
                </td>
                <td>
                    @if($d->office_status == 1)
                        <a
                            class="btn btn-danger btn-xs"
                            data-toggle="modal"
                            href='#modal-id'
                            ic-target=".modal-body"
                            ic-get-from="{{ route('unit-office.getChangeStatus', [$d->id, 'R']) }}">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    @endif
                    <a
                        class="btn btn-primary btn-xs"
                        href="{{ route('unit-office.downloadAdmissionForm', [$d->id]) }}"
                        target="_blank">
                        <i class="fa fa-list"></i> Details
                    </a>


                </td>
            </tr>
        @endforeach
        <tr class="bg-warning">
            <td colspan="9"><b>Total Record: {{count($data)}}</b></td>
        </tr>
        </tbody>
    </table>
    <div class="alert alert-info">
        <strong> এই সার্চ রেজাল্টে সর্বোচ্চ ১৫০ রেকর্ড দেখানো হবে। রেকর্ড খুজে না পেলে
            Admission Roll অথবা Department সিলেক্ট করে পুনরায় সার্চ করুন।
        </strong>
    </div>

    {{-- {{$data->links()}} --}}
@else
    <div class="alert alert-danger">
        <strong> No Student Found </strong>
    </div>
@endif


<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirm</h4>
            </div>
            <div class="modal-body">
                <h2>DO you want to approve this student?</h2>
            </div>
        </div>
    </div>
</div>
