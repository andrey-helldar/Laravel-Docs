<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @foreach($resources as $resource)
    <url>
        <loc>{{ $resource->link }}</loc>
        <lastmod>{{ $resource->lastModified }}</lastmod>
        <priority>{{ $resource->priority }}</priority>
    </url>
    @endforeach

</urlset>