@if (count($data))

    <table id="result_table" class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>

            <th>Exam Roll</th>
            <th>Group</th>
            <th>Subject</th>
            <th>Name</th>
            <th>Photo</th>
            <th>Position</th>
            <th>Bill No</th>
            <th>Bill Status</th>
            <th>Approval</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{$d->unit}}-{{$d->admission_roll}}</td>
                <td>{{$d->unit}}-{{$d->exam_group_no}}</td>
                <td>{{$d->admission_subject->name}}</td>
                <td>{{$d->student->NAME}}</td>
                <td>
                    <img id="img" src="{{Storage::url('uploads/'.$d->student->photo)}}?{{rand()}}" width="70" class="img-responsive img-thumbnail center-block" alt="Image">
                </td>
                <td>{{$d->position}}</td>
                <td>{{$d->bill_id}}</td>
                <td>
                    @if ($d->bill_status==1)
                        Paid
                    @else
                        UnPaid
                    @endif
                </td>
                <td>
                    @if ($d->bill_status==1)
                        <a
                            class="btn btn-primary btn-xs"
                            data-toggle="modal"
                            href='#modal-id'
                            ic-target=".modal-body"
                            ic-get-from="{{ route('unit-office.getChangeStatus', [$d->id, 'A']) }}">
                            <i class="fa fa-check-circle"></i> Approve
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
        </tbody>
    </table>

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
                <h2>DO you want to appprove this student?</h2>
            </div>
        </div>
    </div>
</div>
