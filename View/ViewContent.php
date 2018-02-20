<div class="row">
<div id ='preview'></div>
    <?php 
        $session = new ViewHelpersSessions();
        if (class_exists($view)) {
            $content = new $view($data);
            $session->showMessages();
            $content->render($data);
        }  
    ?>
</div>