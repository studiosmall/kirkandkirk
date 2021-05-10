<section class="two-column section" data-aos="fade-up">
  <div class="two-column__inner">

    <div class="two-column__col">

      @if($c['image'])

        @foreach($c['image'] as $layout)

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

      @endif

    </div>

    <div class="two-column__col">
      @if($c['textarea_right'])
      <div class="two-column__textarea {!! $c['image_position_right'] !!}">
        {!! $c['textarea_right'] !!}
      </div>
      @endif
    </div>

  </div>
</section>