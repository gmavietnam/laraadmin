<div class="container">
	<div class="block-header">
		<h2>@ex_format($module, $module->view_col)
			<small>
                @ex_format($module, 'created_at', trans('view.created_at').' :')
				<br>
                @ex_format($module, 'updated_at',trans('view.updated_at').' :')
			</small>
		</h2>
		<ul class="actions">
			<li>
				<a href="{{ url(config('laraadmin.adminRoute') .'/'. $form_module_name) }}" 
                data-toggle="tooltip" 
                data-placement="bottom" 
                title="{{trans('view.back_to')}} {{trans('/modules/'.$form_module_name.'.view.module_name')}}">
                    <i class="zmdi zmdi-arrow-back"></i>
                </a>
			</li>
			@la_access($form_module_name, "edit")
			<li>
				<a class="btn waves-circle " href="{{ url(config('laraadmin.adminRoute') . '/'.$form_module_name.'/'.$form_key_value.'/edit') }}" 
                        data-toggle="tooltip" 
                        data-placement="bottom" 
                        title="{{trans('view.edit')}}">
                        <i class="zmdi zmdi-edit"></i>
				</a>
			</li>
			@endla_access
			@la_access($form_module_name, "delete")
			<li>
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.'.$form_module_name.'.destroy', $form_key_value], 'method' => 'delete', 'style'=>'display:inline']) }}
				<a class="btn bgm-deeporange btn-icon waves-effect waves-circle waves-float btn-delete row_delete" 
					data-toggle="tooltip" 
					title="{{trans('view.delete_tips')}}" 
					data-name="{{$form_model->$view_col}}"
					name="delete_modal"><i class="zmdi zmdi-delete"></i></a>
				{{ Form::close() }}
			</li>
			@endla_access
		</ul>
	</div>
	<div class="card" id="profile-main">	
		<div class="card-body">
            @yield('form_view_content')
		</div>
	</div>
</div>