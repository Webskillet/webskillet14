<?php

/**
 * @file
 * webskillet14 theme-settings.php
 */
function webskillet14_form_system_theme_settings_alter(&$form, $form_state) {

  $form['webskillet14_google_webfonts'] = array
  (
	'#type' => 'textfield',
	'#title' => t('Google webfonts'),
	'#description' => t('Will be appended to //fonts.googleapis.com/css?family='),
	'#default_value' => theme_get_setting('webskillet14_google_webfonts'),
  );

  $form['webskillet14_load_fontawesome'] = array
  (
	'#type' => 'radios',
	'#title' => t('Load fontawesome?'),
	'#default_value' => theme_get_setting('webskillet14_load_fontawesome'),
	'#options' => array(
		1 => 'Yes',
		0 => 'No',
	),
  );

  $form['webskillet14_twitter_handle'] = array
  (
    '#type' => 'textfield',
    '#title' => t('Twitter handle for sharing links'),
    '#description' => t('If you enter a Twitter handle here, it will be appended to "share this on Twitter" tweets'),
	'#default_value' => theme_get_setting('webskillet14_twitter_handle'),
  );

  $form['webskillet14_twitter_hashtag'] = array
  (
    '#type' => 'textfield',
    '#title' => t('Twitter hashtag for sharing links'),
    '#description' => t('If you enter a Twitter hashtag here, it will be appended to "share this on Twitter" tweets'),
	'#default_value' => theme_get_setting('webskillet14_twitter_hashtag'),
  );

  $form['webskillet14_custom_css'] = array
  (
    '#type' => 'textarea',
    '#title' => t('Custom CSS'),
    '#description' => t('CSS to be added inside &lt;style&gt; tags in &lt;head&gt; element, after all other styles'),
    '#default_value' => theme_get_setting('webskillet14_custom_css'),
    '#cols' => 60,
    '#rows' => 7,
  );

  $form['webskillet14_custom_js'] = array
  (
    '#type' => 'textarea',
    '#title' => t('Custom Javascript'),
    '#description' => t('Javascript to be added inside &lt;script&gt; tags in &lt;head&gt; element, after all other scripts'),
    '#default_value' => theme_get_setting('webskillet14_custom_js'),
    '#cols' => 60,
    '#rows' => 7,
  );

  return $form;
}
