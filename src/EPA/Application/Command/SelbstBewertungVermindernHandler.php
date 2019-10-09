<?php

namespace EPA\Application\Command;

use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use EPA\Domain\SelbstBewertung;
use Lehrberechtigung\Domain\Lehrberechtigung;
use Lehrberechtigung\Domain\LehrberechtigungRepository;
use Lehrberechtigung\Domain\LehrberechtigungsId;
use Lehrberechtigung\Domain\LehrberechtigungsTyp;
use Lehrberechtigung\Domain\LehrberechtigungsUmfang;
use Lehrberechtigung\Domain\Service\LehrberechtigungValidatorService;
use LLPCommon\Domain\Zeitsemester;
use Person\Domain\PersonId;

final class SelbstBewertungVermindernHandler implements CommandHandler
{
    use CommandHandlerTrait;
    use SelbstBewerungsHandlerTrait;

    private function aendereBewertung(SelbstBewertung $selbstBewertung): void {
        $selbstBewertung->vermindereBewertung();
    }

}
