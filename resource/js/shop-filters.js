jQuery( document ).ready( function( $ ) {
	function buildFilterURL() {
		var query = [];
		var baseURL = window.location.pathname;

		var categories = [];
		$( '.filter-category:checked' ).each( function() {
			categories.push( $( this ).val() );
		} );
		if ( categories.length ) {
			query.push( 'product_cat=' + categories.join( ',' ) );
		}

		var brands = [];
		$( '.filter-brand:checked' ).each( function() {
			brands.push( $( this ).val() );
		} );
		if ( brands.length ) {
			query.push( 'product_brand=' + brands.join( ',' ) );
		}

		var tags = [];
		$( '.filter-tags:checked' ).each( function() {
			tags.push( $( this ).val() );
		} );
		if ( tags.length ) {
			query.push( 'product_tag=' + tags.join( ',' ) );
		}

		var ratings = [];
		$( '.filter-rating:checked' ).each( function() {
			ratings.push( $( this ).val() );
		} );
		if ( ratings.length ) {
			query.push( 'rating_filter=' + ratings.join( ',' ) );
		}

		var selectedPrice = $( '.filter-price:checked' );
		if ( selectedPrice.length && selectedPrice.val() !== 'clear' ) {
			query.push( 'min_price=' + selectedPrice.data( 'min' ) );
			query.push( 'max_price=' + selectedPrice.data( 'max' ) );
		}

		window.location.href = baseURL + ( query.length ? '?' + query.join( '&' ) : '' );
	}

	$( '.filter-category, .filter-brand, .filter-tags, .filter-rating, .filter-price, .filter-price-clear' ).on( 'change', function() {
		buildFilterURL();
	} );
} );
