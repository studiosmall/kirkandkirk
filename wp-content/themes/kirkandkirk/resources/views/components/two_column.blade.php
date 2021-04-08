<section class="two-column section" data-aos="fade-up">

  <div class="two-column__inner">

    <div class="two-column__col">

      @if($c['image_left']['url'])
      <img class="two-column__top-image" src="{{ $c['image_left']['url'] }}" alt="{{ $c['image_left']['title'] }}">
      @endif

      @if($c['textarea_left'])
      <div class="two-column__textarea textarea-left">
        {!! $c['textarea_left'] !!}
      </div>
      @endif

      @if($c['bottom_image_left']['url'])
      <div class="two-column__bottom-container {!! $c['image_position_left'] !!}">
        <img src="{{ $c['bottom_image_left']['url'] }}" alt="{{ $c['bottom_image_left']['title'] }}">
      </div>
      @endif

    </div>

    <div class="two-column__col">

      @if($c['image_right']['url'])
        <img class="two-column__top-image" src="{{ $c['image_right']['url'] }}" alt="{{ $c['image_right']['title'] }}">
      @endif

      @if($c['textarea_right'])
      <div class="two-column__textarea {!! $c['image_position_right'] !!}">
        {!! $c['textarea_right'] !!}
      </div>
      @endif

      @if($c['bottom_image_right']['url'])
      <div class="two-column__bottom-container {!! $c['image_position_left'] !!}">
        <img src="{{ $c['bottom_image_right']['url'] }}" alt="{{ $c['bottom_image_right']['title'] }}">
      </div>
      @endif

    </div>

  </div>

</section>