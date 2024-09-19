<?php

import('lib.pkp.classes.form.Form');
import('plugins.reports.journalsReport.report.JournalMetadata');

class EstratoQualisClientConfiguration extends Form
{
    private $plugin;
    private $contextId;

    public function __construct($plugin, $contextId)
    {
        $this->plugin = $plugin;
        $this->contextId = $contextId;
        $this->addCheck(new FormValidatorPost($this));
        $this->addCheck(new FormValidatorCSRF($this));

        parent::__construct($plugin->getTemplateResource('estratoQualisConfiguration.tpl'));
    }

    public function fetch($request, $template = null, $display = false)
    {
        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign('pluginName', $this->plugin->getName());
        $templateMgr->assign('applicationName', Application::get()->getName());
        return parent::fetch($request);
    }

    public function readInputData()
    {
        $this->readUserVars(['estratoQualisUrl']);
        parent::readInputData();
    }

    public function execute(...$functionArgs)
    {
        $request = Application::get()->getRequest();
        $context = $request->getContext();
        $dispatcher = $request->getDispatcher();
        $contextUrl = $dispatcher->url(
            $request,
            ROUTE_PAGE,
            $context->getPath()
        );
        $this->plugin->updateSetting($this->contextId, 'estratoQualisUrl', $this->getData('estratoQualisUrl'), 'string');
        $journalMetadata = new JournalMetadata($context, $contextUrl);
        $journalMetadata->getCsv();
        parent::execute(...$functionArgs);
    }

    public function initData(): void
    {
        $estratoQualisUrl = $this->plugin->getSetting($this->contextId, 'estratoQualisUrl');
        $templateManager = TemplateManager::getManager();
        $templateManager->assign('pluginName', $this->plugin->getName());
        $templateManager->assign('applicationName', Application::get()->getName());
        $templateManager->assign('estratoQualisUrl', $estratoQualisUrl);
    }

    public function display($request = null, $template = null)
    {
        $templateManager = TemplateManager::getManager();
        $request = Application::get()->getRequest();
        $journal = $request->getJournal();
        $templateManager->display($this->plugin->getTemplateResource('estratoQualisConfiguration.tpl'));
    }

}
