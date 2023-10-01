
// url = "../servicios/servicios.php";
url = "http://localhost/konectaServer/src/servicios/servicios.php";

$(() => {
    $("#btnRegistro").on("click", registrar);
    $("#email, #password, #nombre, #apellidos, #dni, #fecha_nacimiento").on("keydown click", cleanError)
    $( "#repassword").on("keydown click", cleanPassword);
})


/**
 * 
 */
function registrar() {

    let usuario =  {
        email: $("#email").val(),
        pass: $("#password").val(),
        nombre: $("#nombre").val(),
        apellidos: $("#apellidos").val(),
        fecha_nacimiento: $("#fecha_nacimiento").val(),
        activo: $("#activo").val(),
        dni: $("#dni").val(),
    }
    if(validarRegistro()){
        $.ajax({
            url: url,
            method: 'post',
            type: JSON,
            data: JSON.stringify(usuario)
        })
        .done((data)=>alert(data))
        .fail((error)=>alert(error))
    }
}




/**
 * 
 * @returns Valida el registro. Cómo queremos que evalúe todas las condiciones
 * para que aparezcan los errores usamos & en lugar de &&
 */
function validarRegistro() {

    let resultado = false;
    if (validarEmail() & validarPassword() & validarNombre()
        & validarApellidos() & validarDni() & validarFecha()) {
            resultado = true;
    }
    return resultado;
}


/**
 * Valida la sintáxis del email
 */
function validarEmail() {

    let resultado = true;
    let userInput = $("#email").val();
    let pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
    if (!pattern.test(userInput)) {
        $("#email").siblings("div.error").removeClass("invisible");
        resultado = false;
        // $("#email").siblings("div.error").attr("hidden", false);
    }
    return resultado;
}



/**
 * 
 * @returns valida que la fecha sea pasada
 */
function validarFecha() {

    let resultado = true;
    let fecha = $("#fecha_nacimiento");
    let fecha_nacimiento = new Date(fecha.val());
    if (!(fecha_nacimiento instanceof Date && !isNaN(fecha_nacimiento)) || fecha_nacimiento >= Date.now()) {
        fecha.siblings("div.error").removeClass("invisible");

        resultado = false;
    }
    return resultado;
}

/**
 * 
 * @param {Limpia el dic que muestra el error en el control del formulario} evt 
 */
function cleanError(evt) {
    $(evt.target).siblings("div.error").addClass("invisible");
    // $(evt.target).siblings("div.error").attr("hidden", true);
}


function cleanPassword(){
    $("#password").siblings("div.error").addClass("invisible");
}
/**
 * 
 * @returns valida que la contraseña introducida es la que se espera
 */
function validarPassword() {

    let password = $("#password");
    let repassword = $("#repassword");
    if (!(password.val().length >= 4 && password.val() == repassword.val())) {
        $("#password").siblings("div.error").removeClass("invisible");
    }
    return password.val() == repassword.val() ? true : false;

}


/**
 * 
 * @returns Valida el length del nombre
 */
function validarNombre() {

    let nombreValido = $("#nombre").val().length > 1 && $("#nombre").val().length <= 30;
    if (!nombreValido) {
        $("#nombre").siblings("div.error").removeClass("invisible");
    }
    return nombreValido;
}

/**
 * 
 * @returns valida el length de los apellidos
 */
function validarApellidos() {

    let apellidoValido = $("#apellidos").val().length > 1 && $("#apellidos").val().length <= 50;
    if (!apellidoValido) {
        $("#apellidos").siblings("div.error").removeClass("invisible");
    }
    return apellidoValido;
}

/**
 * 
 * @returns valida el dni
 */
function validarDni() {

    resultado = true;
    let dni = $("#dni").val();
    let pattern = /^(\d{8})([A-Z])$/i;
    if (!pattern.test(dni)) {
        $("#dni").siblings("div.error").removeClass("invisible");
        resultado = false;
    }
    return resultado;
}



