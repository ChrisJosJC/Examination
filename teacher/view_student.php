<?php require_once('../includes/functions.php') ?>

<?php
    if(!loggedTeacher()){
        header('location:../index.php');
    }
    if(isset($_POST['logout'])){
        logout();
    }
    if(isset($_POST['submit'])){
        addTeacher();
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
                <h1 class="mt-3 h5"><span class="badge badge-pill badge-primary">Students</span></h1>

                <div class="card mt-3 mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <i class="fas fa-table mr-1"></i>
                                Recenty Registered Students
                            </div>
                            <div class="col-md-3 offset-md-3">
                                <form action="class_students.php" method="get">
                                    <div class="input-group input-group-sm">
                                    <select class="form-control" name="class">
                                        <option disabled selected>select</option>
                                        <?php 
                                            $classes = allClasses();
                                            if($classes){
                                                foreach($classes as $class){
                                                    $selected = null;
                                                    if(isset($_POST['class_id'])){
                                                        if($_POST['class_id']==$class['id']){
                                                            $selected = 'selected';
                                                        }
                                                    }
                                                    echo "<option value='{$class['id']}' {$selected}>".htmlspecialchars($class['name'], ENT_QUOTES, 'UTF-8')."</option>";
                                                }
                                                
                                            }
                                        ?>
                                    </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-eye"></i> View</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            $students = recentStudents();
                            if($students){
                        ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Roll No</th>
                                            <th>Class</th>                                           
                                            <th>Username</th>
                                            <th>Profile</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach($students as $student) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?php echo htmlspecialchars($student['roll_no'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?php echo htmlspecialchars($student['class_name'], ENT_QUOTES, 'UTF-8') ?></td>                                           
                                            <td><?php echo htmlspecialchars($student['username'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><a href="student_profile.php?student=<?php echo $student['id'] ?>">Visit</a></td>
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

<?php require_once('layouts/end.php') ?>

