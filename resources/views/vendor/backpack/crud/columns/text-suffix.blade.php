{{-- regular object attribute --}}
<td data-order="{{ $entry->{$column['name']} }}">
    {{ strip_tags($entry->{$column['name']}) . $column['suffix'] }}
</td>