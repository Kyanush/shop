@php
    //социальные сети
    $sameAs = [];
    $social_network = config('shop.social_network');
    foreach ($social_network as $name => $link)
    {
        $sameAs[] = $link;
    }


    //контакты
    $contactPoint = [];
    $number_phones = config('shop.number_phones');
    foreach ($number_phones as $k => $v)
    {
        $contactPoint[] = [
            "@type"       => "ContactPoint",
            "telephone"   => $v['format'],
            "contactType" => "customer service"
        ];
    }


    //адресы
    $address_data = [];
    $address = config('shop.address');
    foreach ($address as $k => $v)
    {
        $address_data[] = [
            "@type"           => "PostalAddress",
            "streetAddress"   => $v["streetAddress"],
            "addressLocality" => $v["addressLocality"],
            "postalCode"      => $v["postalCode"],
            "addressCountry"  => $v["addressCountry"]
        ];
    }

    //seo
    $seo = \App\Tools\Seo::main();


    $schema = [
       "@context"     => "https://schema.org",
       "@type"        => "Organization",
       "name"         => $seo["title"],
       "description"  => $seo["description"],
       "url"          => env('APP_URL'),
       "logo"         => config('shop.logo'),
       "image"        => config('shop.logo'),
       "telephone"    => $number_phones[0]['format'],
       "contactPoint" => $contactPoint,
       "sameAs"       => $sameAs,
       "address"      => $address_data
    ];

@endphp

<script type="application/ld+json">
    <?php echo json_encode($schema);?>
</script>

@if(false)
<div style="display: none;">
    <div itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name"        content="{{ $seo["title"] }}"/>
        <meta itemprop="description" content="{{ $seo["description"] }}"/>
        <link itemprop="url"         href="{{ env('APP_URL') }}"/>
        <link itemprop="logo"        href="{{ config('shop.logo') }}" />
        <link itemprop="image"       href="{{ config('shop.logo') }}" />
        <meta itemprop="telephone"   content="{{ $number_phones[0]['format'] }}"/>

        @foreach ($number_phones as $k => $v)
            <div itemprop="contactPoint" itemtype="https://schema.org/ContactPoint" itemscope>
                <meta itemprop="contactType" content="customer service" />
                <meta itemprop="telephone"   content="{{ $v['format'] }}" />
            </div>
        @endforeach

        @foreach ($social_network as $name => $link)
            <link itemprop="sameAs"       href="{{ $link }}" />
        @endforeach

        @foreach ($address as $k => $v)
            <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress"   content="{{ $v["streetAddress"] }}"/>
                <meta itemprop="addressLocality" content="{{ $v["addressLocality"] }}"/>
                <meta itemprop="postalCode"      content="{{ $v["postalCode"] }}"/>
                <meta itemprop="addressCountry"  content="{{ $v["addressCountry"]}}"/>
            </div>
        @endforeach

    </div>
</div>
@endif