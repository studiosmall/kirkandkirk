@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="inner">
    @if (!have_posts())
      <div class="alert alert-warning">
        {{ __('Sorry, no results were found.', 'sage') }}
      </div>
      {{-- {!! get_search_form(false) !!} --}}
    @endif

    <ul class="products">
      @while(have_posts()) @php the_post() @endphp
        @include('partials.content-search')
      @endwhile
    </ul>
  </div>

  {!! get_the_posts_navigation() !!}
@endsection
