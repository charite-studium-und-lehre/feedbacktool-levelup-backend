<?php

namespace EPA\Infrastructure\UserInterface\EMail;

use EPA\Application\Command\StudiUeberFremdbewertungInformierenCommand;
use EPA\Application\Services\KontaktiereStudiUeberFremdbewertungService;
use Login\Infrastructure\Web\Service\FrontendUrlService;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class KontaktiereStudiUeberFremdbewertungPerMailService implements KontaktiereStudiUeberFremdbewertungService
{
    private Mailer $mailer;

    private FrontendUrlService $frontendUrlService;

    public function __construct(MailerInterface $mailer, FrontendUrlService $frontendUrlService) {
        $this->mailer = $mailer;
        $this->frontendUrlService = $frontendUrlService;
    }

    public function run(StudiUeberFremdbewertungInformierenCommand $command): void {
        $this->sendMassage(
            $this->getMailSubject($command),
            $this->getMailBody($command, $this->getLink()),
            $command->studiEmail
        );
    }

    private function getLink(): string {
        $frontendUrl = $this->frontendUrlService->getFrontendUrl();

        return "https://levelup.charite.de$frontendUrl/epas";
    }

    private function sendMassage(
        string $subject,
        string $body,
        string $to,
        string $from = "levelup@charite.de"
    ): void {
        $email = new Email();
        $email->subject($subject)
            ->from($from)
            ->to($to)
            ->text($body);
        $this->mailer->send($email);
    }

    private function getMailSubject(StudiUeberFremdbewertungInformierenCommand $command): string {
        return "Neue Fremdbewertung wurde abgegeben von "
            . $command->fremdBewerterName;
    }

    private function getMailBody(
        StudiUeberFremdbewertungInformierenCommand $command,
        string $link
    ): string {
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
