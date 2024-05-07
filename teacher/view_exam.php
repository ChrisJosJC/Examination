<?php require_once('../includes/functions.php') ?>

<?php
if (!loggedTeacher()) {
    header('location:../index.php');
} else {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['logout'])) {
    logout();
}
if (isset($_POST['update'])) {
    updateExam();
}
if (isset($_POST['delete']) && isset($_POST['exam_id'])) {
    deleteExamTeacher($_POST['exam_id']);
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
                <h1 class="mt-3 h5"> <span class="badge badge-pill badge-primary"> Exams </span></h1>

                <div class="card mt-3 mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <i class="fas fa-table mr-1"></i>
                                Created Exams
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col">
                                <?php require_once('../includes/form_errors.php') ?>
                            </div>
                        </div>
                        <?php
                        $exams = teacherExams($user_id);
                        if ($exams) {
                        ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Exam Name</th>
                                            <th>Total Time</th>
                                            <th>Total Questions</th>
                                            <th>Total Marks</th>
                                            <th>Pass Marks</th>
                                            <th>Date</th>
                                            <th>Live</th>
                                            <th>Modify</th>
                                            <th>Questions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($exams as $exam) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($exam['exam_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo $exam['total_time'] ?></td>
                                                <td><?php echo $exam['total_questions'] ?></td>
                                                <td><?php echo $exam['total_marks'] ?></td>
                                                <td><?php echo $exam['pass_marks'] ?></td>
                                                <td><?php echo $exam['date'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($exam['is_live']) {
                                                        echo '<i class="fas fa-circle text-success"></i>';
                                                    } else {
                                                        echo '<i class="fas fa-circle text-black-50"></i>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <i class="fas fa-edit mx-1 hover-pointer" data-toggle="modal" data-target="#editModal" data-exam-id="<?php echo $exam['id'] ?>" data-exam-name="<?php echo htmlspecialchars($exam['exam_name'], ENT_QUOTES, 'UTF-8') ?>" data-total-time="<?php echo $exam['total_time'] ?>" data-total-questions="<?php echo $exam['total_questions'] ?>" data-total-marks="<?php echo $exam['total_marks'] ?>" data-pass-marks="<?php echo $exam['pass_marks'] ?>" data-exam-date="<?php echo $exam['date'] ?>">
                                                    </i>
                                                    <i class="fas fa-trash mx-1 hover-pointer" data-toggle="modal" data-target="#deleteModal" data-exam-id="<?php echo $exam['id'] ?>"></i>
                                                </td>

                                                <td>
                                                    <a href="add_questions.php?exam=<?php echo $exam['id'] ?>" class="mx-1"><i class="fas fa-plus-circle"></i></a>
                                                    <a href="view_questions.php?exam=<?php echo $exam['id'] ?>" class="mx-1">view</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>

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
                It will delete all exam data including answers & results of all student if any.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="" method="post">
                    <input type="hidden" name="exam_id">
                    <input type="hidden" name="csrf_token" value="<?php echo $token ?>">
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Exam</h5>
                <span aria-hidden="true" type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</span>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="hidden" name="exam_id">
                    <div class="form-group">
                        <label for="" class="small">Exam Name</label>
                        <input type="text" name="exam_name" class="form-control" placeholder="Exam name">
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Total Time</label>
                        <input type="text" name="total_time" class="form-control" placeholder="Total Time">
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Total Questions</label>
                        <input type="text" name="total_questions" class="form-control" placeholder="Total Questions">
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Total Marks</label>
                        <input type="text" name="total_marks" class="form-control" placeholder="Total Marks">
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Pass Marks</label>
                        <input type="text" name="pass_marks" class="form-control" placeholder="Pass Marks">
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Exam Date</label>
                        <input type="date" name="exam_date" class="form-control" placeholder="Date">
                    </div>
                    <input type="hidden" name="csrf_token" value="<?php echo $token ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var exam_id = button.data('exam-id')
        var modal = $(this)
        modal.find('input[name="exam_id"]').val(exam_id)
    })

    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        modal.find('input[name="exam_id"]').val(button.data('exam-id'))
        modal.find('input[name="exam_name"]').val(button.data('exam-name'))
        modal.find('input[name="total_time"]').val(button.data('total-time'))
        modal.find('input[name="total_questions"]').val(button.data('total-questions'))
        modal.find('input[name="total_marks"]').val(button.data('total-marks'))
        modal.find('input[name="pass_marks"]').val(button.data('pass-marks'))
        modal.find('input[name="exam_date"]').val(button.data('exam-date'))
    })
</script>

<?php require_once('layouts/end.php') ?>