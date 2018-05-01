<?= $this->getContent() ?>
<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous"><?php echo $this->tag->linkTo(["index", "Go Back"]) ?></li>
        </ul>
    </nav>
</div>

<div class="page-header">
	<h3>Log In</h3>

</div>
<?= $this->tag->form(['users/authorize', 'role' => 'form']) ?>
	<fieldset>
		<div class="form-group">
			<label for="email">Username</label>
			<div class="controls">
				<?= $this->tag->textField(['email', 'class' => 'form-control']) ?>
			</div>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<div class="controls">
				<?= $this->tag->passwordField(['password', 'class' => 'form-control']) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->tag->submitButton(['Login', 'class' => 'btn btn-primary btn-large']) ?>
		</div>
                <div class="form-group">
			<li class="previous"><?php echo $this->tag->linkTo(["users/new", "No Account? Sign up here!"]) ?></li>
		</div>
	</fieldset>
<?= $this->tag->endform() ?>