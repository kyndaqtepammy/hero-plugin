<?php

namespace DDHERO\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; 
class Hero extends Widget_Base {
   public function __construct( $data = [], $args = null ) {
      parent::__construct( $data, $args );
   
      wp_register_script( 'hero-js',  plugin_dir_url( __FILE__ ).'assets/js/hero.js', [ 'elementor-frontend' ], '1.0.0', true );
      wp_register_script( 'boot-js',  plugin_dir_url( __FILE__ ).'assets/js/bootstrap/js/bootstrap.js', [ 'elementor-frontend', 'jquery' ], '1.0.0', true );
      wp_register_style( 'boot-css', plugin_dir_url( __FILE__ ).'assets/css/bootstrap/css/bootstrap.min.css' );
      wp_register_style( 'hero-css', plugin_dir_url( __FILE__ ).'assets/css/hero.css' );
      wp_register_style( 'fa', plugin_dir_url( __FILE__ ).'assets/css/hero.css' );
   }
  

   public function get_script_depends() {
      return ['boot-js', 'hero-js' ];
    }

    public function get_style_depends() {
      return [ 'boot-css', 'hero-css', 'fa' ];
    }
   public function get_name() {
      return 'hero';
   }
   public function get_title() {
      return __( 'Hero Podcast' );
   }
   public function get_icon() {
      return 'fa fa-microphone';
   }
   public function get_categories(){
      return ['basic'];
   }

   protected function _register_controls() {
      $this->start_controls_section(
         'section_ph-content',
         [
           'label' => 'Settings',
         ]
       );
       $this->add_control(
         'hero',
         [
           'label' => 'Hero',
           'type' => \Elementor\Controls_Manager::HEADING,
           'default' => 'Hero'
         ]
       );

   
       $this->end_controls_section();
     }
     protected function render(){
      global $post; 
      $settings = $this->get_settings_for_display();
      $args = array(
        'post_type' => 'podcasts',
        'posts_per_page' => 1,
        'orderby' => 'date',
    );
    $podcasts = new \WP_Query($args);
    
?>
 
      <?php while( $podcasts->have_posts() ) : $podcasts->the_post();
      ?>
    <?php  ?>
    <div class="row hero-image" style="background-image: url('<?php the_post_thumbnail_url('full');?>')">
    <?php 
      $audio = get_post_meta($post->ID, 'aw_custom_image', true);
      $terms = wp_get_post_terms( $post->ID, 'collections' );
      foreach( $terms as $term){
         $term=  $term->name;
      }
     ?>
         <div class="dd-play-wrapper"><i class="fa fa-play-circle fa-7x" id="play-podcast-btn"></i><span class="collection-title"><?php echo $term  ?></span></div>
         <div class="dd-pause-wrapper"><i class="fa fa-pause-circle fa-7x" id="pause-podcast-btn"></i><span class="collection-title"><marquee direction="left" width="100%">Playing Audio...</marquee></span></div>
         <div class="controls">
            <span class="ddp-actions" id="dd-share"> <a href="#" style=" text-decoration: none !important;" title="Share Link" data-toggle="popover-share" data-placement="auto" data-trigger="focus">Share</a> </span>
            <span class="ddp-actions" id="dd-show"> <a href="#" style=" text-decoration: none !important;" title="Notes" data-toggle="popover" data-placement="auto" data-trigger="focus" data-content="<?php the_excerpt(); ?>">Show Notes</a>  </span>
            <span class="ddp-actions" id="dd-down"><a href="<?php echo $audio;   ?>" download> Download </a></span>
            <span class="ddp-playback-controls"><i class="fa fa-backward fa-2x" id="prev-podcast-btn"></i></span>
            <span class="ddp-playback-controls"><i class="fa fa-play fa-2x" id="play-podcast-btn"></i></span>
            <span class="ddp-playback-controls"><i class="fa fa-forward fa-2x" id="next-podcast-btn"></i></span>
            <span class="ddp-playback-controls"><strong><?php the_title(); ?></strong> </span>
         </div>
         <div class="share-btsn-dd hide" id="dd-popover-content">
            <span><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="blank" onclick="window.open(this.href, \'twitter-share\', \'width=80\', \'height=30\'); return false "><i class="fa fa-facebook-square fa-2x" id="share-fb"></i></a></span>
            <span><a href="https://www.twitter.com/share?text='<?php the_title(); ?>'url=<?php the_permalink(); ?>" target="blank" onclick="window.open(this.href, \'facebook-share\', \'width=80\', \'height=30\'); return false "><i class="fa fa-twitter-square fa-2x" id="share-tw"></i></span>
         </div>
      </div>
       <?php endwhile; ?>
        
        <?php   
            wp_localize_script('hero-js', 'ajax_obj', array(
               'ajaxurl' => admin_url('admin-ajax.php'),
               'nonce'   => wp_create_nonce('ajax-nonce'),
               'audio_url' => $audio
            )); 
     }


   }