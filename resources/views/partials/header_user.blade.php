@guest

<li class="user user-menu">
	<a href="/acceder" class="dropdown-toggle" data-toggle="dropdown">
		<img src="/img/placeholders/user.svg" class="user-image" alt="Login" title="Login" />
		<span>Acceder</span>
	</a>
</li>

@else

<li class="dropdown user user-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<img src="/img/placeholders/user.svg" class="user-image" alt="{{ Auth::user()->name }}" title="{{ Auth::user()->name }}" />
		<span class="hidden-xs">{{ Auth::user()->name }}</span>
	</a>
	<ul class="dropdown-menu">
		<li class="user-header">
			<img src="/img/placeholders/user.svg" class="img-circle" alt="{{ Auth::user()->name }}" title="{{ Auth::user()->name }}" />
			<p>
				{{ Auth::user()->name }}
			</p>
		</li>
		<li class="user-footer">
			<div class="pull-right">
				<a href="/logout" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
			</div>
		</li>
	</ul>
</li>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>

@endguest
