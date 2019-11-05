<?php

namespace EPA\Infrastructure\UserInterface\EMail;

use EPA\Application\Event\FremdBewertungAnfragenEvent;
use EPA\Application\Services\KontaktiereFremdBewerterService;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;

class VersendeMailAnFremdbewerterService implements KontaktiereFremdBewerterService
{
    /** @var \Swift_Mailer */
    private $swiftMailer;

    /** @var FremdBewertungsAnfrageRepository */
    private $fremdBewertungsAnfrageRepository;

    public function __construct(
        \Swift_Mailer $swiftMailer,
        FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository
    ) {
        $this->swiftMailer = $swiftMailer;
        $this->fremdBewertungsAnfrageRepository = $fremdBewertungsAnfrageRepository;
    }

    public function run(FremdBewertungAnfragenEvent $event): void {
        $this->sendMassage(
            $this->getMailSubject($event,),
            $this->getMailBody($event, $this->getLink($event)),
            $event->fremdBewerterEmail,
            );
    }

    private function getLink(FremdBewertungAnfragenEvent $event): string {
        $token = $this->fremdBewertungsAnfrageRepository->byId(
            FremdBewertungsAnfrageId::fromInt($event->fremdBewertungsAnfrageId)
        )->getFremdBewertungsAnfrageToken();

        return "https://levelup.charite.de/app/fremdbewertung/" . $token->getValue();
    }

    private function sendMassage($subject, $body, $to, $from = "levelup@charite.de") {
        $message = new \Swift_Message();
        $message->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/plain');
        $this->swiftMailer->send($message);
    }

    private function getMailSubject(FremdBewertungAnfragenEvent $event) {
        return "Anfrage zur Fremdbewertung ärztlicher Tätigkeiten von Studierende/r "
            . $event->studiName;
    }

    private function getMailBody(FremdBewertungAnfragenEvent $event, string $link) {
        $text = "Sehr geehrte/r Frau/Herr " . $event->fremdBewerterName . "\n\n"
            . "\n"
            . "Der/Die Studierende " . $event->studiName . " bittet Sie um eine Bewertung\n"
            . "der unter Ihrer Aufsicht durchgeführten ärztlichen Tätigkeiten.\n"
            . "\n";
        if ($event->angefragteTaetigkeiten) {
            $text .= "Zu bewertende Tätigkeiten / Kurs:\n"
                . $event->angefragteTaetigkeiten . "\n\n";
        }
        if ($event->kommentar) {
            $text .= "Kommentar:\n"
                . $event->kommentar . "\n\n";
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
            . $event->studiEmail . "\n"
            . "\n"
            . "Bei technischen Fragen schreiben Sie gerne eine Mail an levelup@charite.de \n"
            . "\n\n"
            . " --- \n"
            . "\n"
            . "Charité - Universitätsmedizin Berlin\n"
            . "Prodekanat für Studium und Lehre | Qualitätssicherung Charité Campus Klinik | Rahel-Hirsch-Weg 5 | 10117 Berlin"
            ;


        return $text;

    }
}
