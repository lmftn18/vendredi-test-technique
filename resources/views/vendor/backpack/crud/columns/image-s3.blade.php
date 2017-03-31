{{-- regular object attribute --}}
<td>
    @if ($entry->{$column['name']})
        <img class="img-thumbnail" src="{{ AppHelper::getS3Url($entry->{$column['name']}) }}">
        <br/>
    @endif
    {!! str_replace('/', '/<wbr>', str_limit(strip_tags($entry->{$column['name']}), 80, "[...]")) !!}
</td>