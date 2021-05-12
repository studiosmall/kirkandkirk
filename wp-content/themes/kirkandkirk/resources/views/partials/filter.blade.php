<section class="filter section">
	<div class="filter__inner">
		<span class="filter__title">Filter <span class="plus"></span></span>

		<div class="filter__container">

			@php dynamic_sidebar('sidebar-primary') @endphp

			{{-- @php
				add_filter('woocommerce_product_query_tax_query', 'custom_product_query_meta_query', 10, 2);

			@endphp --}}

		</div>
	</div>
</section>