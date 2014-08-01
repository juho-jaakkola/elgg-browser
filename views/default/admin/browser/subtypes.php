<?php

$dbprefix = elgg_get_config('dbprefix');
$subtypes = get_data("SELECT * FROM {$dbprefix}entity_subtypes");

$fields = array (
    'id',
    'type',
    'subtype',
    'class',
    'subtype_name',
    'count',
    'list',
    'delete',
);

$headings = '';
foreach ($fields as $field) {
	$headings .= "<th>$field</th>";
}
$headings = "<tr>$headings</tr>";

$rows = '';

$types = array('site', 'user', 'group');
foreach ($types as $type) {
	$cells = '';
	foreach ($fields as $field) {
		switch ($field) {
			case 'subtype_name':
				$value = elgg_echo("item:{$type}");
				break;
			case 'count':
				$value = elgg_get_entities(array(
					'type' => $type,
					'count' => true,
				));
				break;
			case 'list':
				$value = elgg_view('output/url', array(
					'text' => elgg_echo('list'),
					'href' => "admin/browser/entities?type={$type}",
				));
				break;
			case 'type':
				$value = $type;
				break;
			case 'class':
				$value = "Elgg" . ucfirst($type);
				break;
			default:
				$value = '-';
		}

		$cells .= "<td>$value</td>";
	}

	$rows .= "<tr>$cells</tr>";
}

foreach ($subtypes as $subtype) {
	$cells = '';
	foreach ($fields as $field) {
		switch ($field) {
			case 'subtype_name':
				$value = elgg_echo("item:object:{$subtype->subtype}");
				break;
			case 'count':
				$value = elgg_get_entities(array(
					'type' => 'object',
					'subtype' => $subtype->subtype,
					'count' => true,
				));
				break;
			case 'list':
				$value = elgg_view('output/url', array(
					'text' => elgg_echo('list'),
					'href' => "admin/browser/entities?subtype={$subtype->subtype}",
				));
				break;
			case 'delete':
				$value = elgg_view('output/confirmlink', array(
					'text' => elgg_view_icon('delete'),
					'href' => "action/subtype/delete?id={$subtype->id}",
					'is_action' => true,
				));
				break;
			default:
				$value = $subtype->$field;
		}

		$cells .= "<td>$value</td>";
	}

	$rows .= "<tr>$cells</tr>";
}

echo "<table class=\"elgg-table\">$headings $rows</table>";
