<?php
/**
 * @package ElggGravatar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */

/**
 * Init.
 */
function gravatar_init() {
	// Now override icons. Note priority: This sits somewhere between the profile user icons and default icons -
	// so if you specify an icon for a user it will use that, else it will try a gravatar icon.
	elgg_register_plugin_hook('entity:icon:url', 'user', 'gravatar_usericon_hook', 900);
}

/**
 * This hooks into the getIcon API and returns a gravatar icon where possible
 */
function gravatar_usericon_hook($hook, $entity_type, $returnvalue, $params) {
	global $CONFIG;

	// Size lookup. TODO: Do this better to allow for changed themes.
	$size_lookup = array(
		'master' => '200',
		'large' => '200',
		'medium' => '100',
		'small' => '40',
		'tiny' => '25',
		'topbar' => '16',
	);

	if (!$returnvalue) {
		$size = 40;
		if (isset($size_lookup[$params['size']])) {
			$size = $size_lookup[$params['size']];
		}

		return "https://secure.gravatar.com/avatar/".md5($params['entity']->email) . ".jpg?s=$size";
	}
}

// Initialise plugin
elgg_register_event_handler('init', 'system', 'gravatar_init');
