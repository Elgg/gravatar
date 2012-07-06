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

	// check if user already has an icon
	if (!$params['entity']->icontime) {
		$icon_sizes = elgg_get_config('icon_sizes');
		$size = $params['size'];
		if (!in_array($size, array_keys($icon_sizes))) {
			$size = 'small';
		}

		// avatars must be square
		$size = $icon_sizes[$size]['w'];

		$hash = md5($params['entity']->email);
		return "https://secure.gravatar.com/avatar/$hash.jpg?d=mm&s=$size";
	}
}
