
@if(session()->has('flash_message'))
<script>
	swal({
		title: "{!!Session::get('flash_message.title')!!}",
		text: "{!!Session::get('flash_message.message')!!}",
		type: "{{Session::get('flash_message.type')}}",
		timer: {!!Session::get('flash_message.timer')!!},
		showConfirmButton: {!!Session::get('flash_message.overlay') ? "true" : "false" !!}
	});
</script>
@endif
