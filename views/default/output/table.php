<?php

$class = elgg_extract('table_class', $vars, 'elgg-table');
$rows = elgg_extract('rows', $vars);
$headings = elgg_extract('headings', $vars);

$heading_row = '';
foreach ($headings as $name) {
	$heading_row .= "<th>$name</th>";
}
$heading_row = "<tr>$heading_row</tr>";

$data_rows = '';
foreach ($rows as $row) {
	$data_row = '';
	foreach ($row as $cell) {
		$data_row .= "<td>$cell</td>";
	}

	$data_rows .= "<tr>$data_row</tr>";
}

echo "<table class=\"$class\">{$heading_row}{$data_rows}</table>";
