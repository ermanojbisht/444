@extends('layouts.type200.main')
@section('content')

<form class="form-horizontal" method="GET" href="{{route('temp.store')}}">
    @csrf
		{{$acr->id}}
			<input type="hidden" name="{{$acr->id}}"/>
			
			@foreach($groupIds as $groupId)
				{{$groupId}}
				<br>
				{{config('acr.group')[$groupId]['head']}}
				<br>
				{{config('acr.group')[$groupId]['head_note']}}
				<br>

				@foreach($datas as $data)
						
					<div class="form-control">
					<label for="{{$data->id}}">{{$data->description}}</label>
					<input type="hidden" name="{{$data->id}}"/>
					<input type="text" name="t_{{$data->id}}"/>
						
					<input type="text" name="a_{{$data->id}}"/>

					</div>

				@endforeach
				{{config('acr.group')[$groupId]['foot_note']}}
				<br>
			@endforeach
		    <div class="form-group mt-2">
		        <button type="submit" class="btn btn-primary " >Save
		    </div>
</form>
@endsection