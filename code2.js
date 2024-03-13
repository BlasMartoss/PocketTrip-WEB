function LogOut() {
    // Limpiar el localStorage con las variables a 0
    localStorage.setItem("Logged", "0");
    localStorage.setItem("idUser", "0");

    // Redirigir a la página de inicio
    window.location.href = "index.html";
}

// Obtener el id del usuario almacenado en el localStorage
var idUser = localStorage.getItem("idUser");

// Hacer una petición AJAX para obtener los datos del usuario al cargar la página
$.ajax({
    url: 'get_user_data.php',
    type: 'GET',
    data: { id_user: idUser },
    dataType: 'json',
    success: function (data) {
        // Actualizar los elementos HTML con los datos del usuario
        $('#nombre').text(data.name); 
        $('#dni').text(data.dni);
        $('#email').text(data.email);
    },
    error: function (error) {
        console.error('Error al obtener los datos del usuario: ', error);
    }
});
