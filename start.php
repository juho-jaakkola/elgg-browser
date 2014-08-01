<?php

elgg_register_event_handler('init', 'system', 'browser_init');

/**
 * Initialize the plugin
 */
function browser_init() {
	elgg_define_js('jquery.treeview', array(
		'src' => '/mod/browser/vendors/jquery-treeview/jquery.treeview.min.js',
		'exports' => 'jQuery.fn.treeview',
		'deps' => array('jquery'),
	));
	$css_url = 'mod/browser/vendors/jquery-treeview/jquery.treeview.css';
	elgg_register_css('jquery.treeview', $css_url);

	// Menu items for administration panel
	if (elgg_is_admin_logged_in()) {
		elgg_register_menu_item('page', array(
			'name' => 'browser',
			'text' => elgg_echo('browser'),
			'href' => 'admin/browser',
			'section' => 'administer',
			'context' => 'admin',
		));

		$pages = array(
			'subtypes',
			'entities',
			'annotations',
			'metadata',
			'relationships',
			'settings',
			'data',
		);

		foreach ($pages as $page) {
			elgg_register_menu_item('page', array(
				'name' => "browser_{$page}",
				'text' => elgg_echo("admin:browser:$page"),
				'href' => "admin/browser/$page",
				'section' => 'administer',
				'context' => 'admin',
				'parent_name' => 'browser',
			));
		}

	}
}

/**
 * List contents of a directory
 *
 * @param string $dir Absolute path to a directory
 *
 * TODO Make it return an array instead of printing a
 * list? Or use it to register items to a menu?
 */
function list_dir_contents($dir) {
	$content = scandir($dir);

	foreach ($content as $name) {
		if (in_array($name, array('.', '..'))) {
			continue;
		}

		echo "<li>$name";

		$subdir = "{$dir}{$name}/";
		if (is_dir($subdir)) {
			if (ctype_digit($name)) {
				// We're guessing that this is a GUID
				// TODO Confirm this e.g. from the directory path
				if (!get_entity($name)) {
					// Notify that the entity owning this directory doesn't exist anymore
					echo " <span style=\"color: red;\">ORPHAN</span>";
				}
			}

			echo "<ul>";
			list_dir_contents($subdir);
			echo "</ul>";
		}
		echo "</li>";
	}
}

/**
 *
 */
function browser_view_tabs() {
	$guid = get_input('guid');

	if (!$guid) {
		return false;
	}

	$request = Elgg_Http_Request::createFromGlobals();
	$segments = $request->getUrlSegments();

	$pages = array('summary', 'metadata', 'annotations', 'files', 'data', 'views', 'relationships', 'settings');

	$tabs = array();
	foreach ($pages as $page) {
		$selected = ($segments[2] == $page);

		if ($guid) {
			$url = "admin/browser/$page/?guid=$guid";
		} else {
			$url = "admin/browser/$page";
		}

		$tabs[] = array(
			'title' => elgg_echo("admin:browser:$page"),
			'url' => $url,
			'selected' => $selected,
		);
	}

	return elgg_view('navigation/tabs', array('tabs' => $tabs, 'class' => 'mbl'));
}
