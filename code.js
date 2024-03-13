// Manejo del evento de clic en el botón de la hamburguesa (burger)
$('#burger').click(function(){
    // Alternar la visibilidad del menú de la hamburguesa al hacer clic
    $('#menu_burger').slideToggle();
});

// Función para cambiar el fondo (background)
function background(){
    var div_opacity = document.getElementById('opacity_div');
    var display = div_opacity.style.display;
    if(display === "block"){
        div_opacity.style.display = "none";
        return;
    }
    div_opacity.style.display = "block";
}

// Función para mostrar un mensaje de seguridad al intentar cambiar la contraseña
function changePassword(){
    alert("Por temas de seguridad, debe ponerse en contacto con su asesor mediante un mensaje.");
}


// Verificar si hay un usuario logueado y actualizar la visualización en consecuencia
verifyLogin();

// Función para verificar el estado de inicio de sesión y ajustar la visualización en consecuencia
function verifyLogin(){
   
    var logged = localStorage.getItem("Logged");
    var name_container = document.getElementById('div_accounts');
 
    var icon_person = document.getElementById('div_person1');
    if (logged === "1") {
        name_container.style.display = "none"
        icon_person.style.display= "flex"
        document.getElementById("perfil_id2").href="user.html"; 
        document.getElementById("perfil_id").href="user.html"; 
   
    } else {
   
        name_container.style.display = "flex";
        icon_person.style.display= "none";
        document.getElementById("perfil_id2").href="login.php"; 
        document.getElementById("perfil_id").href="login.php"; 
    }
}

// Función para validar que el usuario que accede al viaje haya iniciado sesión
function trip(){

    var logged = localStorage.getItem("Logged");

    if (logged === "1") {
        var idUser = localStorage.getItem("idUser");
        alert("Has reservado cita para unirte al viaje como el usuario: " + idUser + ", En breves recibirás un correo con toda la información del viaje y tu codigo de pasajero.");
   
    } else {
        alert("Crea una cuenta o inicia sesión con tu cuenta para disfrutar de este viaje")
    
    }
 
}

// Función para mostrar el div que contiene el error cuando las credenciales para iniciar sesión son incorrectas
function showErrorMessage(){
    var error_Login = document.getElementById('error_login');
    error_Login.style.display = "block";
}


// Función para mostrar el div que contiene el mensaje de error cuando el email ya existe en la base de datos
function showErrorEmailExistente(condition){
    var error_emailExistente= document.getElementById('error_email_existente');
    if (condition === true){
        error_emailExistente.style.display = "block";
        return;
    }    
        error_emailExistente.style.display = "none";
    return;
}

// Función para mostrar el div que contiene el mensaje de error cuando el email no tiene un formato correcto
function showErrorEmail(condition){
    var error_email = document.getElementById('error_email');
    if (condition){
        error_email.style.display = "block";
        return;
    }    
        error_email.style.display = "none";
    return;
}


// Función para mostrar el div que contiene el mensaje de error cuando el DNI ya existe en la base de datos
function showErrorDNI(condition){

    var error_dni= document.getElementById('error_dni_existente');
    if (condition === true){
        error_dni.style.display = "block";
        return;
    }    
        error_dni.style.display = "none";
    return;
}

function showErrorPassword(condition){

    var error_password= document.getElementById('error_password');
    if (condition === true){
        error_password.style.display = "block";
        return;
    }    
    error_password.style.display = "none";
    return;
}


