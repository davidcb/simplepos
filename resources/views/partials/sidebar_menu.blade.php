<ul class="sidebar-menu">
	<li class="treeview {{ ($menuActive == 'products') ? 'active' : '' }}">
		<a href="/productos">Productos</a>
	</li>
	<li class="treeview {{ ($menuActive == 'providers') ? 'active' : '' }}">
		<a href="/proveedores">Proveedores</a>
	</li>
	<li class="treeview {{ ($menuActive == 'orders') ? 'active' : '' }}">
		<a href="/pedidos">Pedidos</a>
	</li>
	<li class="treeview {{ ($menuActive == 'sales') ? 'active' : '' }}">
		<a href="/ventas">Ventas</a>
	</li>
	<li class="treeview {{ ($menuActive == 'reports') ? 'active' : '' }}">
		<a href="/informes">Informes</a>
	</li>
	<li class="treeview {{ ($menuActive == 'import') ? 'active' : '' }}">
		<a href="/importar">Importar datos</a>
	</li>
	<li class="treeview {{ ($menuActive == 'users') ? 'active' : '' }}">
		<a href="/usuarios">Usuarios</a>
	</li>
</ul>
