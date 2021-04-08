@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      <div class="alert__inner">
        {{ __('Sorry, but the page you were trying to view does not exist.', 'sage') }}
      </div>
    </div>
    {{-- {!! get_search_form(false) !!} --}}
  @endif
@endsection
