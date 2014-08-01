<?php

$guid = get_input('guid');

$files = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'file',
	'owner_guid' => $guid
));

echo elgg_view("admin/browser/header");

echo $files;
