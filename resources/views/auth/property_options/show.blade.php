@extends('auth.layouts.master')

@section('title', 'Вариант свойства ' . $skuOption->name)

@section('content')
    <div class="col-md-12">
        <h1>Вариант свойства {{ $skuOption->name }}</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Поле
                </th>
                <th>
                    Значение
                </th>
            </tr>
            <tr>
                <td>ID</td>
                <td>{{ $skuOption->id }}</td>
            </tr>
            <tr>
                <td>Свойство</td>
                <td>{{ $skuOption->property->name }}</td>
            </tr>
            <tr>
                <td>Название</td>
                <td>{{ $skuOption->name }}</td>
            </tr>
            <tr>
                <td>Название en</td>
                <td>{{ $skuOption->name_en }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
