<form ic-post-to='{{ route('hons_admission.postChangeSubjectChoice') }}' method="POST" class="form-horizontal" role="form">
    @csrf
    @if ($status =='A')
        <p class="text-danger"><i class="fa fa-warning"></i> Do you Really want to Approve the application?</p>
    @else
        <h3 class="well text-danger bg-danger">
            <i class="fa fa-warning"></i> কোন বিভাগ পছন্দের ক্রম থেকে একবার বাদ দিলে পরে তা আর পছন্দের তালিকায় অন্তর্ভূক্ত করা যাবে না।
        </h3>
        <hr>

        <p class="text-danger lead">
            আপনি কি <b>{{$studentChoice->department->name}}</b> পছন্দ ক্রম থেকে বাদ দিতে চান?
        </p>
    @endif

    {{-- title --}}
    <input type="hidden" name="studentChoiceId" value="{{$studentChoice->id}}">
    <input type="hidden" name="status" value="{{$status}}">

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> No</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Yes</button>
    </div>
</form>
