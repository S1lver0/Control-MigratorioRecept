const sonido = new Audio("Sonido.mp3");
var codigo_escaneado;
var scanner = new Instascan.Scanner({
    video: document.getElementById('QR'),
    sCanPeriod: 5,
    mirror: false
});

Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        scanner.start(cameras[0]);
    } else {
        console.error('No se han encontrado camaras');
        alert('Camaras no encontradas');
    }
}).catch(function (e) {
    console.error(e);
    alert("ERROR: " + e);
});

scanner.addListener('scan', function (respuesta) {
    sonido.volume = 0.3;
    sonido.play();
    console.log("Contenido del qr: " + respuesta);
    Swal.fire({
        icon: "success",
        title: "Codigo escaneado",
        text: "El código se escaneo correctamente.",
    });
    //alert("aaa");
    codigo_escaneado = respuesta;
    // Crear el elemento input
    var codigoInput = document.getElementById("codigoqr");
    //obtienes el boton
    var botonqr = document.getElementById("botonqr");
    botonqr.disabled=false;
    codigoInput.value = codigo_escaneado;
    //alert(codigo_escaneado);
    codigoInput.readOnly = true;
    //alert("el id del input es: >>" + codigoInput.id + "<<, el codigo escaneado es: >>" + codigo_escaneado);
});

function mostrarDatos() {
    var codigoInput = document.getElementById("codigoqr");
    //alert("el id del input es: " + codigoInput.id + ", el codigo escaneado es: " + codigo_escaneado);

}

