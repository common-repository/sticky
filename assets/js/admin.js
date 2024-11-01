jQuery( function( $ ) {

    // Editing an individual custom post
    if ( sticky.screen == 'post' ) {

        // Change visibility label if appropriate
        if ( parseInt( sticky.is_sticky ) )
            $( '#post-visibility-display' ).text( sticky.sticky_visibility_text );

        // Add checkbox to visibility form
        $( '#post-visibility-select label[for="visibility-radio-public"]' ).next( 'br' ).after(
            '<span id="sticky-span">' +
                '<input id="sticky" name="sticky" type="checkbox" value="sticky"' + sticky.checked_attribute + ' /> ' +
                '<label for="sticky" class="selectit">' + sticky.label_text + '</label>' +
                '<br />' +
            '</span>'
        );


    // Browsing custom posts
    } else {

        // Add "Sticky" filter above post table if appropriate
        if ( parseInt( sticky.sticky_count ) > 0 ) {
            var publish_li = $( '.subsubsub > .publish' );

            publish_li.append( ' |' );
            publish_li.after(
                '<li class="sticky">' +
                    '<a href="edit.php?post_type=' + sticky.post_type + '&show_sticky=1">' +
                    sticky.sticky_text +
                    ' <span class="count">(' + sticky.sticky_count + ')</span>' +
                    '</a>' +
                '</li>'
            );
        }

        // Add checkbox to quickedit forms
        $( 'span.title:contains("' + sticky.status_label_text + '")' ).parent().after(
            '<label class="alignleft">' +
                '<input type="checkbox" name="sticky" value="sticky" /> ' +
                '<span class="checkbox-title">' + sticky.label_text + '</span>' +
            '</label>'
        );

        // Add sticky hidden field with the data for use in the inline editor for hierarchical post types
        if ( sticky.post_type_hierarchical == 1 ) {
            $( '.wp-list-table.pages td.has-row-actions' ).each( function() {
                var post_id = $( this ).parent().attr( 'id' ).substr(5);
                if( $.inArray( post_id, sticky.sticky_posts ) != -1 ) {
                    $( '#inline_'+post_id ).append( '<div class="sticky">sticky</div>' );
                }
            });
        }
    }

} );