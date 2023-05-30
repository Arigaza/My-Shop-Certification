docReady(() => {

    'use strict';

    const d = document;

    /** Constantes des sélecteurs */
    const actioninstagram = d.querySelector("#actioninstagram");
    const instagramform = d.querySelector("#instagramform");
    const deleteinstagram = d.querySelector("#deleteinstagram");
    const instagramdeleteform = d.querySelector("#instagramdeleteform");
    const email = d.querySelector('#email');
    const password = d.querySelector('#password');
    const cryptedEmail = d.querySelector('#cryptedEmail');
    const cryptedPw = d.querySelector('#cryptedPw');
    const active = d.querySelector('#active');

    /** Récupère le jeton CSRF Token depuis sa balise meta */
    let csrfToken;
    if (d.querySelector('meta[name="csrf-token"]') !== null) {
        csrfToken = d.querySelector('meta[name="csrf-token"]').content;
    }


    /** Positionne le focus sur le 1er champ en erreur ou sur le premier champ */
    let firstfield = d.querySelector('input.is-invalid:first-of-type');
    if (firstfield !== null) {
        firstfield.focus();
    } else {
        firstfield = d.querySelector('input[type="text"]:first-of-type');
        if (firstfield !== null) {
            firstfield.focus();
        }
    }


    /** Evènement ajouter/modifier un utilisateur */
    if (actioninstagram !== null) {
        actioninstagram.addEventListener('click', (e) => {
            e.preventDefault();
            instagramform.submit();
        });
    }

    /** Evènement activer/désactiver un compte */
    if (active !== null) {
        active.addEventListener('click', (e) => {
            const $this = e.currentTarget;
            $this.nextElementSibling.innerHTML = $this.checked ? 'Compte activ&eacute;' : 'Compte d&eacute;sactiv&eacute;';
        });
    }

    /** Evènement supprimer un utilisateur */
    if (deleteinstagram!== null) {
        deleteinstagram.addEventListener('click', (e) => {
            e.preventDefault();
            instagramdeleteform.submit();
        });
    }
});