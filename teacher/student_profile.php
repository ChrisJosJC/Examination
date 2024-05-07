<?php require_once('../includes/functions.php') ?>

<?php
if (!loggedTeacher()) {
    header('location:../index.php');
}
if (!isset($_GET['student'])) {
    header('location:index.php');
} else {
    $student = getStudent($_GET['student']);
    $class = getClass($student['class_id']);
}
if (isset($_POST['logout'])) {
    logout();
}
?>

<?php require_once('layouts/header.php') ?>
<?php require_once('layouts/navbar.php') ?>


<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php require_once('layouts/sidebar.php') ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-3 h5"><span class="badge badge-pill badge-primary">Profile</span></h1>
                <div class="card mt-3 mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?php
                                if ($student['avatar']) {
                                    $url = '../uploads/avatars/' . $student['avatar'];
                                } else {
                                    $url = '../includes/placeholders/150.png';
                                }
                                ?>
                                <img class="img-fluid" src="<?php echo $url; ?>">
                            </div>
                            <div class="col-md-3">
                                <div>Name: <?php echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="mt-1">Class: <?php echo htmlspecialchars($class['name'], ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="mt-1">Roll No: <?php echo $student['roll_no'] ?></div>
                                <div class="mt-1">Username: <?php echo htmlspecialchars($student['username'], ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                            <div class="col-md-7">
                                <?php
                                $profileResults = profileResults($student['id']);
                                if ($profileResults) {
                                ?>
                                    <table class="table table-bordered">
                                        <tr class="bg-light">
                                            <th>Exam</th>
                                            <th>Total</th>
                                            <th>Obtain</th>
                                            <th>Result</th>
                                        </tr>
                                        <?php foreach ($profileResults as $result) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($result['exam_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?php echo $result['total_marks'] ?></td>
                                                <td><?php echo $result['obtain'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($result['obtain'] >= $result['pass_marks']) {
                                                        echo '<span class="text-success">Passed</span>';
                                                    } else {
                                                        echo '<span class="text-danger">Failed</span>';
                                                    }

                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <?php require_once('../includes/form_errors.php') ?>
                    </div>
                </div>
            </div>
        </main>

        <?php require_once('layouts/footer.php') ?>
    </div>
</div>


<script>

</script>

<?php require_once('layouts/end.php') ?>