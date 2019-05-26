<?php

namespace Lipid;

interface Tpl
{
    public function render(array $data = null): string;
}
