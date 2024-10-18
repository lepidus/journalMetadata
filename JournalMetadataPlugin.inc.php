<?php

import('lib.pkp.classes.plugins.ReportPlugin');
import('plugins.reports.journalMetadata.report.JournalMetadata');

class JournalMetadataPlugin extends ReportPlugin
{
    public function register($category, $path, $mainContextId = null): ?bool
    {
        $success = parent::register($category, $path, $mainContextId);
        if ($success) {
            $this->addLocaleData();
            return true;
        }
        return $success;
    }

    public function getName(): string
    {
        return 'JournalMetadataPlugin';
    }

    public function getDisplayName(): string
    {
        return __('plugins.reports.journalMetadata.displayName');
    }

    public function getDescription(): string
    {
        return __('plugins.reports.journalMetadata.description');
    }

    public function display($args, $request): void
    {
        $dispatcher = $request->getDispatcher();
        $templateManager = TemplateManager::getManager();
        $context = $request->getContext();
        $baseUrl = $request->getBaseUrl();

        $templateManager->assign([
            'breadcrumbs' => [
                [
                    'id' => 'reports',
                    'name' => __('manager.statistics.reports'),
                    'url' => $request->getRouter()->url($request, null, 'stats', 'reports'),
                ],
                [
                    'id' => 'journalMetadataPlugin',
                    'name' => __('plugins.reports.journalMetadata.displayName')
                ],
            ],
            'pageTitle', __('plugins.reports.journalMetadata.displayName')
        ]);
        $dispatcher = $request->getDispatcher();
        $contextUrl = $dispatcher->url(
            $request,
            ROUTE_PAGE,
            $context->getPath()
        );
        $journalMetadata = new JournalMetadata($context, $contextUrl);
        $journalMetadata->getCsv();
    }
}
