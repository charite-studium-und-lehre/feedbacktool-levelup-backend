<?php

namespace EPA\Infrastructure\UserInterface\EMail;

use EPA\Application\Command\StudiUeberFremdbewertungInformierenCommand;
use EPA\Application\Services\KontaktiereStudiUeberFremdbewertungService;

class KontaktiereStudiUeberFremdbewertungPerMailService implements KontaktiereStudiUeberFremdbewertungService
{
    /** @var \Swift_Mailer */
    private $swiftMailer;

    public function __construct(\Swift_Mailer $swiftMailer) {
        $this->swiftMailer = $swiftMailer;
    }

    public function run(StudiUeberFremdbewertungInformierenCommand $command): void {
        $this->sendMassage(
            $this->getMailSubject($command,),
            $this->getMailBody($command, $this->getLink($command)),
            $command->studiEmail
        );
    }

    private function getLink(StudiUeberFremdbewertungInformierenCommand $command): string {
        return "https://levelup.charite.de/app-develop/epas";
    }

    private function sendMassage(
        $subject,
        $body,
        $to,
        $from = "levelup@charite.de"
    ) {
        $message = new \Swift_Message();
        $message->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/plain');
        $this->swiftMailer->send($message);
    }

    private function getMailSubject(StudiUeberFremdbewertungInformierenCommand $command) {
        return "Neue Fremdbewertung wurde abgegeben von "
            . $command->fremdBewerterName;
    }

    private function getMailBody(
        StudiUeberFremdbewertungInformierenCommand $command,
        string $link
    ) {
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
