<?php

/**
 * @defgroup plugins_generic_hera hera Plugin
 */
 
/**
 * @file plugins/generic/hera/index.php
 *
 *
 * Copyright 2024
 * Portal de Revistas de la Universidad Nacional de La Plata
 *  https://revistas.unlp.edu.ar 
 *  https://sedici.unlp.edu.ar
 *
 * @author quedaporhacer
 *
 * @ingroup plugins_generic_hera
 * @brief Wrapper for hera plugin.
 *
 */

require_once('HeraPlugin.inc.php');

return new HeraPlugin();

?>
