<?php

namespace iutnc\nrv\render;

interface Renderer
{
    const COMPACT = 1;
    const LONG = 2;
    const COURT = 3;
    const PREFERENCE = 4;
    public function render(int $type): string;
}
