<?php
    session_start();
    require_once('../../../database/DBConnection.php');
   
    require_once('../../../models/GenericModel.php');
    $stmt=$db->prepare("SELECT COUNT(DISTINCT spc.student_id)  as studentID, c.* FROM students_per_class spc LEFT JOIN classes c ON spc.class_id=c.class_id WHERE c.class_id ={$_SESSION['class_id']}");
    $stmt->execute();
    $countstudent=$stmt->fetchAll(PDO::FETCH_OBJ);

    $query=$db->prepare("SELECT spc.*, c.*,t.*,m.* FROM students_per_class spc 
    LEFT JOIN classes c ON spc.class_id=c.class_id
    LEFT JOIN marksheets m ON spc.student_id = m.student_id 
    LEFT JOIN trimeters t ON t.trim_id = m.trim_id
    WHERE c.class_id ={$_SESSION['class_id']}");
    $query->execute();
    $bulletins=$query->fetchAll(PDO::FETCH_OBJ);

 
?>
    
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin</title>
</head>
  
<body>
    <?php
        foreach($bulletins as $bulletin){
        ?>
            <section class="table-section">
                <!-- this is the nav bar for the left side of our system-->
                <div class="top-section">
                    <div class="bulletin-title">
                        <h2>REPUBLIC OF CAMEROON</h2>
                        <h4>COLLEGE SAINT JEAN-BAPTISTE</h4>
                        <p>B.P 50 DOUALA</p>
                        <P>Phone: 1234567889</P>
                    </div>
                    <div class="school-logo">
                        <p><img src="../../../images/logo-st-jean.png" alt=""></p>
                    </div>
                </div>

                <div class="identity">
                    <div>
                        <p>Registration Number: <span><?=$bulletin->regnumber?></span></p>
                        <p>Names: <strong><?=$bulletin->fname." ".$bulletin->lname?></strong></p>
                        <p>Parent adress: <span><?= $bulletin->parent_address?></span></p>
                    </div>
                    <div>
                        <p>Classe: <?= $bulletin->class_name ?></p>
                        <p>Date of the birth: <span><?=$bulletin->Dob?></span></p>
                        <p>Place of the birth: <span><?=$bulletin->Pob?></span></p>
                    </div>
                    <div>
                        <p>Students: <span><?php foreach($countstudent as $numberof_student)echo$numberof_student->studentID ?></span></p>
                    </div>
                </div>
                <table>
                    <tbody>
                    <tr style="font-weight: 500;text-align:center">
                        <td style="border-right: none;border-bottom: none; width:40.8%">First trimester</td>
                        <td style="border-right: none;border-bottom: none;width:29.58%">Second trimester</td>
                        <td style="border-bottom: none;" >Third trimester</td>
                    </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="head" >
                            <td>Discipline</td>
                            <td>M1</td>
                            <td>COMP1</td>
                            <td>MOY</td>
                            <td>Coef</td>
                            <td>Ap</td>
                            <td>TOT</td>
                            <td>M2</td>
                            <td>COM2</td>
                            <td>MOY</td>
                            <td>Coef</td>
                            <td>Ap</td>
                            <td>TOT</td>
                            <td>M3</td>
                            <td>COM3</td>
                            <td>MOY</td>
                            <td>Coef</td>
                            <td>Ap</td>
                            <td>TOT</td>
                        </tr>
                        <tr>
                            <td>Physics</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Mathematics</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>English</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Science</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>French</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>ICT</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Electronic</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Photography</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Design</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Leadership</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Construction</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Electricity</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>10</td>
                            <td>E</td>
                            <td>60</td>
                        </tr>
                    </tbody>
                </table>

                <div class="marks-content">
                    <div class="bulletin-result first-term">
                        <h4>First term</h4>
                        <p>Place: <span>3rd</span></p>
                        <p>Over 20: <span>12</span></p>
                        <p>Total: 2090</p>
                        <p>Conduite: <span>Good</span></p>
                    </div>
                    <div class="bulletin-result second-term">
                        <h4>Second term</h4>
                        <p>Place: <span>3rd</span></p>
                        <p>Over 20: <span>12</span></p>
                        <p>Total: 2090</p>
                        <p>Conduite: <span>Good</span></p>
                    </div>
                    <div class="bulletin-result third-term">
                        <h4>Third term</h4>
                        <p>Place: <span>3rd</span></p>
                        <p>Over 20: <span>12</span></p>
                        <p>Total: 2090</p>
                        <p>Conduite: <span>Good</span></p>
                    </div>
                    <div class="bulletin-result tot-gen">
                        <h4>Total general</h4>
                        <p>Place: <span>3rd</span></p>
                        <p>Over 20: <span>12</span></p>
                        <p>Total: 2090</p>
                        <p>Conduite: <span>Good</span></p>
                    </div>
                </div>

                <div class="admitted">
                    <p>Admitted</p>
                    <i class="fa-regular fa-circle-check"></i>
                </div>

                <div class="principal-signature">
                    <p><img src="../../../images/signature.png" alt="signature"></p>
                    <h3>Armel MBIATAT DANY</h3>
                </div>

                <div class="print">
                    <a  class="printButton" href="javascript:void(0);" id="printPage">Print</a>
                </div>

            </section>
            <hr>
        <?php
        }
    ?>


    <script lang='javascript'>
 $(document).ready(function(){
  $('#printPage').click(function(){
        var data = '<input type="button" value="Print this page" onClick="window.print()">';           
        data += '<div id="div_print">';
        data += $('#your_content').html();
        data += '</div>';

        myWindow=window.open('','','width=200,height=100');
        myWindow.innerWidth = screen.width;
        myWindow.innerHeight = screen.height;
        myWindow.screenX = 0;
        myWindow.screenY = 0;
        myWindow.document.write(data);
        myWindow.focus();
    });
 });
</script>
</body>

</html>