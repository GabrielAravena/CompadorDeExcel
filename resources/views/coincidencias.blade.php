@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Ingresar coincidencias</div>

                <div class="card-body">
                    <label class="h6 text-center mb-5"><strong>Debes ingresar las columnas que deben coincidir entre los archivos.
                            Si una columna no debe coincidir con otra, debes marcarla como "ninguna".
                        </strong></label>
                    <form method="POST" id="form" action="#">
                        @csrf

                        @foreach($cabecerasCiisa as $ciisa)
                        <div class="form-group row justify-content-center">
                            <label class="col-md-4 col-form-label text-md-right">{{ $ciisa }}</label>
                            <select class="col-md-4 form-control" name="{{ $ciisa }}">
                                <option value="ninguna">Ninguna</option>
                                @foreach($cabecerasIngresa as $ingresa)
                                <option value="{{ $ingresa }}">{{ $ingresa }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                        <input type="text" name="id" value="{{ $id }}" style="display:none">
                        <div class="form-group row justify-content-center">
                            <button id="enviar" type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $('#form').on('submit', function(event) {

        event.preventDefault();

        var formData = new FormData(this);
        formData.append('_token', $('input[name=_token]').val());

        $.ajax({
            url: '{{ route("cambiarFormato.coincidencias") }}',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                Swal.fire({
                        title: "¡Perfecto!",
                        text: "Ya puedes ingresar archivos con el nuevo formato",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: "Continuar",
                    })
                    .then(resultado => {
                        if (resultado.value) {
                            window.location = "{{ route('home') }}";
                        }
                    });
            },
            error: function(jqXHR, text, error) {
                Swal.fire({
                    title: "Oops...",
                    text: "Algo aslió mal, inténtalo nuevamente.",
                    icon: 'error',
                    showCancelButton: false,
                });
            }
        });
    });
</script>
@endsection