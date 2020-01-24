<?php

namespace Common\Infrastructure\UserInterface\Web\Twig;

use Common\Infrastructure\UserInterface\Web\Service\CSRFChecker;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CsrfLinkExtension extends AbstractExtension
{
    protected \Common\Infrastructure\UserInterface\Web\Service\CSRFChecker $csrfChecker;

    public function __construct(CSRFChecker $csrfChecker) {
        $this->csrfChecker = $csrfChecker;
    }

    public function getFunctions() {
        return [
            new TwigFunction('csrf_link_to', [$this, 'linkToFunction'],
                             ['is_safe' => ['html']]),
        ];
    }

    /**
     * Build a link with anchor
     *
     * @param string $path
     * @param string $title
     * @param array $options Available options:
     *  string 'confirm' - Text for the popup
     *  string 'method' - HTTP Method: post, delete, put
     *  string 'csrfIntention' - CSRF intention. If empty then no CSRF. Not used for GET requests
     *  string 'csrfField' - CSRF field name. _token by default
     *  bool 'escape' - escape title, TRUE by default
     */
    public function linkToFunction($path, $title, array $options = array()) {
        $default = array(
            'csrf_intention' => '',
            'csrf_field'     => '_token',
            'escape'         => TRUE,
        );

        $options = array_merge($default, $options);

        $ecape = $options['escape'];
        unset($options['escape']);

        $return = '<a href="%s"%s>%s</a>';

        $return = sprintf($return,
                          htmlspecialchars($path, ENT_COMPAT),
                          $this->_tagOptions($this->_options2javascript($options)),
                          ($ecape) ? htmlspecialchars($title, ENT_COMPAT) : $title
        );

        return $return;
    }

    function _tagOptions(array $options = array()) {
        $html = '';
        foreach ($options as $key => $value) {
            $html .= ' ' . $key . '="' . htmlspecialchars($value, ENT_COMPAT) . '"';
        }

        return $html;
    }

    function _options2javascript($options) {
        // confirm
        $confirm = isset($options['confirm']) ? $options['confirm'] : '';

        unset($options['confirm']);

        // method
        $method = isset($options['method']) ? $options['method'] : FALSE;

        unset($options['method']);

        // CSRF Intention
        $csrfIntention = isset($options['csrf_intention']) ? $options['csrf_intention'] : FALSE;

        unset($options['csrf_intention']);

        // CSRF field name
        $csrfField = isset($options['csrf_field']) ? $options['csrf_field'] : FALSE;

        unset($options['csrf_field']);

        $onclick = isset($options['onclick']) ? $options['onclick'] : '';

        if ($confirm && $method) {
            $options['onclick'] =
                $onclick . 'if (' . $this->_confirmJsFunction($confirm) . ') { ' . $this->_methodJsFunction($method,
                                                                                                            $csrfIntention,
                                                                                                            $csrfField)
                . ' };return false;';
        } else {
            if ($confirm) {
                if ($onclick) {
                    $options['onclick'] = 'if (' . $this->_confirmJsFunction($confirm) . ') { return ' . $onclick
                        . '} else return false;';
                } else {
                    $options['onclick'] = 'return ' . $this->_confirmJsFunction($confirm) . ';';
                }
            } else {
                if ($method) {
                    $options['onclick'] =
                        $onclick . $this->_methodJsFunction($method, $csrfIntention, $csrfField) . 'return false;';
                }
            }
        }

        return $options;
    }

    function _confirmJsFunction($confirm) {
        return "confirm('" . $this->_escapeJs($confirm) . "')";
    }

    /**
     * Escape carrier returns and single and double quotes for Javascript segments.
     */
    function _escapeJs($javascript = '') {
        $javascript = preg_replace('/\r\n|\n|\r/', "\\n", $javascript);
        $javascript = preg_replace('/(["\'])/', '\\\\\1', $javascript);

        return $javascript;
    }

    function _methodJsFunction($method, $csrfIntention, $csrfField) {
        $function =
            "var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'post'; f.action = this.href;";

        //put, delete HTTP methods
        if ('post' != strtolower($method)) {
            $function .= "var m = document.createElement('input'); m.setAttribute('type', 'hidden'); ";
            $function .= sprintf("m.setAttribute('name', '_method'); m.setAttribute('value', '%s'); f.appendChild(m);",
                                 strtolower($method));
        }

        // CSRF protection
        if ($csrfIntention) {
            $function .= "var m = document.createElement('input'); m.setAttribute('type', 'hidden'); ";
            $function .= sprintf("m.setAttribute('name', '%s'); m.setAttribute('value', '%s'); f.appendChild(m);",
                                 $csrfField, $this->csrfChecker->generateToken($csrfIntention));
        }

        $function .= "f.submit();";

        return $function;
    }

    public function getName() {
        return 'csrf_link';
    }
}