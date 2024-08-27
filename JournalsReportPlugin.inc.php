<?php

import('lib.pkp.classes.plugins.ReportPlugin');

class JournalsReportPlugin extends ReportPlugin
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
        return 'JournalsReportPlugin';
    }

    public function getDisplayName(): string
    {
        return __('plugins.reports.journalsReport.displayName');
    }

    public function getDescription(): string
    {
        return __('plugins.reports.journalsReport.description');
    }

    public function display($args, $request): void
    {
        $dispatcher = $request->getDispatcher();
        $templateManager = TemplateManager::getManager();
        $templateManager->assign([
            'breadcrumbs' => [
                [
                    'id' => 'reports',
                    'name' => __('manager.statistics.reports'),
                    'url' => $request->getRouter()->url($request, null, 'stats', 'reports'),
                ],
                [
                    'id' => 'journalsReportPlugin',
                    'name' => __('plugins.reports.journalsReport.displayName')
                ],
            ],
            'pageTitle', __('plugins.reports.journalsReport.displayName')
        ]);
        $templateManager->display($this->getTemplateResource('index.tpl'));
    }
}
