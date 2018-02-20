<?php

abstract class CoreView
{
    protected $structure;

    function __construct($data)
    {
        //structure of the input field
        $this->structure  = include('Config/structureInputFields.php');
        
        foreach ($this->helpers as $key => $property) {
            $class = 'ViewHelpers' . $property;
            $this->{$property} = new $class($data);
        }
    }

    public function getColumnNames()
    {
        if (isset($this->columnNames)) {
            return $this->columnNames;
        }
        return false;
    }
}
