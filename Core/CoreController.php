<?php

abstract class CoreController
{
    protected $fieldsStructure;
    protected $config;

    function __construct()
    {
        $this->fieldsStructure = include('Config/structureInputFields.php');
        $this->config = include('Config/config.php');

        foreach ($this->models as $key => $property) {
            $this->{$property} = new $property;
        }

        foreach ($this->components as $key => $property) {
            $class = 'ControllerComponent' . $property;
            $this->{$property} = new $class;
        }
    }

    /**
     * Check user authentication for authorization and access rights
     * @param array $action With action name
     * @param array $params With parameters
     */
    public function beforeCallAction($action, $params)
    {
        foreach ($this->actionsRequireLogin as $key => $value) {
            if ('action' . $value === $action) {
                if ($this->Auth->isAuth() !== true) {
                    header("Location: /crm/login");
                    exit();
                }
            }
        }
    }
}
