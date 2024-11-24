<form ic-post-to='{{ route('hons_admission.postMigrationStop') }}' method="POST" class="form-horizontal" role="form">
    @csrf
    <p class="lead text-danger">
      <i class="fa fa-question-circle"></i> আপনি কি অটো মাইগ্রেশন বন্ধ করতে চান?
    </p>

    <p>
      <i class="fa fa-exclamation-circle"></i> অটো মাইগ্রেশন বন্ধ করলে <b>{{$subjectOption->admission_subject->name}}</b> ছাড়া <u>অন্য কোন বিভাগে ভর্তির সুযোগ থাকবে না।</u>
      <br>  <br>
      <i class="fa fa-exclamation-circle"></i> <b>একবার বন্ধ করলে পরবর্তীতে অটো মাইগ্রেশন আর চালু করা যাবে না।</b>

    </p>

  {{-- title --}}
  {{Form::hidden('subject_option_id', $subjectOption->id)}}

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Yes</button>
    </div>
</form>
