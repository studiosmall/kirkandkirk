<section class="cta-image">

  <div class="cta-image__center" data-aos="fade-up">
    <div class="cta-image__container">
      <img src="{{ $c['image']['url'] }}" alt="{{ $c['image']['alt'] }}">
    </div>
  </div>

  <div class="cta-image__inner">
    <div class="cta-image__bottom" data-aos="slide-up">

      <h3>{!! $c['title'] !!}</h3>
      <a href="{{ $c['link_url'] }}">{{ $c['link_text'] }}</a>

    </div>
  </div>

</section>