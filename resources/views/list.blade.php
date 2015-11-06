@extends('layout.base')

@section('content')
<div class="container">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Otsikko</th>
				<th>Kuvaus</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td><a href="/show">Miten rapsuttaa otsaa?</a></td>
				<td>Lorem ipsum dolor hnngh</td>
				<td>
					<a href="/edit" class="btn btn-primary"><i class="fa fa-pencil fa-fw"></i> Muokkaa</a>
				</td>
				<td>
					<a href="#" class="btn btn-danger"><i class="fa fa-times fa-fw"></i> Poista</a>
				</td>
			</tr>
		</tbody>
	</table>
</div>
@stop
