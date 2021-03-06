<?php
/**
 * @var \Phalcon\Mvc\View\Engine\Php $this
 */
?>

<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous"><?php echo $this->tag->linkTo(["movie", "Back"]) ?></li>
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>
        Edit movie
    </h1>
</div>

<?php echo $this->getContent(); ?>

<?php
    echo $this->tag->form(
        [
            "movie/save",
            "autocomplete" => "off",
            "class" => "form-horizontal"
        ]
    );
?>

<div class="form-group">
    <label for="fieldName" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
        <?php echo $this->tag->textField(["name", "size" => 30, "class" => "form-control", "id" => "fieldName"]) ?>
    </div>
</div>

<div class="form-group">
    <label for="fieldDescription" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <?php echo $this->tag->textField(["description", "size" => 30, "class" => "form-control", "id" => "fieldDescription"]) ?>
    </div>
</div>

<div class="form-group">
    <label for="fieldRating" class="col-sm-2 control-label">Rating</label>
    <div class="col-sm-10">
        <?php echo $this->tag->textField(["rating", "type" => "number", "class" => "form-control", "id" => "fieldRating"]) ?>
    </div>
</div>

<div class="form-group">
    <label for="fieldImageFile" class="col-sm-2 control-label">Upload your Image</label>
    <div class="col-sm-10">
        <?php echo $this->tag->fileField(["imageFile", "size" => 30, "class" => "form-control", "id" => "fieldImageFile"]) ?>
    </div>
</div>



<?php echo $this->tag->hiddenField("id") ?>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?php echo $this->tag->submitButton(["Save", "class" => "btn btn-default"]) ?>
    </div>
</div>

<?php echo $this->tag->endForm(); ?>
<?php


echo $this->tag->linkTo(
    ["review/new",
    "Create a review!"]
);