@component('mail::message')
# Hello {{ $student->NAME }}!

{{-- Intro Lines --}}
Your Admit Card for RU Admission is ready to download.
Please download it from the link below.

@component('mail::table')
|#               |UNIT             |ROLL             |ACTION|
|:----------------|:-----------------|:----------------|:---|
@foreach($student->applications as $application)
|{{ $loop->iteration }}|{{ $application->unit }}|{{ $application->admission_roll }}|<a href="{{ route('site.getAdmitCard', encrypt($student->id.'|'.$application->unit)) }}" >Download</a>|
@endforeach
@endcomponent

You can also download them from  <a href="{{route('student.getLogin')}}">Student panel</a>.

{{-- Salutation --}}
Regards<br>
RU Admission System
@endcomponent
