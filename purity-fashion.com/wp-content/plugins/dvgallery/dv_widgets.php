<?php
/* ----------------------------------------------------------
Carousel widget
------------------------------------------------------------- */

add_action( 'widgets_init', 'dv_dvcarousel_widget' );

function dv_dvcarousel_widget() {
	register_widget( 'dv_dvcarouselwidget' );
}

class dv_dvcarouselwidget extends WP_Widget {

    function __construct() {
		parent::__construct(
			'dv-dvcarousel-widget', // Base ID
			esc_attr__('DV Carousel', 'dvgallery'), // Name
			array( 'description' => esc_attr__('DV Gallery Carousel Widget.', 'dvgallery'), ) // Args
		);
	}
	
	public function widget( $args, $instance ) {
		extract( $args );
        $max = $instance['max'];
        $columns = $instance['columns'];
        $categoryid = $instance['categoryid'];
        $autoplay = $instance['autoplay'];
        $duration = $instance['duration'];

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}  
        echo do_shortcode("[dvcarousel max='" . esc_attr($max) . "' columns='" . esc_attr($columns) . "' categoryid='" . esc_attr($categoryid) . "' autoplay='" . esc_attr($autoplay) . "' duration='" . esc_attr($duration) . "']");
		
		echo $args['after_widget'];
	}
	 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['max'] = $new_instance['max'];
        $instance['columns'] = $new_instance['columns'];
        $instance['categoryid'] = $new_instance['categoryid'];
        $instance['autoplay'] = $new_instance['autoplay'];
        $instance['duration'] = $new_instance['duration'];

		return $instance;
	}
	
	public function form( $instance ) {
		$defaults = array( 'title' => '', 'max' => '99', 'duration' => '4');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'max' )); ?>"><?php esc_attr_e('Maximum number of galleries:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'max' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max' )); ?>" value="<?php if (isset($instance['max'])) { echo esc_attr($instance['max']); } ?>" onkeypress="return validate(event)" type="number" style="width:100%;" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'columns' )); ?>"><?php esc_attr_e('Columns:', 'dvgallery'); ?></label>
    <select name="<?php echo esc_attr($this->get_field_name( 'columns' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'columns' )); ?>">
        <option value="1" <?php if (isset($instance['columns'])) { if ($instance['columns'] == 1) { echo esc_attr('selected="selected"'); }} ?>>1</option>
        <option value="2" <?php if (isset($instance['columns'])) { if ($instance['columns'] == 2) { echo esc_attr('selected="selected"'); }} ?>>2</option>
        <option value="3" <?php if (isset($instance['columns'])) { if ($instance['columns'] == 3) { echo esc_attr('selected="selected"'); }} ?>>3</option>
        <option value="4" <?php if (isset($instance['columns'])) { if ($instance['columns'] == 4) { echo esc_attr('selected="selected"'); }} ?>>4</option>
    </select>
</p>
<?php $carouselterms = get_terms( 'dvgallerytaxonomy'); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'categoryid' )); ?>"><?php esc_attr_e('Select Category:', 'dvgallery'); ?></label>
    <select name="<?php echo esc_attr($this->get_field_name( 'categoryid' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'categoryid' )); ?>">
        <option value=""><?php esc_attr_e('All Categories', 'dvgallery'); ?></option>        
        <?php if ($carouselterms && !is_wp_error($carouselterms)) { ?>
        <?php foreach( $carouselterms as $term ) { ?>
        <?php $termname = $term->name; ?>
        <?php $termid = $term->term_id; ?>
        <option value="<?php echo esc_attr($termid) ?>" <?php if (isset($instance['categoryid'])) { if ($instance['categoryid'] == $termid) { echo esc_attr('selected="selected"'); }} ?>><?php echo esc_attr($termname) ?></option>
        <?php } ?>
        <?php } ?>
    </select>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>"><?php esc_attr_e('Autoplay:', 'dvgallery'); ?></label>
    <select name="<?php echo esc_attr($this->get_field_name( 'autoplay' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>">
        <option value="false" <?php if (isset($instance['autoplay'])) { if ($instance['autoplay'] == 'false') { echo esc_attr('selected="selected"'); }} ?>>False</option>
        <option value="true" <?php if (isset($instance['autoplay'])) { if ($instance['autoplay'] == 'true') { echo esc_attr('selected="selected"'); }} ?>>True</option>
    </select>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'duration' )); ?>"><?php esc_attr_e('Autoplay duration (second):', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'duration' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'duration' )); ?>" value="<?php if (isset($instance['duration'])) { echo esc_attr($instance['duration']); } ?>" onkeypress="return validate(event)" type="number" style="width:100%;" />
</p>
<?php }} ?>
<?php
/* ----------------------------------------------------------
Blog style gallery widget
------------------------------------------------------------- */

add_action( 'widgets_init', 'dv_dvgalleries_widget' );

function dv_dvgalleries_widget() {
	register_widget( 'dv_dvgallerieswidget' );
}

class dv_dvgallerieswidget extends WP_Widget {

    function __construct() {
		parent::__construct(
			'dv-dvgalleries-widget', // Base ID
			esc_attr__('DV Galleries', 'dvgallery'), // Name
			array( 'description' => esc_attr__('DV Blog Style Gallery Widget.', 'dvgallery'), ) // Args
		);
	}
	
	public function widget( $args, $instance ) {
		extract( $args );
        $max = $instance['max'];
        $categoryid = $instance['categoryid'];
        $vertical = $instance['vertical'];

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}  
        echo do_shortcode("[dvgalleries max='" . esc_attr($max) . "' categoryid='" . esc_attr($categoryid) . "' vertical='" . esc_attr($vertical) . "']");
		
		echo $args['after_widget'];
	}
	 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['max'] = $new_instance['max'];
        $instance['categoryid'] = $new_instance['categoryid'];
        $instance['vertical'] = $new_instance['vertical'];

		return $instance;
	}
	
	public function form( $instance ) {
		$defaults = array( 'title' => '', 'max' => '5');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'max' )); ?>"><?php esc_attr_e('Maximum number of galleries:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'max' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max' )); ?>" value="<?php if (isset($instance['max'])) { echo esc_attr($instance['max']); } ?>" onkeypress="return validate(event)" type="number" style="width:100%;" />
</p>
<?php $blogterms = get_terms( 'dvgallerytaxonomy'); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'categoryid' )); ?>"><?php esc_attr_e('Select Category:', 'dvgallery'); ?></label>
    <select name="<?php echo esc_attr($this->get_field_name( 'categoryid' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'categoryid' )); ?>">
        <option value=""><?php esc_attr_e('All Categories', 'dvgallery'); ?></option>        
        <?php if ($blogterms && !is_wp_error($blogterms)) { ?>
        <?php foreach( $blogterms as $term ) { ?>
        <?php $termname = $term->name; ?>
        <?php $termid = $term->term_id; ?>
        <option value="<?php echo esc_attr($termid) ?>" <?php if (isset($instance['categoryid'])) { if ($instance['categoryid'] == $termid) { echo esc_attr('selected="selected"'); }} ?>><?php echo esc_attr($termname) ?></option>
        <?php } ?>
        <?php } ?>
    </select>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'vertical' )); ?>"><?php esc_attr_e('Vertical:', 'dvgallery'); ?></label>
    <select name="<?php echo esc_attr($this->get_field_name( 'vertical' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'vertical' )); ?>">
        <option value="yes"><?php esc_attr_e('Yes', 'dvgallery'); ?></option>
        <option value="no"><?php esc_attr_e('No', 'dvgallery'); ?></option>
    </select>
</p>
<?php }} ?>
<?php
/* ----------------------------------------------------------
Blog style single gallery widget
------------------------------------------------------------- */

add_action( 'widgets_init', 'dv_dvgallery_widget' );

function dv_dvgallery_widget() {
	register_widget( 'dv_dvgallerywidget' );
}

class dv_dvgallerywidget extends WP_Widget {

    function __construct() {
		parent::__construct(
			'dv-dvgallery-widget', // Base ID
			esc_attr__('DV Single Gallery', 'dvgallery'), // Name
			array( 'description' => esc_attr__('DV Single Gallery (Blog Style) Widget.', 'dvgallery'), ) // Args
		);
	}
	
	public function widget( $args, $instance ) {
		extract( $args );
        $id = $instance['id'];
        $vertical = $instance['vertical'];

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}  
        echo do_shortcode("[dvgallery id='" . esc_attr($id) . "' vertical='" . esc_attr($vertical) . "']");
		
		echo $args['after_widget'];
	}
	 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['id'] = $new_instance['id'];
        $instance['vertical'] = $new_instance['vertical'];

		return $instance;
	}
	
	public function form( $instance ) {
		$defaults = array( 'title' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
</p>
<?php $singlegalargs = array('post_type' => 'dvgalleries','posts_per_page' => 999); ?>
<?php $singlegallery_query = new WP_Query( $singlegalargs ); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'id' )); ?>"><?php esc_attr_e('Select Gallery:', 'dvgallery'); ?></label>
    <select name="<?php echo esc_attr($this->get_field_name( 'id' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'id' )); ?>">       
        <?php while($singlegallery_query->have_posts()) : $singlegallery_query->the_post(); ?>
        <?php $id = get_the_ID(); ?>
        <option value="<?php the_ID(); ?>" <?php if (isset($instance['id'])) { if ($instance['id'] == $id) { echo 'selected="selected"'; }} ?>><?php echo the_title(); ?></option>    
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>        
    </select>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'vertical' )); ?>"><?php esc_attr_e('Vertical:', 'dvgallery'); ?></label>
    <select name="<?php echo esc_attr($this->get_field_name( 'vertical' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'vertical' )); ?>">
        <option value="yes"><?php esc_attr_e('Yes', 'dvgallery'); ?></option>
        <option value="no"><?php esc_attr_e('No', 'dvgallery'); ?></option>
    </select>
</p>
<?php }} ?>
<?php
/* ----------------------------------------------------------
Grid gallery widget
------------------------------------------------------------- */

add_action( 'widgets_init', 'dv_dvgrid_widget' );

function dv_dvgrid_widget() {
	register_widget( 'dv_dvgridwidget' );
}

class dv_dvgridwidget extends WP_Widget {

    function __construct() {
		parent::__construct(
			'dv-dvgrid-widget', // Base ID
			esc_attr__('DV Grid', 'dvgallery'), // Name
			array( 'description' => esc_attr__('DV Grid Gallery Widget.', 'dvgallery'), ) // Args
		);
	}
	
	public function widget( $args, $instance ) {
		extract( $args );
        $max = $instance['max'];
        $categoryid = $instance['categoryid'];
        $itemwidth = $instance['itemwidth'];

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}  
        echo do_shortcode("[dvgrid max='" . esc_attr($max) . "' categoryid='" . esc_attr($categoryid) . "' itemwidth='" . esc_attr($itemwidth) . "']");
		
		echo $args['after_widget'];
	}
	 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['max'] = $new_instance['max'];
        $instance['categoryid'] = $new_instance['categoryid'];
        $instance['itemwidth'] = $new_instance['itemwidth'];

		return $instance;
	}
	
	public function form( $instance ) {
		$defaults = array( 'title' => '', 'max' => '5', 'itemwidth' => '300');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'max' )); ?>"><?php esc_attr_e('Maximum number of galleries:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'max' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max' )); ?>" value="<?php if (isset($instance['max'])) { echo esc_attr($instance['max']); } ?>" onkeypress="return validate(event)" type="number" style="width:100%;" />
</p>
<?php $gridterms = get_terms( 'dvgallerytaxonomy'); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'categoryid' )); ?>"><?php esc_attr_e('Select Category:', 'dvgallery'); ?></label>
    <select name="<?php echo esc_attr($this->get_field_name( 'categoryid' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'categoryid' )); ?>">
        <option value=""><?php esc_attr_e('All Categories', 'dvgallery'); ?></option>        
        <?php if ($gridterms && !is_wp_error($gridterms)) { ?>
        <?php foreach( $gridterms as $term ) { ?>
        <?php $termname = $term->name; ?>
        <?php $termid = $term->term_id; ?>
        <option value="<?php echo esc_attr($termid) ?>" <?php if (isset($instance['categoryid'])) { if ($instance['categoryid'] == $termid) { echo esc_attr('selected="selected"'); }} ?>><?php echo esc_attr($termname) ?></option>
        <?php } ?>
        <?php } ?>
    </select>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'itemwidth' )); ?>"><?php esc_attr_e('Min. Item Width (px):', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'itemwidth' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'itemwidth' )); ?>" value="<?php if (isset($instance['itemwidth'])) { echo esc_attr($instance['itemwidth']); } ?>" onkeypress="return validate(event)" type="number" style="width:100%;" />
</p>
<?php }} ?>
<?php
/* ----------------------------------------------------------
Grid gallery with filters widget
------------------------------------------------------------- */

add_action( 'widgets_init', 'dv_dvgridfilter_widget' );

function dv_dvgridfilter_widget() {
	register_widget( 'dv_dvgridfilterwidget' );
}

class dv_dvgridfilterwidget extends WP_Widget {

    function __construct() {
		parent::__construct(
			'dv-dvgridfilter-widget', // Base ID
			esc_attr__('DV Grid with Filters', 'dvgallery'), // Name
			array( 'description' => esc_attr__('DV Grid Gallery with Filters Widget.', 'dvgallery'), ) // Args
		);
	}
	
	public function widget( $args, $instance ) {
		extract( $args );
        $max = $instance['max'];
        $itemwidth = $instance['itemwidth'];

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}  
        echo do_shortcode("[dvgridfilter max='" . esc_attr($max) . "' itemwidth='" . esc_attr($itemwidth) . "']");
		
		echo $args['after_widget'];
	}
	 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['max'] = $new_instance['max'];
        $instance['itemwidth'] = $new_instance['itemwidth'];

		return $instance;
	}
	
	public function form( $instance ) {
		$defaults = array( 'title' => '', 'max' => '5', 'itemwidth' => '300');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'max' )); ?>"><?php esc_attr_e('Maximum number of galleries:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'max' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max' )); ?>" value="<?php if (isset($instance['max'])) { echo esc_attr($instance['max']); } ?>" onkeypress="return validate(event)" type="number" style="width:100%;" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'itemwidth' )); ?>"><?php esc_attr_e('Min. Item Width (px):', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'itemwidth' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'itemwidth' )); ?>" value="<?php if (isset($instance['itemwidth'])) { echo esc_attr($instance['itemwidth']); } ?>" onkeypress="return validate(event)" type="number" style="width:100%;" />
</p>
<?php }} ?>
<?php
/* ----------------------------------------------------------
Square grid gallery widget
------------------------------------------------------------- */

add_action( 'widgets_init', 'dv_dvsquare_widget' );

function dv_dvsquare_widget() {
	register_widget( 'dv_dvsquarewidget' );
}

class dv_dvsquarewidget extends WP_Widget {

    function __construct() {
		parent::__construct(
			'dv-dvsquare-widget', // Base ID
			esc_attr__('DV Square Grid', 'dvgallery'), // Name
			array( 'description' => esc_attr__('DV Square Grid Gallery Widget.', 'dvgallery'), ) // Args
		);
	}
	
	public function widget( $args, $instance ) {
		extract( $args );
        $max = $instance['max'];
        $categoryid = $instance['categoryid'];

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}  
        echo do_shortcode("[dvsquare max='" . esc_attr($max) . "' categoryid='" . esc_attr($categoryid) . "']");
		
		echo $args['after_widget'];
	}
	 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['max'] = $new_instance['max'];
        $instance['categoryid'] = $new_instance['categoryid'];

		return $instance;
	}
	
	public function form( $instance ) {
		$defaults = array( 'title' => '', 'max' => '99');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'max' )); ?>"><?php esc_attr_e('Maximum number of galleries:', 'dvgallery'); ?></label>
    <input id="<?php echo esc_attr($this->get_field_id( 'max' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max' )); ?>" value="<?php if (isset($instance['max'])) { echo esc_attr($instance['max']); } ?>" onkeypress="return validate(event)" type="number" style="width:100%;" />
</p>
<?php $squareterms = get_terms( 'dvgallerytaxonomy'); ?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id( 'categoryid' )); ?>"><?php esc_attr_e('Select Category:', 'dvgallery'); ?></label>
    <select name="<?php echo esc_attr($this->get_field_name( 'categoryid' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'categoryid' )); ?>">
        <option value=""><?php esc_attr_e('All Categories', 'dvgallery'); ?></option>        
        <?php if ($squareterms && !is_wp_error($squareterms)) { ?>
        <?php foreach( $squareterms as $term ) { ?>
        <?php $termname = $term->name; ?>
        <?php $termid = $term->term_id; ?>
        <option value="<?php echo esc_attr($termid) ?>" <?php if (isset($instance['categoryid'])) { if ($instance['categoryid'] == $termid) { echo esc_attr('selected="selected"'); }} ?>><?php echo esc_attr($termname) ?></option>
        <?php } ?>
        <?php } ?>
    </select>
</p>
<?php }} ?>