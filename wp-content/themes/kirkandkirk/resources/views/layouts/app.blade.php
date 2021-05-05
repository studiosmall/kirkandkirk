<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')

  @php $user = wp_get_current_user(); @endphp

  @if ( in_array( 'professional', (array) $user->roles ) )
    @php $user = 'professional-user'; @endphp
  @endif

  <body @php body_class($user) @endphp>
    @php do_action('get_header') @endphp
    @include('partials.header')
    <div class="wrap container" @if($colour['bg']) style="background-color: {!!$colour['bg']!!}"; @endif role="document">
      <div class="content">

        <main class="main">
          @yield('content')

          @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
        @endif
        </main>
      </div>
    </div>

    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
  </body>
</html>
