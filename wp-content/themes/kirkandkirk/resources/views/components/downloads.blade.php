<section class="downloads-section section" data-aos="fade-up">
  <div class="downloads-section__inner">

    <div class="downloads-section__items">
      @if($c['download'])

        @foreach($c['download'] as $download)

            <div class="downloads-section__item">

              <a href="{{ $download['file'] }}" download>
                <img src="{{ $download['thumbnail_image']['url'] }}">
              </a>

              <a href="{{ $download['file'] }}" download>
                <h3>
                  {!! $download['title'] !!}
                </h3>
              </a>
              <span>{!! $download['subtitle'] !!}</span>

            </div>

        @endforeach

      @endif
    </div>

  </div>
</section>