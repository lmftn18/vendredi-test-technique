<td>
    @if($entry->{$column['name']})
        <span class="label label-success">OK</span>
    @else
        <span class="label label-danger">KO</span> <br /> <a href="{{ URL::route($column['route'], ['id' => $entry->id ]) }}">->OK</a>
    @endif
</td>
