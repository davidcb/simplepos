<div class="overlay-wrapper messages">
@if (count($errors) > 0)
<div class="container">
	<div class="image"><img src="/img/icons/ico_error.svg" alt="ERROR" /></div>
	<h3><span>@foreach ($errors->all() as $error) {{ $error }}<br/> @endforeach</span></h3>
	<a href="#" class="button close_button">ACEPTAR</a>
</div>
@endif

@if (session('status'))
<div class="container">
	<div class="image"><img src="/img/icons/ico_success.svg" alt="OK" /></div>
	<h3><span>{{ session('status') }}</span></h3>
	<a href="#" class="button close_button">ACEPTAR</a>
</div>
@endif

@if (session('error'))
<div class="container">
	<div class="image"><img src="/img/icons/ico_error.svg" alt="ERROR" /></div>
	<h3><span>{{ session('error') }}</span></h3>
	<a href="#" class="button close_button">ACEPTAR</a>
</div>
@endif
</div>