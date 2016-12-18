<?php

// Palettes
$GLOBALS['TL_DCA']['tl_news_archive']['palettes']['default'] = '{title_legend},title,alias,jumpTo;{protected_legend:hide},protected;{comments_legend:hide},allowComments';

// Float title left
$GLOBALS['TL_DCA']['tl_news_archive']['fields']['title']['eval'] = [
    'mandatory' => true,
    'maxlength' => 255,
    'tl_class' => 'w50'];

// Alias for link
$GLOBALS['TL_DCA']['tl_news_archive']['fields']['alias'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_news_archive_mod']['alias'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => [
        'rgxp' => 'alias',
        'unique' => true,
        'spaceToUnderscore' => true,
        'maxlength' => 128,
        'tl_class' => 'w50'],
    'save_callback' => [
        ['xuad_blog_extension.listener.news_archive', 'onSaveArchive']
    ],
    'sql' => "varbinary(128) NOT NULL default ''"
];
//$GLOBALS['TL_HOOKS']['parseArticles'][] = ['xuad_blog_extension.listener.parse_article_list', 'onParseArticles'];
//
//class tl_news_archive_mod extends Backend
//{
//
//    /**
//     * Initialize object
//     */
//    public function __construct()
//    {
//        parent::__construct();
//        $this->import('BackendUser', 'User');
//    }
//
//    /**
//     * Auto-generate the news alias if it has not been set yet
//     *
//     * @param mixed
//     * @param \DataContainer
//     *
//     * @return string
//     * @throws \Exception
//     */
//    public function generateAlias($varValue, DataContainer $dc)
//    {
//        $autoAlias = false;
//
//        // Generate alias if there is none
//        if(!strlen($varValue))
//        {
//            $autoAlias = true;
//            $varValue = standardize(String::restoreBasicEntities($dc->activeRecord->title));
//        }
//
//        $objAlias = $this->Database->prepare("SELECT id FROM tl_news_archive WHERE alias=?")
//                                   ->execute($varValue);
//
//        // Check whether the news_archive alias exists
//        if($objAlias->numRows > 1 && !$autoAlias)
//        {
//            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
//        }
//
//        // Add id to alias
//        if($objAlias->numRows && $autoAlias)
//        {
//            $varValue .= '-' . $dc->id;
//        }
//
//        return $varValue;
//    }
//}