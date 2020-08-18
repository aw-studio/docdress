<?php

namespace Docdress;

class State
{
    public const MISSING = 'missing';
    public const UP_TO_DATE = 'up-to-date';
    public const NEED_TO_PULL = 'need-to-pull';
    public const NEED_TO_PUSH = 'need-to-push';
    public const DIVERGE = 'diverge';
}
