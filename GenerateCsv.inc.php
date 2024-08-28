<?php

class GenerateCsv
{
    public static function execute($journalReport)
    {
        header('content-type: text/comma-separated-values');
        header("content-disposition: attachment; filename=journalReport-" . date('Ymd') . '.csv');

        $columns = array(
            "ID", "Título", "Instituição", "Telefone", "Editor responsável", "E-mail", "ISSN Online",
            "ISSN", "Tipo de licença"
        );

        try {
            $fp = fopen('php://output', 'wt');
            fputcsv($fp, $columns);
            fputcsv($fp, [
                $journalReport->getId(),
                $journalReport->getTitle(),
                $journalReport->getAffiliation(),
                $journalReport->getSupportPhone(),
                $journalReport->getContactName(),
                $journalReport->getContactEmail(),
                $journalReport->getOnlineIssn(),
                $journalReport->getPrintIssn(),
                $journalReport->getLicenseUrl()
            ]);
        } catch(Exception $e) {
            error_log("Erro na tentativa de montar o CSV: " . $e->getMessage());
        } finally {
            fclose($fp);
        }
    }
}
