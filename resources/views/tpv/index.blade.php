@extends('layouts.tpv')

@section('content')

@php
    $perpage = 55;
@endphp

<div class="container tpv">
    <div class="products">
        <div class="pages">
            @for ($i = 0, $n = sizeof($products); $i < $n; $i++)
                @if ($i % $perpage == 0)
                    <div class="page {{ $i == 0 ? 'active' : '' }}">
                @endif
                <a class="product" href="#" data-id="{{ $products[$i]->id }}" data-price="{{ $products[$i]->price }}" data-code="{{ $products[$i]->codtpv }}" style="background-color:{{ $products[$i]->color }}">{{ $products[$i]->name }}</a>
                @if ($i % $perpage == $perpage - 1)
                    </div>
                @endif
            @endfor
            @if ($i % $perpage != $perpage - 1)
                </div>
            @endif
        </div>
        <!-- <nav>
            <a class="next {{ $n <= $perpage ? 'disabled' : '' }}" href="#">siguiente</a>
            <a class="prev disabled" href="#">anterior</a>
        </nav> -->
    </div>
    <div class="shopping-list">
        <div class="footer">
            <div class="total_price">0€</div>
            <div>TOTAL:</div>
        </div>
        <div class="header">
            <div style="display:none;">Código</div>
            <div>Producto</div>
            <div style="display:none;">Precio</div>
            <div>Dto.</div>
            <div>Uds.</div>
            <div>Total</div>
        </div>
        <div class="body"></div>
        <div class="actions">
            <a href="#" class="add" title="Añadir 1">Añadir 1</a>
            <a href="#" class="remove" title="Quitar 1">Quitar 1</a>
            <a href="#" class="delete" title="Eliminar">Eliminar</a>
            <a href="#" class="discount" title="Modificar descuento">Modificar descuento</a>
        </div>
    </div>
</div>

<div class="buttons-tpv">
    <div class="ean">
        <form id="search">
            <input type="text" name="ean" placeholder="Referencia o código de barras">
            <button type="submit">Buscar</button>
        </form>
    </div>
    <a href="#" class="park">Aparcar</a>
    <a href="#" class="cancel">Cancelar</a>
    <a href="#" class="charge">Cobrar</a>
</div>

@include('tpv.partials.keyboard')
@include('tpv.partials.price')
@include('tpv.partials.discount')
@include('tpv.partials.charge')

@endsection

@section('scripts')
@parent

<script>
    $(function() {
        $(document).on('click', '.products .next:not(.disabled)', function(e) {
            e.preventDefault();
            $next = $('.page.active').next('.page');
            $('.page.active').removeClass('active');
            $next.addClass('active');
            $('.products .prev').removeClass('disabled');
            if ($next.index() >= $('.pages').children().length - 1) {
                $(this).addClass('disabled');
            }
        });

        $(document).on('click', '.products .prev:not(.disabled)', function(e) {
            e.preventDefault();
            $prev = $('.page.active').prev('.page');
            $('.page.active').removeClass('active');
            $prev.addClass('active');
            $('.products .next').removeClass('disabled');
            if ($prev.index() <= 0) {
                $(this).addClass('disabled');
            }
        });

        $(document).on('click', '.visits .next.disabled, .visits .prev.disabled', function(e) {
            e.preventDefault();
        });

        $('.product').click(function(e) {
            e.preventDefault();
            prev = $('.shopping-list .body').find('.item[data-id="' + $(this).attr('data-id') + '"]');
            if (prev.length > 0) {
                amountTd = prev.find('div:nth-child(5)');
                units = parseInt(amountTd.html());
                amountTd.html(++units);
                calculateRowTotal(prev);
            } else {
                item = $('<div class="item" data-id="' + $(this).attr('data-id') + '"/>');
                item.append($('<div style="display:none;">' + $(this).attr('data-code') + '</div>'));
                item.append($('<div>' + $(this).html() + '</div>'));
                item.append($('<div style="display:none;">' + $(this).attr('data-price') + '€</div>'));
                @if (Session::get('type') == 1)
                item.append($('<div>30%</div>'));
                @elseif (Session::get('type') == 2)
                item.append($('<div>10%</div>'));
                @else
                item.append($('<div>0%</div>'));
                @endif
                item.append($('<div>1</div>'));
                item.append($('<div>' + $(this).attr('data-price') + '€</div>'));
                $('.shopping-list .body').append(item);
                calculateRowTotal(item);
                equalHeight(item);
            }
            updateTotalPrice();
        });

        $(document).on('click', '.shopping-list .item', function(e) {
            e.preventDefault();
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                $('.shopping-list .item').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('.shopping-list .actions .add').click(function(e) {
            e.preventDefault();
            amountTd = $('.shopping-list .item.selected').find('div:nth-child(5)');
            units = parseInt(amountTd.html()) + 1;
            amountTd.html(units);
            calculateRowTotal($('.shopping-list .item.selected'));
            updateTotalPrice();
        });

        $('.shopping-list .actions .remove').click(function(e) {
            e.preventDefault();
            amountTd = $('.shopping-list .item.selected').find('div:nth-child(5)');
            units = parseInt(amountTd.html()) - 1;
            if (units <= 0) {
                $('.shopping-list .item.selected').remove();
            } else {
                amountTd.html(units);
                calculateRowTotal($('.shopping-list .item.selected'));
            }
            updateTotalPrice();
        });

        $('.shopping-list .actions .delete').click(function(e) {
            e.preventDefault();
            $('.shopping-list .item.selected').remove();
            updateTotalPrice();
        });

        $('.shopping-list .actions .discount').click(function(e) {
            e.preventDefault();
            $('.overlay-wrapper.discount').show('fade');
        });

        $('.buttons-tpv .park').click(function(e) {
            e.preventDefault();
            total = parseFloat($('.total_price').html());
            products = new Array();
            i = 0;
            $('.item').each(function() {
                id = $(this).attr('data-id');
                priceTd = $(this).find('div:nth-child(3)');
                discountTd = $(this).find('div:nth-child(4)');
                amountTd = $(this).find('div:nth-child(5)');
                price = parseFloat(priceTd.html());
                discount = parseInt(discountTd.html());
                amount = parseInt(amountTd.html());
                products[i] = [id, price, amount, discount];
                i++;
            });
            $.get("{{ route('tpv.aparcar-venta') }}", { total: total, products: products }, function(data) {
                location.reload();
            });
        });

        $('.buttons-tpv .charge').click(function(e) {
            e.preventDefault();
            total = parseFloat($('.total_price').html()).toFixed(2);
            $('.charge-sale .total span').html(total + '€');
            $('.charge-sale').show('fade');
        });

        $('.buttons-tpv .cancel').click(function(e) {
            e.preventDefault();
            @if ($sale)
            $.get("{{ route('tpv.cancelar-venta', $sale->id) }}", {}, function(data) {
                location.reload();
            });
            @else
            $.get("{{ route('tpv.cancelar-venta') }}", {}, function(data) {
                location.reload();
            });
            @endif
        });

        $('#search').submit(function(e) {
            e.preventDefault();

            $.get("{{ route('tpv.buscar-producto') }}", { code: $(this).find('input').val() }, function(data) {
                if (data.length) {
                    $('.product[data-id=' + data + ']').trigger('click');
                }
            });
        });

        @if ($sale && sizeof($sale->products))
        @foreach ($sale->products as $product)
        @for ($i = 0, $n = $product->pivot->amount; $i < $n; $i++)
        $('.product[data-id=' + "{{ $product->id }}" + ']').trigger('click');
        @endfor
        @if ($product->pivot->discount)
        $('.shopping-list .item[data-id=' + "{{ $product->id }}" + ']').find('div:nth-child(4)').html('{{ $product->pivot->discount }}' + '%');
        calculateRowTotal($('.shopping-list .item[data-id=' + "{{ $product->id }}" + ']'));
        updateTotalPrice();
        @endif
        @endforeach
        @endif
    });

    updateTotalPrice = function() {
        $('.total_price').html(calculateTotalPrice() + '€');
    };

    calculateRowTotal = function(item) {
        priceTd = item.find('div:nth-child(3)');
        discountTd = item.find('div:nth-child(4)');
        amountTd = item.find('div:nth-child(5)');
        totalTd = item.find('div:nth-child(6)');
        price = parseFloat(priceTd.html());
        discount = parseInt(discountTd.html());
        amount = parseInt(amountTd.html());
        total = (price * amount * (100 - discount) / 100).toFixed(2);
        totalTd.html(total + '€');
    };

    calculateTotalPrice = function() {
        total = 0;
        $('.shopping-list .body .item').each(function() {
            totalTd = $(this).find('div:nth-child(6)');
            total += parseFloat(totalTd.html());
        });
        return total.toFixed(2);
    };

    equalHeight = function(elem) {
        maxHeight = 0;
        elem.find('div').each(function() {
            if ($(this).outerHeight() > maxHeight) {
                maxHeight = $(this).outerHeight();
            }
        });
        elem.find('div').each(function() {
            $(this).css('height', maxHeight + 'px');
        });
    }
</script>

@endsection
