
<div class="card">
	<div class="card-header">
		<div class="actions">
			@include('la.layouts.partials.language_filter')
		</div>
	</div>
	<div class="card-body">
		<table class="table table-bordered" id="example1">
			<thead>
			<tr>
				@foreach( $listing_cols as $col )
				<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
				@endforeach
				@if($show_actions)
				<th>{{trans('view.actions')}}</th>
				@endif
			</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>