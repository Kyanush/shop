@php
    $schema = [
          "@context" => "https://schema.org",
          "@type"    => "BreadcrumbList"
    ];

    foreach($breadcrumbs as $key => $item)
    {
       if(!empty($item['link']))
       {
           $schema['itemListElement'][] = [
                "@type"    => "ListItem",
                "position" => $key + 1,
                "item" => [
                  "@id"  => env('APP_URL') . $item['link'],
                  "name" => $item['title']
                ]
           ];
       }
    }
@endphp



@section('schemas_breadcrumb')
    <script type="application/ld+json">
        <?php echo json_encode($schema);?>
    </script>
@stop