<?php

namespace App\Services;

class HtmlSanitizer
{
    /**
     * Allowed HTML tag names.
     */
    protected array $allowedTags = [
        'p', 'br', 'hr',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'strong', 'b', 'em', 'i', 'u', 's', 'strike', 'sub', 'sup', 'span', 'small',
        'ul', 'ol', 'li',
        'a',
        'img',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td',
        'div', 'blockquote', 'pre', 'code',
    ];

    /**
     * Dangerous tags whose content must be completely removed.
     */
    protected array $stripWithContentTags = [
        'script', 'style', 'iframe', 'object', 'embed', 'applet',
        'form', 'input', 'button', 'textarea', 'select', 'option',
        'meta', 'link', 'base', 'frame', 'frameset',
    ];

    /**
     * Allowed attribute names per tag (or '*' for all allowed tags).
     */
    protected array $allowedAttributes = [
        '*' => ['class', 'id', 'title', 'lang', 'dir'],
        'a' => ['href', 'target', 'rel', 'title', 'class'],
        'img' => ['src', 'alt', 'title', 'class', 'style', 'width', 'height'],
        'p' => ['class', 'style', 'align'],
        'div' => ['class', 'style', 'align'],
        'span' => ['class', 'style'],
        'h1' => ['class', 'style', 'align'],
        'h2' => ['class', 'style', 'align'],
        'h3' => ['class', 'style', 'align'],
        'h4' => ['class', 'style', 'align'],
        'h5' => ['class', 'style', 'align'],
        'h6' => ['class', 'style', 'align'],
        'table' => ['class', 'style', 'border', 'cellpadding', 'cellspacing', 'width'],
        'th' => ['class', 'style', 'colspan', 'rowspan', 'scope', 'width', 'align'],
        'td' => ['class', 'style', 'colspan', 'rowspan', 'width', 'align'],
        'blockquote' => ['class', 'style', 'cite'],
        'pre' => ['class', 'style'],
        'code' => ['class', 'style'],
    ];

    /**
     * Sanitize an untrusted HTML string.
     */
    public function sanitize(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        // 1. Remove dangerous blocks directly via regex as first defensive layer
        $cleaned = preg_replace('#<script\b[^>]*>(.*?)</script>#is', '', $html);
        $cleaned = preg_replace('#<style\b[^>]*>(.*?)</style>#is', '', $cleaned);
        $cleaned = preg_replace('#<iframe\b[^>]*>(.*?)</iframe>#is', '', $cleaned);
        $cleaned = preg_replace('#<object\b[^>]*>(.*?)</object>#is', '', $cleaned);
        $cleaned = preg_replace('#<embed\b[^>]*>(.*?)</embed>#is', '', $cleaned);

        // 2. Parse DOM
        $dom = new \DOMDocument();
        $libxmlState = libxml_use_internal_errors(true);

        // Wrap with a container tag to preserve full structure without HTML entity deprecation in PHP 8.3
        $convmap = [0x80, 0x10ffff, 0, 0x1fffff];
        $encoded = mb_encode_numericentity('<div id="__sanitizer_root__">' . $cleaned . '</div>', $convmap, 'UTF-8');
        @$dom->loadHTML($encoded, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        libxml_clear_errors();
        libxml_use_internal_errors($libxmlState);

        $root = $dom->getElementById('__sanitizer_root__');
        if (!$root) {
            // Fallback: strip tags if DOM failed
            return strip_tags($cleaned, '<p><br><b><strong><i><em><u><ul><ol><li><a><img>');
        }

        $this->cleanNode($root);

        // Extract inner HTML of the container
        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }

        return trim($output);
    }

    protected function cleanNode(\DOMNode $node): void
    {
        if ($node->nodeType !== XML_ELEMENT_NODE) {
            return;
        }

        /** @var \DOMElement $node */
        $tagName = strtolower($node->tagName);

        // Check if tag is dangerous and must be removed with all children
        if (in_array($tagName, $this->stripWithContentTags, true)) {
            $node->parentNode?->removeChild($node);
            return;
        }

        // Check if tag is allowed
        if (!in_array($tagName, $this->allowedTags, true)) {
            // Unwrap node (keep children, remove this tag)
            $parent = $node->parentNode;
            if ($parent) {
                while ($node->firstChild) {
                    $child = $node->firstChild;
                    $this->cleanNode($child);
                    $parent->insertBefore($child, $node);
                }
                $parent->removeChild($node);
            }
            return;
        }

        // Clean attributes
        if ($node->hasAttributes()) {
            $allowedAttrs = array_merge(
                $this->allowedAttributes['*'] ?? [],
                $this->allowedAttributes[$tagName] ?? []
            );

            $attrsToRemove = [];
            foreach ($node->attributes as $attr) {
                $attrName = strtolower($attr->name);
                $attrValue = trim($attr->value);

                // Disallow any event handlers (on*)
                if (str_starts_with($attrName, 'on')) {
                    $attrsToRemove[] = $attr->name;
                    continue;
                }

                // Check allowed attributes whitelist
                if (!in_array($attrName, $allowedAttrs, true)) {
                    $attrsToRemove[] = $attr->name;
                    continue;
                }

                // Validate href protocol on <a>
                if ($tagName === 'a' && $attrName === 'href') {
                    if (!$this->isSafeUrl($attrValue, false)) {
                        $attrsToRemove[] = $attr->name;
                        continue;
                    }
                    if ($node->getAttribute('target') === '_blank') {
                        $node->setAttribute('rel', 'noopener noreferrer');
                    }
                }

                // Validate src on <img>
                if ($tagName === 'img' && $attrName === 'src') {
                    if (!$this->isSafeUrl($attrValue, true)) {
                        $attrsToRemove[] = $attr->name;
                        continue;
                    }
                }

                // Sanitize style attribute
                if ($attrName === 'style') {
                    $safeStyle = $this->sanitizeStyle($attrValue);
                    if ($safeStyle === '') {
                        $attrsToRemove[] = $attr->name;
                    } else {
                        $node->setAttribute('style', $safeStyle);
                    }
                }
            }

            foreach ($attrsToRemove as $attrName) {
                $node->removeAttribute($attrName);
            }
        }

        // Recursively clean children
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }
        foreach ($children as $child) {
            $this->cleanNode($child);
        }
    }

    protected function isSafeUrl(string $url, bool $allowDataImage = false): bool
    {
        $trimmed = trim(strtolower($url));

        // Check for disallowed pseudo-protocols
        if (preg_match('/^(javascript|vbscript|data):/i', $trimmed)) {
            if ($allowDataImage && preg_match('/^data:image\/(png|jpeg|jpg|webp|gif);base64,/i', $trimmed)) {
                return true;
            }
            return false;
        }

        // Allowed schemes or relative URLs
        if (str_starts_with($trimmed, 'http://') ||
            str_starts_with($trimmed, 'https://') ||
            str_starts_with($trimmed, 'mailto:') ||
            str_starts_with($trimmed, 'tel:') ||
            str_starts_with($trimmed, '/') ||
            str_starts_with($trimmed, '#')) {
            return true;
        }

        return false;
    }

    protected function sanitizeStyle(string $style): string
    {
        $lowered = strtolower($style);

        // Block expression(), behavior, javascript:, url()
        if (str_contains($lowered, 'expression') ||
            str_contains($lowered, 'javascript:') ||
            str_contains($lowered, 'behavior') ||
            str_contains($lowered, '-moz-binding') ||
            str_contains($lowered, 'url(')) {
            return '';
        }

        return $style;
    }
}
