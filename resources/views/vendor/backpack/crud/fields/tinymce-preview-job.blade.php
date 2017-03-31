@extends('vendor/backpack/crud/fields/tinymce-preview')

@section('preview_html')
    <card-offre v-bind:job="entity"
                v-bind:should-animate="false"
                v-bind:display-links="false"
                v-bind:is-mobile="false"
                v-if="entity"
    ></card-offre>
@endsection

@section('preview_script')
    <script type="text/javascript">
        var previewApp = new window.Vue({
            methods: {
                updateFieldValue: function (fieldValue) {
                    this.entity.{{ $field['name'] }} = fieldValue;
                }
            },
            el: '#preview-{{ $field['name'] }}',
            data: {
                entity: {!! isset($field['preview_data']) ? json_encode($field['preview_data']) : '{}' !!}
            }
        });

        $('#open-preview-{{ $field['name'] }}').click(function () {
            // update the textarea
            tinyMCE.triggerSave();

            var fieldValue = $('#tinymce-{{ $field['name'] }}').val();
            previewApp.updateFieldValue(fieldValue);

            $('#preview-{{ $field['name'] }}').modal('show');

        })
    </script>
@endsection
