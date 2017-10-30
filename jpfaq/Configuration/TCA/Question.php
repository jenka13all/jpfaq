<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_jpfaq_domain_model_question'] = array(
	'ctrl' => $TCA['tx_jpfaq_domain_model_question']['ctrl'],
	'interface' => array(
		'showRecordFieldList'	=> 'question,answer,category',
	),
	'types' => array(
		'1' => array('showitem'	=> 'question,answer,category'),
	),
	'palettes' => array(
		'1' => array('showitem'	=> ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude'			=> 1,
			'label'				=> 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config'			=> array(
				'type'					=> 'select',
				'foreign_table'			=> 'sys_language',
				'foreign_table_where'	=> 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0)
				),
			)
		),
		'l18n_parent' => array(
			'displayCond'	=> 'FIELD:sys_language_uid:>:0',
			'exclude'		=> 1,
			'label'			=> 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config'		=> array(
				'type'			=> 'select',
				'items'			=> array(
					array('', 0),
				),
				'foreign_table' => 'tx_jpfaq_domain_model_question',
				'foreign_table_where' => 'AND tx_jpfaq_domain_model_question.uid=###REC_FIELD_l18n_parent### AND tx_jpfaq_domain_model_question.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'		=>array(
				'type'		=>'passthrough',
			)
		),
		't3ver_label' => array(
			'displayCond'	=> 'FIELD:t3ver_label:REQ:true',
			'label'			=> 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config'		=> array(
				'type'		=>'none',
				'cols'		=> 27,
			)
		),
		'hidden' => array(
			'exclude'	=> 1,
			'label'		=> 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'	=> array(
				'type'	=> 'check',
			)
		),
		'question' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xml:tx_jpfaq_domain_model_question.question',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'answer' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xml:tx_jpfaq_domain_model_question.answer',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => ''
			),
                'defaultExtras' => 'richtext[*]:rte_transform[mode=ts]'
		),
		'category' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xml:tx_jpfaq_domain_model_question.category',
			'config'	=> array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_jpfaq_domain_model_category',
				'MM' => 'tx_jpfaq_question_category_mm',
                            'foreign_sortby' => 'sorting',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,

				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'module' => array(
							'name' => 'wizard_edit',
						),
						'popup_onlyOpenIfSelected' => 1,
						'icon' => 'actions-open',
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1'
					),
					'add' => array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'actions-add',
						'params' => array(
							'table' => 'tx_jpfaq_domain_model_category',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
						'module' => array(
							'name' => 'wizard_add'
						)
					),
				),
			),
		),
	),
);
