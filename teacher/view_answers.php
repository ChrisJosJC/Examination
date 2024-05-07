<?php require_once('../includes/functions.php') ?>

<?php
if (empty($_GET['exam'])) {
    header('location:index.php');
} else {
    $exam_id = $_GET['exam'];
    $student_id = $_GET['student'];
    $student = getStudent($student_id);
    $exam = getExam($exam_id);
}
if (!loggedTeacher()) {
    header('location:../index.php');
}
if (isset($_POST['logout'])) {
    logout();
}
if (isset($_POST['submit'])) {
    addQuestion();
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
                <h1 class="mt-3 h5">
                    <span class="badge badge-pill badge-primary">Answers</span>
                    <span class="text-primary h5">
                        <?php
                        echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8');
                        ?>
                    </span>
                </h1>

                <?php
                $answers = getAnswers($exam_id, $student_id);
                if ($answers) {
                    $count = 0;
                    foreach ($answers as $answer) {
                ?>

                        <div class="card mt-3 mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        Marks - <?php echo $answer['marks'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo $answer['question'] ?>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="" class="small">Correct Option</label>
                                        <div><?php echo $answer['correct_option'] ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="small">Answered Option</label>
                                        <div class="<?php echo ($answer['correct_option'] == $answer['answered_option']) ? 'text-success' : 'text-danger' ?>"><?php echo $answer['answered_option'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    No records found!.
                <?php
                }
                ?>
            </div>
        </main>

        <?php require_once('layouts/footer.php') ?>
    </div>
</div>


<script src="../sbadmin/js/polyfill.min.js"></script>
<script id="MathJax-script" async src="../sbadmin/js/tex-chtml.js"></script>

<?php require_once('layouts/end.php') ?>