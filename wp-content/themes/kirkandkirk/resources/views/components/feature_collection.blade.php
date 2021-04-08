<section class="feature-collection grow" style="background-image:url({{ $c['fullwidth_image'] }})">

  <a class="feature-collection__link" href="/shop/{{ $c['featured_collection']->slug }}"></a>

  <div class="feature-collection__inner">
    <div class="feature-collection__bottom" data-aos="fade-up">

      <h3>{!! $c['featured_collection']->name  !!}</h3>
      <a href="/shop/{{ $c['featured_collection']->slug }}">View Collection</a>

    </div>
  </div>
</section>