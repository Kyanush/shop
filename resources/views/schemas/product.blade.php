@php

$images[] = env('APP_URL') . $product->pathPhoto(true);

if($product->images)
    foreach($product->images as $image)
        $images[] = env('APP_URL') . $image->imagePath(true);


$schema = [
    "@context"    =>  "https://schema.org",
    "@type"       =>  "Product",
    "description" =>  $description_mini,
    "name"        =>  $product->name,
    "sku"         =>  $product->sku,
    "url"         =>  env('APP_URL') . $product->detailUrlProduct(),
    "category"    =>  $category->name,
    "brand"       =>  $category->name,
    "image"       =>  $images,
    //"manufacturer": "HTC",
    //"model":        "Товар 1",
    //"gtin12":       "upc",
    //"gtin8":        "ean",
    "productID"   => $product->id,
];




if(intval($product->avgRating->avg_rating ?? 0) > 0 and $product->reviews_count > 0)
{
    $schema['aggregateRating'] = [
        "@type"       => "AggregateRating",
        "ratingValue" => intval($product->avgRating->avg_rating ?? 0),
        "reviewCount" => $product->reviews_count
    ];
}



$schema['offers'] = [
    "@type"         => "Offer",
    "url"           => env('APP_URL') . $product->detailUrlProduct(),
    "price"         => $product->getReducedPrice(),
    "priceCurrency" => "KZT"
];
if($product->stock > 0)
    $schema['offers']['availability'] = "https://schema.org/InStock";



$reviews = $product->reviews;
if($reviews)
{
    foreach($reviews as $key => $review)
    {
        $schema['review'][] = [
            "@type"          => "Review",
            "author"         => $review->name,
            "datePublished"  => date('Y-m-d', strtotime($review->created_at)),
            "description"    => $review->comment,
            "reviewRating"   => [
                "@type"       => "Rating",
                "bestRating"  => 5,
                "worstRating" => 1,
                "ratingValue" => $review->rating
            ]
        ];
    }
}


if($group_products)
{
    foreach($group_products as $gp_key => $group_product)
    {
        $schema['isRelatedTo'][] = [
            "@type"       => "Product",
            "image"       => env('APP_URL') . $group_product->pathPhoto(true),
            "url"         => env('APP_URL') . $group_product->detailUrlProduct(),
            "name"        => $group_product->name,
            "description" => $group_product->description_mini,
            "offers"      => [
                "@type"         => "Offer",
                "price"         => $group_product->getReducedPrice(),
                "priceCurrency" => "KZT"
            ]
        ];
    }
}

@endphp

@section('schemas_product')
    <script type="application/ld+json">
        <?php echo json_encode($schema);?>
    </script>
@stop


@if(false)
<div style="display:none">
    <div itemtype="https://schema.org/Product" itemscope>
        <meta itemprop="name"        content="{{ $product->name }}"/>
        <meta itemprop="sku"         content="{{ $product->sku }}"/>
        <meta itemprop="url"         content="{{ env('APP_URL') . $product->detailUrlProduct() }}" />
        <meta itemprop="category"    content="{{ $category->name }}"/>
        <meta itemprop="brand"       content="{{ $category->name }}"/>
        <meta itemprop="description" content="{{ $description_mini }}"/>
        <meta itemprop="productID"   content="{{ $product->id }}"/>

        <link itemprop="image" href="{{ env('APP_URL') . $product->pathPhoto(true) }}" />
        @foreach($product->images as $image)
            <link itemprop="image" href="{{ env('APP_URL') . $image->imagePath(true) }}" />
        @endforeach


        <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
            <link itemprop="url" href="{{ env('APP_URL') . $product->detailUrlProduct() }}" />
            @if($product->stock > 0)
               <meta itemprop="availability" content="https://schema.org/InStock" />
            @endif
            <meta itemprop="priceCurrency" content="KZT" />
            <meta itemprop="price" content="{{ $product->getReducedPrice() }}" />

            @if(false)
                <meta itemprop="itemCondition" content="https://schema.org/UsedCondition" />
                <meta itemprop="priceValidUntil" content="2020-11-05" />
                <div itemprop="seller" itemtype="https://schema.org/Organization" itemscope>
                    <meta itemprop="name" content="Executive Objects" />
                </div>
            @endif
        </div>

        @if(intval($product->avgRating->avg_rating ?? 0) > 0 and $product->reviews_count > 0)
            <div itemprop="aggregateRating" itemtype="https://schema.org/AggregateRating" itemscope>
                <meta itemprop="reviewCount" content="{{ intval($product->avgRating->avg_rating ?? 0) }}" />
                <meta itemprop="ratingValue" content="{{ $product->reviews_count }}" />
            </div>
        @endif

        <?php
        $reviews = $product->reviews;
        if($reviews)
        {
            foreach($reviews as $key => $review)
            {?>
                <div itemprop="review" itemtype="https://schema.org/Review" itemscope>
                    <div itemprop="author" itemtype="https://schema.org/Person" itemscope>
                        <meta itemprop="name" content="{{ $review->name }}"/>
                    </div>
                    <meta itemprop="datePublished" content="{{ date('Y-m-d', strtotime($review->created_at)) }}"/>
                    <meta itemprop="description"   content="{{ $review->comment }}"/>
                    <div itemprop="reviewRating" itemtype="https://schema.org/Rating" itemscope>
                        <meta itemprop="bestRating"  content="5" />
                        <meta itemprop="worstRating" content="1" />
                        <meta itemprop="ratingValue" content="{{ $review->rating}}" />
                    </div>
                </div>
            <?}
        }
        ?>

        <?php
        if($group_products)
        {
            foreach($group_products as $gp_key => $group_product)
            {?>
                <div itemprop="isRelatedTo" itemscope itemtype="https://schema.org/Product">
                    <meta itemprop="name"        content="{{ $group_product->name }}"/>
                    <meta itemprop="description" content="{{ $group_product->description_mini }}"/>
                    <link itemprop="url"         href="{{ env('APP_URL') . $group_product->detailUrlProduct() }}"/>
                    <link itemprop="image"       href="{{ env('APP_URL') . $group_product->pathPhoto(true) }}"/>
                    <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="{{ $group_product->getReducedPrice() }}"/>
                        <meta itemprop="price" content="122.00"/>
                    </div>
                </div>
            <?}
        }
        ?>

    </div>
</div>
@endif