<script>
    $(function() {ldelim}
        $('#journalsReportSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
    {rdelim});
</script>
{extends file="layouts/backend.tpl"}

{block name="page"}
    <h1 class="app__pageHeading">
		{translate key="plugins.reports.journalsReport.displayName"}
	</h1>

    <div class="app__contentPanel">
        <div id="journalsReportSettings">
            <form class="pkp_form" id="journalsReportSettingsForm" method="post">
                {csrf}
                {include file="controllers/notification/inPlaceNotification.tpl" notificationId="journalsReportSettingsFormNotification"}

                {fbvFormSection title="plugins.reports.journalsReport.qualisServiceUrlField"}
                    {fbvElement id="estratoQualisUrl" class="estratoQualisUrl" type="text" value="{$estratoQualisUrl|escape}" required="true" label="plugins.reports.journalsReport.qualisServiceUrlField.description" size=$fbvStyles.size.MEDIUM}
                {/fbvFormSection}
                {fbvFormButtons submitText="common.save"}
            </form>
        </div>
    </div>
{/block}
