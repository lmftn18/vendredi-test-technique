<!-- textarea -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <textarea
    	name="{{ $field['name'] }}"
        {{ ($field['max_length'] && !$field['truncate']) ? 'maxlength=' . $field['max_length'] : '' }}
        @include('crud::inc.field_attributes')

    	>{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}</textarea>
    <span id="preview_{{ $field['name'] }}"></span>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


@push('crud_fields_scripts')
    @if ($field['truncate'])
        <script>
            $(function(){
                $('textarea[name="{{ $field['name'] }}"]').keyup(function(){
                    var content = $(this).val();
                    var maxLength = {{ $field['max_length'] }};
                    var placeholder = "{{ isset($field['placeholder']) ? $field['placeholder'] : '(...)' }}";

                    $("#preview_{{ $field['name'] }}").html(
                        content.length > maxLength
                            ? content.substring(0, (maxLength - placeholder.length)) + placeholder
                            : content
                    );
                })
            });
        </script>
    @endif
@endpush