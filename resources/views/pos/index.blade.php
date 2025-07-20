<!-- resources/views/pos/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Product Selection -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Scan barcode..." id="barcode-scanner">
                        <button class="btn btn-primary" id="scan-btn">Scan</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" id="product-grid">
                        @foreach($products as $product)
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-primary w-100 product-btn"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}"
                                    data-barcode="{{ $product->barcode }}">
                                {{ $product->name }}<br>
                                ${{ number_format($product->price, 2) }}<br>
                                <small>{{ $product->barcode }}</small>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Current Sale</h4>
                    <span class="badge bg-primary" id="cart-count">{{ array_sum(array_column($cart, 'qty')) }}</span>
                </div>
                <div class="card-body">
                    <div id="cart-items">
                        @foreach($cart as $item)
                        <div class="cart-item mb-2 border-bottom pb-2" data-rowid="{{ $item['rowId'] }}">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $item['name'] }}</strong>
                                <button class="btn btn-sm btn-danger remove-item">×</button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <input type="number" value="{{ $item['qty'] }}" 
                                       class="form-control form-control-sm qty-input" 
                                       style="width: 60px;">
                                <span>${{ number_format($item['price'], 2) }}</span>
                                <span>${{ number_format($item['subtotal'], 2) }}</span>
                            </div>
                            @if(!empty($item['options']))
                            <div class="text-muted small">
                                @foreach($item['options'] as $key => $value)
                                {{ $key }}: {{ $value }}@if(!$loop->last), @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between">
                            <strong>Subtotal:</strong>
                            <span id="cart-subtotal">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Tax:</strong>
                            <span id="cart-tax">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Discount:</strong>
                            <span id="cart-discount">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <span id="cart-total">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button id="clear-cart" class="btn btn-danger">Clear Cart</button>
                        <button id="checkout-btn" class="btn btn-success float-end">Complete Sale ($<span id="checkout-total">{{ number_format($total, 2) }}</span>)</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Add to cart
    $('.product-btn').click(function() {
        const product = {
            id: $(this).data('id'),
            name: $(this).data('name'),
            price: $(this).data('price'),
            barcode: $(this).data('barcode')
        };

        $.post("{{ route('pos.add-to-cart') }}", {
            _token: "{{ csrf_token() }}",
            product_id: product.id,
            quantity: 1,
            options: { barcode: product.barcode }
        }, function(response) {
            updateCartDisplay(response);
        });
    });

    // Barcode scanning
    $('#barcode-scanner').keypress(function(e) {
        if (e.which === 13) {
            const barcode = $(this).val();
            const product = $('.product-btn[data-barcode="' + barcode + '"]');
            
            if (product.length) {
                product.click();
                $(this).val('').focus();
            } else {
                alert('Product not found!');
            }
        }
    });

    // Update quantity
    $(document).on('change', '.qty-input', function() {
        const rowId = $(this).closest('.cart-item').data('rowid');
        const qty = $(this).val();
        
        $.ajax({
            url: "{{ route('pos.update-cart', '') }}/" + rowId,
            method: 'PATCH',
            data: {
                _token: "{{ csrf_token() }}",
                quantity: qty
            },
            success: function(response) {
                updateCartDisplay(response);
            }
        });
    });

    // Remove item
    $(document).on('click', '.remove-item', function() {
        const rowId = $(this).closest('.cart-item').data('rowid');
        
        $.ajax({
            url: "{{ route('pos.remove-from-cart', '') }}/" + rowId,
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                updateCartDisplay(response);
            }
        });
    });

    // Clear cart
    $('#clear-cart').click(function() {
        if (confirm('Clear the entire cart?')) {
            $.ajax({
                url: "{{ route('pos.clear-cart') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    location.reload();
                }
            });
        }
    });

    // Checkout
    $('#checkout-btn').click(function() {
        // Implement your checkout logic here
        alert('Checkout functionality would go here!');
    });

    // Update cart display
    function updateCartDisplay(data) {
        $('#cart-count').text(data.count);
        $('#cart-subtotal').text('$' + data.total.toFixed(2));
        $('#cart-total').text('$' + data.total.toFixed(2));
        $('#checkout-total').text(data.total.toFixed(2));
        
        // For a more dynamic update, you would refresh the cart items section
        // This example keeps it simple with a page reload
        if (data.cart) {
            location.reload();
        }
    }
});
</script>
@endpush