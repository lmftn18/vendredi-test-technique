{{-- localized date using jenssegers/date --}}
<td data-order="{{ $entry->{$column['name']} }}">
    @if (!empty($entry->{$column['name']}))
        {{ ucfirst(Date::parse($entry->{$column['name']})->format($column['format'])) }}
    @endif
</td>