<?php
// $Id: template.php,v 1.4.2.6 2011/02/18 05:26:30 andregriffin Exp $

/**
 * Implements hook_preprocess_html().
 * Adding extra meta tags to the head for iPhone, Google domain verification
 */
function webskillet14_preprocess_html(&$vars) {
  $meta_xuacompatible = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'http-equiv' => 'X-UA-Compatible',
      'content' => 'IE=edge,chrome=1'
    )
  );
  drupal_add_html_head($meta_xuacompatible, 'meta_xuacompatible');
  $meta_viewport = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'viewport',
      'content' => 'width=device-width, maximum-scale=1.0'
    )
  );
  drupal_add_html_head($meta_viewport, 'meta_viewport');

  $q = isset($_GET['q']) ? $_GET['q'] : 'front';
  $page_id = str_replace('/','-',$q);
  $page_id = strtolower($page_id);
  $page_id = preg_replace('/[^-_a-z0-9]/','',$page_id);
  $vars['page_id'] = 'page-'.$page_id;

  $googlefonts = theme_get_setting('webskillet14_google_webfonts');
  if ($googlefonts) {
    drupal_add_css('//fonts.googleapis.com/css?family='.$googlefonts,array(
		'type' => 'external',
		'group' => CSS_SYSTEM,
		'every_page' => TRUE,
		'weight' => -100,
	));
  }

  if (theme_get_setting('webskillet14_load_fontawesome')) {
    drupal_add_css('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',array(
		'type' => 'external',
		'group' => CSS_SYSTEM,
		'every_page' => TRUE,
		'weight' => -99,
	));
  }

/*
  $meta_google_site_verification = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'google-site-verification',
      'content' => 'RPsvU9KSNxdpmMt1ejPTeTAnH6DsklrG2Ic7HSpyIec'
    )
  );
  drupal_add_html_head($meta_google_site_verification, 'meta_google_site_verification');
*/
}

/**
 * Implements hook_html_head_alter().
 * We are overwriting the default meta character type tag with HTML5 version.
 */
function webskillet14_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * Implements hook_process_html()
 */
function webskillet14_process_html(&$variables) {
  // here are the witdh calculatings and some scrips addings 
  if (theme_get_setting('webskillet14_custom_css')) {
    $variables['styles'] .= '<script type="text/javascript"></script>'; /* Needed to avoid Flash of Unstyle Content in IE */
    $variables['styles'] .= '<style type="text/css">
      ' . theme_get_setting('webskillet14_custom_css') . '
    </style>';
  }
  if (theme_get_setting('webskillet14_custom_js')) {
    $variables['scripts'] .= '<script type="text/javascript">
      ' . theme_get_setting('webskillet14_custom_js') . '
    </script>';
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function webskillet14_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    // Uncomment to add current page to breadcrumb
	// $breadcrumb[] = drupal_get_title();
    $output .= '<nav class="breadcrumb">' . implode(' » ', $breadcrumb) . '</nav>';
    return $output;
  }
}

/**
 * Override or insert variables into the page template.
 */
function webskillet14_preprocess_page(&$vars) {

	/* first version from framework theme, more accessible - 2nd for dropdowns */
	/*
  if (isset($vars['main_menu'])) {
    $vars['main_menu'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('links', 'main-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['main_menu'] = FALSE;
  }
	*/

/*
	// for multi-lingual menus, replace the first two lines below with these 4 lines:
	$src = variable_get('menu_main_links_source', 'main-menu');
    $tree = function_exists('i18n_menu_translated_tree') ? i18n_menu_translated_tree($src) : menu_tree($src);
    $vars['main_menu'] = drupal_render($tree);
    $vars['main_menu'] = str_replace('class="menu"','class="main-menu"',$vars['main_menu']);

	// for multi-lingual om_maximenu menus, see here: https://drupal.org/node/1459416
*/
  if (isset($vars['main_menu'])) {
	$menu_tree = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
	$menutitle = "Navigation";
	if (theme_get_setting('webskillet14_load_fontawesome')) {
		$menutitle = '<i class="fa fa-bars"></i> <span>'.$menutitle.'</span>';
	}
    $vars['main_menu'] = drupal_render($menu_tree);
    $vars['main_menu'] = str_replace('class="menu"','class="main-menu"',$vars['main_menu']);
    $vars['main_menu'] = "<h2 class=\"navigation-header\">".$menutitle."</h2>".$vars['main_menu'];
  }
  else {
    $vars['main_menu'] = FALSE;
  }

  if (isset($vars['secondary_menu'])) {
    $vars['secondary_menu'] = theme('links__system_secondary_menu', array(
          'links' => $vars['secondary_menu'],
          'attributes' => array(
            'id' => 'utility-menu-links',
            'class' => array('links', 'inline', 'clearfix'),
          ),
          'heading' => array(
            'text' => t('Utility menu'),
            'level' => 'h2',
            'class' => array('element-invisible'),
          ),
        ));
  } else {
	$vars['secondary_menu'] = FALSE;
  }
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function webskillet14_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}

/**
 * Override or insert variables into the node template.
 */
function webskillet14_preprocess_node(&$variables) {
  $variables['submitted'] = t('Published by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['date']));
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
  $variables['twitterHashtag'] = theme_get_setting('webskillet14_twitter_hashtag');
  $variables['twitterHandle'] = theme_get_setting('webskillet14_twitter_handle');
}

/**
 * Changes the search form to use the "search" input element of HTML5 and the input.populate in wsutil
 * also add class="search" so IE7 can find it using css selectors
 */
function webskillet14_preprocess_search_block_form(&$vars) {
  $vars['search_form'] = str_replace('type="text"', 'type="search"', $vars['search_form']);
  $vars['search_form'] = str_replace('class="form-text"', 'class="populate form-text search"', $vars['search_form']);
  $vars['search_form'] = str_replace('type="submit"', 'type="image" src="'.base_path().path_to_theme().'/images/btn-search.png" width="20" height="20"', $vars['search_form']);
}

/**
 * The following functions are helper functions available to the theme,
 * but do not do anything on their own
 */

/**
 * Provides unique id for body element based on url
 */
function wsUtil_body_id() {
  $q = isset($_GET['q']) ? $_GET['q'] : 'front';
  $body_id = str_replace('/','-',$q);
  $body_id = strtolower($body_id);
  $body_id = preg_replace('/[^-_a-z0-9]/','',$body_id);
  return 'body-'.$body_id;
}

/**
 * Provides urls for Facebook sharing, tweeting and emails
 */
function wsUtil_share_url($url, $title='', $service='facebook', $options=array()) {
  $site_url = 'http://' .$_SERVER['HTTP_HOST'];
  if (strpos($url, $site_url) === false) { $url = $site_url.$url; }
  switch ($service) {

  case 'facebook':
    $fbShareUrl = 'http://www.facebook.com/sharer.php?u='.urlencode($url);
    if ($title) { $fbShareUrl .= '&amp;t='.urlencode(html_entity_decode($title, ENT_QUOTES)); }
    return $fbShareUrl;
	break;

  case 'twitter':
	$twitterHashtag = isset($options['twitterHashtag']) ? $options['twitterHashtag'] : '';
	$twitterHandle = isset($options['twitterHandle']) ? $options['twitterHandle'] : '';
    $tweetUrl = 'https://twitter.com/intent/tweet?';
    $tweetUrl .= 'url='.urlencode($url);
    $tweetUrl .= $title ? '&amp;text='.urlencode(html_entity_decode($title, ENT_QUOTES)) : '';
    $tweetUrl .= $twitterHashtag ? '&amp;hashtags='.urlencode(html_entity_decode($twitterHashtag, ENT_QUOTES)) : '';
    $tweetUrl .= $twitterHandle ? '&amp;via='.urlencode(html_entity_decode($twitterHandle, ENT_QUOTES)) : '';
    return $tweetUrl;
	break;

  case 'email':
	$emailSubject = isset($options['emailSubject']) ? $options['emailSubject'] : '';
	$emailBody = (isset($options['emailBody']) && $options['emailBody']) ? $options['emailBody']."\n\n" : '';
	$emailUrl = "mailto:?";
	$emailUrl .= $emailSubject ? 'subject='.str_replace('+','%20',urlencode(html_entity_decode($emailSubject, ENT_QUOTES))).'&amp;' : '';
	$emailUrl .= 'body='.str_replace('+','%20',urlencode(html_entity_decode($emailBody.$url, ENT_QUOTES)));
	return $emailUrl;
	break;

  default:
    return '';
	break;

  }
}

/**
 * Provides text or icons for facebook sharing, tweeting, and emailing
 */

function wsUtil_share_text($service = 'facebook') {
  switch ($service) {
	case 'facebook':
	  $icon = 'fa-facebook-square';
	  $text = 'Share on Facebook';
	  break;

	case 'twitter':
	  $icon = 'fa-twitter-square';
	  $text = 'Tweet on Twitter';
	  break;

	case 'email':
	  $icon = 'fa-envelope';
	  $text = 'Send by email';
	  break;

	default:
	  return '';
	  break;
  }
  if (theme_get_setting('webskillet14_load_fontawesome')) {
	$text = "<i class=\"fa $icon\"></i> <span class=\"element-invisible\">$text</span>";
  }
  return $text;
}

/**
 * Handles video
 */
function wsUtil_wrap_video($embedCode) {
	// first, add wmode=opaque to youtube, if it's not already there
	preg_match('/src=(\'|")([^\'"]+)(\'|")/',$embedCode,$src_matches);
	$src = isset($src_matches[2]) ? $src_matches[2] : '';
	if (strpos($src,'youtube.com') || strpos($src,'youtu.be')) {
		if (!strpos($src,'wmode=opaque')) {
			$newsrc = $src . (strpos($src,'?') ? '&' : '?') . 'wmode=opaque';
			$embedCode = str_replace($src, $newsrc, $embedCode);
		}
	}

	preg_match('/height=(\'|")([0-9]+)(\'|")/',$embedCode,$height_matches);
	preg_match('/width=(\'|")([0-9]+)(\'|")/',$embedCode,$width_matches);
	$height = isset($height_matches[2]) ? $height_matches[2] : 0;
	$width = isset($width_matches[2]) ? $width_matches[2] : 0;
	if ($height && $width) {
		$aspect_ratio = ($width > 0) ? $height / $width : 0;
		$embedCode = preg_replace('/height=(\'|")[0-9]+(\'|")/','height="100%"',$embedCode);
		$embedCode = preg_replace('/width=(\'|")[0-9]+(\'|")/','width="100%"',$embedCode);
		return sprintf('<div class="video-container" style="padding-bottom: %.2f%%">%s</div>', $aspect_ratio * 100, $embedCode);
	} else {
		return $embedCode;
	}
}

function wsUtil_get_video_thumb($embedCode, $largethumb = 0) {
	$largethumb = ($largethumb == 1) ? 1 : 0;
	preg_match('#//player.vimeo.com/video/([0-9]+)#',$embedCode,$vm_matches);
	$vimeoId = isset($vm_matches[1]) ? $vm_matches[1] : '';
	if ($vimeoId) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$vimeoId.xml");
		$response = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($response);
		return $largethumb ? (string) $xml->video>thumbnail_large : (string) $xml->video->thumbnail_medium;
	}
	preg_match('#//(www\.)?youtu(be\.com|\.be)/embed/([^?"\']+)#',$embedCode,$yt_matches);
	$youTubeId = isset($yt_matches[3]) ? $yt_matches[3] : '';
	if ($youTubeId) { return sprintf('http://img.youtube.com/vi/%s/%d.jpg',$youTubeId,1-$largethumb); }
	return base_path().path_to_theme().'/images/bg-video.png';
}

function wsUtil_get_video_link($embedCode) {
	preg_match('#//player.vimeo.com/video/([0-9]+)#',$embedCode,$vm_matches);
	$vimeoId = isset($vm_matches[1]) ? $vm_matches[1] : '';
	if ($vimeoId) { return 'http://vimeo.com/'.$vimeoId; }
	preg_match('#//(www\.)?youtu(be\.com|\.be)/embed/([^?"\']+)#',$embedCode,$yt_matches);
	$youTubeId = isset($yt_matches[3]) ? $yt_matches[3] : '';
	if ($youTubeId) { return 'http://youtube.com/watch?v='.$youTubeId; }
	return null;
}

