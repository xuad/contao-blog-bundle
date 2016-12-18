<?php

/**
 * xuad.net blog system
 *
 * @package   xuad_blog
 * @author    Patrick Mosch
 * @license   LGPL
 * @copyright Patrick Mosch
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['ModuleNewsArchiveList'] = '{title_legend},name,headline,type;{config_legend},news_archives;{blogsite_legend},jumpTo;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] = '{title_legend},name,headline,type;{blogNewsListLegend},sortNewsList;{automatic_page_titel_legend},automaticPageTitle,addPageNumber,appendPageNumberMetaDescription,pageTitle;{config_legend},news_archives,numberOfItems,news_featured,perPage,skipFirst;{template_legend:hide},news_metaFields,news_template,imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['newsarchive'] = '{title_legend},name,headline,type;{automatic_page_titel_legend},automaticPageTitle,addPageNumber,appendPageNumberMetaDescription,pageTitle;{config_legend},news_archives,news_jumpToCurrent,news_readerModule,perPage,news_format;{template_legend:hide},news_metaFields,news_template,imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader'] = str_replace('news_archives;', 'news_archives;{jumpToTagsPage_legend},jumpToTagsPage;', $GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader']);

// Checkbox blog-category
$GLOBALS['TL_DCA']['tl_module']['fields']['sortNewsList'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['sortNewsList'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''"
];

// Checkbox activate automatic page titles
$GLOBALS['TL_DCA']['tl_module']['fields']['automaticPageTitle'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['automaticPageTitle'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
    'eval' => ['tl_class' => 'w50']
];

// Add page number to title
$GLOBALS['TL_DCA']['tl_module']['fields']['addPageNumber'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['addPageNumber'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
    'eval' => ['tl_class' => 'w50']
];

// Add pagenumber to metadescription
$GLOBALS['TL_DCA']['tl_module']['fields']['appendPageNumberMetaDescription'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['appendPageNumberMetaDescription'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
    'eval' => ['tl_class' => 'w50']
];

// Add title
$GLOBALS['TL_DCA']['tl_module']['fields']['pageTitle'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['pageTitle'],
    'inputType' => 'text',
    'sql' => "varchar(255) NOT NULL default ''",
    'eval' => ['tl_class' => 'w50']
];

// Add tag jump site
$GLOBALS['TL_DCA']['tl_module']['fields']['jumpToTagsPage'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['jumpToTagsPage'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => ['mandatory' => true, 'fieldType' => 'radio'],
    'sql' => "int(10) unsigned NOT NULL default '0'",
    'relation' => ['type' => 'hasOne', 'load' => 'eager']
];
