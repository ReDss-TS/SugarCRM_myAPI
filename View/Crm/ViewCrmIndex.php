<?php

class ViewCrmIndex extends CoreView
{
    protected $helpers = ['Sessions', 'Forms', 'Table'];

    public function render($data)
    {
        $html = '';
        $html .= '<div class = "page-head">
                    <div class="row justify-content-center">
                        <strong>Get:</strong>&nbsp;
                        ' . $this->getModulButtons($data) . '
                    </div>
                </div>
                <hr class="style2">
                <div class="row">
                <h2>' . $data['module'] . ':</h2>';

        $html .= $this->renderTable($data['data']);
        $html .= '</div>';       
        echo $html;
    }


    private function getModulButtons($data)
    {
        $selectModuls = include('Config/modulButtons.php');
        $uri = $data['uri'];
        $module = $data['module'];

        $renderedButtons = '';
        foreach ($selectModuls as $key => $value) {
            $renderedButtons .= "<a href='/$uri/module:$value/' class = 'btn btn-default btn-xs'>$value </a>&nbsp;|&nbsp";
        }
        return $renderedButtons;
    }

    private function renderTable($data)
    {
        $selectFields = include('Config/selectFields.php');
        $html = '';
        $html .= '<table class="table table-striped table-bordered">';
        $html .= $this->Table->renderTableHeaders($data->entry_list[0]);
        $html .= $this->Table->renderTableData($data->entry_list);
        $html .= '</table>';
        return $html;
    }
}
