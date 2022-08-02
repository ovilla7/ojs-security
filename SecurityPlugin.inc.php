<?php

/**
 * @file plugins/reports/security/SecurityPlugin.inc.php
 *
 * Copyright (c) 2013-2021 Simon Fraser University
 * Copyright (c) 2000-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class SecurityPlugin
 * @ingroup plugins_reports_security
 *
 * @brief Application's plugin class.
 */

import('lib.pkp.classes.plugins.ReportPlugin');

class SecurityPlugin extends ReportPlugin {

	/**
	 * @copydoc Plugin::register()
	 */
	function register($category, $path, $mainContextId = null) {
		$success = parent::register($category, $path, $mainContextId);
		if($success) {
			$this->addLocaleData();
		}
		return $success;
	}

  /**
	 * @copydoc Plugin::getName()
	 */
	function getName() {
		return 'SecurityPlugin';
	}

  /**
	 * Install default settings on journal creation.
	 * @return string
	 */
	function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Get the display name of this plugin.
	 * @return String
	 */
	function getDisplayName() {
		return __('plugins.reports.security.displayName');
	}

	/**
	 * Get a description of the plugin.
	 */
	function getDescription() {
		return __('plugins.reports.security.description');
	}

	/**
	 * Get the latest counter release
	 * @return string
	 */
	function getCurrentRelease() {
		return '1.0';
	}

	/**
	 * @see ReportPlugin::display()
	 */
	function display($args, $request) {
		$responseHttpHeaders = $this->getHttpHeaders();
		$headers['php'] = false;
		$headers['phpVersion'] = 0;
		if (isset($responseHttpHeaders['X-Powered-By'])) {
			$headers['php'] = true;
			$headers['phpVersion'] = array_pop(explode("/", $responseHttpHeaders['X-Powered-By']));
		}

		$data['cwd'] = getcwd();
		$data['files'] = Config::getVar('files', 'files_dir');

		$templateManager = TemplateManager::getManager();
		$templateManager->assign('pluginName', $this->getName());
		$templateManager->assign('data', $data);
		$templateManager->assign('headers', $headers);
		$templateManager->assign('release', $this->getCurrentRelease());
		// legacy reports are site-wide, so only site admins have access
		//$templateManager->assign('showLegacy', Validation::isSiteAdmin());
		$templateManager->assign([
			'breadcrumbs' => [
				[
					'id' => 'reports',
					'name' => __('manager.statistics.reports'),
					'url' => $request->getRouter()->url($request, null, 'stats', 'reports'),
				],
				[
					'id' => 'security',
					'name' => __('plugins.reports.security.displayName')
				],
			],
			'pageTitle', __('plugins.reports.security.displayName')
		]);
		$templateManager->display($this->getTemplateResource('index.tpl'));
	}

	function getHttpHeaders() {
		if (!function_exists('apache_response_headers')) {
				$arh = array();
				$headers = headers_list();
				foreach ($headers as $header) {
					$header = explode(":", $header);
					$arh[array_shift($header)] = trim(implode(":", $header));
				}
		}
		else {
			$arh = apache_response_headers();
		}
		return $arh;
	}

}

