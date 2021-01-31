<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    @foreach($news as $item)
        <url>
            <loc>{{$item->url}}</loc>
            <news:news>
                <news:publication>
                    <news:name>koochita.com</news:name>
                    <news:language>fa</news:language>
                </news:publication>
                <news:publication_date>{{$item->created_at}}</news:publication_date>
                <news:title>{{$item->title}}</news:title>
            </news:news>
        </url>
    @endforeach
</urlset>
