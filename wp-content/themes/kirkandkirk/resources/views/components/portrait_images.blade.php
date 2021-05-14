<section class="portrait-images section">
  <div class="portrait-images__row">

    @foreach($c['images'] as $image)
      <div class="image-container">
        <div class="portrait-images__col" style="background-image:url({{ $image['image']['url'] }})">
          @if($image['url_link'])
            <a class="portrait-images__link" href="{{ $image['url_link'] }}"></a>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</section>