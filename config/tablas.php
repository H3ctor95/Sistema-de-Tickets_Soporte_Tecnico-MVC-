<?php

function db_tbl(string $clave): string {
    static $map = null;
    if ($map === null) {
        $map = [
            'equipos' => 'equipos',
            'tikets' => 'tikets',
            'categorias' => 'tikets_categorias',
            'estados' => 'tikets_estados',
            'prioridades' => 'tikets_prioridades',
            'comentarios' => 'tickets_comentarios',
            'asignaciones' => 'ticket_asignaciones',
            'agentes' => 'agentes',
            'usuarios' => 'usuarios',
            'roles' => 'roles',
        ];
    }
    return $map[$clave] ?? $clave;
}
