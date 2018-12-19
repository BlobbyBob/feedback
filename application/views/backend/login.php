<div class="body"></div>
<div class="container d-flex justify-content-center flex-column" style="min-height: 80vh;">
    <div id="login" class="signin-card">
        <div class="logo-image">
            <i class="fa fa-cog giant mb-3"></i>
        </div>
        <h1 class="display1">Kletterhalle<span>Evaluation</span></h1>
        <p class="subhead">Verwaltung</p>
        <?php if ( ! empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                Die Anmeldedaten sind nicht gültig!
            </div>
        <?php endif; ?>
        <?= form_open() ?>
            <div id="form-login-username" class="form-group">
                <input id="username" class="form-control" name="username" type="text" size="18" alt="login" required/>
                <span class="form-highlight"></span>
                <span class="form-bar"></span>
                <label for="username" class="float-label">Benutzername</label>
            </div>
            <div id="form-login-password" class="form-group">
                <input id="password" class="form-control" name="password" type="password" size="18" alt="password" required>
                <span class="form-highlight"></span>
                <span class="form-bar"></span>
                <label for="password" class="float-label">Passwort</label>
            </div>
            <div>
                <input class="btn btn-block btn-info" type="submit" name="login" value="Anmelden">
            </div>
        </form>
    </div>
</div>