<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div id="app">
	<section class="section">
		<div class="d-flex flex-wrap align-items-stretch">
			<div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
				<div class="p-4 m-3">
					<a href="/login"><img src="<?= base_url() ?>/asset/logo-fk.webp" alt="logo" width="200px" height="78px"></a>
					<br>
					<br>
					<h4 class="text-dark font-weight-normal"><strong><?= lang('Auth.loginTitle') ?></strong></h2>
						<p class="text-muted">Before you get started, you must login or register if you don't already have an account.</p>
						<?= view('\Modules\Login\Views\_message_block') ?>
						<form action="<?= route_to('login') ?>" method="post">
							<?= csrf_field() ?>

							<?php if ($config->validFields === ['email']) : ?>
								<div class="form-group">
									<label for="login"><?= lang('Auth.email') ?></label>
									<input type="email" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.email') ?>">
									<div class="invalid-feedback">
										<?= session('errors.login') ?>
									</div>
								</div>
							<?php else : ?>
								<div class="form-group">
									<label for="login"><?= lang('Auth.emailOrUsername') ?></label>
									<input type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
									<div class="invalid-feedback">
										<?= session('errors.login') ?>
									</div>
								</div>
							<?php endif; ?>
							<div class="form-group">
								<div class="d-block">
									<label for="password" class="control-label"><?= lang('Auth.password') ?></label>
								</div>
								<input type="password" name="password" class="form-control  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
								<div class="invalid-feedback">
									<?= session('errors.password') ?>
								</div>
							</div>
							<?php if ($config->allowRemembering) : ?>
								<div class="form-group">
									<div class="form-check">
										<label class="form-check-label">
											<input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
											<?= lang('Auth.rememberMe') ?>
										</label>
									</div>
								</div>
							<?php endif; ?>
							<div class="form-group text-right">
								<?php if ($config->activeResetter) : ?>
									<a href="<?= route_to('forgot') ?>" class="float-left mt-3">
										<?= lang('Auth.forgotYourPassword') ?>
									</a>
								<?php endif; ?>
								<button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
									<?= lang('Auth.loginAction') ?>
								</button>
							</div>
							<?php if ($config->allowRegistration) : ?>
								<div class="mt-5 text-center">
									Don't have an account? <a href="<?= route_to('register') ?>">Create new one</a>
								</div>
							<?php endif; ?>
						</form>

						<div class="text-center mt-5 text-small">
							Copyright &copy; 2021 UMSU
						</div>
				</div>
			</div>
			<div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="<?= base_url() ?>/asset/login-fk.webp">
				<div class="absolute-bottom-left index-2">
					<div class="text-light p-5 pb-2">
						<div class="mb-5 pb-3">
							<h1 style="color:white;" class="col-lg-12 col-12 mb-2 display-4 font-weight-bold">Dokter Muda</h1>
							<h5 class="col-lg-12 col-12 font-weight-normal text-muted-transparent">Fakultas Kedokteran UMSU</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<?= $this->endSection() ?>