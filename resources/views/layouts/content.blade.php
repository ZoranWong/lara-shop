@extends('layouts.page')

@section('content')
    @include('components.partials.error')
    @include('components.partials.success')
    @include('components.partials.exception')
    @include('components.partials.toastr')
    {!! $content !!}
@endsection