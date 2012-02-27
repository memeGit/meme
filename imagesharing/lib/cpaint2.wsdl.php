<?php
/**
* CPAINT WSDL generation library
*
* This file is part of the CPAINT AJAX library.

* released under the terms of the LGPL
* see http://www.fsf.org/licensing/licenses/lgpl.txt for details
*
* @package    CPAINT
* @author     Dominique Stender <dstender@st-webdevelopment.de>
* @copyright  Copyright (c) 2005-2006 Dominique Stender - http://sf.net/projects/cpaint
* @version    $Id: cpaint2.wsdl.php 313 2006-09-30 08:22:39Z saloon12yrd $
*/




  /**
  * CPAINT WSDL generation library
  *
  * @package    CPAINT
  * @access     public
  * @author     Dominique Stender <dstender@st-webdevelopment.de>
  * @copyright  Copyright (c) 2005-2006 Dominique Stender - http://sf.net/projects/cpaint
  * @version    1.0.0
  */
  class cpaint_wsdl {

    /**
    * Classes version
    *
    * @access public
    * @var    string $version
    */
    var $version = '1.0.0';

    /**
    * array of API function names and their I/O parameters
    *
    * @access protected
    * @var    array $functions
    */
    var $functions;

    /**
    * array of complex type schemata
    *
    * @access protected
    * @var    array $types
    */
    var $types;

    /**
    * base name of the script providing the CPAINT api, with out extension
    *
    * @access protected
    * @var    string $basename
    */
    var $basename;

    /**
    * full URL to the CPAINT service
    *
    * @access protected
    * @var    string $api_url
    */
    var $api_url;

    /**
    * targetNamespace
    *
    * @access protected
    * @var    string $tns
    */
    var $tns;

    /**
    * URI of this service
    *
    * @access protected
    * @var    string $uri
    */
    var $uri;

    /**
    * constructor
    *
    * @access public
    * @return void
    */
    function cpaint_wsdl() {
      // register the destructor
      register_shutdown_function(array(&$this, '__destruct'));

      $this->__construct();
    }

    /**
    * PHP5 constructor
    *
    * @access public
    * @return void
    */
    function __construct() {
      $this->functions  = array();
      $this->types      = array();
      $this->basename   = preg_replace('/\.[a-z0-9]+$/', '', basename($_SERVER['SCRIPT_NAME']));
      $this->tns        = 'http://' . $_SERVER['SERVER_NAME'] . '/soap/' . $this->basename;
      $this->uri        = $_SERVER['SERVER_NAME'] . '/CPAINT/' . $this->basename . '/';
      $this->api_url    = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
    }

    /**
    * destructor
    *
    * @access private
    * @return void
    */
    function __destruct() {
    }

    /**
    * generates the WSDL for a CPAINT API
    *
    * @access public
    * @param  array   $functions      array of functions and their I/O parameter schemata
    * @param  array   $types          array of complex type definitions
    * @return string
    */
    function generate($functions, $types) {
      $return_value     = '<?xml version="1.0" encoding="UTF-8" ?>';
      $this->functions  = (array) $functions;
      $this->types      = (array) $types;

      // open base node
      $return_value .= '<definitions'
                      . ' xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"'
                      . ' xmlns:xsd="http://www.w3.org/2001/XMLSchema"'
                      . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'
                      . ' xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"'
                      . ' xmlns:si="http://soapinterop.org/xsd"'
                      . ' xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"'
                      . ' xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"'
                      . ' xmlns="http://schemas.xmlsoap.org/wsdl/"'
                      . ' xmlns:tns="' . $this->tns . '"'
                      . ' targetNamespace="' . $this->tns . '">';

      // iterate over all complex types
      $return_value .= '<types>'
                    . '<xsd:schema targetNamespace="' . $this->tns . '">'
                      . '<xsd:import namespace="http://schemas.xmlsoap.org/soap/encoding/"/>'
                      . '<xsd:import namespace="http://schemas.xmlsoap.org/wsdl/"/>';

      foreach ($this->types as $type_definition) {
        $return_value .= $this->complex_type($type_definition);
      } // end: foreach

      $return_value .= '</xsd:schema>'
                    . '</types>';

      // iterate over all registered functions
      foreach ($this->functions as $function_name => $function_definition) {
        // build the request
        $return_value .= $this->request($function_name);

        // build the response
        $return_value .= $this->response($function_name);
      } // end: foreach

      // add port and binding information
      $return_value .= $this->port_information()
                    .  $this->binding_information()
                    .  $this->service_information();

      // close base node
      $return_value .= '</definitions>';

      return $return_value;
    }

    /**
    * generates a WSDL representation for all complex types
    *
    * @access protected
    * @param  array       $type_definition      schema of the complex type
    * @return string
    */
    function complex_type($type_definition) {
      $return_value     = '';
      $type_definition  = (array) $type_definition;

      switch ($type_definition['type']) {
        case 'complex':
          $return_value .= '<xsd:complexType name="' . $type_definition['name'] . '">'
                        . '<xsd:all>';
          // recurse through the structure
          if (is_array($type_definition['struct'])) {

            foreach ($type_definition['struct'] as $structure) {
              $return_value .= $this->data_element($structure['name'], $structure['type']);
            } // end: foreach
          } // end: if
          $return_value .=  '</xsd:all>'
                          . '</xsd:complexType>';
          break;

        case 'list':
          $return_value .= '<xsd:complexType name="' . $type_definition['name'] . '">'
                          . '<xsd:complexContent>'
                            . '<xsd:restriction base="SOAP-ENC:Array">'
                              . '<xsd:attribute ref="SOAP-ENC:arrayType" wsdl:arrayType="' . $this->data_type($type_definition['base_type']) . '[]"/>'
                            . '</xsd:restriction>'
                          . '</xsd:complexContent>'
                        . '</xsd:complexType>';
          break;

        case 'restriction':
          $return_value .= '<xsd:simpleType name="' . $type_definition['name'] . '">'
                            . '<xsd:restriction base="' . $this->data_type($type_definition['base_type']) . '">';
          // iterate over all allowed values
          if (is_array($type_definition['values'])) {

            foreach ($type_definition['values'] as $value) {
              $return_value .= '<xsd:enumeration value="' . $value . '" />';
            } // end: foreach
          } // end: if

          $return_value .=    '</xsd:restriction>'
                          . '</xsd:simpleType>';
          break;

        default:
          // unknown type
      } // end: switch

      return $return_value;
    }

    /**
    * handles a single element of a complex data type
    *
    * @access protected
    * @param  string      $element_name       name of the element
    * @param  mixed       $element_type       data type of the element
    * @return string
    */
    function data_element($element_name, $element_type) {
      $return_value = '';
      $element_name = (string) $element_name;
      $element_type = $this->data_type($element_type);

      if ($element_type != '') {
        $return_value = '<xsd:element name="' . $element_name . '" type="' . $element_type . '" />';
      } // end: if

      return $return_value;
    }

    /**
    * creates a XML datatype from a given type
    *
    * @access protected
    * @param  string    $type     native type
    * @return string
    */
    function data_type($type) {
      $return_value = '';
      $type         = (string) $type;

      switch (strtolower($type)) {
        // supported scalar types
        case 'ENTITIES':
        case 'ENTITY':
        case 'ID':
        case 'IDREF':
        case 'IDREFS':
        case 'NCName':
        case 'NMTOKEN':
        case 'NMTOKENS':
        case 'Name':
        case 'anySimpleType':
        case 'anyType':
        case 'base64':
        case 'base64Binary':
        case 'boolean':
        case 'byte':
        case 'date':
        case 'dateTime':
        case 'decimal':
        case 'double':
        case 'duration':
        case 'float':
        case 'gDay':
        case 'gMonth':
        case 'gMonthDay':
        case 'gYear':
        case 'gYearMonth':
        case 'hexBinary':
        case 'i4':
        case 'int':
        case 'integer':
        case 'language':
        case 'long':
        case 'negativeInteger':
        case 'nonNegativeInteger':
        case 'nonPositiveInteger':
        case 'normalizedString':
        case 'positiveInteger':
        case 'short':
        case 'string':
        case 'time':
        case 'timeInstant':
        case 'token':
        case 'unsignedByte':
        case 'unsignedInt':
        case 'unsignedLong':
        case 'unsignedShort':
        case 'ur-type':
          $return_value = 'xsd:' . $type;
          break;

        default:

          foreach ($this->types as $id => $type_definition) {

            if ($type_definition['name'] == $type) {
              $return_value = 'tns:' . $type;
              break;
            } // end: if
          } // end: foreach
      } // end: switch

      return $return_value;
    }

    /**
    * generates a XML representation of a request / response argument
    *
    * @access private
    * @param  string    $name     name of the argument
    * @param  string    $type     data type of that argument
    * @return string
    */
    function part($name, $type) {
      $return_value = false;
      $name         = (string) $name;
      $type         = $this->data_type($type);

      if ($type != '') {
        $return_value = '<part name="' . $name . '" type="' . $type . '" />';
      } // end: if

      return $return_value;
    }

    /**
    * generates a WSDL representation for a request
    *
    * @access protected
    * @param  string  $request_name     name of the request
    * @return string
    */
    function request($request_name) {
      $return_value = '';
      $request_name = (string) $request_name;

      $return_value .= '<message name="' . $request_name . 'Request">'
                      . $this->part('head', 'cpaintRequestHead');

      // iterate over all request arguments
      foreach ($this->functions[$request_name]['input'] as $structure) {
        $return_value .= $this->part($structure['name'], $structure['type']);
      } // end: foreach

      $return_value .=  ''
                    . '</message>';

      return $return_value;
    }

    /**
    * generates a WSDL representation for a response
    *
    * @access protected
    * @param  string  $response_name     name of the response
    * @return string
    */
    function response($response_name) {
      $return_value   = '';
      $response_name  = (string) $response_name;

      $return_value .= '<message name="' . $response_name . 'Response">'
                      . $this->part('head', 'cpaintResponseHead');

      // iterate over all response argument
      foreach ($this->functions[$response_name]['output'] as $structure) {
        $return_value .= $this->part($structure['name'], $structure['type']);
      } // end: foreach

      $return_value .= '</message>';

      return $return_value;
    }

    /**
    * generates the port information
    *
    * @access protected
    * @return string
    */
    function port_information() {
      $return_value = '<portType name="' . $this->basename . 'PortType">';

      // describe all API operations
      foreach ($this->functions as $function_name => $function_definition) {
        $return_value .= '<operation name="' . $function_name . '">'
                        . '<documentation>'
                          . $function_definition['comment']
                        . '</documentation>'
                        . '<input message="tns:' . $function_name . 'Request" />'
                        . '<output message="tns:' . $function_name . 'Response" />'
                      . '</operation>';
      } // end: foreach

      $return_value .= '</portType>';

      return $return_value;
    }

    /**
    * generates the binding information
    *
    * @access protected
    * @return string
    */
    function binding_information() {
      $return_value = '<binding name="' . $this->basename . 'Binding" type="tns:' . $this->basename . 'PortType">'
                      . '<soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http" />';

      // describe all API operations
      foreach ($this->functions as $function_name => $function_definition) {
        $return_value .= '<operation name="' . $function_name . '">'
                        . '<soap:operation soapAction="uri:' . $this->uri . $function_name . '" style="rpc" />'
                        . '<input>'
                          . '<soap:body use="encoded" namespace="uri:' . $this->uri . '" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'
                        . '</input>'
                        . '<output>'
                          . '<soap:body use="encoded" namespace="uri:' . $this->uri . '" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'
                        . '</output>'
                      . '</operation>';
      } // end: foreach

      $return_value .= '</binding>';

      return $return_value;
    }

    /**
    * generates the service information
    *
    * @access protected
    * @return string
    */
    function service_information() {
      $return_value = '<service name="' . $this->basename . '">'
                      . '<port name="' . $this->basename . 'Port" binding="tns:' . $this->basename . 'Binding">'
                        . '<soap:address location="' . $this->api_url . '"/>'
                      . '</port>'
                    . '</service>';

      return $return_value;
    }

  }

?>