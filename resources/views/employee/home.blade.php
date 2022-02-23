@extends('layouts.type50.admin')
@section('content')
<div class="content">
    <div class="row">
        @if(session('status'))
            <div class="alert alert-info" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if(session('fail'))
            <div class="alert alert-danger" role="alert">
                {{ session('fail') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @if(auth()->user())
                      <p>&#128591; {{strtoupper(auth()->user()->shriName)}}</p>
                    @endif
                </div>
                <div class="card-body">

                    @if(auth()->user())
                        @if(strpos(auth()->user()->email, 'emp.com') !== false )
                                @if(file_exists(app_path('Http/Controllers/Auth/ChangeEmailController.php')))
                                    <div class="card border border-0">
                                        <div class="col-auto border-left" >
                                            <p class="h5"> For Security Resons .Please change your mail .</p>
                                            <p>Please Use Your Personal Mail Only</p>
                                            <a class="btn btn-danger" href="{{ route('profile.email.edit') }}">
                                                <i class="fa fa-envelope"></i>
                                                Change Your Email
                                            </a>
                                        </div>
                                    </div>
                              @endif
                        @else
                              @if(!auth()->user()->email_verified_at)
                                <div class="card border border-0">
                                    <div class="col-auto border-left" >
                                        <p class="h5">Please verify your mail</p>
                                        <a class="btn btn-danger" href="{{ route('verification.notice') }}">
                                            <i class="fa fa-envelope"></i>
                                            Process Verification
                                        </a>
                                    </div>
                                </div>
                              @endif
                        @endif
                    @endif
                    @if(strpos(auth()->user()->email, 'emp.com') == false && auth()->user()->email_verified_at)
                    <div class="row p-3">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5">
                                            <p class="display-3 font-weight-bold">
                                            {{$user_acr_count}}
                                            </p>
                                        </div>
                                        <div class="col-7 d-flex align-items-center">
                                            <p class="h4 text-center">ACR Submitted</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection
