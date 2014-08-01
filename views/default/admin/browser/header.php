<?php

$guid = get_input('guid');

$entity = get_entity($guid);

if ($entity) {
	$name = $entity->getDisplayName();
} else {
	$request = Elgg_Http_Request::createFromGlobals();
	$segments = $request->getUrlSegments();

	if (isset($segments[2])) {
		$page = ":{$segments[2]}";
	}

	$name = elgg_echo("admin:browser{$page}");
}

echo elgg_view_title($name, array('class' => 'mvl'));
echo browser_view_tabs();
