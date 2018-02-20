<?php

class ExceptionErrorPage extends Exception
{
    public function createErrorPage($codeError) {
        http_response_code($codeError);
        $viewRenderObject = new ViewRender('ViewErrorPage' . $codeError, '');
    }
}
