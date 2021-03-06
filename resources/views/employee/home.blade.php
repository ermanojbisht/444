@extends('layouts.type200.main')

@section('styles')
@endsection

@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu_home')
@endsection

@section('pagetitle')
   &#128591; {{Auth::User()->shriName}}
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [ 'datas'=> [
        ['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
        ['label'=> 'My Acrs','active'=>true]]])
@endsection

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
                        @if(auth()->user()->password == '$2y$10$bpBO0cksrytDfWVG3eReEOPC4izWcDXDY5B4tcoX2hDCHPzB7e5JC' )
                        <div class="card border border-0">
                            <div class="col-auto border-left" >
                                <p class="h5 text-danger">Your security is on risk</p>
                                Please update your Password
                            </div>
                        </div>
                        @endif
                    @endif
                    @if(strpos(auth()->user()->email, 'emp.com') == false && auth()->user()->email_verified_at && $fromShashan == false)
                    <div class="row p-3">
                        @if($user_grievance_count)
                            <div class="col-lg-3 col-md-4 col-sm-12 ">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-5">
                                                <p class="display-2 font-weight-bold">
                                                {{$user_grievance_count}}
                                                </p>
                                            </div>
                                            <div class="col-7 d-flex align-items-center">
                                                <p class="h4">My Grievance</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="card-footer text-right text-decoration-none bg-light  " href="{{route('employee.hr_grievance')}}">
                                        <span>view</span>
                                        <i class="fa fa-arrow-circle-right" ></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($user_acr_count)
                            <div class="col-lg-3 col-md-4 col-sm-12 ">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-5">
                                                <p class="display-2 font-weight-bold">
                                                {{$user_acr_count}}
                                                </p>
                                            </div>
                                            <div class="col-7 d-flex align-items-center">
                                                <p class="h4">My ACRs</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="card-footer text-right text-decoration-none bg-light  " href="{{route('acr.myacrs')}}">
                                        <span>view</span>
                                        <i class="fa fa-arrow-circle-right" ></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($user_acr_to_report_count)
                            <div class="col-lg-3 col-md-4 col-sm-12 ">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-5">
                                                <p class="display-2 font-weight-bold">
                                                {{$user_acr_to_report_count}}
                                                </p>
                                            </div>
                                            <div class="col-7 d-flex align-items-center">
                                                <p class="h4">Pending for Report</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="card-footer text-right text-decoration-none bg-light  " href="{{route('acr.others.index')}}">
                                        <span>view</span>
                                        <i class="fa fa-arrow-circle-right" ></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($user_acr_to_review_count)
                            <div class="col-lg-3 col-md-4 col-sm-12 ">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-5">
                                                <p class="display-2 font-weight-bold">
                                                {{$user_acr_to_review_count}}
                                                </p>
                                            </div>
                                            <div class="col-7 d-flex align-items-center">
                                                <p class="h4">Pending for Review</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="card-footer text-right text-decoration-none bg-light  " href="{{route('acr.others.index')}}">
                                        <span>view</span>
                                        <i class="fa fa-arrow-circle-right" ></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($user_acr_to_accept_count)
                            <div class="col-lg-3 col-md-4 col-sm-12 ">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-5">
                                                <p class="display-2 font-weight-bold">
                                                {{$user_acr_to_accept_count}}
                                                </p>
                                            </div>
                                            <div class="col-7 d-flex align-items-center">
                                                <p class="h4">Pending for Accept</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="card-footer text-right text-decoration-none bg-light  " href="{{route('acr.others.index')}}">
                                        <span>view</span>
                                        <i class="fa fa-arrow-circle-right" ></i>
                                    </a>
                                </div>
                            </div>
                        @endif
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
