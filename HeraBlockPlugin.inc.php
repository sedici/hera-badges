<?php

/**
 * @file plugins/block/badges/HeraBlockPlugin.inc.php
 * 
 * Copyright 2024 
 * Portal de Revistas de la Universidad Nacional de La Plata
 *  https://revistas.unlp.edu.ar 
 *  https://sedici.unlp.edu.ar
 *
 * @author quedaporhacer
 *
 * @class hera
 * @ingroup plugins_block_dates
 *
 * @brief hera plugin block
 */

import('lib.pkp.classes.plugins.BlockPlugin');

class HeraBlockPlugin extends BlockPlugin {
	protected $_parentPlugin;

	/**
	 * Constructor
	 * @param $parentPlugin AnnouncementFeedPlugin
	 */
	public function __construct($parentPlugin) {
		$this->_parentPlugin = $parentPlugin;
		parent::__construct();
	}

	/**
	 * Get the name of this plugin. The name must be unique within
	 * its category.
	 * @return String name of plugin
	 */
	public function getName() {
		return 'HeraBlockPlugin';
	}

	/**
	 * Hide this plugin from the management interface (it's subsidiary)
	 */
	public function getHideManagement() {
		return false;
	}

	/**
	 * Get the plugin display name.
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.generic.badges.displayNameBlock');
	}

	/**
	 * Get the plugin description.
	 * @return string
	 */
	function getDescription() {
		return __('plugins.generic.badges.descriptionBlock');
	}

	/**
	 * @see BlockPlugin::getContents
	 */
	public function getContents($templateMgr, $request = null) {
		$context = $request->getContext();
		$issn = $context->getData('onlineIssn');
		$templateMgr->assign([
			'issn' => $issn,
		  ]);

		return parent::getContents($templateMgr, $request);
	}

}
?>
