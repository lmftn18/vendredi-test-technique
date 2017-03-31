<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <?php $entity_model = $crud->model; ?>
    <select
    	name="{{ $field['name'] }}"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])
    	>

    	@if ($entity_model::isColumnNullable($field['name']))
            <option value="">-</option>
        @endif

	    	@if (isset($field['model']))
	    		@foreach ($field['model']::all() as $connected_entity_entry)
	    			<option value="{{ $connected_entity_entry->getKey() }}"
						@if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->getKey() ) || (isset($field['value']) && $connected_entity_entry->getKey()==$field['value']))
							 selected
						@endif
	    			>{{ $connected_entity_entry->{$field['attribute']} }}</option>
	    		@endforeach
	    	@endif
	</select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('js/select2.min.js') }}"></script>
    @endpush

@endif
@push('crud_fields_scripts')
    <script>
        $(function(){
            $.fn.select2.defaults.set( "theme", "bootstrap" );
            // trigger select2 for each untriggered select2 box
            $('.select2[name="{{ $field['name'] }}"]').each(function (i, obj) {
                if (!$(obj).data("select2"))
                {
                    $(obj).select2(
                        $.extend({}, {!! isset($field['options']) ? json_encode($field['options']) : '{}' !!})
                    );
                }
            });
        });
    </script>
@endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}