@extends("la.layouts.app")
@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/modules') }}">{{trans('/modules/Modules.view.module_name')}}</a> :
@endsection
@section("contentheader_description", $module->model)
@section("section", trans('/modules/Modules.view.model'))
@section("section_url", url(config('laraadmin.adminRoute') . '/modules'.$module->id))
@section("sub_section", trans('view.edit'))
@section("htmlheader_title", trans('view.edit') .' : '.$module->model)
@section("main-content")
@if($errors->any())
<ul class="alert alert-danger">
	@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
</ul>
@endif
@section ("form_content")
<div class="row">
	<div class="col-md-8 col-md-offset-2">
	{{ Form::hidden("module_id", $module->id) }}
					
		<div class="form-group">
			<label for="label">{{trans('/modules/Modules.database.field_name')}} :</label>
			{{ Form::text("label", $field->label, ['class'=>'form-control', 'placeholder'=>'Field Label', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>30, 'required' => 'required']) }}
		</div>
		
		<div class="form-group">
			<label for="colname">{{trans('/modules/Modules.database.field_name')}} :</label>
			{{ Form::text("colname", $field->colname, ['class'=>'form-control', 'placeholder'=>'Column Name (lowercase)', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>100, 'data-rule-banned-words' => 'true', 'required' => 'required']) }}
		</div>
		
		<div class="form-group">
			<label for="field_type">{{trans('/modules/Modules.database.field_ui_type')}}:</label>
			{{ Form::select("field_type", $ftypes, $field->field_type, ['class'=>'form-control', 'required' => 'required']) }}
		</div>
		
		<div id="unique_val">
			<div class="form-group">
				<label for="unique">{{trans('/modules/Modules.database.field_unique')}}:</label>
				{{ Form::checkbox("unique", $field->unique) }}
				<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
			</div>
		</div>

		<div class="form-group">
			<label for="defaultvalue">{{trans('/modules/Modules.database.field_default_value')}} :</label>
			{{ Form::text("defaultvalue", $field->defaultvalue, ['class'=>'form-control', 'placeholder'=>'Default Value']) }}
		</div>
		<div class="form-group">
			<label for="is_copy">{{trans('/modules/Modules.database.field_is_copy')}}:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			{{ Form::checkbox("is_copy", $field->is_copy) }}
				<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
		</div>
		<div class="form-group">
			<label for="is_translate">{{trans('/modules/Modules.database.field_is_translate')}} :</label>
			{{ Form::checkbox("is_translate", $field->is_translate) }}
				<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
		</div>

		<div class="form-group">
			<label for="is_same">{{trans('/modules/Modules.database.field_is_same')}} :</label>
			{{ Form::checkbox("is_same", $field->is_same) }}
				<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
		</div>
		
		<div id="length_div">
			<div class="form-group">
				<label for="minlength">{{trans('/modules/Modules.database.field_minimum')}} :</label>
				{{ Form::number("minlength", $field->minlength, ['class'=>'form-control', 'placeholder'=>'Default Value']) }}
			</div>
			
			<div class="form-group">
				<label for="maxlength">{{trans('/modules/Modules.database.field_maximum')}} :</label>
				{{ Form::number("maxlength", $field->maxlength, ['class'=>'form-control', 'placeholder'=>'Default Value']) }}
			</div>
		</div>
		
		<div class="form-group">
			<label for="required">{{trans('/modules/Modules.database.field_required')}}:</label>
			{{ Form::checkbox("required", $field->required) }}
			<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
		</div>
		
		<div class="form-group values">
			<label for="popup_vals">{{trans('/modules/Modules.database.field_values')}} :</label>
			<?php
			$default_val = "";
			$popup_value_type_table = false;
			$popup_value_type_list = false;
			if(starts_with($field->popup_vals, "@")) {
				$popup_value_type_table = true;
				$default_val = str_replace("@", "", $field->popup_vals);
			} else if(starts_with($field->popup_vals, "[")) {
				$popup_value_type_list = true;
				$default_val = json_decode($field->popup_vals);
			}
			?>
			<div class="radio" style="margin-bottom:20px;">
				<label>{{ Form::radio("popup_value_type", "table", $popup_value_type_table) }} {{trans('/modules/Modules.database.field_form_table')}}</label>
				<label>{{ Form::radio("popup_value_type", "list", $popup_value_type_list) }} {{trans('/modules/Modules.database.field_form_list')}}</label>
			</div>
			{{ Form::select("popup_vals_table", $tables, $default_val, ['class'=>'form-control', 'rel' => '']) }}
			
			<select class="form-control popup_vals_list" rel="taginput" multiple="1" data-placeholder="Add Multiple values (Press Enter to add)" name="popup_vals_list[]">
				@if(is_array($default_val))
					@foreach ($default_val as $value)
						<option selected>{{ $value }}</option>
					@endforeach
				@endif
			</select>

			<div class="form-group" style="margin-top:20px;">
				<label for="defaultvalue">{{trans('/modules/Modules.database.field_filter_expressions')}} :</label>
				{{ Form::text("filter_expressions", $field->filter_expressions, ['class'=>'form-control', 'placeholder'=>'Filter Expressions']) }}
			</div>
			
			<?php
			// print_r($tables);
			?>
		</div>
		
		<br>
		<div class="form-group">
			{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id) }}">Cancel</a></button>
		</div>

			
	</div>
@endsection
@include('la.layouts.partials.default_edit',[
	'form_model' => $module,
	'form_module_name' => 'module_fields',
	'form_key_value' => $module->id,
	'form_action_id_tpl' => 'field-edit-form'
])
@endsection
@push('scripts')
<script>
$(function () {
	$("select.popup_vals_list").show();
	$("select.popup_vals_list").next().show();
	$("select[name='popup_vals_table']").hide();
	function showValuesSection() {
		var ft_val = $("select[name='field_type']").val();
		if(ft_val == 7 || ft_val == 15 || ft_val == 18 || ft_val == 20) {
			$(".form-group.values").show();
		} else {
			$(".form-group.values").hide();
		}
		$('#length_div').removeClass("hide");
		if(ft_val == 2 || ft_val == 4 || ft_val == 5 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 21 || ft_val == 24 ) {
			$('#length_div').addClass("hide");
		}
		$('#unique_val').removeClass("hide");
		if(ft_val == 1 || ft_val == 2 || ft_val == 3 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 20 || ft_val == 21 || ft_val == 24 ) {
			$('#unique_val').addClass("hide");
		}
	}
	$("select[name='field_type']").on("change", function() {
		showValuesSection();
	});
	showValuesSection();
	function showValuesTypes() {
		console.log($("input[name='popup_value_type']:checked").val());
		if($("input[name='popup_value_type']:checked").val() == "list") {
			$("select.popup_vals_list").show();
			$("select.popup_vals_list").next().show();
			$("select[name='popup_vals_table']").hide();
		} else {
			$("select[name='popup_vals_table']").show();
			$("select.popup_vals_list").hide();
			$("select.popup_vals_list").next().hide();
		}
	}
	$("input[name='popup_value_type']").on("change", function() {
		showValuesTypes();
	});
	showValuesTypes();
	$.validator.addMethod("data-rule-banned-words", function(value) {
		return $.inArray(value, ['files']) == -1;
	}, "Column name not allowed.");
	$("#field-edit-form").validate({
	});
});
</script>
@endpush