<div class="mini-cart-info">
   <table>
      <tbody>
         @foreach($cartProductsList as $cart_product)
               <tr>
                  <td class="image">
                     <a href="{{ $cart_product->product->detailUrlProduct() }}">
                        <img src="{{ $cart_product->product->pathPhoto(true) }}"
                             alt="{{ $cart_product->name }}" title="{{ $cart_product->name }}"></a>
                  </td>
                  <td class="name">
                     <a href="{{ $cart_product->product->detailUrlProduct() }}">
                        {{ $cart_product->product->name }}
                     </a>
                     <div></div>
                  </td>
                  <td class="quantity">x&nbsp;{{ $cart_product->quantity }}</td>
                  <td class="total">{{ \App\Tools\Helpers::priceFormat($cart_product->product->price) }}.</td>
                  <td class="remove" onclick="headerCartProductDelete(this)" product_id="{{ $cart_product->product_id }}">
                     <img src="/site/images/remove-small.png" alt="Удалить" title="Удалить">
                  </td>
               </tr>
         @endforeach
      </tbody>
   </table>
</div>
<div class="mini-cart-bottom">
   <div class="mini-cart-total">
      <b>Итого:</b>{{ $total['sum'] }}.
      <div class="mini-cart-shipping">(Без учета стоимости доставки)</div>
   </div>
   <div class="checkout">
      <a href="/checkout">
         <span>Оформление заказа</span>
      </a>
   </div>
</div>