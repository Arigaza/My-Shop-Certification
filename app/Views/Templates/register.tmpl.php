<div class="text-center" oncontextmenu="return false;">
<main id="form-signin" class="form-signin w-100 m-auto border border-1 rounded-3">
    <form autocomplete="off">
        <img class="mb-4" src="imgs/syradev.svg" alt="Syradev &copy; <?= date('Y'); ?>">
        <h3 class="mb-3 fw-normal w-full">Créer un nouveau compte</h3>
        <div class="form-floating">
            <input type="email" class="form-control" id="login" placeholder="name@domain.tld">
            <label for="login">Adresse Email</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" id="name" placeholder="Votre prénom">
            <label for="name">Votre prénom</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" id="surname" placeholder="Votre nom">
            <label for="surname">Votre nom</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" placeholder="Password">
            <label for="password">Mot de passe</label>
        </div>
        <div class="form-floating">
        <label for="password_confirm">Valider votre mot de passe</label>
<input class="form-control" type="password" id="password_confirm" name="password_confirm">
        </div>
        <button id="registerBtn" class="w-100 btn btn-lg btn-primary" type="button">Se connecter</button>
        <p class="mt-5 mb-3 text-body-secondary">Syradev &copy; <?= date('Y'); ?></p>
    </form>
</main>
</div>

