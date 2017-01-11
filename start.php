<?php
/**
 * Gravatar plugin
 */

elgg_register_event_handler('init', 'system', 'gravatar_init');

function gravatar_init() {
	elgg_register_plugin_hook_handler('entity:icon:url', 'user', 'gravatar_avatar_hook', 900);
}

/**
 * This hooks into the getIcon API and returns a gravatar icon
 */
function gravatar_avatar_hook($hook, $type, $url, $params) {
	if ($params['entity']->icontime) {
		return;	
	}
	
	$api = 'https://www.gravatar.com/avatar';
// 	$api = 'https://seccdn.libravatar.org/avatar';

	$email = $params['entity']->email;
	$hash = md5(strtolower(trim($email)));

	$size = $params['size'];
	$sizes = function_exists("elgg_get_icon_sizes") ? elgg_get_icon_sizes('user') : elgg_get_config('icon_sizes');
	if (!empty($sizes[$size])) {
		$size = 'small';
	}

	// avatars must be square
	$pixels = !empty($sizes[$size]['w']) ? $sizes[$size]['w'] : 40;

	$icon_view = "icons/user/default/{$size}.gif";
	if (!elgg_view_exists($icon_view)) {
		// Elgg 2.x
		$icon_view = "icons/user/default{$size}.gif";
	}
	$default = elgg_get_simplecache_url($icon_view);

	// Comment this out if you wanna send your URLs to gravatar and have your
	// own default icon displayed in case they have none for users email address
	$default = "mm";

	return "$api/$hash?" . http_build_query([
		's' => $pixels,
		'd' => $default,
	]);
}
