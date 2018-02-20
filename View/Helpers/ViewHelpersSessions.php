<?php

class ViewHelpersSessions
{
    public function showMessages()
    {
        $messages = '';
        if (!empty($_SESSION['message'])) {
            foreach ($_SESSION['message'] as $key => $value) {
                $messages .= "<label class ='msg'>$value</label><br/>";
            }
        }
        unset($_SESSION['message']);
        echo $messages;
    }
}
