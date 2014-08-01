<?php

$options = array(
	'type' => 'object',
	'limit' => false,
);

$type = get_input('type');
if ($type) {
	$options['type'] = $type;
}

$subtype = get_input('subtype');
if ($subtype) {
	$options['subtype'] = $subtype;
}

$entities = elgg_get_entities($options);

$count = count($entities);

$headings = array(
	elgg_echo(''),
	elgg_echo('name'),
	elgg_echo('subtype'),
	elgg_echo('owner'),
);

$rows = array();
foreach ($entities as $entity) {
	$link = elgg_view('output/url', array(
		'href' => "admin/browser/summary?guid={$entity->guid}",
		'text' => $entity->getDisplayName(),
	));

	$icon = elgg_view_entity_icon($entity, 'small');

	$type_key = "item:{$entity->getType()}:{$entity->getSubtype()}";
	$type = elgg_echo($type_key);
	if ($type_key == $type) {
		$type = elgg_echo("item:{$entity->getType()}");
	}

	$subtype_link = elgg_view('output/url', array(
		'href' => "admin/browser/entities?subtype={$entity->getSubtype()}",
		'text' => $type,
	));

	$owner_link = elgg_view('output/url', array(
		'href' => "admin/browser/summary?guid={$entity->getOwnerGUID()}",
		'text' => $entity->getOwnerEntity()->name,
	));

	$rows[] = array(
		$icon,
		$link,
		$subtype_link,
		$owner_link,
	);
}

echo $count;

echo elgg_view('output/table', array(
	'headings' => $headings,
	'rows' => $rows,
));
