// Carga el Js cuando el DOM termina de cargar.
document.addEventListener('DOMContentLoaded', function() {
    // Mandamos llamar la funcion para que cargue las demas cuando termine de cargar el DOM
    startApp();
});

function startApp() {
    showPassword();
}

function showPassword() {
    // seleccionamos el input y el boton del primer elemento
    const btnShow = document.getElementById('mostrar');
    const inputPassword = document.getElementById('password');
    // Seleccionamos el input y el boton del segundo elemento
    const btnShow2 = document.getElementById('mostrar2');
    const inputPassword2 = document.getElementById('password2');

    inputPassword2.addEventListener('input', () => {
        if(inputPassword2.value.length === 0) {
            btnShow2.classList.remove('container-auth__btn-password--mostrar');
        } else {
            
            btnShow2.classList.add('container-auth__btn-password--mostrar');
        }
    });
    btnShow2.addEventListener('click', () => {
        if(inputPassword2.type === 'password') {
            inputPassword2.type = 'text';
            btnShow2.textContent = 'Hidden';
        } else  {
            inputPassword2.type = 'password';
            btnShow2.textContent = 'Show';
        }
    });

    inputPassword.addEventListener('input', () => {
        if(inputPassword.value.length === 0) {
            btnShow.classList.remove('container-auth__btn-password--mostrar');
        } else {
            
            btnShow.classList.add('container-auth__btn-password--mostrar');
        }
    });
    btnShow.addEventListener('click', () => {
        if(inputPassword.type === 'password') {
            inputPassword.type = 'text';
            btnShow.textContent = 'Hidden';
        } else  {
            inputPassword.type = 'password';
            btnShow.textContent = 'Show';
        }
    });
}

