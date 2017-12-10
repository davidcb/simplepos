<?php

// Inicio
Breadcrumbs::register('', function($breadcrumbs)
{
    $breadcrumbs->push('SimplePOS', '');
});
Breadcrumbs::register('/', function($breadcrumbs)
{
    $breadcrumbs->push('SimplePOS', '/');
});

// Inicio > Acceder
Breadcrumbs::register('entrar', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Entrar', route('entrar'));
});

Breadcrumbs::register('login', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Entrar', route('login'));
});

Breadcrumbs::register('password.reset', function($breadcrumbs, $token = null)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Restablecer contraseña', route('password.reset', $token));
});

Breadcrumbs::register('password.request', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Restablecer contraseña', route('password.request'));
});

// ERP > Importar
Breadcrumbs::register('importar', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Importar datos', route('importar'));
});

// ERP > Importar
Breadcrumbs::register('importar-form', function($breadcrumbs, $module)
{
    $breadcrumbs->parent('importar');
    $breadcrumbs->push('Formulario', route('importar-form', $module));
});

// ERP > Informes
Breadcrumbs::register('informes', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Informes', route('informes'));
});

// ERP > Proveedores
Breadcrumbs::register('proveedores', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Proveedores', route('proveedores'));
});

// ERP > Proveedores > Nuevo proveedor
Breadcrumbs::register('nuevo-proveedor', function($breadcrumbs)
{
    $breadcrumbs->parent('proveedores');
    $breadcrumbs->push('Nuevo proveedor', route('nuevo-proveedor'));
});

// ERP > Proveedores > Editar proveedor
Breadcrumbs::register('editar-proveedor', function($breadcrumbs, $id)
{
    $provider = App\Models\Provider::findOrFail($id);
    $breadcrumbs->parent('proveedores');
    $breadcrumbs->push($provider->name, route('editar-proveedor', $provider->id));
});

// ERP > Pedidos
Breadcrumbs::register('pedidos', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Pedidos', route('pedidos'));
});

// ERP > Pedidos > Nuevo pedido
Breadcrumbs::register('nuevo-pedido', function($breadcrumbs)
{
    $breadcrumbs->parent('pedidos');
    $breadcrumbs->push('Nuevo pedido', route('nuevo-pedido'));
});

// ERP > Pedidos > Editar pedido
Breadcrumbs::register('editar-pedido', function($breadcrumbs, $id)
{
    $order = App\Models\Order::findOrFail($id);
    $breadcrumbs->parent('pedidos');
    $breadcrumbs->push($order->order_number, route('editar-pedido', $order->id));
});

// ERP > Pedidos > Imprimir pedido
Breadcrumbs::register('imprimir-pedido', function($breadcrumbs, $id)
{
    $order = App\Models\Order::findOrFail($id);
    $breadcrumbs->parent('pedidos');
    $breadcrumbs->push($order->order_number, route('imprimir-pedido', $order->id));
});

// ERP > Productos
Breadcrumbs::register('productos', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Productos', route('productos'));
});

// ERP > Productos > Nuevo producto
Breadcrumbs::register('nuevo-producto', function($breadcrumbs)
{
    $breadcrumbs->parent('productos');
    $breadcrumbs->push('Nuevo producto', route('nuevo-producto'));
});

// ERP > Productos > Editar producto
Breadcrumbs::register('editar-producto', function($breadcrumbs, $id)
{
    $product = App\Models\Product::findOrFail($id);
    $breadcrumbs->parent('productos');
    $breadcrumbs->push($product->name, route('editar-producto', $product->id));
});

// ERP > Ventas
Breadcrumbs::register('ventas', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Ventas', route('ventas'));
});

// ERP > Ventas > Nueva venta
Breadcrumbs::register('nueva-venta', function($breadcrumbs)
{
    $breadcrumbs->parent('ventas');
    $breadcrumbs->push('Nueva venta', route('nueva-venta'));
});

// ERP > Ventas > Editar venta
Breadcrumbs::register('editar-venta', function($breadcrumbs, $id)
{
    $sale = App\Models\Sale::findOrFail($id);
    $breadcrumbs->parent('ventas');
    $breadcrumbs->push(strip_tags($sale->sale_number), route('editar-venta', $sale->id));
});

// ERP > Usuarios
Breadcrumbs::register('usuarios', function($breadcrumbs)
{
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Usuarios', route('usuarios'));
});

// ERP > Usuarios > Nuevo usuario
Breadcrumbs::register('nuevo-usuario', function($breadcrumbs)
{
    $breadcrumbs->parent('usuarios');
    $breadcrumbs->push('Nuevo usuario', route('nuevo-usuario'));
});

// ERP > Usuarios > Editar usuario
Breadcrumbs::register('editar-usuario', function($breadcrumbs, $id)
{
    $user = App\Models\User::findOrFail($id);
    $breadcrumbs->parent('usuarios');
    $breadcrumbs->push($user->name, route('editar-usuario', $user->id));
});
