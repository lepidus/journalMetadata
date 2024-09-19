<?php

import('lib.pkp.classes.plugins.ReportPlugin');
import('plugins.reports.journalsReport.EstratoQualisClientConfiguration');

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
                    'id' => 'journalsReportPlugin',
                    'name' => __('plugins.reports.journalsReport.displayName')
                ],
            ],
            'pageTitle', __('plugins.reports.journalsReport.displayName')
        ]);

        $requestHandler = new PKPRequest();
        $form = new EstratoQualisClientConfiguration($this, $context->getId());
        $form->initData();
        $requestHandler = new PKPRequest();
        if ($requestHandler->isPost($request)) {
            $form->readInputData();
            $form->execute($request);
        } else {
            $form->display();
        }
    }
}
