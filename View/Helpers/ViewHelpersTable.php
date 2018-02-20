<?php

class ViewHelpersTable
{

    //array with data that will be at table;
    protected $data = [];

    //abstract protected function renderData($data);

    function __construct($tableData) {
        $this->data = $tableData;       
    }

    public function renderTableHeaders($data)
    {   
        $html = '';
        $html .= '<thead>';
        $html .= '<tr>';
        foreach ((array)$data->name_value_list as $key => $value) {
             $html .= "<th>$key</th>";
        }
        $html .= '</tr>';
        $html .= '</thead>';

        return $html;
    }

    public function renderTableData($data)
    {   
        $html = '';
        $html .= '<tbody>';
        foreach ($data as $key => $value) {
            $html .= '<tr>';
            foreach ((array)$value->name_value_list as $key => $value) {
                $html .= '<td>' . $value->value . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';

        return $html;
    }

}