<?php

namespace AG\WebApp;

interface Tpl
{
    public function render(array $data = null): string;
}
