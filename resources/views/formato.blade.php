@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Cambiar formato</div>

                <div class="card-body">
                    <div class="text-center" style="margin-top:15px; margin-bottom:30px;">
                        <label class="h6 float-center"><strong>Debes ingresar los archivos Excel con los nuevos formatos.</strong></label>
                    </div>
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
                                <input id="documento_2" type="file" role="button" name="documento2" accept=".xlsx, .xls, .csv" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center ">
                            <button id="enviar" type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                            <a class="btn btn-success text-white ml-5" role="button" href="javascript:history.back(-1);">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
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

    $('#formFiles').on('submit', function(event) {

        event.preventDefault();

        var formData = new FormData(this);
        formData.append('_token', $('input[name=_token]').val());

        $.ajax({
            url: '{{ route("cambiarFormato.create") }}',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                Swal.fire({
                        title: "¡Perfecto!",
                        text: "Los formatos se han cargado exitosamente",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: "Continuar",
                    })
                    .then(resultado => {
                        if (resultado.value) {
                            window.location = "{{ route('cambiarFormato.ingresarCoincidencias') }}";
                        }
                    });
            },
            error: function(jqXHR, text, error) {
                Swal.fire({
                    title: "Oops...",
                    text: "Algo salió mal, inténtalo nuevamente.",
                    icon: 'error',
                    showCancelButton: false,
                });
            }
        })
    });
</script>

@endsection