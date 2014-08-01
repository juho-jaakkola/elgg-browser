<?php

$guid = get_input('guid');

$options = array('limit' => false);

if ($guid) {
	$options['guid'] = $guid;
}

$metadata = elgg_get_metadata($options);

$fields = array (
    'id',
    'name',
    'value',
    'value_type',
    'time_created',
    'entity_guid',
    'owner_guid',
    'access_id',
    'enabled',
);

$headings = '';
foreach ($fields as $field) {
	$headings .= "<th>$field</th>";
}
$headings = "<tr>$headings</tr>";

$rows = '';
foreach ($metadata as $item) {
	$cells = '';
	foreach ($fields as $name) {
		$cells .= "<td>{$item->$name}</td>";
	}

	$rows .= "<tr>$cells</tr>";
}

echo elgg_view("admin/browser/header");

echo "<table class=\"elgg-table\">$headings $rows</table>";
