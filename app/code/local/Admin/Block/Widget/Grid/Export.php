<?php
class Admin_Block_Widget_Grid_Export extends Admin_Block_Widget_Grid
{
    public function __construct()
    {
        $this->setTemplate("admin/widget/grid/export.phtml");
    }
    public function prepareExport()
    {
        $export = $this->getRequest()->getQuery('export');
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
    }
}