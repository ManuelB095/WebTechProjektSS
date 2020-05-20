<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
        <a class="navbar-brand" href=".">
            <img class="fh_logo" src="./img/logo-300x160_0.png" alt="Startseite">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item <?php if ($_GET['page'] == "home") {?>active<?php }?>">
                <a class="nav-link" href="?page=home">Home<?php
                    if (isset($_GET['page']) && $_GET['page'] === "home") {
                    ?><span class="sr-only"> (current)</span><?php
                    } ?>
                </a>
            </li>            
            <li class="nav-item <?php if ($_GET['page'] == "formular") {?>active<?php }?>">
                <a class="nav-link" href="?page=<?php $pagename = "formular"; echo $pagename; ?>">Formular<?php
                    if (isset($_GET['page']) && $_GET['page'] === "formular") {
                      ?><span class="sr-only"> (current)</span><?php
                    }?>
                </a>
            </li>
            <li class="nav-item <?php if ($_GET['page'] == "memory") {?>active<?php }?>">
                <a class="nav-link" href="?page=<?php $pagename = "memory"; echo $pagename; ?>">Memory<?php
                    if (isset($_GET['page']) && $_GET['page'] === "memory") {
                      ?><span class="sr-only"> (current)</span><?php
                    }?>
                </a>
            </li>
            <li class="nav-item <?php if ($_GET['page'] == "imgUpload") {?>active<?php }?>">
                <a class="nav-link" href="?page=<?php $pagename = "imgUpload"; echo $pagename; ?>">Upload<?php
                    if (isset($_GET['page']) && $_GET['page'] === "imgUpload") {
                      ?><span class="sr-only"> (current)</span><?php
                    }?>
                </a>
            </li>
                <?php if(empty($_SESSION["username"])) { 
                  include("./sitecontent/loginNavigation.php");
                }
                else if(!empty($_SESSION["username"]))
                {
                  include("./sitecontent/logoutNavigation.php");
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