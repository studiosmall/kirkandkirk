{{--
  Template Name: About Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    {{-- @include('partials.content-page') --}}
    @include('partials.about-navigation')
    @include('partials.about-content-blocks')
    {{-- @include('partials.content-page') --}}
  @endwhile
@endsection
