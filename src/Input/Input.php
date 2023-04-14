<?php

namespace TripSorter\Input;

interface Input
{
    public function parse(string $text);
}
