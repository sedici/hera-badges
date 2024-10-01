{**
 * plugins/generic/badges/settingsForm.tpl
 *
 * Copyright 2019 
 * Portal de Revistas de la Universidad Nacional de La Plata
 *  https://revistas.unlp.edu.ar 
 *  https://sedici.unlp.edu.ar
 *
 * @author gonetil *
 * Badges plugin settings
 *
 *}
<div id="badgesSettings">
<div id="description">{translate key="plugins.generic.badges.manager.settings.description"}</div>

<h3>{translate key="plugins.generic.badges.settings"}</h3>

<script>
	$(function() {ldelim}
		// Attach the form handler.
		$('#badgesSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="badgesSettingsForm" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}">
	{csrf}
	{include file="controllers/notification/inPlaceNotification.tpl" notificationId="badgesSettingsFormNotification"}

	{fbvFormArea id="badgesSettingsFormArea"}

		{fbvFormSection list="true"}
			{fbvElement type="checkbox" id="showHeraArticle" label="plugins.generic.badges.manager.settings.showHera" checked=$showHeraArticle|compare:true}
		{/fbvFormSection}

		{fbvFormSection list="true"}
			{fbvElement type="checkbox" id="showHeraJournal" label="plugins.generic.badges.manager.settings.showHeraJournal" checked=$showHeraJournal|compare:true}
		{/fbvFormSection}

	{/fbvFormArea}

	{fbvFormButtons}
</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
</div>
