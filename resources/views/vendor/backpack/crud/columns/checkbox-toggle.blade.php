<td>
    <input type="checkbox"
           data-toggle="toggle"
           data-id="{{ $entry->id }}"
           data-url="{{ $column['url'] }}"
           class="toggle-checkbox"
           {{ $entry->{$column['name']} ? 'checked' : '' }}
    >
</td>

@push('after_scripts_stack')
    @if(false === $crud->isColumnAlreadyLoaded($column['type']))
        <script>
            $(function () {
                $('body').on('change', '.toggle-checkbox', function (e) {
                    var checkbox = $(this);
                    var isOn = ! checkbox.parent('div').hasClass('off');

                    var form = $('<form action="' + checkbox.data('url') + '" method="post">' +
                        '<input type="hidden" name="id" value="' + checkbox.data('id') + '" />' +
                        '<input type="hidden" name="isOn" value="' + isOn + '" />' +
                        '</form>');
                    $('body').append(form);
                    form.submit();
                });
            });
        </script>
    @endif
    @php($crud->addToLoadedColumns($column['type']))
@endpush