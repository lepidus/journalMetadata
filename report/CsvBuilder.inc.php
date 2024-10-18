<?php

class CsvBuilder
{
    public static function generate($journalMetadata)
    {
        header('content-type: text/comma-separated-values');
        header("content-disposition: attachment; filename=journalMetadata-" . date('Ymd') . '.csv');

        $columns = array(
            "Título da revista", "Editora", "Telefone do apoio técnico", "Telefone do contato principal",
            "Nome do contato principal", "E-mail do contato principal", "ISSN Online",
            "ISSN", "URL", "Tipo de licença", "Estrato Qualis", "Prefixo DOI"
        );

        try {
            $httpClient = Application::get()->getHttpClient();
            $fp = fopen('php://output', 'wt');
            fputcsv($fp, $columns);
            fputcsv($fp, [
                $journalMetadata->getTitle(),
                $journalMetadata->getAffiliation(),
                $journalMetadata->getSupportPhone(),
                $journalMetadata->getContactPhone(),
                $journalMetadata->getContactName(),
                $journalMetadata->getContactEmail(),
                $journalMetadata->getOnlineIssn(),
                $journalMetadata->getPrintIssn(),
                $journalMetadata->getUrl(),
                $journalMetadata->getLicenseUrl(),
                $journalMetadata->getEstratoQualis($httpClient),
                $journalMetadata->getDoiPrefix()
            ]);
        } catch (Exception $e) {
            error_log("Erro na tentativa de montar o CSV: " . $e->getMessage());
        } finally {
            fclose($fp);
        }
    }
}
