@extends('layouts.type200.main')
@section('content')

{{$acr->id}}

	@foreach($groupIds as $groupId)
		{{$groupId}}
		<br>
		{{config('acr.group')[$groupId]['head']}}
		<br>
		{{config('acr.group')[$groupId]['head_note']}}
		<br>
		@foreach($datas as $data)

			{{$data->description}}
			<br>
		@endforeach
		{{config('acr.group')[$groupId]['foot_note']}}
		<br>
	@endforeach
@endsection