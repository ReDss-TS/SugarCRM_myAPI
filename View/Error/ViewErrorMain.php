<?php

abstract class ViewErrorMain
{

    public function render()
    {
        $html = '';
        $html .= '<p><font size="40" color="red" face="Arial" align="center">' . $this->msg . '</font>';
        echo $html;
    }

}
