<?php
    class Form {
        private $fields = array();
        public $title;
        private $value ;
        private $btnName;
        private $datastored;
        public function addField($type, $name, $label,$placeholder) {
            $this->fields[] = array("type" => $type, "name" => $name, "label" => $label,"placeholder"=>$placeholder);
        }
       
       public function __construct(string $title, string $btnName,string $value)
       {
            $this->title=$title;
            $this->value=$value;
            $this->btnName=$btnName;
       }
       
        public function displayForm($errror) {
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                    <h3 ><?= $this->title?></h3>    
                <?php
                    foreach ($this->fields as $field) {
                        ?>
                        <div class="input-content">
                            <div class="all-inputs">
                                <label for="<?= $field["name"] ?>"> <?= $field["label"] ?>:</label>
                                <input  type="<?= $field["type"] ?>" id="<?= $field["name"] ?>"  name="<?= $field["name"] ?>" placeholder="<?= isset($_POST[($field['name'])]) ? ($_POST[($field['name'])]): $field['placeholder'] ?>"  required>
                            </div>
                        </div>
                        <?php
                    }
                
                ?>
                    <div class="btn">
                        <button type="submit" name="<?=$this->btnName?>"><?=$this->value?></button>
                    </div>
            </form>
            <?php
        }
        public function signin_signup_form() {
            ?>
            <h3><?=$this->title?></h3>
           <form action="" method="post">
                    <div class="input-content">
                        <div class="all-inputs">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="input-content">
                        <div class="all-inputs">
                            <i class="fa-solid fa-lock"></i>
                            <input class="password" name="password" type="password" placeholder="Enter your password" required>
                            <div class="eyes">
                                <i class="fa-solid fa-eye open"></i>
                                <i class="fa-solid fa-eye-slash close hidden"></i>
    
                            </div>
                        </div>
                    </div>
                    <div class="forgotten-password">
                        <p>Forgotten password</p>
                        <a href="#">click here </a>
                    </div>
                    <div class="btn">
                        <button type="submit" name="<?= $this->btnName?>"><?= $this->value?></button>
                    </div>
                </form>
            <?php
        }
   
    }



