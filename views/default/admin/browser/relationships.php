<?php

$guid = get_input('guid');

if ($guid) {
	$relationships = get_entity_relationships($guid, false);
	$relationships2 = get_entity_relationships($guid, true);

	$relationships = array_merge($relationships2, $relationships);
} else {
	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT * FROM {$dbprefix}entity_relationships";
	$relationships = get_data($query, "row_to_elggrelationship");
}

$fields = array (
    'id',
    'guid_one',
    'relationship',
    'guid_two',
);

$headings = '';
foreach ($fields as $field) {
	$headings .= "<th>$field</th>";
}
$headings = "<tr>$headings</tr>";

$rows = '';
foreach ($relationships as $relationship) {
	$cells = '';
	foreach ($fields as $name) {
		$cells .= "<td>{$relationship->$name}</td>";
	}

	$rows .= "<tr>$cells</tr>";
}

echo elgg_view("admin/browser/header");

echo "<table class=\"elgg-table\">$headings $rows</table>";
