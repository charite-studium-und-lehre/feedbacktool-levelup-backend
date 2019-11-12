<?php

namespace EPA\Infrastructure\UserInterface\EMail;

use EPA\Application\Command\FremdBewertungAnfrageVerschickenCommand;
use EPA\Application\Services\KontaktiereStudiUeberFremdbewertungService;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsRepository;

class KontaktiereStudiUeberFremdbewertungPerMailService implements KontaktiereStudiUeberFremdbewertungService
{
    /** @var \Swift_Mailer */
    private $swiftMailer;

    /** @var FremdBewertungsAnfrageRepository */
    private $fremdBewertungsRepository;

    public function __construct(
        \Swift_Mailer $swiftMailer,
        FremdBewertungsRepository $fremdBewertungsRepository
    ) {
        $this->swiftMailer = $swiftMailer;
        $this->fremdBewertungsRepository = $fremdBewertungsRepository;
    }

    public function run(FremdBewertungAnfrageVerschickenCommand $command): void {
        $this->sendMassage(
            $this->getMailSubject($command,),
            $this->getMailBody($command, $this->getLink($command)),
            $command->studiEmail
        );
    }

    private function getLink(FremdBewertungAnfrageVerschickenCommand $command): string {
        return "https://levelup.charite.de/app-develop/epas";
    }

    private function sendMassage($subject, $body, $to, $from = "levelup@charite.de") {
        $message = new \Swift_Message();
        $message->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/plain');
        $this->swiftMailer->send($message);
    }

    private function getMailSubject(FremdBewertungAnfrageVerschickenCommand $command) {
        return "Neue Fremdbewertung wurde abgegeben von "
            . $command->fremdBewerterName;
    }

    private function getMailBody(FremdBewertungAnfrageVerschickenCommand $command, string $link) {
        $text = "Liebe/r " . $command->studiName . "\n\n"
            . "\n"
            . "Sie haben soeben eine neue Fremdbewertung erhalten von\n"
            . $command->fremdBewerterName . " - " . $command->fremdBewerterEmail . "\n"
            . "\n";
        $text .=
            "\n"
            . "Sie können diese Bewertung auf Levelup einsehen:\n"
            . "\n"
            . "$link\n"
            . "\n"
            . "Mit freundlichen Grüßen\n"
            . "\n"
            . "Ihr Level-Up-Team\n"
            . "\n"
            . " --- \n"
            . "\n"
            . "Bei technischen Fragen schreiben Sie gerne eine Mail an levelup@charite.de \n"
            . "\n\n"
            . " --- \n"
            . "\n"
            . "Charité - Universitätsmedizin Berlin\n"
            . "Prodekanat für Studium und Lehre | Qualitätssicherung Charité Campus Klinik | Rahel-Hirsch-Weg 5 | 10117 Berlin";

        return $text;
    }
}
