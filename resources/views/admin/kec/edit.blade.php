@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.update') }} {{ trans('cruds.kecamatan.title_singular') }}
    </div>

    <div class="card-body">
        <form class="form-material mt-4" action="{{ route("admin.kecamatan.update",$kec->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            
            <div class="form-group {{ $errors->has('id_kab') ? 'has-error' : '' }}">
                <label for="id_kab">{{ trans('cruds.member.fields.kabupaten') }}*</label>
                <select name="id_kab" id="id_kab" class="form-control select2" required style="width: 100%; height:36px;">
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    @foreach($kab as $data => $row)
                        <option value="{{ $data }}" @if ($kec->id_kab == $data) selected @endif name="{{ $row }}">{{ $row }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_kab'))
                    <em class="invalid-feedback">
                        {{ $errors->first('id_kab') }}
                    </em>
                @endif
            </div>
                
            <div class="row">
                <div class="col">
                    <div class="form-group {{ $errors->has('kecamatan') ? 'has-error' : '' }}">
                        <label for="kecamatan">Nomor Kecamatan*</label>
                        <input type="text" id="id_kec" name="id_kec" class="form-control" value="{{ $kec->id_kec }}">
                        @if($errors->has('kecamatan'))
                            <em class="invalid-feedback">
                                {{ $errors->first('kecamatan') }}
                            </em>
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="form-group {{ $errors->has('kecamatan') ? 'has-error' : '' }}">
                        <label for="kecamatan">{{ trans('cruds.member.fields.kecamatan') }}*</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="{{ $kec->name }}">
                        @if($errors->has('kecamatan'))
                            <em class="invalid-feedback">
                                {{ $errors->first('kecamatan') }}
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
                <a href="{{ route('admin.kecamatan.index') }}" class="btn btn-default"> 
                    <i class="fa fa-arrow-left"> {{ trans('global.back_to_list') }}</i>
                </a>
            </div>
        </form>


    </div>
</div>
@endsection