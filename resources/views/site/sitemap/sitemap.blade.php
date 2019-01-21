<? echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

   <url>
      <loc>{{ env('APP_URL') }}</loc>
      <changefreq>weekly</changefreq>
      <priority>1.0</priority>
   </url>
   <url>
      <loc>{{ env('APP_URL') }}/wishlist</loc>
      <changefreq>weekly</changefreq>
   </url>
   <url>
      <loc>{{ env('APP_URL') }}/compare-products</loc>
      <changefreq>weekly</changefreq>
   </url>
   <url>
      <loc>{{ env('APP_URL') }}/contact</loc>
      <changefreq>weekly</changefreq>
   </url>
   <url>
      <loc>{{ env('APP_URL') }}/guaranty</loc>
      <changefreq>weekly</changefreq>
   </url>
   <url>
      <loc>{{ env('APP_URL') }}/delivery-payment</loc>
      <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/checkout</loc>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/publicoferta</loc>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/about</loc>
        <changefreq>weekly</changefreq>
    </url>






    @foreach($categories as $category)
        <url>
            <loc>{{ env('APP_URL') }}/catalog/{{ $category->url }}</loc>
            <lastmod><?php echo date('c', strtotime($category->updated_at)); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach


    @foreach($products as $product)
      <url>
         <loc>{{ env('APP_URL') . $product->detailUrlProduct() }}</loc>
         <lastmod><?php echo date('c', strtotime($product->updated_at)); ?></lastmod>
         <changefreq>weekly</changefreq>
         <priority>0.6</priority>
      </url>

          @foreach(['attributes', 'reviews', 'questions'] as $url)
            <url>
                <loc>{{ env('APP_URL') . $product->detailUrlProduct() }}/{{ $url }}</loc>
                <lastmod><?php echo date('c', strtotime($product->updated_at)); ?></lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.6</priority>
            </url>
          @endforeach

    @endforeach

</urlset>