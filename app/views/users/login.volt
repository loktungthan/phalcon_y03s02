{{ content() }}
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
{{ form('users/authorize', 'role': 'form') }}
	<fieldset>
		<div class="form-group">
			<label for="email">Username</label>
			<div class="controls">
				{{ text_field('email', 'class': "form-control") }}
			</div>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<div class="controls">
				{{ password_field('password', 'class': "form-control") }}
			</div>
		</div>
		<div class="form-group">
			{{ submit_button('Login', 'class': 'btn btn-primary btn-large') }}
		</div>
                <div class="form-group">
			<li class="previous"><?php echo $this->tag->linkTo(["users/new", "No Account? Sign up here!"]) ?></li>
		</div>
	</fieldset>
{{  endform() }}