<article @php post_class('article') @endphp style="border-color: {{ $article['colour'] }}">


    <div class="two-column__inner">
      <div class="two-column__col">
        @foreach($article['images'] as $layout)
          @if($layout['layout'] == 'landscape')

            <div class="two-column__top-image">
              <img src="{{ $layout['landscape']['url'] }}" alt="{{ $layout['landscape']['title'] }}">

              @if($layout['landscape']['caption'])
                <span class="caption">{!! $layout['landscape']['caption'] !!}</span>
              @endif
            </div>

          @elseif ($layout['layout'] == 'portrait')

            <div class="two-column__portrait">
              <div class="col">
                <img src="{{ $layout['portrait']['url'] }}" alt="{{ $layout['portrait']['title'] }}">

                @if($layout['portrait']['caption'])
                  <span class="caption">{!! $layout['portrait']['caption'] !!}</span>
                @endif
              </div>
              <div class="col">
                <img src="{{ $layout['portrait_right']['url'] }}" alt="{{ $layout['portrait_right']['title'] }}">

                @if($layout['portrait_right']['caption'])
                  <span class="caption">{!! $layout['portrait_right']['caption'] !!}</span>
                @endif
              </div>
            </div>

          @endif
        @endforeach

      </div>
      <div class="two-column__col">
          <h1 class="entry-title">{!! get_the_title() !!}</h1>
          <div class="entry-content">
            {!! $article['readmore'] !!}
          </div>
      </div>
    </div>

</article>
