@extends('auth.layouts.master')

@isset($category)
    @section('title', 'Редактировать категорию ' . $category->name)
@else
    @section('title', 'Создать категорию')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($category)
            <h1>Редактировать Категорию <b>{{ $category->name }}</b></h1>
        @else
            <h1>Добавить Категорию</h1>
        @endisset

        <form method="POST" enctype="multipart/form-data"
              @isset($category)
                  action="{{ route('categories.update', $category) }}"
              @else
                  action="{{ route('categories.store') }}"
            @endisset
        >
            @isset($category)
                @method('PUT')
            @endisset
            @csrf
            <div class="form-group row">
                <label for="code" class="col-sm-2 col-form-label">Код: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="code" id="code" value="{{ $category->code ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Название: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" value="{{ $category->name ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                <div class="col-sm-10">
                    <textarea name="description" id="description" class="form-control" cols="30"
                              rows="5">{{ $category->description ?? '' }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                <div class="col-sm-10">
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
