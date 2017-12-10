@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div id="example2_wrapper" class="dataTables_wrapper form-inline" role="grid">
				<div class="row">
					<div class="col-xs-6"></div>
					<div class="col-xs-6"></div>
				</div>
				<form id="form" action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="file" />
					<button type="submit">Importar</button>
					{{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
