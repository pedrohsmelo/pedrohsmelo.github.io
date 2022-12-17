<?php
/**
 * 404 content.
 */
return array(
	'title'      => __( '404', 'startupzy' ),
	'categories' => array( 'startupzy-basic' ),
	'content'    => '
            <!-- wp:group {"layout":{"inherit":false}} -->
            <div class="wp-block-group"><!-- wp:cover {"url":"' . esc_url( STARTUPZY_URI ) . 'assets/img/action-african-american-african-descent-agreement-american-black-1448357-pxhere.com.webp","id":128,"dimRatio":92,"customOverlayColor":"#02132d","focalPoint":{"x":"0.50","y":"0.48"},"minHeight":530,"contentPosition":"center center","style":{"spacing":{"padding":{"bottom":"380px","right":"0px","left":"0px","top":"0px"}}}} -->
            <div class="wp-block-cover" style="padding-top:0px;padding-right:0px;padding-bottom:380px;padding-left:0px;min-height:530px"><span aria-hidden="true" class="has-background-dim-90 wp-block-cover__gradient-background has-background-dim" style="background-color:#02132d"></span><img class="wp-block-cover__image-background wp-image-128" alt="" src="' . esc_url( STARTUPZY_URI ) . 'assets/img/action-african-american-african-descent-agreement-american-black-1448357-pxhere.com.webp" style="object-position:50% 48%" data-object-fit="cover" data-object-position="50% 48%"/><div class="wp-block-cover__inner-container"><!-- wp:template-part {"slug":"header","theme":"startupzy"} /-->
            
            <!-- wp:group {"tagName":"main","style":{"spacing":{"padding":{"top":"280px"}}},"layout":{"wideSize":"1170px","contentSize":"1170px"}} -->
            <main class="wp-block-group" style="padding-top:280px"><!-- wp:columns -->
            <div class="wp-block-columns"><!-- wp:column -->
            <div class="wp-block-column"><!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"bottom":"40px"}},"typography":{"fontStyle":"normal","fontWeight":"700","textTransform":"uppercase","letterSpacing":"6px","lineHeight":"0.6"},"color":{"text":"#1e70ea"}},"fontSize":"gigantic"} -->
            <h2 class="has-text-align-center has-text-color has-gigantic-font-size" style="color:#1e70ea;font-style:normal;font-weight:700;line-height:0.6;margin-bottom:40px;text-transform:uppercase;letter-spacing:6px">404</h2>
            <!-- /wp:heading -->
            
            <!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"bottom":"30px"}}},"textColor":"white","fontSize":"extra-large"} -->
            <h2 class="has-text-align-center has-white-color has-text-color has-extra-large-font-size" style="margin-bottom:30px">Page Not Found</h2>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph {"align":"center","textColor":"white"} -->
            <p class="has-text-align-center has-white-color has-text-color">It looks like nothing was found at this location. Maybe try a search?</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:spacer {"height":"20px"} -->
            <div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->
            
            <!-- wp:search {"label":"Search...","showLabel":false,"width":50,"widthUnit":"%","buttonText":"Search","align":"center","style":{"border":{"radius":"5px"}},"borderColor":"fifth"} /--></div>
            <!-- /wp:column --></div>
            <!-- /wp:columns --></main>
            <!-- /wp:group --></div></div>
            <!-- /wp:cover --></div>
            <!-- /wp:group -->',
);
