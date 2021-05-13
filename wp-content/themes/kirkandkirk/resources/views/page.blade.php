@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

    @if($type['page_type'] == 'professional')

      @if( in_array( 'professional', (array) $type['user']->roles ) )

        @include('partials.page-header')
        {{-- @include('partials.filter') --}}
        @include('partials.content-page')
        @include('partials.content-blocks')
        @include('partials.about-content-blocks')
        {{-- @include('partials.content-page') --}}

      @else
        <section class="message">
          <div class="message__inner">
            Please sign in to access the Professional Portal
          </div>
        </section>
      @endif

    @elseif($type['page_type'] == 'normal')

      @include('partials.page-header')
      {{-- @include('partials.filter') --}}
      @include('partials.content-page')
      @include('partials.content-blocks')
      @include('partials.about-content-blocks')
      {{-- @include('partials.content-page') --}}

    @endif

  @endwhile
@endsection