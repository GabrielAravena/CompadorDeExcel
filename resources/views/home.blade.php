@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Cargar archivos</div>

                <div class="card-body">
                    <form action="#" id="formFiles" enctype="multipart/form-data">
                        <div class="form-group row justify-content-center" style="margin-top:15px">
                            <label for="documento_1" class="col-md-4 col-form-label text-md-right">Ingresar archivo Excel Ingresa</label>

                            <div class="col-md-6 col-form-label">
                                <input id="documento_1" type="file" role="button" name="documento1" accept=".xlsx, .xls" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mb-5">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Ingrese archivo Excel Ciisa</label>

                            <div class="col-md-6 col-form-label">
                                <input id="documento_2" type="file" role="button" name="documento2" accept=".xlsx, .xls" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">

                            <button id="enviar" type="submit" class="btn btn-primary">
                                Enviar
                            </button>

                        </div>
                    </form>
                </div>
            </div>
            <button class="btn btn-danger text-white float-right mt-3" type="button" onclick="cambiarFormato()">Cambiar formato de entrada</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $('input[type="file"]').on('change', function() {
        var ext = $(this).val().split('.').pop();
        if ($(this).val() != '') {
            if (ext == "xls" || ext == "xlsx") {} else {
                $(this).val('');
                Swal.fire('Oops...', 'Los archivos con extención "' + ext + '" no están permitidos', 'error');
            }
        }
    });

    function cambiarFormato() {
        Swal.fire({
                title: "Atención",
                text: "Estás a punto de cambiar el formato con el que ingresas los archivos Excel, ¿deseas continuar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Continuar",
                cancelButtonText: "Cancelar",
            })
            .then(resultado => {
                if (resultado.value) {
                    window.location = "{{ route('cambiarFormato.index') }}";
                } else {

                }
            });
    }
    
    $('#formFiles').on('submit', function(event) {

        event.preventDefault();

        var formData = new FormData(this);
        formData.append('_token', $('input[name=_token]').val());

        $.ajax({
            url: '{{ route("archivos.index") }}',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                Swal.fire({
                    title: "¡Perfecto!",
                    text: "Tu archivo está listo.",
                    icon: 'success',
                    confirmButtonText: "Descargar",
                    })
                    .then(resultado => {
                        if (resultado.value) {
                            window.location = "{{ route('archivos.comparar') }}";
                        }
                    });
            },
            error: function(jqXHR, text, error) {
                Swal.fire({
                    title: "Oops...",
                    text: "Algo salió mal, inténtalo nuevamente",
                    icon: 'error',
                    showCancelButton: false,
                });
            }
        });
    });
</script>
@endsection