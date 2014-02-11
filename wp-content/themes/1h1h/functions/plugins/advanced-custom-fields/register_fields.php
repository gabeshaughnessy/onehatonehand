<?php
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_case-study-options',
		'title' => 'Case Study Options',
		'fields' => array (
			array (
				'key' => 'field_52f9a2ac22322',
				'label' => 'Case Study File',
				'name' => 'case_study_file',
				'type' => 'file',
				'instructions' => 'upload a web optimized PDF file.',
				'save_format' => 'object',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
?>