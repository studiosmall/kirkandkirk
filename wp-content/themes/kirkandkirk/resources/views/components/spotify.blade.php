<section class="spotify" style="background-color: {!! $c['background_colour'] !!};">
  <div class="spotify__inner">

    <div class="spotify__row">

      <div class="spotify__col">

        <img class="spotify__code" src="{{ $c['spotify_link_image']['url'] }}" alt="Spotify – Kirk & Kirk">

        <div class="spotify__info" data-aos="fade-up">
          <h3>Spotify</h3>
          <h4>{{ $c['playlist_name'] }}</h4>
        </div>

      </div>

      <div class="spotify__col">
        <div class="spotify__quote">
          <p>“{!! $c['quote'] !!}”</p>
          <span class="">{!! $c['quote_by'] !!}</span>
        </div>
      </div>

    </div>

  </div>
</section>