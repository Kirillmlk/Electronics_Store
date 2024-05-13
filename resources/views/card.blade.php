<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <img src="{{ Vite::asset('resources/images/png-iphone-x.png') }}" alt="iPhone X 64GB">
        <div class="caption">
            <h3>iPhone X 64GB</h3>
            <p>71990 руб.</p>
            <p>
                <a href="{{ route('basket') }}" class="btn btn-primary"
                   role="button">В корзину</a>
                @isset($category)
                {{ $category->name }}
                @endisset
                <a href="http://laravel-diplom-1.rdavydov.ru/mobiles/iphone_x_64" class="btn btn-default"
                   role="button">Подробнее</a>
            </p>
        </div>
    </div>
</div>
