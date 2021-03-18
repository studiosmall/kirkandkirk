<section class="fullwidth-image" style="background-image:url({{ $c['fullwidth_image'] }})">

  @if($c['header_text'])
    <div class="ticker-wrap">
      <div class="ticker">
      
          @foreach( $c['header_text'] as $message )
              <div class="ticker__item">{{ $message['text'] }}</div>
              <?php
                $i++;
                if($i > 32){ 
                  break;
                }
              ?>
            @endforeach
      </div>
    </div>
  @endif

  <div class="fullwidth-image__inner">
    @if( $c['text'] == 'enable')
      <div class="fullwidth-image__bottom" data-aos="fade-up">
        {!! $c['footer_text'] !!}
      </div>
    @endif
  </div>
</section>