<?php
global $newsletter; // Newsletter object
global $post; // Current post managed by WordPress

if (!defined('ABSPATH'))
    exit;

/*
 * Some variabled are prepared by Newsletter Plus and are available inside the theme,
 * for example the theme options used to build the email body as configured by blog
 * owner.
 *
 * $theme_options - is an associative array with theme options: every option starts
 * with "theme_" as required. See the theme-options.php file for details.
 * Inside that array there are the autmated email options as well, if needed.
 * A special value can be present in theme_options and is the "last_run" which indicates
 * when th automated email has been composed last time. Is should be used to find if
 * there are now posts or not.
 *
 * $is_test - if true it means we are composing an email for test purpose.
 */


// This array will be passed to WordPress to extract the posts
$filters = array();

// Maximum number of post to retrieve
$filters['posts_per_page'] = 5;
if ( isset($theme_options['theme_max_posts'] ) ) {
  $filters['posts_per_page'] = (int) $theme_options['theme_max_posts'];
}
if ($filters['posts_per_page'] == 0) {
    $filters['posts_per_page'] = 5;
}

if (!empty($theme_options['theme_tags'])) {
    $filters['tag'] = $theme_options['theme_tags'];
}


// Maximum number of events to retrieve
$filters['theme_max_agenda'] = 5;
if ( isset($theme_options['theme_max_agenda'] ) ) {
  $filters['theme_max_agenda'] = (int) $theme_options['theme_max_agenda'];
}
if ($filters['theme_max_agenda'] == 0) {
    $filters['theme_max_agenda'] = 5;
}


// Include only posts from specified categories. Do not filter per category is no
// one category has been selected.
if ( isset($theme_options['theme_categories'] ) ) {
  if (is_array($theme_options['theme_categories'])) {
      $filters['cat'] = implode(',', $theme_options['theme_categories']);
  }
}


// Retrieve the posts asking them to WordPress
$posts = get_posts($filters);

// Styles
$color = isset( $theme_options['theme_color'] ) ? $theme_options['theme_color'] : '#777';
if (empty($color))
    $color = '#777';

$font       = isset( $theme_options['theme_font'] ) ? $theme_options['theme_font'] : '';
$font_size  = isset( $theme_options['theme_font_size'] ) ? $theme_options['theme_font_size'] : '';




$theme_nieuwsbrieftitel  = isset( $theme_options['theme_nieuwsbrieftitel'] ) ? $theme_options['theme_nieuwsbrieftitel'] : 'Digitale Overheid - {date}';
$colofon_blok1  = isset( $theme_options['theme_colofon_block_1'] ) ? $theme_options['theme_colofon_block_1'] : 'Dit is een publicatie van de ministeries van Binnenlandse Zaken en Koninkrijksrelaties en van Economische Zaken.';
$colofon_blok2  = isset( $theme_options['theme_colofon_block_2'] ) ? $theme_options['theme_colofon_block_2'] : 'Heeft u tips of leuk nieuws voor de nieuwsbrief? Wij horen  graag van u! Stuur een email naar <a href="mailto:redactie@digitaleoverheid.nl">redactie@digitaleoverheid.nl</a>';
$colofon_blok3  = isset( $theme_options['theme_colofon_block_3'] ) ? $theme_options['theme_colofon_block_3'] : 'Digitale Overheid is ook te volgen op Twitter: <a href="https://twitter.com/digioverheid">@digioverheid</a>';
$theme_show_featuredimage  = isset( $theme_options['theme_show_featuredimage'] ) ? $theme_options['theme_show_featuredimage'] : '';


$theme_piwiktrackercode   = isset( $theme_options['theme_piwiktrackercode'] ) ? '?pk_campaign=' . $theme_options['theme_piwiktrackercode'] : '';


/**
 * Accepts a post or a post ID.
 * 
 * @param WP_Post $post
 */
function rhswp_newsletter_the_excerpt($post, $words = 80) {
    $post = get_post($post);
    $excerpt = $post->post_excerpt;
    if (empty($excerpt)) {
        $excerpt = $post->post_content;
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = wp_strip_all_tags($excerpt, true);
    }
    echo wp_trim_words($excerpt, $words);
}


?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css" media="screen">
table {
  font: 12px verdana, sans-serif;
  background-color: #fff;
}
.header a, .text .colofon a {
  text-decoration: underline;
  color: #000;
}
.header a:hover, .colofon a:hover, .text a:hover {
  color: #010101;
  text-decoration: underline;
}
.text p, .disclaimer p, p {
  margin-bottom: 1em !important;
}
.text a {
  color: #154273;
  text-decoration: none;
}
.text a:hover {
  text-decoration: underline;
}
.text a.up {
  display: block;
  font-size: 11px;
  color: #555;
}
.text a.head {
  color: #000;
}
.text a.head:hover {
  color: #154273;
}
</style>
</head>
<body style="background-color: #fff;">
<table style="width: 100%; border: none;background-color: #fff">
  <tr>
    <td align="center"><table style="width: 648px; background-color: #efefef; text-align: left; border-collapse: collapse">
        <tr>
          <td style="padding: 0px 20px 20px 20px"><table class="header" style="width: 608px; background-color: #efefef; border-collapse: collapse; padding: 0; border: 0; color: #474747; font-size: 10px">
              <tr>
                <td style="height: 30px; vertical-align: middle">Kunt u deze nieuwsbrief niet goed lezen? <a href="{email_url}">Bekijk dan de online versie</a>.</td>
                <td style="height: 30px; vertical-align: middle; text-align: right">{date}</td>
              </tr>
            </table>
            <div class="logo" style="background-color: #275937;"> <img src="https://digitaleoverheid.nl/mailingassets/assets-newsletter-do/header-newsletter-digitale-overheid.jpg" width="608" height="87" alt="Digitale Overheid" title="Digitale Overheid"> </div>
            <table class="text" style="background-color: #fff; border-collapse: collapse">
              <tr>
                <td style="padding: 30px 20px 0 20px">
                  <div style="font: normal 20px arial, sans-serif; margin: 0; color: #000"><?php echo $theme_nieuwsbrieftitel ?></div>
                  
              </tr>
              <tr>
                <td style="padding: 30px 20px 0px 20px"><table style="width: 568px; border-collapse:collapse">

                    <tr>
                      <td style="width: 372px; padding-right: 20px; vertical-align: top"><!-- Items -->
                        
                        <table style="width: 372px; border-collapse: collapse;  font: 12px/17px verdana, sans-serif; color: #000">
                          <?php
                                foreach ($posts as $post) {
                                    setup_postdata($post);
                                    
                                    $defaultwidth = '264px';
                                    
                                    if ( $theme_show_featuredimage ) {
                                      $defaultwidth = '264px';
                                      $image = nt_post_image(get_the_ID(), 'thumbnail');
                                    }
                                    else {
                                      $defaultwidth = '352px';
                                    }
                                    ?>
                          <tr>
                            <td style="width: <?php echo $defaultwidth ?>; padding: 12px 20px 12px 0; vertical-align: top; border-bottom: 1px solid #dcdcdc;"><div style="margin: 0; font: bold 16px arial, sans-serif;"><a href="<?php echo get_permalink() . $theme_piwiktrackercode; ?>" class="head"><?php the_title(); ?></a></div>
                              <div style="border-bottom: 5px solid #fff">
                              <?php rhswp_newsletter_the_excerpt($post); ?><br><a href="<?php echo get_permalink() . $theme_piwiktrackercode; ?>" style="font-size: 11px"><?php echo $theme_options['theme_read_more']; ?></a> </div></td>

                            <?php
                              if ( $theme_show_featuredimage ) { 
                              // idealiter is dit plaatje 88px breed
                                if ( $image ) {
                                  // er is een plaatje gevonden
                                  ?>
                                  <td style="text-align: right; vertical-align: top;  padding-top: 12px; border-bottom: 1px solid #dcdcdc;">
                                    <a target="_tab" href="<?php echo get_permalink() . $theme_piwiktrackercode; ?>" target="_blank"><img src="<?php echo $image; ?>" alt="" width="100" border="0" height="100"></a>
                                  </td>
                                    <?php 
                                }
                                else {
                                  // er zou een plaatje moeten zijn, maar dat is er niet
                                  ?>
                                  <td style="text-align: right; vertical-align: top;">&nbsp;</td>
                                    <?php 
                                }
                              }
                              ?>                              
                          </tr>
                          <?php
                                }
                                ?>

                        </table></td>
                      <td style="width: 176px; vertical-align: top; padding: 0; color: #555"><!-- Agenda -->

<div style="font: bold 14px arial, sans-serif; border-bottom: 1px solid #dcdcdc; padding-bottom: 2px; display:block; color: #000">Agenda</div>

                        
                        <?php
if (class_exists('EM_Events')) {

  $agendablok = EM_Events::output(
    array(
      'format'      =>  '<div style="font: bold 12px arial, sans-serif; color: #000; border-top: 12px solid #fff;">#_EVENTLINK</div>
      <div style="border-bottom: 1px solid #DCDCDC">#_EVENTDATES {has_location}(#_LOCATIONTOWN){/has_location}<br>&nbsp;
      </div>',
      'limit'       =>  $filters['theme_max_agenda'] ) );
  
  
  // tricky dick!
  $agendablok = str_replace( '/">', '/' . $theme_piwiktrackercode  .'">', $agendablok );
  
  echo $agendablok;

}
else {
  echo 'Er staat niets in de agenda.';
}


?>
                      </td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td style="padding: 30px 20px 20px 20px"><!-- Colofon -->
                  
                  <div style="display: block; border-bottom: 1px solid #dcdcdc; font: bold 14px arial, sans-serif; padding-bottom: 2px; color: #000">Colofon</div>
                  <table style="width: 568px; border-collapse: collapse; color: #555; line-height: 15px; font-size: 11px">
                    <tr>
                      <td style="vertical-align: top; width: 176px; padding: 0.5em 20px 30px 0"><?php echo $colofon_blok1 ?></td>
                      <td style="vertical-align: top; width: 176px; padding: 5px 20px 30px 0"><?php echo $colofon_blok2 ?></td>
                      <td style="vertical-align: top; width: 176px;  padding: 5px 0 30px 0"><?php echo $colofon_blok3 ?></td>
                    </tr>
                  </table>
                  <p class="colofon" style="color: #555; line-height: 15px; font-size: 11px; margin-bottom: 0 !important;">Wilt u deze nieuwsbrief niet meer ontvangen? <a href="{unsubscription_url}">Meld u dan hier af.</a></p></td>
              </tr>
            </table>
            
            <!-- Footer ribbon -->
            
            <table style="border-collapse: collapse; width: 100%">
              <tr>
                <td colspan="3" style="background-color: #275937; height: 25px">&nbsp;</td>
              <tr>
                <td style="background-color: #275937; width: 282px;"></td>
                <td style="background-color: #123552; width: 44px; height: 15px"></td>
                <td style="background-color: #275937; width: 282px"></td>
              </tr>
            </table>
            
            <!-- Disclaimer -->
            
            <table class="disclaimer" style="border-collapse:collapse; background-color: #efefef; color: #555; font-size: 10px; line-height: 13px">
              <tr>
                <td style="padding: 30px 20px;"><p style="margin-top: 0"> Dit bericht kan informatie bevatten die niet voor u is bestemd. Indien u niet de geadresse erde bent of dit bericht abusievelijk aan u is toegezonden, wordt u verzocht dat aan de afzender te melden en het bericht te verwijderen. 
                    De Staat aanvaardt geen aansprakelijkheid voor schade, van welke aard ook, die verband houdt met risico's verbonden aan het elektronisch verzenden van berichten. </p>
                  <p> This message may contain information that is not intended for you. If you are not the addressee or if this message was sent to you by mistake, you are requested to inform the sender and delete the message.
                    The State accepts no liability for damage of any kind resulting from the risks inherent in the electronic transmission of messages. </p></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
