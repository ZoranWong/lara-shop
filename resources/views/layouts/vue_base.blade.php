{{-- 引入vue文件 --}}
@section('css')
  <link href="{{ asset('css/my.css') }}?v=20171130" rel="stylesheet">
@stop
@push('js')
  <script src="{{ asset('js/my.js') }}?v=20171130"></script>
@endpush