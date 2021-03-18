<section class="cta-image">

  <div class="cta-image__center" data-aos="fade-up">
    <img src="{{ $c['image']['url'] }}" alt="{{ $c['image']['alt'] }}">
  </div>

  <div class="cta-image__inner">
    <div class="cta-image__bottom" data-aos="slide-right">

      <h3>{!! $c['title'] !!}</h3>
      <a href="{{ $c['link_url'] }}">{{ $c['link_text'] }}</a>

    </div>
  </div>

</section>