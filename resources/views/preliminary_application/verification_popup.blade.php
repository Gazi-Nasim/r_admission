<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">মোবাইল নম্বর ভেরিফিকেশন</h4>
            </div>
            <div class="modal-body">
                <h4><i class="fa fa-exclamation-circle"></i> আপনার প্রদত্ত মোবাইল নম্বরে এখন একটি
                    ভেরিফিকেশন কোড পাঠানো হবে।</h4>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> বাতিল করুন</button>
                <a class="btn btn-primary"
                   ic-include="#_token,#route"
                   ic-post-to="{{ route('identity_verification.postVerificationChallenge') }}"
                > <i class="fa fa-check-circle"></i> কোড পাঠান
                </a>
            </div>
        </div>
    </div>
</div>
