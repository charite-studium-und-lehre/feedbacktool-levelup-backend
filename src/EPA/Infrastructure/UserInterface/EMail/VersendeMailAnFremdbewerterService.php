<?php

namespace EPA\Infrastructure\UserInterface\EMail;

use EPA\Application\Command\FremdBewertungAnfrageVerschickenCommand;
use EPA\Application\Services\KontaktiereFremdBewerterService;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use Login\Infrastructure\Web\Service\FrontendUrlService;
use Swift_Mailer;
use Swift_Message;

class VersendeMailAnFremdbewerterService implements KontaktiereFremdBewerterService
{
    private Swift_Mailer $swiftMailer;

    private FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository;

    private FrontendUrlService $frontendUrlService;

    public function __construct(
        Swift_Mailer $swiftMailer,
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

    private function sendeMailAnBewerter(
        string $subject,
        string $body,
        string $to,
        string $from = "levelup@charite.de"
    ): void {
        $message = new Swift_Message();
        $message->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/plain');
        $this->swiftMailer->send($message);
    }

    private function sendeKopieAnStudi(
        string $subject,
        string $body,
        string $to,
        string $originalTo,
        string $from = "levelup@charite.de"
    ): void {
        $subjectStudi = "Levelup: Anfrage zu Fremdbewertug versendet an $originalTo";
        $body = "Folgende Nachricht wurde gerade verschickt:\n\n"
            . "An: $originalTo\n"
            . "Betreff: $subject\n"
            . "Inhalt:\n\n" . $body;
        $message = new Swift_Message();
        $message->setSubject($subjectStudi)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/plain');
        $this->swiftMailer->send($message);
    }

    private function getMailSubject(FremdBewertungAnfrageVerschickenCommand $command): string {
        return "Anfrage zur Fremdbewertung ärztlicher Tätigkeiten von Studierende/r "
            . $command->studiName;
    }

    private function getMailBody(FremdBewertungAnfrageVerschickenCommand $command, string $link): string {
        $text = "Sehr geehrte/r Frau/Herr " . $command->fremdBewerterName . "\n\n"
            . "Studierenden des MSM 2.0 der Charité steht seit November 2019 die interne Feedback-Seite "
            . "LevelUp mit detailliert aufbereiteten Ergebnissen diverser Prüfungsformate auf einen Blick zur "
            . "Verfügung. \n"
            . "Ein weiteres Feature von LevelUp ist, dass Sie als Lehrende/r Studierenden eine direkte Rückmeldung "
            . "zu bestimmten ärztlichen Tätigkeiten auf einer Fremdbewertungsskala geben können. "
            . "\n\n"
            . "Weitere Informationen zu LevelUp finden Sie hier: "
            . "https://intranet.charite.de/service/meldungen/artikel/detail/levelup_ist_online/\n"
            . "Bitte beachten Sie unsere Datenschutzhinweise: "
            . "https://levelup.charite.de/app-develop/user/dataProtection\n\n"
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
            . "$link\n\n"
            . "Fremdbewertungen von Lehrenden helfen Studierenden ihre Entwicklung in der praktischen Kompetenz "
            . "festzuhalten und geben wichtige Hinweise, wo Nachsteuerungsbedarf besteht.\n"
            . "Vielen Dank für Ihre individuelle Rückmeldung!\n"
            . "\n"
            . "Mit freundlichen Grüßen\n"
            . "\n"
            . "Ihr Level-Up-Team\n"
            . "\n"
            . " --- \n"
            . "\n\n"
            . "Bei Fragen schreiben Sie gerne eine Mail an levelup@charite.de \n"
            . "\n\n"
            . " --- \n"
            . "\n"
            . "Charité - Universitätsmedizin Berlin\n"
            . "Prodekanat für Studium und Lehre | Qualitätssicherung Charité Campus Klinik | Rahel-Hirsch-Weg 5 | 10117 Berlin";

        return $text;

    }
}
