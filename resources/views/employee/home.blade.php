@extends('layouts.type50.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
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


                    <p>
                    @if(auth()->user())
                      &#128591; {{strtoupper(auth()->user()->name)}}
                      @if(strpos(auth()->user()->email, 'emp.com') !== false )
                      <br>For Security Resons .Please change your mail . todo button
                      @endif
                      {{-- @if(auth()->user()->chat_id <= 11111 )
                      <br>Your telegram is not mapped with PWD System, You may like to share the info with set procedure .Consult to PWD IT Cell.  <a href="http://mis.pwduk.in/dms/index.php/summary/128-website-software-trainning-material/1276-subscribe-telegram-bot-for-pwd-alerts">You may follow this video link</a>
                      @endif --}}
                    @endif
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection
