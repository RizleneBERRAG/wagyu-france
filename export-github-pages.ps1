$repoName = Read-Host "Nom exact du depot GitHub, exemple wagyu-france"
$base = "/$repoName"
$out = "docs"

function Save-Utf8NoBom($path, $content) {
    $dir = Split-Path $path
    if (!(Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
    }

    [System.IO.File]::WriteAllText($path, $content, [System.Text.UTF8Encoding]::new($false))
}

function Get-Utf8Html($url) {
    $client = New-Object System.Net.WebClient
    $bytes = $client.DownloadData($url)
    return [System.Text.Encoding]::UTF8.GetString($bytes)
}

Remove-Item -Recurse -Force $out -ErrorAction SilentlyContinue
New-Item -ItemType Directory -Path $out | Out-Null

Copy-Item -Recurse public\assets "$out\assets"

$pages = [ordered]@{
    "/" = "index.html"
    "/boutique" = "boutique.html"
    "/le-wagyu" = "le-wagyu.html"
    "/histoire" = "histoire.html"
    "/blog" = "blog.html"
    "/contact" = "contact.html"
    "/professionnels" = "professionnels.html"
    "/reserve-professionnelle" = "reserve-professionnelle.html"
    "/decoupe-volumes" = "decoupe-volumes.html"
    "/tracabilite" = "tracabilite.html"
    "/mentions-legales" = "mentions-legales.html"
    "/politique-de-confidentialite" = "politique-de-confidentialite.html"
    "/conditions-generales-de-vente" = "conditions-generales-de-vente.html"
}

foreach ($route in $pages.Keys) {
    $file = $pages[$route]
    $url = "http://127.0.0.1:8000$route"

    Write-Host "Export $route -> $file"

    $html = Get-Utf8Html $url

    $html = $html.Replace('href="/assets/', "href=`"$base/assets/")
    $html = $html.Replace('src="/assets/', "src=`"$base/assets/")
    $html = $html.Replace('href="http://127.0.0.1:8000/assets/', "href=`"$base/assets/")
    $html = $html.Replace('src="http://127.0.0.1:8000/assets/', "src=`"$base/assets/")

    $html = $html.Replace('href="/?univers=pro"', "href=`"$base/index.html?univers=pro`"")
    $html = $html.Replace('href="/?univers=particulier"', "href=`"$base/index.html?univers=particulier`"")
    $html = $html.Replace('href="http://127.0.0.1:8000?univers=pro"', "href=`"$base/index.html?univers=pro`"")
    $html = $html.Replace('href="http://127.0.0.1:8000?univers=particulier"', "href=`"$base/index.html?univers=particulier`"")
    $html = $html.Replace('href="http://127.0.0.1:8000/?univers=pro"', "href=`"$base/index.html?univers=pro`"")
    $html = $html.Replace('href="http://127.0.0.1:8000/?univers=particulier"', "href=`"$base/index.html?univers=particulier`"")

    foreach ($linkRoute in $pages.Keys) {
        $linkFile = $pages[$linkRoute]
        $finalLink = "$base/$linkFile"

        if ($linkRoute -eq "/") {
            $html = $html.Replace('href="/"', "href=`"$base/index.html`"")
            $html = $html.Replace('href="http://127.0.0.1:8000"', "href=`"$base/index.html`"")
            $html = $html.Replace('href="http://127.0.0.1:8000/"', "href=`"$base/index.html`"")
        } else {
            $html = $html.Replace("href=`"$linkRoute`"", "href=`"$finalLink`"")
            $html = $html.Replace("href=`"http://127.0.0.1:8000$linkRoute`"", "href=`"$finalLink`"")
        }
    }

    Save-Utf8NoBom "$out\$file" $html
}

Get-ChildItem "$out\assets\css" -Filter *.css -Recurse | ForEach-Object {
    $css = Get-Content $_.FullName -Raw -Encoding UTF8

    $css = $css.Replace("url('/assets/", "url('$base/assets/")
    $css = $css.Replace('url("/assets/', "url(`"$base/assets/")
    $css = $css.Replace("url(/assets/", "url($base/assets/")

    Save-Utf8NoBom $_.FullName $css
}

$jsPath = "$out\assets\js\universe-switch.js"

if (Test-Path $jsPath) {
    $js = Get-Content $jsPath -Raw -Encoding UTF8

    $js = $js.Replace('const HOME_URL = "/";', "const HOME_URL = `"$base/index.html`";")

    $js = $js.Replace('ctaHref: "/boutique"', "ctaHref: `"$base/boutique.html`"")
    $js = $js.Replace('ctaHref: "/reserve-professionnelle"', "ctaHref: `"$base/reserve-professionnelle.html`"")
    $js = $js.Replace('homeHref: "/?univers=particulier"', "homeHref: `"$base/index.html?univers=particulier`"")
    $js = $js.Replace('homeHref: "/?univers=pro"', "homeHref: `"$base/index.html?univers=pro`"")
    $js = $js.Replace('cardLinkHref: "/boutique"', "cardLinkHref: `"$base/boutique.html`"")
    $js = $js.Replace('cardLinkHref: "/reserve-professionnelle"', "cardLinkHref: `"$base/reserve-professionnelle.html`"")

    Save-Utf8NoBom $jsPath $js
}

Write-Host ""
Write-Host "Export termine proprement dans /docs"
Write-Host "Base utilisee : $base"
