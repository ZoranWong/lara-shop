@foreach($js as $j)
<script src="{{ assert("$j") }}"></script>
@endforeach