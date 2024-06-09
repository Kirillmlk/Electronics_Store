@extends('auth.layouts.master')

@isset($skuOption)
    @section('title', 'Редактировать вариант свойства ' . $skuOption->name)
@else
    @section('title', 'Создать вариант свойства')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($skuOption)
            <h1>Редактировать вариант свойства <b>{{ $skuOption->name }}</b></h1>
        @else
            <h1>Добавить вариант свойства</h1>
        @endisset

        <form method="POST" enctype="multipart/form-data"
              @isset($skuOption)
                  action="{{ route('property-options.update', [$sku, $skuOption]) }}"
              @else
                  action="{{ route('property-options.store', $sku) }}"
            @endisset
        >
            <div>
                @isset($skuOption)
                    @method('PUT')
                @endisset
                @csrf
                <div>
                    <h2>Свойство {{ $sku->name }}</h2>
                </div>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" name="name" id="name"
                               value="@isset($skuOption){{ $skuOption->name }}@endisset">
                    </div>
                </div>

                <br>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название en: </label>
                    <div class="col-sm-6">
                        @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" name="name_en" id="name_en"
                               value="@isset($skuOption){{ $skuOption->name_en }}@endisset">
                    </div>
                </div>

                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
