<div class="overlay"></div>
<section id="mailinglist" class="mailinglist" style="display: none;">

	<span class="mailinglist__close">+</span>

	<div class="mailinglist__inner">

		<div class="mailinglist__inner--title">
			<h3>SIGN UP TO OUR NEWSLETTER</h3>
		</div>

		@php
			$form = 2;
			gravity_form($form, false, true, false, '', true, 1);
		@endphp

		{{-- <!-- Begin Mailchimp Signup Form -->
		<div id="mc_embed_signup">
			<form action="" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div id="mc_embed_signup_scroll">

			<div class="mc-field-group">
				<input type="email" placeholder="Email address" value="" name="EMAIL" class="required email" id="mce-EMAIL">
					<div style="position: absolute; left: -5000px;" aria-hidden="true">
						<input type="text" name="b_4622faccf3d33e018c84d21ce_10ac2b8998" tabindex="-1" value=""></div>
						<input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="button">
					</div>
			</div>
			<div id="mergeRow-gdpr" class="mergeRow gdpr-mergeRow content__gdprBlock mc-field-group">
					<div class="content__gdpr">
								<label class="checkbox subfield" for="gdpr_833">
									<input type="checkbox" id="gdpr_833" name="gdpr[833]" value="Y" class="av-checkbox gdpr"><span>I agree to be emailed by Kirk and Kirk</span> 
								</label>
					</div>
					<div class="content__gdprLegal">
					</div>
			</div>
				<div id="mce-responses" class="clear">
					<div class="response" id="mce-error-response" style="display:none"></div>
					<div class="response" id="mce-success-response" style="display:none"></div>
				</div>  
			</form>
		</div>
		<!--End mc_embed_signup--> --}}

  </div>

</section>