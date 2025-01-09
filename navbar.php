<?php session_start(); ?>
<nav class="navbar navbar-expand-md sticky-top py-3 navbar-dark" id="mainNav">
    <div class="container"><a class="navbar-brand d-flex align-items-center" href="index.php#home"><img src="assets/img/logo.png" width="99" height="45"></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="index.php#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#service">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#aboutUs">Contact us</a></li>
                <li class="nav-item"><a class="nav-link active" href="addwork.php">+ Add Note</a></li>
            </ul>
            <!--Check Is Login Or Not! -->
            <?php if (isset($_SESSION["login"]) && $_SESSION["login"] == "OK"){ ?>
                <a class="btn btn-primary disabled shadow" role="button" href="" style="background: var(--bs-navbar-toggler-border-color);">Welcome <?php echo htmlspecialchars(isset($_SESSION["name"]) ? $_SESSION["name"] : '', ENT_QUOTES, 'UTF-8');  ?> </a><a class="btn btn-primary shadow" role="button" href="exit.php" style="background: rgb(100,52,52);">Exit</a>
            <?php } else { ?>
                <a class="btn btn-primary shadow" role="button" href="login.php" style="background: var(--bs-navbar-toggler-border-color);">Login</a><a class="btn btn-primary shadow" role="button" href="signup.php">Sign up</a>
            <?php } ?>

        </div>
    </div>
</nav>