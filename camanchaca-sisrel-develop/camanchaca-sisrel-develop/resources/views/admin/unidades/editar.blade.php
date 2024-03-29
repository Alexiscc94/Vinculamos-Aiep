@extends('admin.panel_admin')

@section('contenido')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            @if (Session::has('errorUnidad'))
                                <div class="alert alert-danger alert-dismissible show fade mb-4 text-center">
                                    <div class="alert-body">
                                        <strong>{{ Session::get('errorUnidad') }}</strong>
                                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    </div>
                                </div>
                            @endif






                        </div>
                        <div class="col-3"></div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-md-2 col-lg-2"></div>
                        <div class="col-8 col-md-8 col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Editar unidad</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.actualizar.unidad', $unid->unid_codigo) }}"
                                        method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Nombre de la unidad</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-hotel"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control" id="unid_nombre"
                                                            name="unid_nombre"
                                                            value="{{ old('unid_nombre') ?? @$unid->unid_nombre }}"
                                                            autocomplete="off">
                                                    </div>
                                                    @if ($errors->has('unid_nombre'))
                                                        <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                            <div class="alert-body">
                                                                <button class="close"
                                                                    data-dismiss="alert"><span>&times;</span></button>
                                                                <strong>{{ $errors->first('unid_nombre') }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-3">
                                                <label class="label" for="tuni_codigo">Tipo de unidad</label>
                                                <div class="form-group">
                                                    <select class="form-control" id="tuni_codigo" name="tuni_codigo">
                                                        @foreach ($tuni as $tuni)
                                                            <option value="{{ $tuni->tuni_codigo }}"
                                                                {{ $unid->tuni_codigo == $tuni->tuni_codigo ? 'selected' : '' }}>
                                                                {{ $tuni->tuni_nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-3">
                                                <label class="label" for="comu_codigo">Comuna asociada</label>
                                                <div class="form-group">
                                                    <select class="form-control select2" id="comu_codigo" name="comu_codigo"
                                                        onchange="cargarCoordenadas()">
                                                        @foreach ($comu as $comu)
                                                            <option value="{{ $comu->comu_codigo }}"
                                                                {{ $unid->comu_codigo == $comu->comu_codigo ? 'selected' : '' }}>
                                                                {{ $comu->comu_nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Geolocalización</label>
                                                    <div class="form-group">
                                                        <label>Latitud</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control" id="lat"
                                                                name="lat" value="{{ old('lat') ?? @$unid->lat }}"
                                                                autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Longitud</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control" id="lng"
                                                                name="lng" value="{{ old('lng') ?? @$unid->lng }}"
                                                                autocomplete="off">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="run">Descripción de la unidad</label>
                                                <div class="input-group">
                                                    <textarea rows="7" cols="60" class="formbold-form-input" placeholder="Ingrese una descripción..."
                                                        id="unid_descripcion" name="unid_descripcion" autocomplete="off">{{ old('unid_descripcion') ?? @$unid->unid_descripcion }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">


                                            <div class="form-group col-3">
                                                <label for="apellido">Cargo de la unidad</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-clipboard"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" id="unid_nombre_cargo"
                                                        name="unid_nombre_cargo"
                                                        value="{{ old('unid_nombre_cargo') ?? @$unid->unid_nombre_cargo }}"
                                                        autocomplete="off">
                                                </div>
                                                @if ($errors->has('unid_nombre_cargo'))
                                                    <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                        <div class="alert-body">
                                                            <button class="close"
                                                                data-dismiss="alert"><span>&times;</span></button>
                                                            <strong>{{ $errors->first('unid_nombre_cargo') }}</strong>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>


                                            <div class="form-group col-3">
                                                <label for="text">Persona a cargo</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-user-tie"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" id="unid_responsable"
                                                        name="unid_responsable"
                                                        value="{{ old('unid_responsable') ?? @$unid->unid_responsable }}"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label>Estado de la unidad</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-traffic-light"></i>
                                                            </div>
                                                        </div>
                                                        <select class="form-control form-control-sm" name="unid_vigente"
                                                            id="unid_vigente">
                                                            <option value="S"
                                                                {{ $unid->unid_vigente == 'S' ? 'selected' : '' }}>Activo
                                                            </option>
                                                            <option value="N"
                                                                {{ $unid->unid_vigente == 'N' ? 'selected' : '' }}>Inactivo
                                                            </option>
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('unid_vigente'))
                                                        <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                            <div class="alert-body">
                                                                <button class="close"
                                                                    data-dismiss="alert"><span>&times;</span></button>
                                                                <strong>{{ $errors->first('unid_vigente') }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary waves-effect"><i
                                                    class="fas fa-undo-alt"></i> Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-md-2 col-lg-2"></div>

                        <div class="col-8 col-md-8 col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Seleccione la ubicación de la unidad</h4>
                                </div>
                                <div class="card-body">
                                    <div id="map" style="height: 180px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('public/js/unidades.js') }}"></script>
@endsection
