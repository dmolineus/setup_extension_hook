<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   setup_extension_hook 
 * @author    David Molineus 
 * @license   GNU/LGPL 
 * @copyright 2012 David Molineus netzmacht creative 
 */

// initialize hook array
// hook will be passed to the parseTemplate hook
// $GLOBALS['SETUP_EXT_HOOK']['extension-name'][] = array('Class', 'method')
if(!isset($GLOBALS['SETUP_EXT_HOOK']))
{
	$GLOBALS['SETUP_EXT_HOOK'] = array();
}
