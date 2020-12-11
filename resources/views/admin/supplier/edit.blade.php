@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.update') }} {{ trans('cruds.suppliers.title_singular') }}
    </div>

    <div class="card-body">
        <form class="form-material mt-4" action="{{ route("admin.supplier.update",$supplier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
                <label for="nama">{{ trans('cruds.suppliers.fields.nama') }}*</label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $supplier->nama) }}">
                @if($errors->has('nama'))
                    <em class="invalid-feedback">
                        {{ $errors->first('nama') }}
                    </em>
                @endif
                <p class="helper-block">

                </p>
            </div>
            <div class="form-group {{ $errors->has('no_telp') ? 'has-error' : '' }}">
                <label for="no_telp">{{ trans('cruds.suppliers.fields.no_telp') }}*</label>
                <input type="text" onkeypress="return isNumber(event)" id="no_telp" name="no_telp" class="form-control" value="{{ old('no_telp', $supplier->no_telp) }}">
                @if($errors->has('no_telp'))
                    <em class="invalid-feedback">
                        {{ $errors->first('no_telp') }}
                    </em>
                @endif
                <p class="helper-block">

                </p>
            </div>
            <div class="form-group {{ $errors->has('no_hp') ? 'has-error' : '' }}">
                <label for="no_hp">{{ trans('cruds.suppliers.fields.no_hp') }}*</label>
                <input type="text" onkeypress="return isNumber(event)" id="no_hp" name="no_hp" class="form-control" value="{{ old('no_hp', $supplier->no_hp) }}">
                @if($errors->has('no_hp'))
                    <em class="invalid-feedback">
                        {{ $errors->first('no_hp') }}
                    </em>
                @endif
                <p class="helper-block">

                </p>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('cruds.suppliers.fields.email') }}*</label>
                <input type="text" id="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
                <p class="helper-block">

                </p>
            </div>
            <div class="form-group {{ $errors->has('pic') ? 'has-error' : '' }}">
                <label for="pic">{{ trans('cruds.suppliers.fields.pic') }}*</label>
                <input type="text" id="pic" name="pic" class="form-control" value="{{ old('pic', $supplier->pic) }}">
                @if($errors->has('pic'))
                    <em class="invalid-feedback">
                        {{ $errors->first('pic') }}
                    </em>
                @endif
                <p class="helper-block">

                </p>
            </div>
            <div class="form-group {{ $errors->has('no_rekening') ? 'has-error' : '' }}">
                <label for="no_rekening">{{ trans('cruds.suppliers.fields.no_rekening') }}*</label>
                <input type="text" id="no_rekening" name="no_rekening" class="form-control" value="{{ old('no_rekening', $supplier->no_rekening) }}">
                @if($errors->has('no_rekening'))
                    <em class="invalid-feedback">
                        {{ $errors->first('no_rekening') }}
                    </em>
                @endif
                <p class="helper-block">

                </p>
            </div>
            <div class="form-group {{ $errors->has('ppn') ? 'has-error' : '' }}">
                {{ trans('cruds.suppliers.fields.ppn') }}
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ppn" @if($supplier->ppn == \App\MstSupplier::YesPpn) checked @endif id="inlineRadio1" value="{{ \App\MstSupplier::YesPpn }}">
                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ppn" @if($supplier->ppn == \App\MstSupplier::NoPpn) checked @endif id="inlineRadio2" value="{{ \App\MstSupplier::NoPpn }}">
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
                 @if($errors->has('ppn'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ppn') }}
                    </em>
                @endif
                <p class="helper-block">

                </p>
            </div>
            <div class="form-group {{ $errors->has('alamat') ? 'has-error' : '' }}">
                <label for="alamat">{{ trans('cruds.suppliers.fields.alamat') }}*</label>
                <input type="text" id="alamat" name="alamat" class="form-control" value="{{ old('alamat', $supplier->alamat) }}">
                @if($errors->has('alamat'))
                    <em class="invalid-feedback">
                        {{ $errors->first('alamat') }}
                    </em>
                @endif
                <p class="helper-block">

                </p>
            </div>
            <div>
                <button class="btn btn-primary" id="save" type="submit">
                    <span class="spinner-border spin-save spinner-border-sm" role="status" aria-hidden="true"></span>
                    <i class="fa fa-save"></i> {{ trans('global.update') }}
                </button>
                <a href="{{ route('admin.supplier.index') }}" class="btn btn-default"> 
                    <i class="fa fa-arrow-left"> {{ trans('global.back_to_list') }}</i>
                </a>
            </div>
        </form>


    </div>
</div>
@endsection