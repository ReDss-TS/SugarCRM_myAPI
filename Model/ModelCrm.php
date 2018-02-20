<?php

class ModelCrm extends CoreModel
{    
    public function call($method, $parameters, $url)
    {
        ob_start();
        $curl_request = curl_init();

        curl_setopt($curl_request, CURLOPT_URL, $url);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl_request, CURLOPT_HEADER, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);

        $jsonEncodedData = json_encode($parameters);

        $post = array(
             "method" => $method,
             "input_type" => "JSON",
             "response_type" => "JSON",
             "rest_data" => $jsonEncodedData
        );

        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl_request);
        curl_close($curl_request);

        $result = explode("\r\n\r\n", $result, 2);
        $response = json_decode($result[1]);
        ob_end_flush();

        return $response;
    }

    private function getUserID()
    {    
        try {
            $session = new ModelSessions;
            return $session->getUserID();
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n"; //TODO
        }
    }

    public function getData($param, $url)
    {
        $selectModul = $this->getSelectModule($param);
        $userId = $this->getUserID();
        $selectFields = include('Config/selectFields.php');

        $get_entry_list_parameters = array(
            //session id
            'session' => $userId,
            //The name of the module from which to retrieve records
            'module_name' => $selectModul,
            //The SQL WHERE clause without the word "where".
            'query' => "",
            //The SQL ORDER BY clause without the phrase "order by".
            'order_by' => "",
            //The record offset from which to start.
            'offset' => '0',
            //Optional. A list of fields to include in the results.
            'select_fields' => $selectFields,
            /*
            A list of link names and the fields to be returned for each link name.
            */
            'link_name_to_fields_array' => array(
            ),
            //To exclude deleted records
            'deleted' => '0',
            //If only records marked as favorites should be returned.
            'Favorites' => false,
        );

        $get_entry_list_result = $this->call('get_entry_list', $get_entry_list_parameters, $url);

        return $get_entry_list_result ;
    }

    public function getSelectModule($param)
    {
        $selectModuls = include('Config/modulButtons.php');

        if (!isset($param['module'])) {
            $module = $selectModuls[0];
        } else {
            foreach ($selectModuls as $key => $value) {
                if ($param['module'] == $value) {
                    $module = $param['module'];
                    break;
                } else {
                    $module = $param['module'];
                }
            }
        }
        return $module;
    }
}
