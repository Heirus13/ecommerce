@foreach ($products as $product)
<div class="col-12 col-md-4 col-lg-3 mb-5 product-item" data-product-name="{{ $product->name }}">
    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid product-thumbnail" alt="{{ $product->name }}">
    <h3 class="product-title">{{ $product->name }}</h3>
    <strong class="product-price">${{ number_format($product->price, 2) }}</strong>
    @if ($product->stock > 0)
        <form id="add-to-cart-form-{{ $product->id }}" action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form mt-auto">
            @csrf
            <input type="hidden" name="name" value="{{ $product->name }}">
            <input type="hidden" name="price" value="{{ $product->price }}">
            <input type="hidden" name="image" value="{{ asset('storage/' . $product->image) }}">
            <button type="button" class="btn btn-primary btn-block add-to-cart-button" data-product-id="{{ $product->id }}">Add to Cart</button>
        </form>
    @else
        <button class="btn btn-secondary btn-block" disabled>Out of Stock</button>
    @endif
</div>
@endforeach