@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.update') }} {{ trans('cruds.provinsi.title_singular') }}
    </div>

    <div class="card-body">
        <form class="form-material mt-4" action="{{ route("admin.provinsi.update",$val->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group {{ $errors->has('zona_waktu') ? 'has-error' : '' }}">
                <label for="zona_waktu">{{ trans('cruds.member.fields.zone') }}*</label>
                <select name="zona_waktu" id="zona_waktu" class="form-control select2" required style="width: 100%; height:36px;">
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    <option value="01" @if ($val->zona_waktu == '01') selected @endif>Waktu Indonesia Barat</option>
                    <option value="02" @if ($val->zona_waktu == '02') selected @endif>Waktu Indonesia Tengah</option>
                    <option value="03" @if ($val->zona_waktu == '03') selected @endif>Waktu Indonesia Timur</option>
                </select>
                @if($errors->has('zona_waktu'))
                    <em class="invalid-feedback">
                        {{ $errors->first('zona_waktu') }}
                    </em>
                @endif
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group {{ $errors->has('id_prov') ? 'has-error' : '' }}">
                        <label for="id_prov">Nomor Provinsi*</label>
                        <input type="text" id="id_prov" name="id_prov" class="form-control" value="{{ $val->id_prov }}">
                        @if($errors->has('id_prov'))
                            <em class="invalid-feedback">
                                {{ $errors->first('id_prov') }}
                            </em>
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
                        <label for="nama">{{ trans('cruds.member.fields.nama') }}*</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="{{ $val->name }}">
                        @if($errors->has('nama'))
                            <em class="invalid-feedback">
                                {{ $errors->first('nama') }}
                            </em>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <button class="btn btn-primary" id="save" type="submit">
                    <span class="spinner-border spin-save spinner-border-sm" role="status" aria-hidden="true"></span>
                    <i class="fa fa-save"></i> {{ trans('global.save') }}
                </button>
                <a href="{{ route('admin.provinsi.index') }}" class="btn btn-default"> 
                    <i class="fa fa-arrow-left"> {{ trans('global.back_to_list') }}</i>
                </a>
            </div>
        </form>


    </div>
</div>
@endsection