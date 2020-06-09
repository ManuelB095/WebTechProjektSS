<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
        <a class="navbar-brand" href=".">
            <img class="fh_logo" src="./assets/FHLogo.png" alt="Startseite">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item <?php if ($_GET['subpage'] == "shop") {?>active<?php }?>">
                <a class="nav-link" href="shop">Galerie<?php
                    if (isset($_GET['subpage']) && $_GET['subpage'] === "shop") {
                    ?><span class="sr-only"> (current)</span><?php
                    } ?>
                </a>
            </li>            
            <li class="nav-item <?php if ($_GET['subpage'] == "help") {?>active<?php }?>">
                <a class="nav-link" href="help">Hilfe<?php
                    if (isset($_GET['subpage']) && $_GET['subpage'] === "help") {
                      ?><span class="sr-only"> (current)</span><?php
                    }?>
                </a>
            </li>
            <li class="nav-item <?php if ($_GET['subpage'] == "news") {?>active<?php }?>">
                <a class="nav-link" href="news">RSS Feed<?php
                    if (isset($_GET['subpage']) && $_GET['subpage'] === "news") {
                      ?><span class="sr-only"> (current)</span><?php
                    }?>
                </a>
            </li>
            <?php if(!empty($_SESSION["is_admin"])) { ?>
            <li class="nav-item <?php if ($_GET['subpage'] == "admin") {?>active<?php }?>">
                <a class="nav-link" href="admin">Administration<?php
                    if (isset($_GET['subpage']) && $_GET['subpage'] === "admin") {
                      ?><span class="sr-only"> (current)</span><?php
                    }?>
                </a>
            </li>
            <?php } ?>
                <?php if(empty($_SESSION["username"])) { 
                  include("../pageparts/loginNavigation.php");
                }
                else if(!empty($_SESSION["username"]))
                {
                  include("../pageparts/logoutNavigation.php");
                }
                ?>
            <!--
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Javascript
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" onclick="showTime('firstAnchor')" href="#">What Time is it right now?</a>
                <a class="dropdown-item" onclick="disableOrEnable('showTimeItem', 'secondAnchor')" href="#">Toggle Disable/Enable</a>
                <a class="dropdown-item" onclick="showOrHide('showTimeItem', 'thirdAnchor')" href="#">Toggle Show/Hide</a>
              </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="showTimeItem">What Time is it right now?</a>
            </li> -->
          </ul>
        </div>
      </nav>
