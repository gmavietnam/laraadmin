{!! Form::model($form_model, ['route' => [config('laraadmin.adminRoute') . '.'.$form_module_name.'.update', $form_key_value ], 'method'=>'PUT', 'id' => $form_action_id_tpl]) !!}

<div class="card">
	<div class="card-header">
		<div class="actions">
			@include('la.layouts.partials.language')
		</div>
	</div>
    <div class="card-body">
            @yield('form_content')
    </div>
</div>
{!! Form::close() !!}