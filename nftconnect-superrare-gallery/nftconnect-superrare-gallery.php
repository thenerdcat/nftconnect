<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=DM+Sans">
<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.thenerdcat.com
 * @since             1.0.0
 * @package           Nftconnect_Superrare_Gallery
 *
 * @wordpress-plugin
 * Plugin Name:       NFTConnect
 * Plugin URI:        www.thenerdcat.com/nftconnect
 * Description:       Simple SuperRare NFT Gallery plugin for Wordpress.
 * Version:           1.0.0
 * Author:            Fernando Torres
 * Author URI:        www.thenerdcat.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nftconnect-superrare-gallery
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NFTCONNECT_SUPERRARE_GALLERY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nftconnect-superrare-gallery-activator.php
 */
function activate_nftconnect_superrare_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nftconnect-superrare-gallery-activator.php';
	Nftconnect_Superrare_Gallery_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nftconnect-superrare-gallery-deactivator.php
 */
function deactivate_nftconnect_superrare_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nftconnect-superrare-gallery-deactivator.php';
	Nftconnect_Superrare_Gallery_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nftconnect_superrare_gallery' );
register_deactivation_hook( __FILE__, 'deactivate_nftconnect_superrare_gallery' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nftconnect-superrare-gallery.php';
 function nftconnect_superrare_gallery($atts, $content = null) {
	 //$defaults = ['username'=>'bananakin'];
	 $a = shortcode_atts( array(
        'username' => '',
		 'url' => ''
    ), $atts );
	 if(!empty($a['url'])){
	 $urltokenid = substr($a['url'], strrpos($a['url'], '-' )+1)."\n";}
	  if(!empty($content)){
	 $urltokenid = substr($content, strrpos($content, '-' )+1)."\n";}
	// print_r($urltokenid);
	 $urluser = "https://superrare.co/api/v2/user?username=".$a['username']; 
	// print_r($urltokenid);
	 $urlcreations = "https://superrare.co/api/v2/nft/get-by-market-details";
		 
		 $argumentsurl = array(
			 'method' => 'GET',
			 );
	
	 
		 
		 $responseurl = wp_remote_get( $urluser, $argumentsurl);
		 
		 if (is_wp_error($responseurl)){
		 $error_message = $responseurl -> get_error_message();
		 return "Something went wrong: $error_message";
		 }
		 
		 
		 $resultsurl = json_decode(wp_remote_retrieve_body($responseurl));
	 foreach($resultsurl as $result){
	$username =  $result->username;
	 		 $ethAddress = "0x".$result->ethAddress;
}
	  //print_r($ethAddress);
	 $contaddress = '["0x41a322b28d0ff354040e2cbc676f0320d8c8850d","0xb932a70a57673d89f4acffbe830e8ed7f75fb9e0"]';
	 
	 $body = [
    'contractAddresses'  => ["0x41a322b28d0ff354040e2cbc676f0320d8c8850d","0xb932a70a57673d89f4acffbe830e8ed7f75fb9e0"],
    'creatorAddress' => $ethAddress,
		 'orderBy' => 'TOKEN_ID_DESC',
];
 
$body = wp_json_encode( $body );
 
$options = [
    'body'        => $body,
    'headers'     => [
        'Content-Type' => 'application/json',
    ],
    'timeout'     => 60,
    'redirection' => 5,
    'blocking'    => true,
    'httpversion' => '1.0',
    'sslverify'   => false,
    'data_format' => 'body',
];
	 

	  $responsecreations = wp_remote_post( $urlcreations,  $options);
		 
		 if (is_wp_error($responsecreations)){
		 $error_message = $responsecreations -> get_error_message();
		 return "Something went wrong: $error_message";
		 }
		 
		 
		 $resultscreations = json_decode(wp_remote_retrieve_body($responsecreations));
	 
	//var_dump($resultscreations);
			
				
	
	  $count = 0;
	 //print_r($urltokenid);
	 if(!empty($a['url']) || !empty($content)){
		 foreach($resultscreations as $resultc){
			
			 while($count < $resultc->totalCount ){
	 	if ($resultc->collectibles[$count]->tokenId == $urltokenid ){
	$Content .= "<div class='collectible-card col-sm-6 col-md-4'>";
			$urlcreation = 'https://superrare.co/artwork-v2/'.strtolower (preg_replace('/\s+/', '-', $resultc->collectibles[$count]->name)).'-'.$resultc->collectibles[$count]->tokenId;
			$decideimage= (empty($resultc->collectibles[$count]->nftImage->imageVideoMedium)) ? "<div><img src='". $resultc->collectibles[$count]->nftImage->imageMedium ."'  class='new-grid-img' alt='".$resultc->collectibles[$count]->name." - ".$resultc->collectibles[$count]->description."'></img></div>" : "<div class='artwork-thumbnail__img new-grid-img' defaultmuted='true' style='width: 640px; height: 360px;'><video src='". $resultc->collectibles[$count]->nftImage->imageVideoMedium ."'preload='auto' autoplay='' loop='' playsinline='' webkit-playsinline='' x5-playsinline='' style='width: 100%; height: 100%;'></video></div>";
    $Content .= "<section class='md-media md-media--1-1'><a href='".$urlcreation."'><div class='artwork-thumbnail__container'><div><div>".$decideimage."</div></div></div></a></section>";
	   $Content .= "<div class='collectible-card__info-container'><div class='collectible-card__first-section' style='width: 95%;'><a class='collectible-card__name' href='".$urlcreation."'>".$resultc->collectibles[$count]->name."</a></div>";  
			$listprice = ($resultc->collectibles[$count]->hasSalePrice == false) ? "<span>-</span>":"<span>1</span><span class='eth-symbol' style='font-size: 15px;'>Ξ</span> ($<span>5,498</span>)";
			//$Content .= "<div class='collectible-card__price-item-container'><div class='collectible-card__price-item'><a class='collectible-card__price-number' href='".$urlcreation."'><div style='overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>".$listprice."</div></a><p class='collectible-card__price-text '>List price</p></div><div class='collectible-card__price-item'><a class='collectible-card__price-number' href='".$urlcreation."'><span>1</span><span class='eth-symbol' style='font-size: 15px;'>Ξ</span> ($1,459)</a><p class='collectible-card__price-text'>Last sale price</p></div></div>";
			//			
					  $decideimageowner = (empty($resultc->collectibles[$count]->owner->avatar)) ? "https://icons-for-free.com/iconfiles/png/512/profile+user+icon-1320166082804563970.png": $resultc->collectibles[$count]->owner->avatar;
			 $decideuserowner = (empty($resultc->collectibles[$count]->owner->username)) ? "anonymous": $resultc->collectibles[$count]->owner->username;
					$Content .= "<div class='collectible-card__user-section' style='visibility: visible;'><hr class='collectible-card__user-section-divider'><div class='collectible-card__user-container'><div class='collectible-card__user-item'><div class='collectible-card__user-title'>ARTIST</div><div class='user'><div class='sc-AxgMl fVjqHL'><a class='sc-Axmtr hvJMgY' href='https://superrare.co/".$resultc->collectibles[$count]->creator->username."'><div class='md-inline-block md-avatar md-avatar--default user__avatar'><img src='".$resultc->collectibles[$count]->creator->avatar."' role='presentation' class='md-avatar-img'></div></a><a class='sc-AxmLO gmtmqV' href='https://superrare.co/".$resultc->collectibles[$count]->creator->username."'><span class='user__username'>".$resultc->collectibles[$count]->creator->username."</span></a></div></div></div><div class='collectible-card__user-item'><div class='collectible-card__user-title'>OWNER</div><div class='user'><div class='sc-AxgMl fVjqHL'><a class='sc-Axmtr hvJMgY' href='https://superrare.co/".$resultc->collectibles[$count]->owner->username."'><div class='md-inline-block md-avatar md-avatar--default user__avatar'><img src='".$decideimageowner."' role='presentation' class='md-avatar-img'></div></a><a class='sc-AxmLO gmtmqV' href='https://superrare.co/".$resultc->collectibles[$count]->owner->username."'><span class='user__username'>".$decideuserowner."</span></a></div></div></div></div></div>";
			$Content .= "</div></div>";
				
}$count = $count+1;}
			  $count = 0;
		 }
	 }else{
		 foreach($resultscreations as $resultc){
		 while($count < $resultc->totalCount ){
	 $Content .= "<div class='collectible-card col-sm-6 col-md-4'>";
			$urlcreation = 'https://superrare.co/artwork-v2/'.strtolower (preg_replace('/\s+/', '-', $resultc->collectibles[$count]->name)).'-'.$resultc->collectibles[$count]->tokenId;
			$decideimage= (empty($resultc->collectibles[$count]->nftImage->imageVideoMedium)) ? "<div><img src='". $resultc->collectibles[$count]->nftImage->imageMedium ."'  class='new-grid-img' alt='".$resultc->collectibles[$count]->name." - ".$resultc->collectibles[$count]->description."'></img></div>" : "<div class='artwork-thumbnail__img new-grid-img' defaultmuted='true' style='width: 640px; height: 360px;'><video src='". $resultc->collectibles[$count]->nftImage->imageVideoMedium ."'preload='auto' autoplay='' loop='' playsinline='' webkit-playsinline='' x5-playsinline='' style='width: 100%; height: 100%;'></video></div>";
    $Content .= "<section class='md-media md-media--1-1'><a href='".$urlcreation."'><div class='artwork-thumbnail__container'><div><div>".$decideimage."</div></div></div></a></section>";
	   $Content .= "<div class='collectible-card__info-container'><div class='collectible-card__first-section' style='width: 95%;'><a class='collectible-card__name' href='".$urlcreation."'>".$resultc->collectibles[$count]->name."</a></div>";  
			$listprice = ($resultc->collectibles[$count]->hasSalePrice == false) ? "<span>-</span>":"<span>1</span><span class='eth-symbol' style='font-size: 15px;'>Ξ</span> ($<span>5,498</span>)";
			//$Content .= "<div class='collectible-card__price-item-container'><div class='collectible-card__price-item'><a class='collectible-card__price-number' href='".$urlcreation."'><div style='overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>".$listprice."</div></a><p class='collectible-card__price-text '>List price</p></div><div class='collectible-card__price-item'><a class='collectible-card__price-number' href='".$urlcreation."'><span>1</span><span class='eth-symbol' style='font-size: 15px;'>Ξ</span> ($1,459)</a><p class='collectible-card__price-text'>Last sale price</p></div></div>";
			//
			
			 $decideimageowner = (empty($resultc->collectibles[$count]->owner->avatar)) ? "https://icons-for-free.com/iconfiles/png/512/profile+user+icon-1320166082804563970.png": $resultc->collectibles[$count]->owner->avatar;
			 $decideuserowner = (empty($resultc->collectibles[$count]->owner->username)) ? "anonymous": $resultc->collectibles[$count]->owner->username;
					$Content .= "<div class='collectible-card__user-section' style='visibility: visible;'><hr class='collectible-card__user-section-divider'><div class='collectible-card__user-container'><div class='collectible-card__user-item'><div class='collectible-card__user-title'>ARTIST</div><div class='user'><div class='sc-AxgMl fVjqHL'><a class='sc-Axmtr hvJMgY' href='https://superrare.com/".$resultc->collectibles[$count]->creator->username."'><div class='md-inline-block md-avatar md-avatar--default user__avatar'><img src='".$resultc->collectibles[$count]->creator->avatar."' role='presentation' class='md-avatar-img'></div></a><a class='sc-AxmLO gmtmqV' href='https://superrare.co/".$resultc->collectibles[$count]->creator->username."'><span class='user__username'>".$resultc->collectibles[$count]->creator->username."</span></a></div></div></div><div class='collectible-card__user-item'><div class='collectible-card__user-title'>OWNER</div><div class='user'><div class='sc-AxgMl fVjqHL'><a class='sc-Axmtr hvJMgY' href='https://superrare.co/".$resultc->collectibles[$count]->owner->username."'><div class='md-inline-block md-avatar md-avatar--default user__avatar'><img src='".$decideimageowner."' role='presentation' class='md-avatar-img'></div></a><a class='sc-AxmLO gmtmqV' href='https://superrare.co/".$resultc->collectibles[$count]->owner->username."'><span class='user__username'>".$decideuserowner."</span></a></div></div></div></div></div>";
			$Content .= "</div></div>";
				$count = $count+1;
		 
		 
	 }}}
	 
	$count = 0;
	
    return $Content;
}
add_shortcode('nftconnect', 'nftconnect_superrare_gallery');
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nftconnect_superrare_gallery() {

	$plugin = new Nftconnect_Superrare_Gallery();
	$plugin->run();

}
run_nftconnect_superrare_gallery();
