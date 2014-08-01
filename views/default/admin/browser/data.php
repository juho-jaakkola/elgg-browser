<?php

elgg_load_css('jquery.treeview');

$guid = get_input('guid');

$dir = elgg_get_config('dataroot');

if ($guid) {
	$entity = get_entity($guid);
	$locator = new Elgg_EntityDirLocator($guid);
	$dir .= $locator->getPath();
}

echo elgg_view("admin/browser/header");

echo elgg_echo('browser:files:title', array($dir));
echo '<ul class="browser-nav"><li>';
list_dir_contents($dir);
echo "</li></ul>";

?>

<script>
require(['jquery', 'jquery.treeview'], function($) {
	$(function() {
		var collapsed = true;

		var url = elgg.parse_url(window.location.href);
		if (url.query) {
			// TODO Verify that the parameters include a GUID
			//var guid = url.query.split("=")[1];
			collapsed = false;
		}

		$(".browser-nav").treeview({
			persist: "location",
			collapsed: collapsed,
		});
	});
});
</script>
