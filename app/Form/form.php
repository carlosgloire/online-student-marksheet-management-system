<?php
    class Form {
        private $fields = array();
        public $title;
        private $value ;
        public function addField($type, $name, $label,$placeholder) {
            $this->fields[] = array("type" => $type, "name" => $name, "label" => $label,"placeholder"=>$placeholder);
        }
       public function __construct($title,$value)
       {
            $this->title=$title;
            $this->value=$value;
       }
       
        public function displayForm() {
            ?>
            <form method="post">
                    <h3 ><?= $this->title?></h3>    
                <?php
                    foreach ($this->fields as $field) {
                        ?>
                        <div class="input-content">
                            <div class="all-inputs">
                                <label for="<?= $field["name"] ?>"> <?= $field["label"] ?>:</label>
                                <input  type="<?= $field["type"] ?>" id="<?= $field["name"] ?>" name="<?= $field["name"] ?>" placeholder="<?= $field["placeholder"] ?>" required>
                            </div>
                        </div>
                        <?php
                    }
                
                ?>
                    <div class="btn">
                        <button type="submit" name="<?= $this->value?>">Add new form tutor</button>
                    </div>
            </form>
            <?php
        }
    }

   

    
    ?>


