<?php require_once('../includes/functions.php') ?>

<?php
if (empty($_GET['exam'])) {
    header('location:index.php');
} else {
    $exam_id = $_GET['exam'];
}
if (!loggedTeacher()) {
    header('location:../index.php');
}
if (isset($_POST['logout'])) {
    logout();
}
if (isset($_POST['delete']) && isset($_POST['question_id'])) {
    deleteQuestion($_POST['question_id']);
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
                    <span class="badge badge-pill badge-primary">Questions</span>
                    <span class="text-primary h5">
                        <?php
                        $exam = getExam($exam_id);
                        echo htmlspecialchars($exam['exam_name'], ENT_QUOTES, 'UTF-8');
                        ?>
                    </span>
                </h1>

                <?php
                $questions = viewQuestions($exam_id);
                if ($questions) {
                    $count = 0;
                    foreach ($questions as $question) {
                        $correct_option = $question['correct_option'];
                ?>

                        <div class="card mt-3 mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        Question - <?php echo ++$count ?> |
                                        Marks - <?php echo $question['marks'] ?>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end text-dark">
                                        <a href="edit_questions.php?question=<?php echo $question['id'] ?>"><i class="fas fa-edit mx-1"></i></a>
                                        <a><i class="fas fa-trash mx-1 hover-pointer" data-toggle="modal" data-target="#deleteModal" data-question-id="<?php echo $question['id'] ?>"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo $question['question'] ?>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="" class="small <?php echo ($correct_option == 'option_a') ? 'badge badge-success font-weight-normal' : null ?>">Option A</label>
                                        <div><?php echo $question['option_a'] ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="small <?php echo ($correct_option == 'option_b') ? 'badge badge-success font-weight-normal' : null ?>">Option B</label>
                                        <div><?php echo $question['option_b'] ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="small <?php echo ($correct_option == 'option_c') ? 'badge badge-success font-weight-normal' : null ?>">Option C</label>
                                        <div><?php echo $question['option_c'] ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="small <?php echo ($correct_option == 'option_d') ? 'badge badge-success font-weight-normal' : null ?>">Option D</label>
                                        <div><?php echo $question['option_d'] ?></div>
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

<!-- Modal -->
<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Are you sure?</h5>
                <span aria-hidden="true" class="close hover-pointer" data-dismiss="modal" aria-label="Close">&times;</span>
            </div>
            <div class="modal-body">
                It will delete this question including all linked data.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="" method="post">
                    <input type="hidden" name="question_id">
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../sbadmin/js/polyfill.min.js"></script>
<script id="MathJax-script" async src="../sbadmin/js/tex-chtml.js"></script>

<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var question_id = button.data('question-id')
        var modal = $(this)
        modal.find('input[name="question_id"]').val(question_id)
    })
</script>


<?php require_once('layouts/end.php') ?>