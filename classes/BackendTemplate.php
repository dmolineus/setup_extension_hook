<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   setup_extension_hook
 * @author    David Molineus <http://www.netzmacht.de>
 * @license   GNU/LGPL 
 * @copyright Copyright 2012 David Molineus netzmacht creative 
 * 
 */  


class BackendTemplate extends Contao\BackendTemplate
{
	/**
	 * store info if hook was already added.
	 * we only have to do it one time
	 */
	protected static $blnHookAdded = false;
	
	
	/**
	 * extend the parse metho to provide our new hooks
	 * 
	 * @return string result of parent::parse()
	 */
	public function parse()
	{
		
		$strExtension = \Input::get('install') != null ? \Input::get('install') : 
						(\Input::get('uninstall') != null ? \Input::get('uninstall') : 
						(\Input::get('update') != null ? \Input::get('update'): \Input::get('upgrade')));	
		
		if(static::$blnHookAdded || \Input::get('do') != 'repository_manager' || $strExtension == '')
		{
			return parent::parse();
		}
		
		// get extension name which probably is extended by the version number
		$strExtension = strpos($strExtension, '.') !== false ? substr($strExtension, 0, strpos($strExtension, '.')) : $strExtension;
		
		// remove all actions for updated extensions
		if(\Input::post('repository_installbutton') != null) 
		{			
			foreach((array) \Input::post('repository_enable') as $strExtension)
			{
				if(isset($GLOBALS['SETUP_EXT_HOOK'][$strExtension])) 
				{
					unset($GLOBALS['SETUP_EXT_HOOK'][$strExtension]);
				}
				
			}
		}
		elseif(\Input::get('uninstall') != null && \Input::post('repository_submitbutton') != null && isset($GLOBALS['SETUP_EXT_HOOK'][$strExtension])) 
		{
			unset($GLOBALS['SETUP_EXT_HOOK'][$strExtension]);
		}
		
		// assign hooks to TL_HOOKS. Template will do the rest. This hack works
		// because RepositoryManager deletes all hooks before calling the template parse method
		
		foreach($GLOBALS['SETUP_EXT_HOOK'] as $strExtension => $arrExtension)
		{
			$GLOBALS['TL_HOOKS']['parseTemplate'] = array_merge((array)$GLOBALS['TL_HOOKS']['parseTemplate'], $arrExtension);
					
		}
		
		static::$blnHookAdded = true;
		return parent::parse();
	}
	
}
