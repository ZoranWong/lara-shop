<script>
    @foreach($jsContainer as $js)
    $.batchLoadJs({!! json_encode($js[0]) !!}, function(script, textStatus){
        if (textStatus == 'success') {
            {!! !isset($js[1])?:$js[1] !!}
        }
    });
    @endforeach
</script>
