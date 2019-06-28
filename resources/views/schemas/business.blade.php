@php
//online generate
//https://microdatagenerator.org/localbusiness-microdata-generator/

$seoMain = \App\Tools\Seo::main();
$address = config('shop.address');
$number_phones = config('shop.number_phones');

$schema = [
   "@context"    => "https://schema.org",
	"@type"      => "Store",
	"name"       => $seoMain['title'],
	"image"      => config('shop.logo'),
	"email"      => config('shop.site_email'),
	"telePhone"  => $number_phones[0]['format'],
	"url"        => env('APP_URL'),
	"priceRange" => "$",

    "address" => [
		"@type"           => "PostalAddress",
		"streetAddress"   => $address[0]['streetAddress'],
		"addressLocality" => $address[0]['addressLocality'],
		"addressRegion"   => "KZT",
		"postalCode"      => $address[0]['postalCode']
	],
	"geo" => [
		"@type"     => "GeoCoordinates",
		"latitude"  => $address[0]['geo']['latitude'],
		"longitude" => $address[0]['geo']['longitude']
	],
	"paymentAccepted" => [
	    "cash",
	    "credit card",
	    "invoice"
	],
	"openingHours"    => "Mo,Tu,We,Th,Fr,Sa,Su 10:00-19:00",
	"openingHoursSpecification" => [
	    [
            "@type" => "OpeningHoursSpecification",
            "dayOfWeek" => [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
                "Sunday"
            ],
            "opens"  => "10:00",
            "closes" => "19:00"
	    ]
	]
];
@endphp


<script type="application/ld+json">
    <?php echo json_encode($schema);?>
</script>

@if(false):
<div style="display: none">
    <div itemscope itemtype="https://schema.org/Store">
        <meta itemprop="name"        content="{{ $seoMain['title'] }}"/>
        <meta itemprop="image"       content="{{ config('shop.logo') }}"/>
        <meta itemprop="email"       content="{{ config('shop.site_email') }}"/>
        <meta itemprop="telePhone"   content="{{ $number_phones[0]['format'] }}"/>
        <link itemprop="url"         href="{{ env('APP_URL') }}" />
        <meta itemprop="priceRange"  content="$"/>
        <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
            <meta itemprop="streetAddress"   content="{{ $address[0]['streetAddress'] }}"/>
            <meta itemprop="addressLocality" content="{{ $address[0]['addressLocality'] }}"/>
            <meta itemprop="addressRegion"   content="KZT"/>
            <meta itemprop="postalCode"      content="{{ $address[0]['postalCode'] }}"/>
        </div>
        <div itemprop="geo" itemscope itemtype="https://schema.org/GeoCoordinates">
            <meta itemprop="latitude"   content="{{ $address[0]['geo']['latitude'] }}"/>
            <meta itemprop="longitude"  content="{{ $address[0]['geo']['longitude'] }}"/>
        </div>
        <meta itemprop="paymentAccepted"       content="cash"/>
        <meta itemprop="paymentAccepted"       content="credit card"/>
        <meta itemprop="paymentAccepted"       content="invoice"/>
        <meta itemprop="openingHours"          content="Mo,Tu,We,Th,Fr,Sa,Su 10:00-19:00"/>
        <div itemprop="openingHoursSpecification" itemscope itemtype="https://schema.org/OpeningHoursSpecification">
            <meta itemprop="dayOfWeek"       content="Monday"/>
            <meta itemprop="dayOfWeek"       content="Tuesday"/>
            <meta itemprop="dayOfWeek"       content="Wednesday"/>
            <meta itemprop="dayOfWeek"       content="Thursday"/>
            <meta itemprop="dayOfWeek"       content="Friday"/>
            <meta itemprop="dayOfWeek"       content="Saturday"/>
            <meta itemprop="dayOfWeek"       content="Sunday"/>
            <meta itemprop="opens"           content="10:00"/>
            <meta itemprop="closes"          content="19:00"/>
        </div>
    </div>
</div>
@endif