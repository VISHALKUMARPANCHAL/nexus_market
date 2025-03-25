<?php
class Admin_Block_Export_Csv extends Core_Block_Template
{
    public function __construct()
    {
        $this->_template = "admin/export/csv.phtml";
    }
    public function prepareCsv()
    {
        $export = $this->getRequest()->getQuery('export');
        $exportall = $this->getRequest()->getQuery('exportall');
        if (!empty($export)) {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=data.csv');
            $file = fopen("php://output", "w");
            $data = $this->getParent()->getCollection()->getData();
            $columns = array_keys($data[0]->getData());
            fputcsv($file, $columns);
            foreach ($data as $_data) {
                fputcsv($file, $_data->getData());
            }
            fclose($file);
            exit;
        }
        if (!empty($exportall)) {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=data.csv');
            $file = fopen("php://output", "w");
            $data = $this->getParent()->getHoleCollection()->getData();
            $columns = array_keys($data[0]->getData());
            // Mage::log($data);
            fputcsv($file, $columns);
            foreach ($data as $_data) {
                fputcsv($file, $_data->getData());
            }
            fclose($file);
            exit;
        }
    }
}