jQuery( document ).ready( function( $ ) {

    $( '.sticky-goto' ).on( 'click', function(){
        window.location.href = $( this ).data( 'url' );             
    });

} );