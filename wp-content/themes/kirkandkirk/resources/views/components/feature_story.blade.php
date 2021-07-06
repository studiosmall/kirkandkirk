 @foreach($c['story'] as $story)     
  @php
    $image 		= get_the_post_thumbnail_url($story, 'large');
    $title 		= get_the_title($story);
    $link 		= get_permalink($story);
    $fields  	= get_fields($story);

    $textarea       = $fields['textarea'];
    $readTextarea   = $fields['read_more_text'];
    $colour         = $fields['colour']; 
  @endphp

  <section class="feature-story">
 
      <div class="feature-story__items">
        <div class="feature-story__item bg-color" style="background-color: {{ $colour }}">

          @if($image)
            <div class="feature-story__image">
              <img src="{{ $image }}"  alt="{{ $title }}">
            </div>
          @endif

        </div>

        <div class="feature-story__item bg-color alt">

          <div class="feature-story__inner">
            <h3>MEET</h3>
            <h2>{{ $title }}</h2>

            <p>{!! $textarea !!}</p>

            @if($readTextarea)
              <a href="{{ $link }}">Read more</a>
            @else
              <a href="/stories">Read more stories</a>
            @endif
            

          </div>

        </div>

      </div>

  </section>
@endforeach