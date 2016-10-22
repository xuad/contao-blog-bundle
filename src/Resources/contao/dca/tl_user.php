<?php

/**
 * xuad.net blog system
 * 
 * @package   xuad_blog 
 * @author    Patrick Mosch 
 * @license   LGPL 
 * @copyright Patrick Mosch 
 */
/**
 * Extend default palettes
 */
$GLOBALS['TL_DCA']['tl_user']['palettes']['login'] = str_replace('google;', 'google;{about_legend},about;{avatar_legend},addAvatar;', $GLOBALS['TL_DCA']['tl_user']['palettes']['login']);
$GLOBALS['TL_DCA']['tl_user']['palettes']['admin'] = str_replace('google;', 'google;{about_legend},about;{avatar_legend},addAvatar;', $GLOBALS['TL_DCA']['tl_user']['palettes']['admin']);
$GLOBALS['TL_DCA']['tl_user']['palettes']['default'] = str_replace('google;', 'google;{about_legend},about;{avatar_legend},addAvatar;', $GLOBALS['TL_DCA']['tl_user']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_user']['palettes']['group'] = str_replace('google;', 'google;{about_legend},about;{avatar_legend},addAvatar;', $GLOBALS['TL_DCA']['tl_user']['palettes']['group']);
$GLOBALS['TL_DCA']['tl_user']['palettes']['extend'] = str_replace('google;', 'google;{about_legend},about;{avatar_legend},addAvatar;', $GLOBALS['TL_DCA']['tl_user']['palettes']['extend']);
$GLOBALS['TL_DCA']['tl_user']['palettes']['custom'] = str_replace('google;', 'google;{about_legend},about;{avatar_legend},addAvatar;', $GLOBALS['TL_DCA']['tl_user']['palettes']['custom']);

$GLOBALS['TL_DCA']['tl_user']['palettes']['__selector__'][] = 'addAvatar';

/**
 * Add subpalettes
 */
$GLOBALS['TL_DCA']['tl_user']['subpalettes'] = array
	(
	'addAvatar' => 'avatarImage,avatarImageAlt,avatarImageSize',
);


/**
 * Add new fields
 */
$GLOBALS['TL_DCA']['tl_user']['fields']['about'] = array
	(
	'label' => &$GLOBALS['TL_LANG']['tl_user']['about'],
	'exclude' => true,
	'search' => true,
	'inputType' => 'textarea',
	'eval' => array('rte' => 'tinyMCE', 'tl_class' => 'clr'),
	'sql' => "text NULL"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['addAvatar'] = array
	(
	'label' => &$GLOBALS['TL_LANG']['tl_user']['addAvatar'],
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => array('submitOnChange' => true),
	'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['avatarImage'] = array
	(
	'label' => &$GLOBALS['TL_LANG']['tl_user']['avatarImage'],
	'exclude' => true,
	'inputType' => 'fileTree',
	'eval' => array('filesOnly' => true, 'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes'], 'fieldType' => 'radio', 'mandatory' => true),
	'sql' => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['avatarImageAlt'] = array
	(
	'label' => &$GLOBALS['TL_LANG']['tl_user']['avatarImageAlt'],
	'exclude' => true,
	'search' => true,
	'inputType' => 'text',
	'eval' => array('maxlength' => 255, 'tl_class' => 'w50'),
	'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['avatarImageSize'] = array
	(
	'label' => &$GLOBALS['TL_LANG']['tl_user']['avatarImageSize'],
	'exclude' => true,
	'inputType' => 'imageSize',
	'options' => $GLOBALS['TL_CROP'],
	'reference' => &$GLOBALS['TL_LANG']['MSC'],
	'eval' => array('rgxp' => 'digit', 'nospace' => true, 'helpwizard' => true, 'tl_class' => 'w50'),
	'sql' => "varchar(64) NOT NULL default ''"
);

/**
 * Class UserMod
 *
 * More functionality
 * @copyright  Patrick Mosch
 * @author     Patrick Mosch <http://xuad.net>
 * @package    xuad_blog
 */
class UserMod extends Backend
{

	/**
	 * Return the link picker wizard
	 * @param \DataContainer
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		return ' <a href="contao/page.php?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_' . $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
	}
}