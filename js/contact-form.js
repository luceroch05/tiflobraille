$(document).ready(function () {
    // Crear modal dinámicamente
    const modalHTML = `
        <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mensaje</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="responseMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    if (!$('#responseModal').length) {
        $('body').append(modalHTML);
    }

    function showError(fieldSelector, message) {
        $(fieldSelector).addClass('is-invalid');
        $(fieldSelector).next('.error-message').remove();
        $(fieldSelector).after(`<div class="error-message text-danger">${message}</div>`);
    }

    function removeError(fieldSelector) {
        $(fieldSelector).removeClass('is-invalid');
        $(fieldSelector).next('.error-message').remove();
    }

    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function showModal(message) {
        $('#responseMessage').text(message);
        $('#responseModal').modal('show');
    }

    $('#contact-form').on('submit', function (e) {
        e.preventDefault();

        $('#cf-submit input').val('Enviando...').prop('disabled', true);

        let isValid = true;

        const nombre = $('#name').val().trim();
        const correo = $('#email').val().trim();
        const ruc = $('#ruc').val().trim();
        const telefono = $('#telefono').val().trim();
        const ciudad = $('#ciudad').val().trim();
        const descripcion = $('#message').val().trim();

        removeError('#name');
        removeError('#email');
        removeError('#ruc');
        removeError('#telefono');
        removeError('#ciudad');
        removeError('#message');

        if (nombre === '') {
            showError('#name', 'Ingrese su nombre completo');
            isValid = false;
        }
        if (correo === '') {
            showError('#email', 'Ingrese su correo');
            isValid = false;
        } else if (!isValidEmail(correo)) {
            showError('#email', 'Correo inválido');
            isValid = false;
        }

        if (ruc === '') {
            showError('#ruc', 'Ingrese su número de RUC');
            isValid = false;
        }

        if (telefono === '') {
            showError('#telefono', 'Ingrese su teléfono');
            isValid = false;
        }

        if (ciudad === '') {
            showError('#ciudad', 'Ingrese su ciudad');
            isValid = false;
        }
        if (descripcion === '') {
            showError('#message', 'Ingrese su mensaje');
            isValid = false;
        }

      
      
       
        if (!isValid) {
            $('#cf-submit input').val('Enviar Mensaje').prop('disabled', false);
            return;
        }

        $.ajax({
            url: 'sendmail.php',
            type: 'POST',
            data: {
                nombre: nombre,
                correo: correo,
                ruc: ruc,
                telefono: telefono,
                ciudad: ciudad,
                descripcion: descripcion
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    showModal(response.message);
                    $('#contact-form')[0].reset();
                } else {
                    showModal(response.message || 'Error al enviar. Intente de nuevo.');
                }
            },
            error: function (xhr) {
                showModal('Hubo un error de conexión. Intente más tarde.');
                console.log(xhr.responseText);
            },
            complete: function () {
                $('#cf-submit input').val('Enviar Mensaje').prop('disabled', false);
            }
        });
    });

    $('#contact-form input, #contact-form textarea').on('input', function () {
        removeError('#' + $(this).attr('id'));
    });
});
