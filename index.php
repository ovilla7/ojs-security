<?php

/**
 * @defgroup plugins_reports_security
 */

/**
 * @file plugins/reports/index.php
 *
 * Copyright (c) 2013-2021 Simon Fraser University
 * Copyright (c) 2000-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @brief Wrapper for security plugin
 *
 * @ingroup plugins_reports_security
 */

require_once('SecurityPlugin.inc.php');

return new SecurityPlugin();


