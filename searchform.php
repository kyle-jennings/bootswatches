<?php
/**
* The search form for our theme
*
* @link https://developer.wordpress.org/reference/functions/get_search_form/
*
* @package Bootswatch
*/

?>
<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="form-group" role="search">

        <input class="form-control" id="search-field-small"
            name="s"
            placeholder="<?php echo esc_attr_x( 'Search ...', 'placeholder', 'bootswatch' ); ?>"
            title="<?php echo esc_attr_x( 'Search for:', 'title','bootswatch' ) ?>"
            type="search"
            value="<?php echo get_search_query() ?>"
        />
    </div>

    <div class="form-group">
        <button class="btn btn-primary" type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'bootswatch' ); ?>">
            Search
        </button>
    </div>

</form>