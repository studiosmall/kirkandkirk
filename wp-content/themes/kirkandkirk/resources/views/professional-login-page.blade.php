{{--
  Template Name: Professional Login Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    @include('partials.login-page')
    @include('partials.content-blocks')
  @endwhile
@endsection

