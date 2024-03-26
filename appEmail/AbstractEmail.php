<?php

namespace GabrielBinottiEmail;

abstract class AbstractEmail
{
    abstract protected function setConfig($fileName);
    abstract public static function email($fileName);
}