@extends('layout.base')

@section('content')
	<div class="miten__card">
		<h1 class="miten__title">Miten</h1>
		<p class="miten__description">
			Miten sidon kengännauhat?<br>
			Miten leikkaan omat hiukseni?<br>
			Miten solmin solmion?
		</p>
	</div>
	<ul>
		@foreach($guides as $guide)
		<li><pre>{!! $guide !!}</pre></li>
		@endforeach
	</ul>
@stop
