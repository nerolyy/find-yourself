<?php

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function asset(string $path): string
{
    return 'assets/' . ltrim($path, '/');
}

function render_name_list(array $names, string $emptyText): void
{
    if (!$names) {
        echo '<p class="empty-note">' . e($emptyText) . '</p>';
        return;
    }

    echo '<ul>';
    foreach ($names as $name) {
        echo '<li>' . e($name) . '</li>';
    }
    echo '</ul>';
}
