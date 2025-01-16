<?php
namespace App\Xml;


class XMLBuilder extends \DOMDocument {

  public string $defaultNodeName = "node";

  private string $rootNodeName = "root";

  private \DOMElement $rootElement;


  public function __construct(string $version = "1.0", string $encoding = "utf-8") {
    parent::__construct($version, $encoding);

    $this->rootElement = $this->addData($this->rootNodeName);
  }

  
  public function addData(string|int|float $name, mixed $data = null, array $attributes = [], ?\DOMElement $ParentNode = null): \DOMElement {
    $nodeName = is_string($name) ? $name : $this->defaultNodeName;
    $nodeName = preg_replace('~\s+~u', "", $nodeName);

    switch(true) {
      case is_object($data) AND $data instanceof \DateTimeInterface:
        $Node = $this->addData($nodeName, [
          "date" => $data->format("Y-m-d H:i:s.u"),
          "timezone" => $data->getTimezone()->getName()
        ], $attributes, $ParentNode);
      break;


      case is_iterable($data):
        $Node = parent::createElement($nodeName);
        foreach ($data as $key => $value) {
          if(is_numeric($key) || is_numeric(substr($key, 0, 1))) {
        		$this->addData($this->defaultNodeName, $value, ["id" => $key], $Node);
        	}else {
            $this->addData($key, $value, [], $Node);
        	}
        }
      break;

      case is_object($data) AND $data instanceof XMLSerializable:
        $Node = $this->addData($nodeName, $data->xmlSerialize(), $attributes, $ParentNode);
      break;


      default:
        $Node = parent::createElement($nodeName);
        if(!is_null($data)) {
          $Node->appendChild(parent::createTextNode($data));
        }
    }


    $this->appendAttributes($Node, $attributes);

    if($ParentNode) {
      $ParentNode->appendChild($Node);
    }elseif(isset($this->rootElement)) {
      $this->rootElement->appendChild($Node);
    }else {
      $this->appendChild($Node);
    }

    return $Node;
  }


  public function xslTransform(string $stylesheet): string {
    if(!file_exists($stylesheet)) {
      throw new \RuntimeException("XSL Stylesheet '{$stylesheet}' not found");
    }

    libxml_use_internal_errors(true);
    libxml_clear_errors();
    $XSL = new \DOMDocument();
    if($XSL->load($stylesheet) === false) {
      throw new \RuntimeException("Error ".libxml_get_last_error()->message." while loading xsl template");
    }

    $XSLT = new \XSLTProcessor();
    $XSLT->registerPHPFunctions();
    $XSLT->importStylesheet($XSL);

    libxml_clear_errors();
    $output = $XSLT->transformToXml($this);
    if(libxml_get_errors()) {
      throw new \RuntimeException("XSL transformation failed. Error ".libxml_get_last_error()->message);
    }

    return strval($output);
  }



  public function __toString(): string {
    return $this->saveXML();
  }


  private function appendAttributes(\DOMElement $Node, array $attributes = []): void {
    foreach ($attributes as $name => $value) {
      $attribute = parent::createAttribute($name);
      $Node->appendChild($attribute);

      $textNode = parent::createTextNode($value);
      $attribute->appendChild($textNode);
    }
  }
}
