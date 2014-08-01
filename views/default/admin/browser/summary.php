<?php

$guid = get_input('guid');

$entity = get_entity($guid);

if ($entity) {
	$metadata_count = elgg_get_metadata(array(
		'guid' => $guid,
		'count' => true,
	));

	$annotation_count = elgg_get_annotations(array(
		'guid' => $guid,
		'count' => true,
	));

	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT count(id) AS count FROM {$dbprefix}entity_relationships WHERE guid_one = $guid OR guid_two = $guid";
	$result = get_data($query);
	$relationship_count = $result[0]->count;

	$data = array(
		array('title', $entity->getDisplayName()),
		array('description', $entity->description),
		array('type', $entity->getType()),
		array('subtype', $entity->getSubtype()),
		array('metadata', $metadata_count),
		array('annotations', $annotation_count),
		array('relationships', $relationship_count),
	);
} else {
	$data = array();
}

echo elgg_view("admin/browser/header");

echo elgg_view('output/table', array(
	'rows' => $data,
	'table_class' => 'elgg-table-alt',
));