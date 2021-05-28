<?php
/**
 * Handle integration with Affiliate WP.
 *
 * @version 2.9.0
 * @package WCPBC/Integrations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WCPBC_Affiliate_WP' ) ) :

	/**
	 * WCPBC_Affiliate_WP Class
	 */
	class WCPBC_Affiliate_WP {

		/**
		 * Hook actions and filters
		 */
		public static function init() {
			add_filter( 'affwp_woocommerce_add_pending_referral_amount', array( __CLASS__, 'add_pending_referral_amount' ), 999, 2 );
		}

		/**
		 * Convert the amount to the AffilateWP currency using the exchange rate.
		 *
		 * @param float $amount   Calculated referral amount.
		 * @param int   $order_id Order ID (reference).
		 */
		public static function add_pending_referral_amount( $amount, $order_id ) {
			$order = wc_get_order( $order_id );
			if ( ! $order ) {
				return $amount;
			}
			$order_currency = $order->get_currency();
			$affwp_currency = affwp_get_currency();
			$base_currency  = wcpbc_get_base_currency();

			if ( $order_currency !== $affwp_currency ) {
				// Convert the amount.
				$error       = false;
				$zone        = WCPBC_Pricing_Zones::get_zone_from_order( $order );
				$base_amount = $zone ? $zone->get_base_currency_amount( $amount ) : $amount;

				if ( $affwp_currency !== $base_currency ) {
					// Lookup a pricing zone with the Aff currency.
					$aff_exchange_rate = false;
					foreach ( WCPBC_Pricing_Zones::get_zones() as $zone ) {
						if ( $affwp_currency === $zone->get_currency() ) {
							$aff_exchange_rate = $zone->get_real_exchange_rate();
							break;
						}
					}

					$aff_exchange_rate = $aff_exchange_rate ? $aff_exchange_rate : apply_filters( 'wc_price_based_country_affwp_woo_currency_rate', $aff_exchange_rate );

					if ( $aff_exchange_rate ) {
						$base_amount = $base_amount * $aff_exchange_rate;
					} else {
						// translators: Currency codes.
						$error = sprintf( __( 'No exchange rate to convert the AffiliateWP referral from %1$s to %2$s.', 'wc-price-based-country-pro' ), $base_currency, $affwp_currency );
						$order->add_order_note( 'Price Based on Country - Error: ' . $error );
					}
				}

				if ( ! $error && $amount !== $base_amount ) {
					$format_amount      = affwp_format_amount( $amount ) . '&nbsp;' . $order_currency;
					$format_base_amount = affwp_format_amount( $base_amount ) . '&nbsp;' . $affwp_currency;
					$exchange_rate      = "1&nbsp;{$order_currency} = " . wc_format_localized_decimal( round( $base_amount / $amount, 6 ), false ) . '&nbsp;' . $affwp_currency;

					// Convert the amount to the base currency.
					$decimals = affwp_get_decimal_count();
					$amount   = round( $base_amount, $decimals );

					// Add a order note.
					$order->add_order_note(
						sprintf(
							// translators: 1:original amount, 2: converted amount, 3: exchange rate.
							__(
								'Referral for %1$s converted to %2$s by Price Based on Country (%3$s).',
								'wc-price-based-country-pro'
							),
							$format_amount,
							$format_base_amount,
							$exchange_rate
						)
					);
				}
			}
			return $amount;
		}

		/**
		 * Checks the environment for compatibility problems.
		 *
		 * @return boolean
		 */
		public static function check_environment() {
			if ( defined( 'AFFILIATEWP_VERSION' ) && version_compare( AFFILIATEWP_VERSION, '2.4.4', '<' ) ) {
				add_action( 'admin_notices', array( __CLASS__, 'min_version_notice' ) );
				return false;
			}

			return true;
		}

		/**
		 * Display admin minimun version required
		 */
		public static function min_version_notice() {
			$affwp_version = defined( 'AFFILIATEWP_VERSION' ) ? AFFILIATEWP_VERSION : 'undefined';
			// translators: 1: HTML tag, 2: HTML tag, 3: AFFILIATEWP version.
			$notice = sprintf( __( '%1$sPrice Based on Country Pro & AffiliateWP%2$s compatibility requires AffiliateWP +2.4.4. You are running AffiliateWP %3$s.', 'wc-price-based-country-pro' ), '<strong>', '</strong>', $affwp_version );
			echo '<div id="message" class="error"><p>' . wp_kses_post( $notice ) . '</p></div>';
		}
	}

	if ( WCPBC_Affiliate_WP::check_environment() ) {
		WCPBC_Affiliate_WP::init();
	}

endif;
