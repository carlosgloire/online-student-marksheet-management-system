
<?php
require_once('../../../database/DBConnection.php');
$searchErr = '';
$product_details='';



		    $search = htmlspecialchars($_GET['search']);
            $request = $db->prepare("SELECT * FROM students_per_class WHERE  fname LIKE '%$search%' OR  lname LIKE '%$search%' AND class_id = :class_id");
            $request->execute(array('class_id' => $_SESSION['class_id']));
            $students = $request->fetchAll(PDO::FETCH_OBJ);
   
        //Requete pour compter le nombre des resultats trouvee
	
			
	
   

?>

		<div class="form-group">
			<span class="error" style="color:red;"> <?php echo $searchErr;?></span>
		</div>
    
        <section class="principal-Section">
        <!-- this is the nav bar for the left side of our system-->
        <?php require_once('navbar.php')?>

        <div class="class-content">
        <div>
				<?php
                   $query= $db->prepare("SELECT count(student_id) as studentID FROM students_per_class  WHERE fname LIKE '%$search%' OR  lname LIKE '%$search%'");
                   $query->execute();
					while($result=$query->fetch()){
						if($result['studentID'] > 1){
							?>
								<div class="text-center mb-2">
									<p class="text-green-500 pl-10"><?php echo $result['studentID'].' résultats trouvés' ?></p>

								</div>
							<?php
						}
						elseif($result['studentID'] == 1){
							?>
								<div class="text-center">
									<p class="text-green-500 "><?php echo $result['studentID'].'  résultat trouvé' ?></p>
								</div>
							<?php
					}
					}
				
				?>

				</div>
            <?php
                if(! $students){
                    echo "No student found";
                }
                else{
                    ?>
                          <?php if (count($students) > 0): ?>
                            <?php foreach ($students as $student): ?>
                                <div class="list-student">
                                    <div class="student-identity">
                                        <div class="stdt">
                                            <p class="regnumber"><?= $student->regnumber ?></p>
                                            <p><?= $student->fname . " " . $student->lname ?></p>
                                        </div>
                                        <div>
                                            <a class="modify" href="./edit_student.php?student_id=<?= $student->student_id ?>"><i class="fa-solid fa-pencil"></i></a>
                                            <button class="delete" data-formteacher-id="<?= $student->student_id ?>"><i class="fa-solid fa-trash-can"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="popup hidden-popup">
                                    <div class="popup-container">
                                        <h4>Dear Form teacher,</h4>
                                        <p>Are sure you want to delete this student</p>
                                        <p>into your system?</p>
                                        <div class="popup-btn">
                                            <button style="cursor:pointer" class="cancel-popup">Cancel</button>
                                            <button style="cursor:pointer" class="delete-popup">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color:red; text-align:center;">No student already added !!</p>
                        <?php endif; ?>
                    <?php
                }
            ?>
          
        </div>

    </section>
    