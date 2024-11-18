<!-- navbar.php -->
<?php
// Define an array of menu items
$menuItems = [
    'Home' => 'index.php',
    'Classes' => 'classes.php',
];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Students Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php
                foreach ($menuItems as $name => $link) {
                    echo "<li class=\"nav-item\">";
                    echo "<a class=\"nav-link\" href=\"$link\">$name</a>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
