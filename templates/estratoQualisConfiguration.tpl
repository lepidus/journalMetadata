<script>
    $(function() {ldelim}
        $('#estratoQualisConfigurationForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
    {rdelim});
</script>
{extends file="layouts/backend.tpl"}

{block name="page"}
    <h1 class="app__pageHeading">
		{translate key="plugins.reports.journalsReport.displayName"}
	</h1>

    <div class="app__contentPanel">
        <div id="estratoQualisConfiguration">
            <form class="pkp_form" id="estratoQualisConfigurationForm" method="post">
                {csrf}
                {include file="controllers/notification/inPlaceNotification.tpl" notificationId="estratoQualisConfigurationFormNotification"}

                {fbvFormSection title="plugins.reports.journalsReport.qualisServiceUrlField"}
                    {fbvElement id="estratoQualisUrl" class="estratoQualisUrl" type="text" value="{$estratoQualisUrl|escape}" required="true" label="plugins.reports.journalsReport.qualisServiceUrlField.description" size=$fbvStyles.size.MEDIUM}
                {/fbvFormSection}
                {fbvFormButtons submitText="common.export"}
            </form>
        </div>
    </div>
{/block}
