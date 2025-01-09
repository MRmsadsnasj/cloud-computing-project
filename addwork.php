<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Notino</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
</head>

<body>
    <?php require_once("./navbar.php"); ?>
    <?php if (!(isset($_SESSION["login"]) && $_SESSION["login"] == "OK")){
        header('Location: '."login.php");
    } ?>
    <section id="add">
    
        <div class="container py-5">
            <div class="row mb-4 mb-lg-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="fw-bold text-success mb-2">Work</p>
                    <h2 class="fw-bold text-danger">Add New Work !</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body text-center d-flex flex-column align-items-center">
                            <div class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                                <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z"/>
                            </svg></div>
                            <form method="post" action="add-work-form.php">
                                <div class="mb-3">
                                    <input class="form-control" type="text" name="subject" placeholder="Work subject?" required>
                                </div>
                                <div class="mb-3">
                                    <textarea type="text" name="explain" placeholder="Your explain about work" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" name="necessary_level" required>
                                        <optgroup label="necessary level" >
                                            <option value="" disabled selected>Select necessary level</option>
                                            <option value="0">low</option>
                                            <option value="1">middle</option>
                                            <option value="2">high</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" name='dtime' type="datetime-local" required>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary shadow d-block w-100" type="submit">Add Work</button>
                                </div>
                                <p class="text-muted">Want To Check Your added works? <a href="show-works.php">Click</a></p>                            
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    </section>
    <?php require_once("footer.php"); ?>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
</body>

</html>