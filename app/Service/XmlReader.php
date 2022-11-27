<?php
declare(strict_types=1);

namespace App\Service;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use DOMXPath;

/**
 * Class XmlReader
 */
class XmlReader
{
    /**
     * @var DOMXPath
     */
    private $xpath;

    /**
     * @var DOMDocument
     */
    private $dom;

    /**
     * @param string $xmlString
     * @param bool $clearNamespaces
     */
    public function loadXml($xmlString, $clearNamespaces=false)
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        @$doc->loadXML($xmlString);
        $this->loadDom($doc, $clearNamespaces);
    }

    /**
     * @param DOMDocument $document
     * @param bool $clearNamespaces
     */
    public function loadDom(DOMDocument $document, $clearNamespaces=false)
    {
        $this->dom=$document;
        $this->xpath = new DOMXPath($document);
        if ($clearNamespaces) {
            $this->clearNamespaces();
        }
    }

    /**
     * @return DOMXPath
     */
    public function getXpath()
    {
        return $this->xpath;
    }

    public function clearNamespaces()
    {
        /** @var DOMNode $namespaceNode */
        foreach ($this->xpath->query('//namespace::*') as $namespaceNode) 
        {
            $prefix = str_replace('xmlns:', '', $namespaceNode->nodeName);
            $nodes  = $this->xpath->query("//*[namespace::{$prefix}]");
            /** @var DOMElement $node */
            foreach ($nodes as $node) 
            {
                $namespaceUri = $node->lookupNamespaceURI($prefix);
                $node->removeAttributeNS($namespaceUri, $prefix);
            }
        }
        $this->loadXml($this->dom->saveXML(), false);        
    }

    /**
     * @param string $query                 Query xpath
     * @param DomNode|null $context        Context node
     * @param string|null $def                   Default Value
     * @return string
     */
    public function getValue($query, DOMNode $context = null, ?string $def = ''): ?string
    {
        $nodes = $this->xpath->query($query, $context);
        if ($nodes->length == 0) {
            return $def;
        }

        return $nodes->item(0)->nodeValue;
    }

    /**
     * @param string $query                 Query xpath
     * @param string $attr          Атрибут
     * @param DomNode|null $context        Context node
     * @param string|null $def                   Default Value
     * @return string
     */
    public function getAttribute($query, $attr, DOMNode $context = null, ?string $def = ''): ?string
    {
        $nodes = $this->xpath->query($query, $context);
        if ($nodes->length == 0) {
            return $def;
        }

        return $nodes->item(0)->getAttribute($attr);
    }

    /**
     * @param string        $query
     * @param DOMNode|null $context
     * @return DOMElement|null
     */
    public function getNode($query, $context): ?DOMElement
    {
        $nodes = $this->xpath->query($query, $context);
        if ($nodes->length == 0) {
            return null;
        }

        $node = $nodes->item(0);

        return $node instanceof DOMElement ? $node : null;
    }

    /**
     * @param string        $query
     * @param DOMNode|null $context
     * @return DOMNodeList
     */
    public function getNodes($query, $context)
    {
        return $this->xpath->query($query, $context);
    }
    
    /**
     * Cast a DOMNode into a DOMElement
     */
    private function cast_e(DOMNode $node) : ?DOMElement 
    {
        if ($node) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                return $node;
            }
        }
        return null;
    }

    const QUERY = "query";
    const ATTR = "attr";

    /**
     * @param array        $aQuery
     * @param DOMNode|null $context
     * @return array
     */
    public function extractValues($aQuery, $context): array
    {
        $aProp=array();

        foreach ($aQuery as $key => $q) {
            if ( isset($q[self::ATTR]) ) 
            { 
                if (isset($q[self::QUERY]))
                {
                    $aProp[$key] = $this->getAttribute($q[self::QUERY], $q[self::ATTR], $context); 
                }
                else
                {
                    // getXpath() ?
                    $aProp[$key] = $this->cast_e($context)->getAttribute($q[self::ATTR]);
                    //$aProp[$key] = $this->getAttribute($q["query"], $q["attr"], $context);
                }
            }
            else
            {
                $aProp[$key] = $this->getValue($q[self::QUERY], $context);
            }
            
        }

        return $aProp;

    }
}