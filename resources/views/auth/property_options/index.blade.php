@extends('auth.layouts.master')

@section('title', 'Варианты свойств')

@section('content')
    <div class="col-md-12">
        <h1>Варианты свойств</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Свойство
                </th>
                <th>
                    Название
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($skuOptions as $skuOption)
                <tr>
                    <td>{{ $skuOption->id }}</td>
                    <td>{{ $sku->name }}</td>
                    <td>{{ $skuOption->name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('property-options.destroy', [$sku, $skuOption]) }}" method="POST">
                                <a class="btn btn-success" type="button" href="{{ route('property-options.show', [$sku, $skuOption]) }}">Открыть</a>
                                <a class="btn btn-warning" type="button" href="{{ route('property-options.edit', [$sku, $skuOption]) }}">Редактировать</a>
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger" type="submit" value="Удалить"></form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $skuOptions->links() }}
        <a class="btn btn-success" type="button"
           href="{{ route('property-options.create', $sku) }}">Добавить вариант свойства</a>
    </div>
@endsection
