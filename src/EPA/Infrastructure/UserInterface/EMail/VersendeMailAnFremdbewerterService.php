<?php

namespace EPA\Infrastructure\UserInterface\EMail;

use EPA\Application\Command\FremdBewertungAnfrageVerschickenCommand;
use EPA\Application\Services\KontaktiereFremdBewerterService;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use Login\Infrastructure\Web\Service\FrontendUrlService;

class VersendeMailAnFremdbewerterService implements KontaktiereFremdBewerterService
{
    /** @var \Swift_Mailer */
    private $swiftMailer;

    /** @var FremdBewertungsAnfrageRepository */
    private $fremdBewertungsAnfrageRepository;

    /** @var FrontendUrlService */
    private $frontendUrlService;

    public function __construct(
        \Swift_Mailer $swiftMailer,
        FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository,
        FrontendUrlService $frontendUrlService
    ) {
        $this->swiftMailer = $swiftMailer;
        $this->fremdBewertungsAnfrageRepository = $fremdBewertungsAnfrageRepository;
        $this->frontendUrlService = $frontendUrlService;
    }

    public function run(FremdBewertungAnfrageVerschickenCommand $command): void {
        $subject = $this->getMailSubject($command);
        $body = $this->getMailBody($command, $this->getLink($command));
        $to = $command->fremdBewerterEmail;
        $studiTo = $command->studiEmail;
        $this->sendeMailAnBewerter($subject, $body, $to);
        $this->sendeKopieAnStudi($subject, $body, $studiTo, $to);
    }

    private function getLink(FremdBewertungAnfrageVerschickenCommand $command): string {
        $token = $this->fremdBewertungsAnfrageRepository->byId(
            FremdBewertungsAnfrageId::fromInt($command->fremdBewertungsAnfrageId)
        )->getAnfrageToken();

        $appUrl = $this->frontendUrlService->getFrontendUrl();
        return "https://levelup.charite.de$appUrl/epas/fremdbewertung/" . $token->getValue();
    }

    private function sendeMailAnBewerter($subject, $body, $to, $from = "levelup@charite.de") {
        $message = new \Swift_Message();
        $message->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/plain');
        $this->swiftMailer->send($message);
    }

    private function sendeKopieAnStudi($subject, $body, $to, $originalTo, $from = "levelup@charite.de") {
        $subjectStudi = "Levelup: Anfrage zu Fremdbewertug versendet an $originalTo";
        $body = "Folgende Nachricht wurde gerade verschickt:\n\n"
            . "An: $originalTo\n"
            . "Betreff: $subject\n"
            . "Inhalt:\n\n" . $body;
        $message = new \Swift_Message();
        $message->setSubject($subjectStudi)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/plain');
        $this->swiftMailer->send($message);
    }

    private function getMailSubject(FremdBewertungAnfrageVerschickenCommand $command) {
        return "Anfrage zur Fremdbewertung ärztlicher Tätigkeiten von Studierende/r "
            . $command->studiName;
    }

    private function getMailBody(FremdBewertungAnfrageVerschickenCommand $command, string $link) {
        $text = "Sehr geehrte/r Frau/Herr " . $command->fremdBewerterName . "\n\n"
            . "\n"
            . "Der/Die Studierende " . $command->studiName . " bittet Sie um eine Bewertung\n"
            . "der unter Ihrer Aufsicht durchgeführten ärztlichen Tätigkeiten.\n"
            . "\n";
        if ($command->angefragteTaetigkeiten) {
            $text .= "Zu bewertende Tätigkeiten / Kurs:\n"
                . $command->angefragteTaetigkeiten . "\n\n";
        }
        if ($command->kommentar) {
            $text .= "Kommentar:\n"
                . $command->kommentar . "\n\n";
        }
        $text .=
            "\n"
            . "Bitte folgen Sie zum Bewerten dem untenstehenden Link.\n"
            . "\n"
            . "$link\n"
            . "\n"
            . "Mit freundlichen Grüßen\n"
            . "\n"
            . "Ihr Level-Up-Team\n"
            . "\n"
            . " --- \n"
            . "\n\n"
            . "Bei inhaltlichen Fragen wenden Sie sich bitte direkt an den/die Studierende/n: \n"
            . $command->studiEmail . "\n"
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
