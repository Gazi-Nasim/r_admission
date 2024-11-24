@section('sidebar')
    <div class="col-sm-2 no-print" id="sidebar">
        <div class="list-group">
            @if (Auth::user()->hasRole('Admin') && !Route::is('controlRoom.getStudentInfo'))
                <a href="{{ route('user.dashboard') }}" class="list-group-item"><i class="fa fa-dashboard"></i>
                    Dashboard</a>
                <a href="{{ route('controlRoom.getDashboard') }}" class="list-group-item"><i class="fa fa-camera"></i>
                    Photo Capture</a>


                <a href="{{ route('admin.admitCard.index') }}" class="list-group-item"><i class="fa fa-search"></i>
                    Applicant Search</a>
                <a href="{{ route('admin.student.index') }}" class="list-group-item"><i class="fa fa-users"></i>
                    Students</a>
                <a href="{{ route('admin.bill.index') }}" class="list-group-item"><i class="fa fa-dollar"></i> Bills</a>
                <a href="{{ route('admin.oth.index') }}" class="list-group-item"><i class="fa fa-tag"></i> OTH
                    Applications</a>
                <a href="{{ route('admin.complainbox.index') }}" class="list-group-item"><i class="fa fa-inbox"></i>
                    Complains Box</a>
                <a href="{{ route('admin.photo_review.index') }}" class="list-group-item"><i class="fa fa-magic"></i>
                    Photo Changes</a>
                <a href="{{ route('admin.mobile-change.index') }}" class="list-group-item"><i class="fa fa-mobile-phone"></i>
                    Mobile Changes</a>
                <a href="{{ route('admin.sms.index') }}" class="list-group-item"><i class="fa fa-envelope"></i> SMS
                    Sender</a>
                <a href="{{ route('admin.photo_check.index') }}" class="list-group-item"><i
                        class="fa fa-check-square"></i> Check Photos</a>
                <a href="{{ route('admin.photo_check.indexRejectedPhoto') }}" class="list-group-item"><i
                        class="fa fa-times"></i> Rejected Photos</a>
                <a href="{{ route('admin.photo_check.indexRejectedSelfie') }}" class="list-group-item"><i
                        class="fa fa-times"></i> Rejected Selfies</a>
                <a href="{{ route('site.home') }}" class="list-group-item"><i class="fa fa-file-pdf-o"></i> Download
                    Quota Docs.</a>

                <a href="{{ route('admin.misc.capturedPhotos') }}" class="list-group-item"><i class="fa fa-users"></i>
                     Captured Photos</a>

            @endif

            {{-- for operator --}}
            @if (Auth::user()->hasRole('Operator'))
                <a href="{{ route('user.dashboard') }}" class="list-group-item"><i class="fa fa-dashboard"></i>
                    Dashboard</a>
                <a href="{{ route('admin.admitCard.index') }}" class="list-group-item"><i class="fa fa-search"></i>
                    Applicant Search</a>
                <a href="{{ route('admin.student.index') }}" class="list-group-item"><i class="fa fa-users"></i>
                    Students</a>
                <a href="{{ route('admin.bill.index') }}" class="list-group-item"><i class="fa fa-dollar"></i> Bills</a>
                <a href="{{ route('admin.photo_check.index') }}" class="list-group-item"><i
                        class="fa fa-check-square"></i> Check Photos</a>
            @endif


            {{-- For Unit Office --}}
            @if (auth()->user()->hasRole('UnitOffice'))
                <a href="{{ route('user.dashboard') }}" class="list-group-item"><i class="fa fa-dashboard"></i>
                    Dashboard</a>
                @if ( in_array(auth()->user()->username,['aaa','asbtariq']))
                    <a href="{{ route('admin.admitCard.index') }}" class="list-group-item"><i class="fa fa-search"></i>
                        Applicant Search</a>
                @endif
                <a href="{{ route('unit-office.getApproveStudent') }}" class="list-group-item"><i
                        class="fa fa-check-circle"></i> Approve Admission</a>
                <a href="{{ route('unit-office.getCancelStudent') }}" class="list-group-item"><i
                        class="fa fa-times-circle"></i> Cancel Admission</a>
            @endif


        </div>


        @if (Auth::user()->hasRole('Admin') && !Route::is('controlRoom.getStudentInfo'))
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Admin</h3>
                </div>
                <div class="list-group">
                    <a href="{{ route('admin.user.index') }}" class="list-group-item"> <i class="fa fa-users"></i> Users</a>
                    <a href="{{ route('admin.cms.index') }}" class="list-group-item"> <i class="fa fa-pagelines"></i> CMS</a>
                    <a href="{{ route('admin.settings.index') }}" class="list-group-item"><i class="fa fa-cogs"></i>
                        App. Settings</a>
                    <a href="{{ route('admin.log.index') }}" class="list-group-item"><i class="fa fa-file-text"></i> Log Viewer</a>
                    <a href="{{ route('admin.vendor.log-viewer') }}"  target="_blank" class="list-group-item text-danger"><i class="fa fa-file-text"></i> Log
                        Viewer 2</a>
                </div>
            </div>
        @endif

    </div>
@show
