<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RuntimeException;
use Throwable;

class ExportGithubPages extends Command
{
    protected $signature = 'preview:export
        {--output=docs : Dossier de sortie relatif à la racine du projet}
        {--base-path=/wagyu-france : Préfixe public utilisé par GitHub Pages}';

    protected $description = 'Génère la version statique du site public dans docs pour GitHub Pages';

    /**
     * @var array<string, string>
     */
    private array $pages = [
        '/' => 'index.html',
        '/boutique' => 'boutique.html',
        '/le-wagyu' => 'le-wagyu.html',
        '/histoire' => 'histoire.html',
        '/blog' => 'blog.html',
        '/contact' => 'contact.html',
        '/mentions-legales' => 'mentions-legales.html',
        '/politique-de-confidentialite' => 'politique-de-confidentialite.html',
        '/conditions-generales-de-vente' => 'conditions-generales-de-vente.html',
        '/professionnels' => 'professionnels.html',
        '/reserve-professionnelle' => 'reserve-professionnelle.html',
        '/decoupe-volumes' => 'decoupe-volumes.html',
        '/tracabilite' => 'tracabilite.html',
    ];

    public function handle(Kernel $kernel): int
    {
        $outputOption = trim((string) $this->option('output'));

        if ($outputOption === '' || str_contains($outputOption, '..') || str_starts_with($outputOption, '/')) {
            $this->error('Le dossier de sortie doit être un chemin relatif sûr, par exemple docs.');

            return self::FAILURE;
        }

        $outputPath = base_path($outputOption);
        $basePath = '/'.trim((string) $this->option('base-path'), '/');
        $basePath = $basePath === '/' ? '' : $basePath;

        try {
            File::ensureDirectoryExists($outputPath);

            foreach (File::glob($outputPath.'/*.html') ?: [] as $htmlFile) {
                File::delete($htmlFile);
            }

            $this->replaceDirectory(public_path('assets'), $outputPath.'/assets');

            $storageSource = storage_path('app/public');
            if (File::isDirectory($storageSource)) {
                $this->replaceDirectory($storageSource, $outputPath.'/storage');
            }

            foreach ($this->pages as $route => $filename) {
                $request = Request::create('http://localhost'.$route, 'GET');
                $response = $kernel->handle($request);

                try {
                    if ($response->getStatusCode() >= 400) {
                        throw new RuntimeException(sprintf(
                            'La route %s répond avec le statut HTTP %d.',
                            $route,
                            $response->getStatusCode(),
                        ));
                    }

                    $html = $response->getContent();
                    if (! is_string($html)) {
                        throw new RuntimeException('La réponse de '.$route.' ne contient pas de HTML exploitable.');
                    }

                    File::put(
                        $outputPath.'/'.$filename,
                        $this->rewriteHtml($html, $basePath),
                    );

                    $this->line(sprintf('  <info>✓</info> %-36s %s', $route, $filename));
                } finally {
                    $kernel->terminate($request, $response);
                }
            }

            File::put($outputPath.'/.nojekyll', '');

            $this->newLine();
            $this->info('Aperçu GitHub Pages généré dans '.$outputOption.'.');
            $this->comment('Les formulaires sont volontairement désactivés sur la version statique.');

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error('Export interrompu : '.$exception->getMessage());

            return self::FAILURE;
        }
    }

    private function replaceDirectory(string $source, string $destination): void
    {
        if (! File::isDirectory($source)) {
            throw new RuntimeException('Dossier source introuvable : '.$source);
        }

        if (File::exists($destination)) {
            File::deleteDirectory($destination);
        }

        if (! File::copyDirectory($source, $destination)) {
            throw new RuntimeException('Impossible de copier '.$source.' vers '.$destination.'.');
        }
    }

    private function rewriteHtml(string $html, string $basePath): string
    {
        $html = str_replace([
            'http://localhost:8000',
            'https://localhost:8000',
            'http://127.0.0.1:8000',
            'https://127.0.0.1:8000',
            'http://localhost',
            'https://localhost',
        ], '', $html);

        $routes = $this->pages;
        uksort($routes, static fn (string $left, string $right): int => strlen($right) <=> strlen($left));

        foreach ($routes as $route => $filename) {
            $target = $basePath.'/'.$filename;

            foreach (['"', "'"] as $quote) {
                $html = str_replace('href='.$quote.$route.$quote, 'href='.$quote.$target.$quote, $html);
                $html = str_replace('href='.$quote.$route.'?', 'href='.$quote.$target.'?', $html);
                $html = str_replace('href='.$quote.$route.'#', 'href='.$quote.$target.'#', $html);
            }
        }

        foreach (['"', "'"] as $quote) {
            foreach (['href', 'src', 'poster'] as $attribute) {
                $html = str_replace(
                    $attribute.'='.$quote.'/assets/',
                    $attribute.'='.$quote.$basePath.'/assets/',
                    $html,
                );

                $html = str_replace(
                    $attribute.'='.$quote.'/storage/',
                    $attribute.'='.$quote.$basePath.'/storage/',
                    $html,
                );
            }
        }

        $html = preg_replace_callback(
            '/\bsrcset=(["\'])(.*?)\1/i',
            static function (array $matches) use ($basePath): string {
                $value = str_replace(
                    ['/assets/', '/storage/'],
                    [$basePath.'/assets/', $basePath.'/storage/'],
                    $matches[2],
                );

                return 'srcset='.$matches[1].$value.$matches[1];
            },
            $html,
        ) ?? $html;

        $html = preg_replace(
            '/\bdata-(order|request)-url=(["\']).*?\2/i',
            'data-$1-url="#"',
            $html,
        ) ?? $html;

        $html = preg_replace(
            '/\baction=(["\'])\/(?:contact|boutique\/demande|reserve-pro\/demande)\1/i',
            'action="#"',
            $html,
        ) ?? $html;

        if (! str_contains($html, 'name="robots"')) {
            $html = str_replace(
                '</head>',
                "    <meta name=\"robots\" content=\"noindex,nofollow\">\n</head>",
                $html,
            );
        }

        $previewScript = <<<'HTML'
<script data-preview-static>
document.addEventListener('submit', function (event) {
    event.preventDefault();
    window.alert('Version de démonstration : les formulaires ne sont pas envoyés.');
});
</script>
HTML;

        return str_replace('</body>', $previewScript."\n</body>", $html);
    }
}
