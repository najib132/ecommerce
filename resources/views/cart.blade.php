@extends('layout')

@section('title', 'Products')

@section('extra-css')
@endsection

@section('content')
 @component('components.breadcrumbs')
        <a href="#">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shopping Cart</span>
    @endcomponent

<div class="cart-section container">
	<div>
		@if(session()->has('success_message'))  
		  <div class="alert alert-success">
		  	{{ session()->get('success_message') }}
		  </div>
		@endif

		@if(count($errors)>0)
		 <div class="alert alert-danger">
		 	<ul>
		 		@foreach($errors->all() as $error )
		 		 <li>{{ $error }}</li>
		 		@endforeach
		 	</ul>
		 </div>
		@endif
	<!----Shopping Cart///////////////////////////////////------>
	@if(Cart::count() > 0)
            <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>
            <div class="cart-table">
            	@foreach(Cart::content() as $item)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{ route('shop.show',$item->model->slug) }}">
                          <img src="{{ asset('storage/'.$item->model->image)}}" alt="product" class="active" >
                        </a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{route('shop.show',$item->model->slug)}}">{{ $item->model->name }}</a></div>
                            <div class="cart-table-description">{{$item->model->details}}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                         <form action="{{ route('cart.destroy',$item->rowId) }}" method="post">
                         	{{ csrf_field() }}
                         	{{ method_field('delete') }}
                           <button type="submit" class="cart-options" >remove</button>
                         </form>
                         <form action="{{ route('cart.switchToSaveForLater',$item->rowId) }}" method="post">
                         	{{ csrf_field() }}
                           <button type="submit" class="cart-options" >Save For Later</button>
                         </form>
                        </div>
                        <div>
                            <select class="quantity" data-id="{{ $item->rowId }}" data-productQuantity="{{ $item->model->quantity }}">
                               @for ($i = 1; $i < 5 + 1 ; $i++)
                                  <option {{ $item->qty == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                  </option>
                                @endfor
                            </select>
                        </div>
                        <div>{{ presentPrice($item->subtotal) }}</div>
                    </div>
                </div> <!-- end cart-table-row -->
                @endforeach

                 @if(! session()->has('coupon'))
                <a href="#" class="have-code">Have a Code?</a>
                <div class="have-code-container">
                    <form action="{{ route('coupon.store') }}" method="POST">
                      {{ csrf_field() }}
                      <input type="text" name="coupon_code" id="coupon_code">
                      <button type="submit" class="button button-plain">Apply</button>
                    </form>
                    <br>
                </div>
                @endif

             <!--   <a href="#" class="have-code">Have a Code?</a>
                <div class="have-code-container">
                    <form action="#" method="POST">
                        <input type="hidden" name="_token" value="">
                        <input type="text" name="coupon_code" id="coupon_code">
                        <button type="submit" class="button button-plain">Apply</button>
                    </form>
                </div>  end have-code-container -->  
            <div class="cart-totals">
                <div class="cart-totals-left">
                    Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like figuring out :).
                </div>
                <div class="cart-totals-right">
                    <div>
                        Subtotal <br>
                         @if(session()->has('coupon'))
                        code({{session()->get('coupon')['name']}}) 
                          <form action="{{ route('coupon.destroy') }}" method="POST" style="display:inline">
                            {{ csrf_field()    }}
                            {{ method_field('delete') }}
                            <button type="submit" style="font-size:14px; display: block">Remove</button>
                          </form>
                          <br>
                          <hr>
                          New Subtotal<br>
                        @endif
                        Tax (13%)<br>
                        <span class="cart-totals-total">Total</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        {{ presentPrice(Cart::subtotal()) }} <br>
                        @if(session()->has('coupon'))
                           -{{ presentPrice($discount) }} <br>
                           <hr>
                           {{ presentPrice($newSubtotal) }} <br>
                        @endif
                        {{ presentPrice($newTax) }} <br>
                        <span class="cart-totals-total">{{ presentPrice($newTotal) }}</span>
                    </div>
                </div>


            </div> <!-- end cart-totals -->
            <div class="cart-buttons">
                <a href="{{route('shop.index')}}" class="button">Continue Shopping</a>
                <a href="{{route('checkout.index')}}" class="button-primary">Proceed to Checkout</a>
            </div>
        </div>
        <!----end Shopping Cart//////////////////////---------->
        <!----No items cart////////////////////////-->
        @else

          <h3>No items in Cart!</h3>
                <div class="spacer"></div>
                <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                <div class="spacer"></div>
        @endif
        <!-----fin no items later---------->
        <!---save later------>
        @if (Cart::instance('saveForLater')->count() > 0)
        <h2>{{ Cart::count() }} item(s) Saved For Later</h2>

            <div class="saved-for-later cart-table">
            	@foreach(Cart::instance('saveForLater')->content() as $item )
                  <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{route('shop.show',$item->model->slug)}}"><img src="{{ asset('img/products/'.$item->model->slug.'.jpg')}}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{route('shop.show',$item->model->slug)}}">{{$item->model->name}}</a></div>
                            <div class="cart-table-description">{{$item->model->presentPrice()}}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                         <form action="{{ route('saveForLater.destroy',$item->rowId) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                           <button type="submit" class="cart-options" >remove</button>
                         </form>
                         <form action="{{ route('saveForLater.switchToCart',$item->rowId) }}" method="post">
                            {{ csrf_field() }}
                           <button type="submit" class="cart-options" >Move to Carte</button>
                         </form>
                            
                        </div>
                        <div>$2479.16</div>
                    </div>
                </div> <!-- end cart-table-row -->
                @endforeach
            </div> <!-- end saved-for-later -->
            @else

            <h3>You have no items Saved for Later.</h3>
            @endif

  </div> <!-- end cart-section -->
</div> <!-- end cart-table -->


@include('partials.might-like')

@endsection

@section('extra-js')
<script src="{{ asset('js/app.js') }}"></script>
<script>

  //document.querySelectorAll(".quantity").forEach(function (element) {console.log(element)}) 
 const classname = document.querySelectorAll('.quantity')
      Array.from(classname).forEach(function(element) {
          element.addEventListener('change', function() {
            const id = element.getAttribute('data-id')
            const productQuantity = element.getAttribute('data-productQuantity')

            axios.patch(`/cart/${id}`, {
                quantity         :this.value,
                productQuantity  : productQuantity
              })
              .then(function (response) {
                window.location.href = '{{ route('cart.index') }}'
              })
              .catch(function (error) {
                console.log(error);
                window.location.href = '{{ route('cart.index') }}'
              });

          })
        })
          
</script>


@endsection

