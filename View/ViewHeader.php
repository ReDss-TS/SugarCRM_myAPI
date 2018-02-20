<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">TEST TASK</a>
        </div>
        <div class="navbar">
            <?php
                include "View/ViewMenu.php";
                echo getMenuItems($data['menuItems']);
            ?>
        </div>
    </div>
</nav>
