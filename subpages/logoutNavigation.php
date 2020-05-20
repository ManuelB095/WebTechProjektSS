<li class="nav-item">
    <a class="nav-link disabled" href=""><?php echo $_SESSION["firstname"];?></a>
</li>
<li class="nav-item">
    <a class="nav-link disabled" href=""><?php echo $_SESSION["lastname"];?></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="./php/logoutUser.php">Logout</a>
</li>
<li class="nav-item <?php if ($_GET['subpage'] == "edit") {?>active<?php }?>">
    <a class="nav-link" href="edit"><i class="fas fa-wrench"></i><?php
        if (isset($_GET['subpage']) && $_GET['subpage'] === "edit") {
            ?><span class="sr-only"> (current)</span><?php
        }?>
    </a>
</li>
<?php 
if(!empty($_SESSION["is_admin"]) && $_SESSION["is_admin"] == "1") { ?> <!-- Only admins get a crown ! -->
    <li class="nav-item">
        <a class="nav-link disabled" href=""><i class="fas fa-crown"></i></a>
    </li>
<?php } ?>