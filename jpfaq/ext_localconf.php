<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'JaccoVanDerPost.' . $_EXTKEY,
	'Jpfaq',
	array(
		'Question' => 'list'
	),
	array(

	)
//    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::TYPE_PLUGIN
);