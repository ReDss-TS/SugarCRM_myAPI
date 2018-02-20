<?php

class ViewHelpersForms
{
    //array with input data and results of validation;
    protected $data = [];
    //array with keys to be contained in $data;
    protected $dataKeys = [
        'data',
        'validate',
    ];

    protected $fieldData;

    public function __construct($formData)
    {
        $this->data = $formData;
    }

    public function startForm($elements)
    {
        $form = "
            <div class='col-md-6 col-md-offset-3'>
                <div class='panel panel-primary'>
                    <div class='panel-heading'><h3>" . $elements['header'] . "</h3></div>
                    <br>
                    <div class ='row'>
                    <div class ='col-xs-12 col-sm-12 col-lg-8 col-centered'>
                        <form class='form-horizontal' role='form' enctype='multipart/form-data' method='POST' action=''>";
        return $form;
    }

    public function endForm()
    {
        $form = "
            </form>
            </div>
            </div>
            </div>
            </div>";
        return $form;
    }

    public function getFieldData($name)
    {
        foreach ($this->dataKeys as $value) {
            $parameters[$value] = (isset($this->data[$value][$name])) ? $this->data[$value][$name] : '';
            if ($value == 'news_img') {
                $parameters[$value] = (isset($this->data[$value])) ? $this->data[$value] : '';
            }
        }
        return $parameters;
    }

    public function renderInput($field, $parameters)
    {
        $name  = $field['name'];
        $label = $field['label'];
        $type  = $field['type'];

        if ($type == 'textarea') {
            $inputField = $this->getTextAreaField($name, $parameters);
        } elseif ($type == 'file') {
            $inputField = $this->getFileField($name, $parameters);
        } else {
            $inputField = $this->getInputField($name, $type, $parameters, $label);
        }

        $inputForm = "<div class ='form-group'>
                        <label for ='$name' class ='col-sm-2 form-label'>$label:</label>
                        $inputField
                        <br>
                        <p class ='help-block col-sm-8 pull-right'>" . $parameters['validate'] . "</p>
                    </div>";
        return $inputForm;
    }

    private function getInputField($name, $type, $parameters, $label)
    {
        return "<div class='col-sm-8 pull-right'>
                    <input type ='$type' class='form-control' placeholder ='$label' id ='$name' name ='$name' value=\"" . $parameters['data'] . "\">
                </div>";
    }

    private function getTextAreaField($name, $parameters)
    {
        $textArea = '';
        $textArea .= "<div class ='col-sm-8 pull-right'>";
        $textArea .= "<textarea class ='form-control form-textarea' id='$name' name='$name' placeholder='write a text'>";
        $textArea .= $parameters['data'];
        $textArea .= '</textarea>';
        $textArea .= '</div>';
        return $textArea;
    }

    private function getFileField($name, $parameters)
    {
        $fileField = '';
        $fileField .= "<div class ='col-sm-8 pull-right'>";
        $fileField .= "<input type='file' class ='form-control' id='$name' name='$name'>";
        $fileField .= "</div>";
        return $fileField;
    }

    public function submitBtn($elements)
    {
        $submitBtn = $elements['submitBtn'];
        $backLink  = $elements['backBtn'];
        $backBtn   = explode('/', $backLink);
        $someBtn   = '';
        if (isset($elements['Btn'])) {
            $someBtn = $this->getSomeBtn($elements['Btn']);
        }
        $btns = "<div class='form-group col-sm-12'>
                    <input class = 'btn btn-success btn-sm pull-right' type = 'submit' name = '" . $submitBtn . "Btn' value = '$submitBtn'/>
                    $someBtn
                    <a href = '/$backLink' class = 'btn btn-default  btn-sm'>$backBtn[1]</a>
                </div>";
        return $btns;
    }

    private function getSomeBtn($btnName)
    {
        return " <div class='col-sm-4 text-center pull-right'>
                    <input class = 'btn btn-info btn-sm btn-preview' type = 'button' onclick='insertData()' name = '" . $btnName . "Btn' value = '$btnName'/>
                </div>";
    }

}
