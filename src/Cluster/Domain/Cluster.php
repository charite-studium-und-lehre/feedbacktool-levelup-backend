<?php

namespace Cluster\Domain;

use Assert\Assertion;

class Cluster
{

    const MIN_TAG_LAENGE = 2;

    const MAX_TAG_LAENGE = 50;

    const INVALID_ZU_KURZ = "Die Clusterbezeichnung muss mindestens " . self::MIN_TAG_LAENGE . " Zeichen enthalten!";

    const INVALID_ZU_LANG = "Die Clusterbezeichnung darf maximal " . self::MAX_TAG_LAENGE . " Zeichen enthalten!";

    /** @var ClusterArt */
    private $clusterArt;

    private $clusterBezeichnung;


    public static function fromValues(ClusterArt $clusterArt, string $clusterBezeichnung): self {
        Assertion::minLength($clusterBezeichnung, self::MIN_TAG_LAENGE, self::INVALID_ZU_KURZ);
        Assertion::maxLength($clusterBezeichnung, self::MAX_TAG_LAENGE, self::INVALID_ZU_LANG);

        if ($clusterBezeichnung != strip_tags($clusterBezeichnung)) {
            throw new ClusterBezeichnungEnthaeltHTMLException();
        }

        $object = new self();
        $object->clusterBezeichnung = $clusterBezeichnung;
        $object->clusterArt = $clusterArt;

        return $object;
    }

    public function getClusterArt(){
        return $this->clusterArt;
    }
    public function getClusterBezeichnung() {
        return $this->clusterBezeichnung;
    }

    public function __toString() {
        return $this->clusterBezeichnung;
    }
}

final class ClusterBezeichnungEnthaeltHTMLException extends \Exception
{
    protected $message = "Die Clusterbezeichnung darf keine HTML-Tags enthalten!";

}
