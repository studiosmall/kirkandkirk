{{--
  Template Name: Product Collection Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    {{-- @include('partials.filter') --}}
    @include('partials.content-page')
    @include('partials.content-blocks')
    @include('partials.about-content-blocks')
  @endwhile
@endsection

