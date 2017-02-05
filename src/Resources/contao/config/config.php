<?php

// Modules

// Modified news list
$GLOBALS['FE_MOD']['news']['newslist'] = 'Xuad\\BlogBundle\\Module\\ModuleNewsList';


// Hooks

// Extended news with new vars, automatic light box and https links
$GLOBALS['TL_HOOKS']['parseArticles'][] = ['xuad_blog.listener.parse_article_list', 'onParseArticles'];

// FRONT END MODULES
$GLOBALS['FE_MOD']['news']['ModuleNewsArchiveList'] = 'Xuad\BlogBundle\Module\ModuleNewsArchiveList';