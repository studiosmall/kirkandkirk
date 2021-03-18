 @foreach($c['story'] as $story)     
  @php
    $image 		= get_the_post_thumbnail_url($story, 'large');
    $title 		= get_the_title($story);
    $fields  	= get_fields($story);

    $textarea  = $fields['textarea'];
    $colour    = $fields['colour']; 
  @endphp

  <section class="feature-story">
 
      <div class="feature-story__items">
        <div class="feature-story__item bg-color__{{ $colour }}">

          @if($image)
            <div class="feature-story__image">
              <img src="{{ $image }}"  alt="{{ $title }}">
            </div>
          @endif

        </div>

        <div class="feature-story__item  bg-color__{{ $colour }}--alt">

          <div class="feature-story__inner" data-aos="fade-up">
            <h3>MEET</h3>
            <h2>{{ $title }}</h2>

            {!! $textarea !!}

            <a href="/stories">Read more stories</a>

          </div>

        </div>

      </div>

  </section>
@endforeach