<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($lists as $item)
        <url>
            <loc>{{$item[0]}}/</loc>
{{--            <lastmod>{{$item[1]}}</lastmod>--}}
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>