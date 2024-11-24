@if ($photo_reviews && $photo_reviews->count() )
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>APP. ID</th>
            <th>Bill ID</th>
            <th>Bill Status</th>
            <th>NAME</th>
            <th>HSC_ROLL </th>
            <th>HSC_BOARD</th>
            <th>HSC_REG</th>
            <th>mobile_no</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($photo_reviews as $photo_review)
            <tr>
                <td>{{$photo_review->applicant->id}}</td>
                <td>{{$photo_review->bill_id}}</td>
                <td>{{$photo_review->bill_status}}</td>
                <td>{{$photo_review->applicant->NAME}}</td>
                <td>{{$photo_review->applicant->HSC_ROLL_NO}}</td>
                <td>{{$photo_review->applicant->HSC_BOARD_NAME}}</td>
                <td>{{$photo_review->applicant->HSC_REGNO}}</td>
                <td>{{$photo_review->applicant->mobile_no}}</td>
                <td>{{$photo_review->status}}</td>
                <td>
                    <a href="{{ route('admin.photo_review.show',$photo_review->id) }}" class="label label-info">		View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-center">
        {{$photo_reviews->links('admin.pagination',['target'=>'#result'])}}
    </div>

@else
    <div class="alert alert-info">
        <strong><i class="fa fa-info-circle"></i> No data found</strong>
    </div>
@endif
