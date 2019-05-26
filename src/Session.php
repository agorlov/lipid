<?php

namespace Lipid;

interface Session
{
    public function exists($param): bool;

    public function get($param);

    public function set($param, $value): void;

    public function unset($param): void;
}
