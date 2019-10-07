@php

    $images = '';
    $images.= '"' . env('APP_URL') . $product->pathPhoto(true) . '",';

    if($product->images)
        foreach($product->images as $image)
            $images.= '"' . env('APP_URL') . $image->imagePath(true) . '",';
    $images = mb_substr($images, 0, -1);



    $description_mini = '';

    foreach($product->attributes as $attribute)
        if(!in_array($attribute->id, [49, 61, 62]) and $attribute->pivot->value)
                $description_mini.= $attribute->name . ': ' . $attribute->pivot->value . ',';

    if($product->description_mini)
         $description_mini.= $product->description_mini;
    else
         $description_mini = mb_substr($description_mini, 0, -1);

@endphp

@section('schemas_product')
<script type="application/ld+json">
{
    "@context"    :  "https://schema.org",
    "@type"       :  "Product",
    "description" :  "{{ strip_tags($description_mini) }}",
    "name"        :  "{{ $product->name }}",
    "sku"         :  "{{ $product->sku }}",
    "url"         :  "{{ $product->detailUrlProduct() }}",
    "category"    :  "{{ $category->name }}",
    "brand"       :  "{{ $category->name }}",
    "productID"   :  "{{ $product->id }}",
    "image"       :  [ {!! $images !!} ],

    @if(intval($product->avgRating[0]->avg_rating ?? 0) > 0 and $product->reviews_count > 0)
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ intval($product->avgRating[0]->avg_rating ?? 0) }}",
        "reviewCount": "{{ $product->reviews_count }}"
    },
    @endif

    "offers": {
        "@type"         : "Offer",
        "url"           : "{{ $product->detailUrlProduct() }}",
        "price"         : "{{ $product->getReducedPrice() }}",
        "priceCurrency" : "KZT",

        @php
        $specificPrice = $product->specificPrice(function ($query){
                                      $query->DateActive();
                                 })
                                 ->first();
        @endphp
        @if($specificPrice)
            @if($specificPrice->expiration_date)
                "priceValidUntil": "{{ date('Y-m-d', strtotime($specificPrice->expiration_date)) }}",
            @endif
        @endif

        @if($product->stock > 0)
            "availability" : "https://schema.org/InStock",
            "itemCondition": "http://schema.org/NewCondition"
        @else
            "availability" : "https://schema.org/OutOfStock"
        @endif
   },

@php $reviews = $product->reviews; @endphp
    @if($reviews)
        "review": [
            @foreach($reviews as $key => $review)
            {
                "@type": "Review",
                "author": "{{ $review->name }}",
                "datePublished": "{{ date('Y-m-d', strtotime($review->created_at)) }}",
                "description": "{{ strip_tags($review->comment) }}",
                "reviewRating": {
                    "@type": "Rating",
                    "bestRating": "5",
                    "worstRating": "1",
                    "ratingValue": "{{ $review->rating }}"
                }
            }<?=(count($reviews) > $key + 1) ? ',' : '';?>
            @endforeach
        ],
    @endif

    @if($group_products)
        "isRelatedTo": [
            @foreach($group_products as $gp_key => $group_product)
                {
                       "@type"        : "Product",
                        "image"       : "{{ env('APP_URL') . $group_product->pathPhoto(true) }}",
                        "url"         : "{{ $group_product->detailUrlProduct() }}",
                        "name"        : "{{ $group_product->name }}",
                        "description" : "{{ strip_tags($group_product->description_mini) }}",
                        "offers"      : {
                            "@type": "Offer",
                            "price": "{{ $group_product->getReducedPrice() }}",
                            "priceCurrency": "KZT"
                        }
                }<?=(count($group_products) > $gp_key + 1) ? ',' : '';?>
            @endforeach
        ]
    @endif

}
</script>
@stop
