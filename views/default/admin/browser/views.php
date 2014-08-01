<?php

$guid = get_input('guid');

$entity = get_entity($guid);

echo elgg_view("admin/browser/header");

if ($entity) {
	$full_view = elgg_view_entity($entity, array('full_view' => true));

	$multiple_entities = array($entity, $entity, $entity);

	$short_view = elgg_view_entity_list($multiple_entities, array('full_view' => false));

	elgg_set_context('widgets');
	$widget_view = elgg_view_entity_list($multiple_entities, array('full_view' => false));
	elgg_pop_context();

	elgg_set_context('gallery');
	$gallery_view = elgg_view_entity_list($multiple_entities, array('full_view' => false, 'list_type' => 'gallery'));
	elgg_pop_context();

	// main, info, popup, aside
	echo elgg_view_module('main', 'full_view', $full_view, array('class' => 'mvl'));
	echo elgg_view_module('main', 'short_view', $short_view, array('class' => 'mvl'));
	echo elgg_view_module('main', 'widget_view', $widget_view, array('class' => 'mvl'));
	echo elgg_view_module('main', 'gallery_view', $gallery_view, array('class' => 'mvl'));
} else {
	echo elgg_echo('notfound');
}
