<?php

namespace App\Services\Pdf;

class SimplePdfDocument
{
    private const PAGE_WIDTH = 595.28;
    private const PAGE_HEIGHT = 841.89;

    /** @var array<int, string> */
    private array $pages = [];

    private int $currentPage = -1;

    public function addPage(): void
    {
        $this->pages[] = '';
        $this->currentPage = array_key_last($this->pages);
    }

    public function pageHeight(): float
    {
        return self::PAGE_HEIGHT;
    }

    public function fillRect(float $x, float $top, float $width, float $height, array $color): void
    {
        $y = self::PAGE_HEIGHT - $top - $height;
        $this->append($this->colorCommand($color, 'rg'));
        $this->append(sprintf('%.2F %.2F %.2F %.2F re f', $x, $y, $width, $height));
    }

    public function strokeRect(
        float $x,
        float $top,
        float $width,
        float $height,
        array $color = [0, 0, 0],
        float $lineWidth = 1
    ): void {
        $y = self::PAGE_HEIGHT - $top - $height;
        $this->append($this->colorCommand($color, 'RG'));
        $this->append(sprintf('%.2F w %.2F %.2F %.2F %.2F re S', $lineWidth, $x, $y, $width, $height));
    }

    public function line(
        float $x1,
        float $top1,
        float $x2,
        float $top2,
        array $color = [0, 0, 0],
        float $lineWidth = 1
    ): void {
        $y1 = self::PAGE_HEIGHT - $top1;
        $y2 = self::PAGE_HEIGHT - $top2;
        $this->append($this->colorCommand($color, 'RG'));
        $this->append(sprintf('%.2F w %.2F %.2F m %.2F %.2F l S', $lineWidth, $x1, $y1, $x2, $y2));
    }

    public function text(
        float $x,
        float $baselineTop,
        string $text,
        float $size = 10,
        string $font = 'regular',
        array $color = [0, 0, 0]
    ): void {
        $fontResource = match ($font) {
            'bold' => 'F2',
            'serif' => 'F3',
            'serif-bold' => 'F4',
            default => 'F1',
        };

        $y = self::PAGE_HEIGHT - $baselineTop;
        $encoded = $this->encodeText($text);

        $this->append($this->colorCommand($color, 'rg'));
        $this->append(sprintf(
            'BT /%s %.2F Tf 1 0 0 1 %.2F %.2F Tm (%s) Tj ET',
            $fontResource,
            $size,
            $x,
            $y,
            $encoded
        ));
    }

    /**
     * Writes wrapped text and returns the next available top coordinate.
     */
    public function wrappedText(
        float $x,
        float $top,
        string $text,
        float $maxWidth,
        float $size = 10,
        string $font = 'regular',
        array $color = [0, 0, 0],
        ?float $lineHeight = null
    ): float {
        $lineHeight ??= $size * 1.35;
        $paragraphs = preg_split('/\R/u', trim($text)) ?: [''];
        $cursor = $top;

        foreach ($paragraphs as $paragraphIndex => $paragraph) {
            $words = preg_split('/\s+/u', trim($paragraph)) ?: [];
            $line = '';

            if ($words === [] || $words === ['']) {
                $cursor += $lineHeight;
                continue;
            }

            foreach ($words as $word) {
                $candidate = $line === '' ? $word : $line . ' ' . $word;

                if ($line !== '' && $this->measureText($candidate, $size, $font) > $maxWidth) {
                    $this->text($x, $cursor, $line, $size, $font, $color);
                    $cursor += $lineHeight;
                    $line = $word;
                } else {
                    $line = $candidate;
                }
            }

            if ($line !== '') {
                $this->text($x, $cursor, $line, $size, $font, $color);
                $cursor += $lineHeight;
            }

            if ($paragraphIndex < count($paragraphs) - 1) {
                $cursor += $lineHeight * 0.35;
            }
        }

        return $cursor;
    }

    public function measureText(string $text, float $size, string $font = 'regular'): float
    {
        $length = mb_strlen($text);
        $factor = in_array($font, ['bold', 'serif-bold'], true) ? 0.56 : 0.52;

        return $length * $size * $factor;
    }

    public function output(): string
    {
        if ($this->pages === []) {
            $this->addPage();
        }

        $objects = [
            1 => '<< /Type /Catalog /Pages 2 0 R >>',
            3 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>',
            4 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>',
            5 => '<< /Type /Font /Subtype /Type1 /BaseFont /Times-Roman /Encoding /WinAnsiEncoding >>',
            6 => '<< /Type /Font /Subtype /Type1 /BaseFont /Times-Bold /Encoding /WinAnsiEncoding >>',
        ];

        $pageReferences = [];

        foreach ($this->pages as $index => $stream) {
            $contentObject = 7 + ($index * 2);
            $pageObject = $contentObject + 1;
            $pageReferences[] = $pageObject . ' 0 R';

            $objects[$contentObject] = sprintf(
                "<< /Length %d >>\nstream\n%s\nendstream",
                strlen($stream),
                $stream
            );

            $objects[$pageObject] = sprintf(
                '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 %.2F %.2F] /Resources << /ProcSet [/PDF /Text] /Font << /F1 3 0 R /F2 4 0 R /F3 5 0 R /F4 6 0 R >> >> /Contents %d 0 R >>',
                self::PAGE_WIDTH,
                self::PAGE_HEIGHT,
                $contentObject
            );
        }

        $objects[2] = sprintf(
            '<< /Type /Pages /Kids [%s] /Count %d /MediaBox [0 0 %.2F %.2F] >>',
            implode(' ', $pageReferences),
            count($pageReferences),
            self::PAGE_WIDTH,
            self::PAGE_HEIGHT
        );

        ksort($objects);
        $maxObject = max(array_keys($objects));
        $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offsets = [0 => 0];

        for ($number = 1; $number <= $maxObject; $number++) {
            $offsets[$number] = strlen($pdf);
            $pdf .= $number . " 0 obj\n" . ($objects[$number] ?? '<< >>') . "\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= 'xref' . "\n";
        $pdf .= '0 ' . ($maxObject + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($number = 1; $number <= $maxObject; $number++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$number]);
        }

        $pdf .= 'trailer' . "\n";
        $pdf .= sprintf('<< /Size %d /Root 1 0 R >>', $maxObject + 1) . "\n";
        $pdf .= 'startxref' . "\n" . $xrefOffset . "\n%%EOF";

        return $pdf;
    }

    private function append(string $command): void
    {
        if ($this->currentPage < 0) {
            $this->addPage();
        }

        $this->pages[$this->currentPage] .= $command . "\n";
    }

    private function colorCommand(array $color, string $operator): string
    {
        [$red, $green, $blue] = array_pad($color, 3, 0);

        return sprintf(
            '%.3F %.3F %.3F %s',
            max(0, min(255, (float) $red)) / 255,
            max(0, min(255, (float) $green)) / 255,
            max(0, min(255, (float) $blue)) / 255,
            $operator
        );
    }

    private function encodeText(string $text): string
    {
        $encoded = iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text);

        if ($encoded === false) {
            $encoded = preg_replace('/[^\x20-\x7E]/', '?', $text) ?? '';
        }

        return str_replace(
            ['\\', '(', ')', "\r", "\n"],
            ['\\\\', '\\(', '\\)', ' ', ' '],
            $encoded
        );
    }
}
