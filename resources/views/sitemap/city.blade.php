<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($lists as $item)
        <url>
            <loc>{{$item}}/</loc>
{{--            <lastmod>2020-11-08 11:06:02</lastmod>--}}
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>