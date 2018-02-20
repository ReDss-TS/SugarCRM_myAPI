<?php

    function getMenuItems($items)
    {
        $menuItems = '';
        $menuItems .= '<ul class="nav navbar-nav">';
        foreach ($items as $key => $value) {
            $menuItems .= "<li><a href='/" . $value['controller'] . "/" . $value['action'] . "'><span>$key</span></a></li>";
        }
        $menuItems .= '</ul>';
        return $menuItems;
    }
