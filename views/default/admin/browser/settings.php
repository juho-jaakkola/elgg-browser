<?php

$guid = get_input('guid');

	$dbprefix = elgg_get_config('dbprefix');
if ($guid) {
	$query = "SELECT * FROM {$dbprefix}private_settings WHERE entity_guid = $guid";
} else {
	$query = "SELECT * FROM {$dbprefix}private_settings";
}

$settings = get_data($query);

$fields = array(
	'id',
	'entity_guid',
	'name',
	'value',
);

$rows = array();
foreach ($settings as $setting) {
	$cells = array();
	foreach ($fields as $field) {
		$cells[] = $setting->$field;
	}

	$rows[] = $cells;
}

echo elgg_view("admin/browser/header");

echo elgg_view('output/table', array(
	'headings' => $fields,
	'rows' => $rows,
));
