@extends('vendor/backpack/crud/fields/tinymce-preview')

@section('preview_html')
<card-asso
        v-bind:show-missions-default="true"
        v-bind:expanded="false"
        v-bind:display-links="false"
        v-bind:association="entity"
        v-bind:should-animate="false"
        v-if="entity"
></card-asso>
@endsection

@section('preview_script')
    <script type="text/javascript">
    var previewApp = new window.Vue({
        methods: {
            updateFieldValue: function (data) {
                this.entity.missions[0].description = data.description;
                this.entity.missions[0].title = data.title;
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

        var descriptionValue = $('#tinymce-{{ $field['name'] }}').val();
        var titleValue = $('input[name="title"]').val();
        previewApp.updateFieldValue({
            description : descriptionValue,
            title : titleValue
        });

        $('#preview-{{ $field['name'] }}').modal('show');
    })
</script>
@endsection