<?php

/**
 * @file plugins/generic/badges/BadgesSettingsForm.inc.php
 *
 * Copyright 2019 
 * Portal de Revistas de la Universidad Nacional de La Plata
 *  https://revistas.unlp.edu.ar 
 *  https://sedici.unlp.edu.ar
 *
 * @author gonetil *
 * @class BadgesSettingsForm
 * @ingroup plugins_generic_badges
 *
 * @brief Form for journal managers to modify Almetric Badges plugin options
 */ 

import('lib.pkp.classes.form.Form');

class HeraSettingsForm extends Form {

	/** @var int */
	var $_journalId;

	/** @var object */
	var $_plugin;

	/**
	 * Constructor
	 * @param $plugin BadgesPlugin
	 * @param $journalId int
	 */
	function __construct($plugin, $journalId) {
		$this->_journalId = $journalId;
		$this->_plugin = $plugin;

		parent::__construct($plugin->getTemplateResource('heraSettingsForm.tpl'));

		$this->addCheck(new FormValidatorPost($this));
		$this->addCheck(new FormValidatorCSRF($this));
	}
	/**
	 * Initialize form data.
	 */
	function initData() {
		$this->_data = array(
			'showHeraJournal' => $this->_plugin->getSetting($this->_journalId, 'showHeraJournal'),
			'showHeraArticle' => $this->_plugin->getSetting($this->_journalId, 'showHeraArticle'),
		);
    }

    /**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(array('showHeraJournal'));
		$this->readUserVars(array('showHeraArticle'));
	
    }
    
    /**
	 * Fetch the form.
	 * @copydoc Form::fetch()
	 */
	function fetch($request,$template = NULL, $display = false) {
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('pluginName', $this->_plugin->getName());
		return parent::fetch($request);
    }
    
    /**
	 * Save settings.
	 */
		/**
	 * @copydoc Form::execute()
	 */


	function execute(...$functionArgs) {
		$plugin =& $this->_plugin;
		$contextId = $this->_journalId;

		$plugin->updateSetting($contextId, 'showHeraJournal', $this->getData('showHeraJournal'), 'string');
		$plugin->updateSetting($contextId, 'showHeraArticle', $this->getData('showHeraArticle'), 'string');

		parent::execute(...$functionArgs);

	}



}