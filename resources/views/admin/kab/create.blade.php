@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.kabupaten.title_singular') }}
    </div>

    <div class="card-body">
        <form class="form-material mt-4" action="{{ route("admin.kabupaten.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('id_prov') ? 'has-error' : '' }}">
                <label for="id_prov">{{ trans('cruds.member.fields.provinsi') }}*</label>
                <select name="id_prov" id="id_prov" class="form-control select2" required style="width: 100%; height:36px;">
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    @foreach($prov as $data => $row)
                        <option value="{{ $data }}" name="{{ $row }}">{{ $row }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_prov'))
                    <em class="invalid-feedback">
                        {{ $errors->first('id_prov') }}
                    </em>
                @endif
            </div>
                
            <div class="row">
                <div class="col">
                    <div class="form-group {{ $errors->has('id_kab') ? 'has-error' : '' }}">
                        <label for="id_kab">Nomor Kabupaten*</label>
                        <input type="text" id="id_kab" name="id_kab" class="form-control" value="{{ old('id_kab', '') }}">
                        @if($errors->has('id_kab'))
                            <em class="invalid-feedback">
                                {{ $errors->first('id_kab') }}
                            </em>
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
                        <label for="nama">{{ trans('cruds.member.fields.nama') }}*</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', '') }}">
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
                <a href="{{ route('admin.program.index') }}" class="btn btn-default"> 
                    <i class="fa fa-arrow-left"> {{ trans('global.back_to_list') }}</i>
                </a>
            </div>
        </form>


    </div>
</div>
@endsection