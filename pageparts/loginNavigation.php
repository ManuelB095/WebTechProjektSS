<li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Login
              </a>
                <div class="dropdown-menu dropdown-menu-right" id="loginMenu" aria-labelledby="navbarDropdown">
                    <form id="loginForm" class="px-2" method="post" accept-charset="UTF-8">
                        <div class="form-group">
                            <span class="sr-only"><label for="login-username">Username</label></span>
                            <input class="form-control" type="text" id="login-username" name="username" placeholder="Username" required/>
                        </div>
                        <div class="form-group">
                            <span class="sr-only"><label for="login-password">Password</label></span>
                            <input class="form-control" type="password" id="login-password" name="userpwd" placeholder="Password" required/>
                        </div>
                        <button id="btnLogin" class="btn btn-warning" type="submit">Login</button>                        
                    </form>
                    <!-- BIG TO DO : SET UP Registry Link via GET -->
                    <a class="px-2 pt-2" href="register">Register<?php
                    if (isset($_GET['subpage']) && $_GET['subpage'] === "register") {
                      ?><span class="sr-only"> (current)</span><?php
                    }?>
                </a>
                </div>
             </li>
<!-- <script src="./js/loginUtilities.js"></script> -->
