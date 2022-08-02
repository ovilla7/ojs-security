{**
 * plugins/reports/security/templates/reportForm.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Security plugin report
 *
 *}
{extends file="layouts/backend.tpl"}

{block name="page"}
	<h1 class="app__pageHeading">
		{translate key="plugins.reports.security.displayName"}, {translate key="plugins.reports.security.release"} {$release}
	</h1>

	<div class="app__contentPanel">
		<p>{translate key="plugins.reports.security.description"}</p>
		
		{if $headers['php'] eq 1}
			Tu servidor expone la versión de php: <strong>{$headers['phpVersion']}</strong>. En tu archivo php.ini cambia la opción 'expose_php' a 'off'
		{/if}
		{* <br/>
		{$data['cwd']}
		<br/>
		{$data['files']} *}
		
	</div>
{/block}
