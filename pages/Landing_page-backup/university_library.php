<?php include 'banner.php'; ?>

<!-- Library Tabs -->
<div class="library-tabs">
    <a href="?page=university_library&tab=library_updates" class="<?= (!isset($_GET['tab']) || $_GET['tab'] == 'library_updates') ? 'active' : '' ?>">Library Updates</a>
    <a href="?page=university_library&tab=resources" class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'resources') ? 'active' : '' ?>">Library Resources</a>
    <a href="?page=university_library&tab=hours" class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'hours') ? 'active' : '' ?>">Operating Hours</a>
    <a href="?page=university_library&tab=projects" class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'projects') ? 'active' : '' ?>">Research Projects</a>
</div>

<div class="container">
   
        <?php
        // Allowed tabs inside the University Library
        $allowedTabs = ['library_updates', 'resources', 'hours', 'projects'];
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'library_updates'; // Default tab
        $tabPath = "pages/Landing_page/library/$tab.php";

        if (in_array($tab, $allowedTabs) && file_exists($tabPath)) {
            include $tabPath;
        } else {
            include 'under_construction.php';
        }
        ?>
  
</div>
