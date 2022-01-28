@extends('layouts.type200.main')

@section('content')

<x-alert message="hi" type="warning" >
    <slot name="othertext">Hello</slot>
</x-alert>


<x-form method="get" action="{{Route('admin.se-offices.create')}}" has-files>
    <x-form.label field="email">
        my label
    </x-form.label>
</x-form>

{{-- <nav class="tabs">
        <ul>
            <x-navigation-item :href="route('mailcoach.emailLists.subscribers', $emailList)">
                <x-icon-label icon="fa-users" text="Subscribers" :count="$emailList->subscribers()->count() ?? 0" />
            </x-navigation-item>
        </ul>
    </nav> --}}
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Estimate Lsts</div>
            <div class="card-body">
                <div class="row">
                        <div class="row">
                            <div class="col-3">
                                <x-box1 title="Manoj Bisht" dataDetail="9,1223" type="info" link="#" />
                            </div>                           
                            <div class="col-3">
                                <x-box1 title="Sent" dataDetail="22,643" type="danger" />                               
                            </div>
                            <div class="col-3">
                                <x-box1 title="Created" dataDetail="78,623" type="warning" />                              
                            </div>                           
                            <div class="col-3">
                                <x-box1 title="." dataDetail="." />
                            </div>                          
                        </div>
                        <hr class="mt-0">
                         <div class="row">
                            <div class="col-3">
                                <x-progress-bar-1 title="Total" percentage="20.50" type="warning" />
                            </div>
                            <div class="col-9">
                                 <x-box1 title="Manoj Bisht" dataDetail="9,1223" type="info" />                                           
                            </div>
                         </div>


                </div>

            </div>
        </div>
    </div>
    <!-- /.col-->
</div>





@endsection
