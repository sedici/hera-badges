<?php

/**
 * @file plugins/generic/badges/BadgesPlugin.inc.php
 * 
 * Copyright 2019 
 * Portal de Revistas de la Universidad Nacional de La Plata
 *  https://revistas.unlp.edu.ar 
 *  https://sedici.unlp.edu.ar
 *
 * @author gonetil
 *
 * @class badges
 * @ingroup plugins_generic_dates
 *
 * @brief badges plugin class
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class BadgesPlugin extends GenericPlugin {
	/**
	 * Called as a plugin is registered to the registry
	 * @param $category String Name of category plugin was registered to
	 * @return boolean True iff plugin initialized successfully; if false,
	 * 	the plugin will not be registered.
	 */
	function register($category, $path, $mainContextId = NULL) {
		$success = parent::register($category, $path);
		
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;
		
		$context = $this->getRequest()->getContext();

		if ($success && $this->getEnabled()) {

			$showHeraArticle = $this->getSetting($context->getId(), 'showHeraArticle');
			if ($showHeraArticle == "on"){
				HookRegistry::register('Templates::Article::Details', array($this, 'addHeraArticleLevelMetrics'));
				HookRegistry::register('Templates::Preprint::Details', array($this, 'addHeraArticleLevelMetrics'));
			}
			
			$showHeraJournal = $this->getSetting($context->getId(), 'showHeraJournal');
			if ($showHeraJournal == "on"){
				$this->import('HeraBlockPlugin');
				PluginRegistry::register('blocks', new HeraBlockPlugin($this), $this->getPluginPath());
			}
		}
		return $success;
	}

	/**
	 * Get the plugin display name.
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.generic.badges.displayName');
	}

	/**
	 * Get the plugin description.
	 * @return string
	 */
	function getDescription() {
		return __('plugins.generic.badges.description');
	}

	private function getPubId($smarty) {
		$application = Application::getName();
		switch($application){
			case 'ojs2':
				$submission = $smarty->getTemplateVars('article');
				break;
			case 'ops':
				$submission = $smarty->getTemplateVars('preprint');
				break;
		}

		return $submission->getStoredPubId('doi');
	}

	/**
	 * Add badges to article/preprint landing page
	 * @param $hookName string
	 * @param $params array
	 */
	function addHeraArticleLevelMetrics($hookName, $params) {
		$request = $this->getRequest();
		$context = $request->getContext();

		$smarty =& $params[1];
		$output =& $params[2];

		$doi = $this->getPubId($smarty);
		$doi = '10.24215/23143738e136 ';
		$smarty->assign('doi', $doi);

		$showHeraArticle = $this->getSetting($context->getId(), 'showHeraArticle');

		if ($showHeraArticle == "on")
			$smarty->assign("showHeraArticle","true");	

		$output .= $smarty->fetch($this->getTemplateResource('badges.tpl'));
		return false;		

	}
	
	/**
	 * @copydoc Plugin::getActions()
	 */
	function getActions($request, $verb) {
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		return array_merge(
			$this->getEnabled()?array(
				new LinkAction(
					'settings',
					new AjaxModal(
						$router->url($request, null, null, 'manage', null, array('verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic')),
						$this->getDisplayName()
					),
					__('manager.plugins.settings'),
					null
				),
			):array(),
			parent::getActions($request, $verb)
		);
    }
    

    /**
	 * @copydoc Plugin::manage()
	 */
	function manage($args, $request) {
		switch ($request->getUserVar('verb')) {
			case 'settings':
				$context = $request->getContext();

				AppLocale::requireComponents(LOCALE_COMPONENT_APP_COMMON,  LOCALE_COMPONENT_PKP_MANAGER);
				$templateMgr = TemplateManager::getManager($request);
				$templateMgr->register_function('plugin_url', array($this, 'smartyPluginUrl'));

				$this->import('BadgesSettingsForm');
				$form = new BadgesSettingsForm($this, $context->getId());

				if ($request->getUserVar('save')) {
					$form->readInputData();
					if ($form->validate()) {
						$form->execute();
						return new JSONMessage(true);
					}
				} else {
					$form->initData();
				}
				return new JSONMessage(true, $form->fetch($request));
		}
		return parent::manage($args, $request);
	}
}

?>
