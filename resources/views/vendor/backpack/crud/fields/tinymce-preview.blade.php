{{--
MODIFICATION:
    - extend the tinymce intitialization to pass some custom parameters
    - add job preview card
--}}

<!-- Tiny MCE -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <textarea
            id="tinymce-{{ $field['name'] }}"
            name="{{ $field['name'] }}"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control tinymce'])
    >{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}</textarea>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

<!-- Button trigger modal -->
<div class="form-group col-md-12">
    <button id="open-preview-{{ $field['name'] }}" type="button" class="btn btn-primary" data-toggle="modal">
        Preview: {!! $field['label'] !!}
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="preview-{{ $field['name'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Preview</h4>
            </div>
            <div class="modal-body">
                <div class="form-group col-md-12">
                    <div class="preview-container" id="preview-container-{{ $field['container_name'] }}">
                        <div class="preview render-as-public-site" id="preview-{{ $field['name'] }}">
                            @yield('preview_html')
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@push('after_scripts_stack')

@yield('preview_script')
@endpush

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <!-- include tinymce js-->
    <script src="{{ asset('vendor/backpack/tinymce/tinymce.min.js') }}"></script>
    {{-- <script src="{{ asset(config('backpack.base.route_prefix').'/js/vendor/tinymce/jquery.tinymce.min.js') }}"></script> --}}

    <script type="text/javascript">
        tinymce.init(
            {{-- MODIFICATION - extend the init options --}}
            $.extend({
                selector: "textarea.tinymce",
                skin: "dick-light",
                plugins: "image,link,media,anchor",
                file_browser_callback: elFinderBrowser,
                // don't encode characters as tinyMCE 'named' option (ex: don't switch a non-brakable space with &nbsp;)
                // except the necessary ones (ex: <, >, '...) or it might break the XML validator when sanitizing (try with a nbsp to confirm)
                entity_encoding: 'raw'
            }, {!! isset($field['options']) ? json_encode($field['options']) : '{}' !!}));

        function elFinderBrowser(field_name, url, type, win) {
            tinymce.activeEditor.windowManager.open({
                file: '{{ url(config('backpack.base.route_prefix').'/elfinder/tinymce4') }}',// use an absolute path!
                title: 'elFinder 2.0',
                width: 900,
                height: 450,
                resizable: 'yes'
            }, {
                setUrl: function (url) {
                    win.document.getElementById(field_name).value = url;
                }
            });
            return false;
        }
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}