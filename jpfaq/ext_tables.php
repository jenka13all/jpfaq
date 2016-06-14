<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'JaccoVanDerPost.' . $_EXTKEY,
	'Jpfaq',
	'jpFAQ plugin'  // A title shown in the backend dropdown field
);

// flexform
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_jpfaq'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($_EXTKEY . '_jpfaq', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_jpfaq'] = 'layout,select_key,recursive,pages';




\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'jpFAQ');




\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_jpfaq_domain_model_question', 'EXT:jpfaq/Resources/Private/Language/locallang_csh_tx_jpfaq_domain_model_question.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_jpfaq_domain_model_question');
$TCA['tx_jpfaq_domain_model_question'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xml:tx_jpfaq_domain_model_question',
		'label' 			=> 'question',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
            'sortby' => 'sorting',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Question.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_jpfaq_domain_model_question.gif'
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_jpfaq_domain_model_category', 'EXT:jpfaq/Resources/Private/Language/locallang_csh_tx_jpfaq_domain_model_category.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_jpfaq_domain_model_category');
$TCA['tx_jpfaq_domain_model_category'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xml:tx_jpfaq_domain_model_category',
		'label' 			=> 'category',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
            'sortby' => 'sorting',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_jpfaq_domain_model_category.gif'
	)
);