<?php

namespace ENI\QCM\Bundle\StagiaireBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EniQcmStagiaireBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
