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
    <?php
    if (!(isset($_SESSION["login"]) && $_SESSION["login"] == "OK")) {
        header('Location: ' . "login.php");
    }
    ?>
    <section class="py-5">
        <div class="container">
            <div>
                <div class="col offset-lg-0">
                    <h6 class="fs-6 fw-bold">export as         <div class="btn-group" role="group">
                    
                    <a href=<?php echo "export.php?user_id=".$_SESSION['id']."&export_as=e";?> ><button class="btn btn-primary" type="button">EXCEL</button></a>
                    
                    <a href=<?php echo "export.php?user_id=".$_SESSION['id']."&export_as=p";?> ><button class="btn btn-primary" type="button">PDF</button></a>
                    
                    <a href=<?php echo "export.php?user_id=".$_SESSION['id']."&export_as=w";?> ><button class="btn btn-primary" type="button">WORD</button></div></a>
                    </h6>
                </div>
            </div>
            </br>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                      <?php 
                          $id = $_SESSION['id'];
                          require_once("./DBs/functions.php");

                          $inf = get_works_info($id);
                          if (count($inf) == 0){?>
                          <div class="col-md-8 col-xl-6 text-center mx-auto">
                            <p class="fw-bold text-warning mb-2">You Don't Have any Notes</p>
                          </div><?php
                          }else{ ?>
                        <table class="table table-striped table-dark">

                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Necessary</th>
                                    <th scope="col">Expiry Time</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select = $_GET['work'] ?? '';

                                if (!empty($inf)) {
                                    for ($counter = 0; $counter < count($inf); $counter++) {
                                        $subject = $inf[$counter][1];
                                        $explain = $inf[$counter][2];
                                        $work_id = $inf[$counter][0];
                                        $nessesary = $inf[$counter][3];

                                        // Check if the current $work_id matches the selected $select
                                        $isSelected = ($select == $work_id);
                                        // echo $isSelected;
                                        // Output the row with a different background color if selected
                                        echo '<tr ' . ($isSelected ? 'class="table-info"' : '') . ' id="' . $work_id . '">';
                                        echo '<th scope="row">' . ($counter + 1) . '</th>';
                                        echo '<td>' . $subject . '</td>';
                                        echo '<td>' . $explain . '</td>';

                                        if ($nessesary == 0) { //low
                                            echo '<td class="text-success">Low</td>';
                                        } elseif ($nessesary == 1) { //medium
                                            echo '<td class="text-warning">Medium</td>';
                                        } else { //high
                                            echo '<td class="text-danger">High</td>';
                                        }

                                        $date = $inf[$counter][5]; //expiry
                                        $targetTimestamp = strtotime($date);
                                        $currentTimestamp = time();

                                        $threshold = 172800; // 2 day
                                        $timeDifference = abs($currentTimestamp - $targetTimestamp);

                                        if ($currentTimestamp >= $targetTimestamp) {
                                            echo "<td class='text-muted'>Passed! ($date)</td>";
                                        } elseif ($timeDifference <= $threshold) {
                                            echo "<td class='text-danger'>Near! ($date)</td>";
                                        } else {
                                            echo "<td class='text-success'>Far! ($date)</td>";
                                        }

                                        echo '<td><a href="delete-work.php?id=' . $work_id . '" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                            </svg></a></td>';
                                        echo '</tr>';
                                    }
                                }
                              }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once("footer.php"); ?>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
</body>

</html>
