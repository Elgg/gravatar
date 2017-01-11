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

	$hash = md5($params['entity']->email);

	$size = $params['size'];
        $sizes = function_exists("elgg_get_icon_sizes") ? elgg_get_icon_sizes('user') : elgg_get_config('icon_sizes');
	if (!empty($sizes[$size])) {
		$size = 'small';
	}

        // avatars must be square
	$pixels = !empty($sizes[$size]['w']) ? $sizes[$size]['w'] : 40;

        $default = "mm";

	// use local default icons
// 	if (elgg_view_exists("icons/user/default/{$size}.gif")) {
// 		$default = elgg_get_simplecache_url("icons/user/default/{$size}.gif");
// 	} else {
// 		$default = elgg_get_simplecache_url("icons/user/default{$size}.gif");
// 	}

	return "https://www.gravatar.com/avatar/$hash?" . http_build_query([
		's' => $pixels,
		'd' => $default,
	]);
}
