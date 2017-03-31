<button type="button" class="btn btn-default ladda-button" data-toggle="modal" data-target="#import-modal">
    <span class="ladda-label"><i class="fa fa-upload"></i>
        Importer CSV
    </span>
</button>

<div class="modal fade" id="import-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import</h4>
            </div>
            <div class="modal-body">
                <p>
                    Les champs attendus sont:
                    <ol>
                        @foreach($crud->getImporter()->getFields() as $importField)
                        	<li>{{ $importField }}</li>
                        @endforeach
                    </ol>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <form action="{{ url($crud->route.'/import') }}" method="post" enctype="multipart/form-data"
                      class="inline" id="import-form">
                    {{ csrf_field() }}
                    <label class="btn btn-primary ladda-button" data-style="zoom-in">
                    <span class="ladda-label"><i class="fa fa-upload"></i>
                        Importer CSV <input type="file" class="hidden" id="import-file" name="import">
                    </span>
                    </label>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('after_scripts_stack')
<script>
    $('#import-file').change(function () {
        $('#import-form').submit();
    });
</script>
@endpush

@push('crud_list_styles')
<style>
    .inline {
        display: inline-block;
    }
</style>
@endpush
