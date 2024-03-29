<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */
// +----------------------------------------------------------------------+
// | UDDI: A PHP class library implementing the Universal Description,    |
// | Discovery and Integration API for locating and publishing Web        |
// | Services listings in a UBR (UDDI Business Registry)                  |
// +----------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or        |
// | modify it under the terms of the GNU Lesser General Public           |
// | License as published by the Free Software Foundation; either         |
// | version 2.1 of the License, or (at your option) any later version.   |
// |                                                                      |
// | This library is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU    |
// | General Public License for more details.                             |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this library; if not, write to the Free Software          |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, |
// | USA, or visit http://www.gnu.org/copyleft/lesser.html                |
// +----------------------------------------------------------------------+
// | Authors: Jon Stephens & Lee Reynolds (authors of non-PEAR version)   |
// |          Maintainers and PEARifiers:                                 |
// |          Christian Wenz <chw@hauser-wenz.de>                         |
// |          Tobias Hauser <th@hauser-wenz.de>                           |
// +----------------------------------------------------------------------+
//
//    $Id$
/* Original Credits:

  phpUDDI
  A PHP class library implementing the Universal Description,
  Discovery and Integration API for locating and publishing Web
  Services listings in a UBR (UDDI Business Registry).

  Copyright (C) 2002-2004 Lee Reynolds and Jon Stephens

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA
  or point your web browser to http://www.gnu.org/licenses/lgpl.html.

  Conceived and developed in conjunction with the
  authors' work for the book "PHP Web Services" from Wrox Press
  Ltd. (ISBN-1861008074)

  Original developers:
  Lee Reynolds lee@annasart.com
  Jon Stephens jon@hiveminds.info

  Useful Links:

  Wrox Press "Programmer To Programmer" Discussion Groups
  Pro PHP: http://p2p.wrox.com/list.asp?list=pro_php
  Pro XML: http://p2p.wrox.com/list.asp?list=xml

  HiveMinds Group
  http://www.hiveminds.info/
  http://forums.hiveminds.info/

  Version History:

  0.1   -- 15 November 2002 -- Basic Proof of concept
  0.2   -- 20 November 2002 -- Base class redefinition to
                include public and private methods
  0.3   -- 25 November 2002 -- All UDDI 2.0 Inquiry APIs implemented
  0.3.1 -- 14 March 2004    -- small bugfixes (Christian); license change to LPGL (Lee, Jon)

  Objective for 1.0 release is complete implementation of the UDDI 2.0 API
  (http://www.uddi.org/pubs/ProgrammersAPI-V2.04-Published-20020719.pdf).
  (http://bluetetra.com/resource/uddi2/xsd/urn_uddi-org_api_v2/index.htm).

  Objective for 1.5 release is backwards compatibility with UDDI 1.0.

  Objective for 2.0 release is complete implementation of the UDDI 3.0 API
  (http://www.uddi.org/pubs/uddi-v3.00-published-20020719.pdf).

*/

require_once 'PEAR.php';

/**
 * PEAR::UDDI
 * class that implements the UDDI API
 * @link http://www.uddi.org/
 *
 * pearified version of phpUDDI by Stephens & Reynolds
 * 
 * 
 * @category Web Services
 * @package  UDDI
 * @version  0.2.3
 * @author   Christian Wenz <chw@hauser-wenz.de>
 * @author   Tobias Hauser <th@hauser-wenz.de>
 * @todo     fully implement UDDI 2.0 (and later 1.0, 3.0)
 * @todo     more helper functions (for analyzing the data returned by querying a UBR)


Name:
  UDDI.php - UDDI Registry access library (PEARified version)

Synopsis:
  require_once 'UDDI/UDDI.php';

Currently, PEAR::UDDI supports one function call in one UDDI API.

Variables supported:
  $UDDI::_api
  currently 2 values are supported, and they represent 2 of the 6 published APIs by UDDI.org.
  'Inquiry' which represents the search and _query API
  'Publish' which represents the publishing API

  Usage:
  <code>
    $UDDI::_api = 'Inquiry'; // (default)
    $UDDI::_api = 'Publish';
  </code>

  $UDDI::_uddiversion
  This is the API version of the UPI spec you want to use
  Values are either 1, 2, or 3.

  Usage:
  <code>
    $UDDI::_uddiversion = 2;
  </code>

  Default:
    currently, the version default is '1';

  Note: As stated above, we are aiming for a 1.0 release of this library which implements
  the UDDI 2.0 Programming API; we cannot guarantee at this time that any of the API functions
  as implemented here will work correctly (or at all) unless you set the version to 2 as shown
  under 'Usage' immediately above or by setting the version when you call the UDDI class constructor:

  <code>
  $my_uddi = new UDDI('SAP', 2);
  </code>

  At a later date we will make this class compatible with UDDI Versions 1.0 and 3.0.

  $UDDI::_regarray
  We currently support the one remaining test registry: 'SAP'.
  We also support 2 API interfaces. These are, as noted above, 'Inquiry' and 'Publish'.

  To add live registry entries, or your own test registry, you must append a multiple index array element
  to $UDDI::_regarray.  The form for this follows:
  <code>
    array('registry name' =>
    array('Inquiry' =>
      array('url' => 'url_for_inquiry',
        'port' => 80),
        'Publish' =>
      array('url' => 'url_for_publish',
        'port' => 443)));
  </code>
  Internally this is accessed as 
  <code>URL = $_regarray['registry_name']['Inquiry']['url']</code>
  , and
  <code>port = $_regarray['registry_name']['Inquiry']['port']</code>

  PLEASE NOTE: You're adding elements to this array, instead of overwriting old ones.

  Usage:
  <code>
    $UDDI::_regarray = array('private' =>
              array('Inquiry' =>
              array('url' =>'url_for_inquiry',
                  'port' => 80),
                  'Publish' =>
                      array('url' => 'url_for_publishing',
                          'port' => 443)));
  </code>

  $UDDI::_xmlns
  You can modify the XML namespace by reassigning a value to this

  Usage:
  <code>
    $UDDI::_xmlns = 'new_ns_definition';
  </code>

  Default:
     'urn:uddi-org:api'

  $UDDI::_debug
  Turns on debugging by echoing HTTP headers and UDDI queries.

  Usage:
  <code>
    $UDDI::_debug = true;
  </code>

  Default:
    false

  $UDDI::_transmit
  Turns on _posting of UDDI message to UBR.

  Usage:
  <code>
    $UDDI::_transmit = false;
  </code>

  Default:
    true;


EXAMPLE:

This queries SAP's UDDI Registry for the first 50 businesses whose names include
the word "Acme", matches sorted first in ascending order by name, then in descending
order by date last updated. The raw XML that's returned is escaped and echoed to the page.

<code>
$my_uddi = new UDDI('SAP', 1);
$result = htmlspecialchars($my_uddi->find_business(array('name' => '%Acme%', 'maxRows' => 50, 'findQualifiers' => 'sortByNameAsc,sortByDateAsc')));
echo "<pre>$result</pre>";
</code>

*/


// {{{ constants
/**
 * version of corresponding phpUDDI version
 * still included so that moving from phpUDDI to PEAR::UDDI is easier 
 */

define('UDDI_PHP_LIB_VERSION', '0.3.1p'); //suffix p = PEAR :-)

// }}}
// {{{ UDDI

/**
 * UDDI
 *
 * class that implements the UDDI API
 * 
 * @package  UDDI
 * @author   Christian Wenz <chw@hauser-wenz.de>
 * @author   Tobias Hauser <th@hauser-wenz.de>
*/
class UDDI extends PEAR
{
    // {{{ properties

    /**
     * version of package
     * @var string $_version
     */
    var $_version = '0.2.3';

    /**
     * whether to return the UDDI call�s response headers
     * ('headers'), the body ('body'), or both ('all', default)
     * @var string $_returnMode
     */
    var $_returnMode = 'all';

    /**
     * list of known registries
     * @var array $regarray
     */
    var $_regarray =
        array(
            'SAP' =>
                array(
                    'Inquiry'  =>
                        array(
                            'url'  => 'uddi.sap.com/uddi/api/inquiry/',
                            'port' => 80),
                    'Publish' =>
                        array('url' => 'https://uddi.sap.com/uddi/api/publish/',
                            'port' => 443))/*,
            'IBM' =>
                array(
                    'Inquiry'  =>
                        array(
                            'url'  => 'www-3.ibm.com/services/uddi/testregistry/inquiryapi',
                            'port' => 80),
                    'Publish' =>
                        array('url' => 'https://www-3.ibm.com/services/uddi/testregistry/protect/publishapi',
                            'port' => 443)),
            'Microsoft' =>
                array(
                    'Inquiry' =>
                        array(
                            'url' => 'test.uddi.microsoft.com/inquire',
                            'port' => 80),
                    'Publish' =>
                        array(
                            'url' => 'https://test.uddi.microsoft.com/publish',
                            'port' => 443))*/);

    /**
     * which API to use (Inquiry/Publish)
     * @var string $_api
     */
    var $_api = 'Inquiry';

    /**
     * used XML namespace
     * @var string $_xmlns
     */
    var $_xmlns = 'urn:uddi-org:api';

    /**
     * used UDDI version
     * @var string $_uddiversion
     */
    var $_uddiversion  = 1;

    /**
     * used XML generic version
     * @var string $_generic
     */
    var $_generic;

    /**
     * debug mode
     * @var boolean $_debug
     */
    var $_debug    = false;

    /**
     * Turns on _posting of UDDI message to UBR
     * @var boolean $_transmit
     */
    var $_transmit = true;

    /**
     * Host to use
     * @var string $_host
     */
    var $_host;

    /**
     * URL to use
     * @var string $_url
     */
    var $_url;

    // }}}
    // {{{ constructor

    /**
     * constructor
     *
     * @access   public
     * @param    string   $registry    name of registry to use (defaults to SAP)
     * @param    integer  $version     UDDI version to use 
     */
    function UDDI($registry = 'SAP', $version = 1)
    {
        $this->splitUrl($registry, $version);
    }

    // }}}
    // {{{ splitUrl()

    /**
     * retrieves information from URL and sets params
     *
     * @access   public
     * @param    string   $registry    name of registry to use
     * @param    integer  $version     UDDI version to use 
     */
    function splitUrl($registry, $version)
    {
        $this->_registry = $registry;
        $reg = $this->_regarray[$this->_registry][$this->_api]['url'];
        $reg = str_replace('http://', '', $reg);
        $pos = strpos($reg, '/');
        if ($pos === false) {
            return PEAR::raiseError("Invalid registry (POS = $pos, URL = '$reg')\n");
        }
        $this->_host = substr($reg, 0, $pos);
        $this->_url = substr($reg, $pos, strlen($reg) - 1);

        if ($version > 1) {
            $this->_xmlns .= "_v$version";
        }

        $this->_generic = "$version.0";
    }

    // }}}
    // {{{ post()

    /**
     * assembles HTTP headers and posts these and the UDDI message to the UBR
     *
     * @access   public
     * @param    string  $message    the UDDI message to send
     * @return   string  $data       data returned from the UBR
     */
    function post($message)
    {
        $msg_length = strlen($message);
        $php_version = phpversion();
        $date = str_replace('+0000', 'GMT', gmdate('r', time()));

        $header = '';
        $header .= "POST $this->_url HTTP/1.0\r\n";
        $header .= "Date: $date\r\n";
        $header .= "Content-Type: text/xml; charset=UTF-8\r\n";
        $header .= "User-agent: PEAR::UDDI/$this->_version php/$php_version\r\n";
        $header .= "Host: $this->_host\r\n";
        $header .= "SOAPAction: \"\"\r\n";
        $header .= "Content-Length: $msg_length\r\n\r\n";

        //  echoes HTTP header and UDDI message to page if true
        if ($this->_debug) {
            echo '<pre>' . htmlspecialchars(str_replace('><', ">\n<", $header . $message)) . '</pre>';
        }

        //  sends header and message to UBR if true
        if ($this->_transmit) {
            $port = $this->_regarray[$this->_registry][$this->_api]['port'];
            $fp = fsockopen($this->_host, $port, $errno, $errstr, 5);
            if ($fp === false) {
                return PEAR::raiseError("Couldn't connect to server at $this->_host:$port.<br />Error #$errno: $errstr.");
            };

            $result = fputs($fp, $header);
            if ($result === false) {
                  return PEAR::raiseError('Couldn\'t send HTTP headers.');
            }
            $result = fputs($fp, "$message\n\n");
            if ($result === false) {
                return PEAR::raiseError('Couldn\'t send UDDI message.');
            }

            $response = '';
            while (!feof($fp)) {
                $data = fgets($fp, 1024);
                if ($data !== false) {
                    $response .= $data;
                } else {
                    return PEAR::raiseError('No response from server.');
                }
            }
            $result = fclose($fp);
            if ($result === false) {
                return PEAR::raiseError('Warning: Couldn\'t close HTTP connection.');
            }

            $response = str_replace('><', ">\n<", $response);
            return $response;
        }
    }

    // }}}
    // {{{ query()

    /**
     * sends and UDDI query to the registry server
     *
     * @access   public
     * @param    string  $method     the UDDI message to send
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function query($method, $params)
    {
        if ($this->_api == 'Publish') {
            $message = $this->assemblePublish($method, $params);
        }
        else {
            $message = $this->assembleInquiry($method, $params);
        }
        $data = $this->post($message);
        
        switch ($this->_returnMode) {
            case 'headers': 
                $pos = strpos($data, "\r\n\r\n");
                if ($pos !== false) {
                    $data = substr($data, 0, $pos);
                }
                // if no blank line is found, 
                // assume that only headers were returned
                return $data;
                break; 
            case 'body': 
                $pos = strpos($data, "\r\n\r\n");
                if ($pos !== false) {
                    $data = substr($data, $pos + 4);
                    return $data;
                } else {
                    return '';
                }
                break; 
            case 'all': 
                return $data;
                break; 
            default: 
                return PEAR::raiseError('Unknown return mode.');
                break;                 
        }
    }

    // }}}
    // {{{ assembleInquiry()

    /**
     * generate XML creating the UDDI query for inquiry methods
     *
     * @access   public
     * @param    string  $method     the UDDI message to send
     * @param    array   $params     parameters for the query
     * @return   string  $data       the desired XML query code
     */
    function assembleInquiry($method, $params)
    {
        $head = '<?xml version="1.0" encoding="utf-8"?>';
        $head .= '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">';
        $head .= '<Body>';

        $end = "</$method></Body></Envelope>";

        $attrib = '';
        $element = '';

        if (isset($params['discoveryURLs']) && ($params['discoveryURLs'] != '')) {
            $element .= '<discoveryURLs>' . $params['discoveryURLs'] . '</discoveryURLs>';
        }

        if (isset($params['bindingKey']) && ($params['bindingKey'] != '')) {
            $element .= '<bindingKey>' . $params['bindingKey'] . '</bindingKey>';
        }

        if (isset($params['businessKey']) && ($params['businessKey'] != '')) {
            $element .= '<businessKey>' . $params['businessKey'] . '</businessKey>';
        }

        if (isset($params['serviceKey']) && ($params['serviceKey'] != '')) {
    
            if ($method == 'find_binding') {
                $attrib .= ' serviceKey="' . $params['serviceKey'] . '"';
            }
            if ($method == 'get_serviceDetail') {
                $element .= '<serviceKey>' . $params['serviceKey'] . '</serviceKey>';
            }
        }

        if (isset($params['tModelKey']) && ($params['tModelKey'] != '')) {
            $element .= '<tModelKey>uuid:' . $params['tModelKey'] . '</tModelKey>';
        }

        if (isset($params['findQualifiers']) && ($params['findQualifiers'] != '')) {
            $element .= '<findQualifiers>';
            $findQualifiers = explode(',', $params['findQualifiers']);
            for ($i = 0; $i < count($findQualifiers); $i++) {
                $element .= '<findQualifier>' . $findQualifiers[$i] . '</findQualifier>';
            }
            $element .= '</findQualifiers>';
        }

        if (isset($params['tModelBag']) && ($params['tModelBag'] != '')) {
            $tModelKey = explode(',', $params['tModelBag']);
            $element .= '<tModelBag>';
            for ($i = 0; $i < count($tModelKey); $i++) {
                $element .= '<tModelKey>uuid:' . $tModelKey[$i] . '</tModelKey>';
                $element .= '</tModelBag>';
            }
        }

        if (isset($params['name']) && ($params['name'] != '')) {
            $lang = '';
            if (isset($params['lang']) && ($params['lang'] != '')) {
                $lang = "xml:lang=\"$lang\"";
            }
            $element .= '<name ' . $lang . '>' . $params['name'] . '</name>';
        }

        if (isset($params['identifierBag']) && ($params['identifierBag'] != '')) {
            $element .= '<identifierBag>';
            $keyedReference = explode(',', $params['identifierBag']);
            for ($i = 0; $i < count($keyedReference); $i++) {
                $element .= '<keyedReference>' . $keyedReference[$i] . '</keyedReference>';
            }
            $element .= '</identifierBag>';
        }

        if (isset($params['categoryBag']) && ($params['categoryBag'] != '')) {
            $element .= '<categoryBag>';
            $keyedReference = explode(',', $params['identifierBag']);
            for ($i = 0; $i<count($keyedReference); $i++) {
                $element .= '<keyedReference>' . $keyedReference[$i] . '</keyedReference>';
            }
            $element .= '</categoryBag>';
        }

        if (isset($params['maxRows']) && ($params['maxRows'] != '')) {
            $attrib .= ' maxRows="' . $params['maxRows'] . '"';
        }

        $head .= "<$method $attrib xmlns=\"$this->_xmlns\" generic=\"$this->_generic\">";

        $message = $head;
        $message .= $element;
        $message .= $end;

        return $message;
    }

    // }}}
    // {{{ assemblePublish()

    /**
     * generate XML creating the UDDI query for publishing methods
     *
     * @access   public
     * @param    string  $method     the UDDI message to send
     * @param    array   $params     parameters for the query
     * @return   string  $data       the desired XML query code
     */
    function assemblePublish($method, $params)
    {
        $head = '<?xml version="1.0" encoding="utf-8"?>';
        $head .= '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/"';
        $head .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
        $head .= '<Body>';

        $end = "</$method></Body></Envelope>";

        $attrib = '';
        $element = '';

        if (isset($params['authInfo'])) {
            if (($params['authInfo'] != null)) {
                $element .= '<authInfo>authToken:' . $params['authInfo'] . '</authInfo>';
            }
            else {
                $element .= '<authInfo xsi:null="1"/>';
            }
        }

        if (isset($params['businessEntity']) && (is_array($params['businessEntity']))) {
            $businessEntity = $params['businessEntity'];
            $businessKey = '';
            if (isset($params['businessKey'])) {
                $businessKey = $params['businessKey'];
            }
            $element .= '<businessEntity businessKey="' . $businessKey . '">';
            if (isset($businessEntity['name'])) {
                $element .= $this->getMultiElement('name', 'lang', $businessEntity['name']);
            }
            if (isset($businessEntity['description'])) {
                $element .= $this->getMultiElement('description', 'lang', $businessEntity['description']);
            }
            if (isset($businessEntity['contacts']) && (is_array($businessEntity['contacts']))) {
                $element .= '<contacts>';
                for ($i = 0; $i < count($businessEntity['contacts']); $i++) {
                    $contact = $businessEntity['contacts'][$i];
                    if (is_array($contact)) {
                        $useType = '';
                        if (isset($contact['useType']) && ($contact['useType'] != '')) {
                            $useType = ' useType="' . $contact['useType'] . '"';
                        }
                        $element .= '<contact' . $useType . '>';
                        if (isset($contact['description'])) {
                            $element .= $this->getMultiElement('description', 'lang', $contact['description']);
                        }
                        if (isset($contact['personName'])) {
                            $element .= '<personName>' . $contact['personName'] . '</personName>';
                        }
                        if (isset($contact['phone'])) {
                            $element .= $this->getMultiElement('phone', 'useType', $contact['phone']);
                        }
                        if (isset($contact['email'])) {
                            $element .= $this->getMultiElement('email', 'useType', $contact['email']);
                        }
                        if (isset($contact['address'])) {
                            if (is_array($contact['address'])) {
                                for ($i = 0; $i < count($contact['address']); $i++) {
                                    $address = $contact['address'][$i];
                                    if (is_array($address)) {
                                        if (isset($address['content'])) {
                                            $attributes = '';
                                            if (isset($address['useType']) && ($address['useType'] != '')) {
                                                $attributes .= ' useType="' . $address['useType'] . '"';
                                            }
                                            if (isset($address['sortCode']) && ($address['sortCode'] != '')) {
                                                $attributes .= ' sortCode="' . $address['sortCode'] . '"';
                                            }
                                            if (isset($address['tModelKey']) && ($address['tModelKey'] != '')) {
                                                $attributes .= ' tModelKey="' . $address['tModelKey'] . '"';
                                            }
                                            $element .= '<address' . $attributes . '>' . $address['content'] . '</address>';
                                        }
                                    }
                                    else {
                                        $element .= '<address>' . $address . '</address>';
                                    }
                                }
                            }
                            else {
                                $element .= '<address>' . $contact['address'] . '</address>';
                            }
                        }
                        $element .= '</contact>';
                    }
                }
                $element .= '</contacts>';
            }
            $element .= '</businessEntity>';
        }

        if ($method == 'save_service') {
            $serviceKey = ' serviceKey="';
            if (isset($params['serviceKey'])) {
                $serviceKey .= $params['serviceKey'];
            }
            $serviceKey .= '"';
            $businessKey = '';
            if ((isset($params['businessKey'])) && ($params['businessKey'] != '')) {
                $businessKey = ' businessKey="' . $params['businessKey'] . '"';
            }
            $element .= '<businessService' . $serviceKey . $businessKey . '>';
            if (isset($params['name'])) {
                $element .= $this->getMultiElement('name', 'lang', $params['name']);
            }
            if (isset($params['description'])) {
                $element .= $this->getMultiElement('description', 'lang', $params['description']);
            }
            // TODO: include support for bindingTemplates
            // TODO: include support for categoryBag
            $element .= '</businessService>';
        }

        if ($method == 'save_binding') {
            $bindingKey = ' bindingKey="';
            if (isset($params['bindingKey'])) {
                $bindingKey .= $params['bindingKey'];
            }
            $bindingKey .= '"';
            $serviceKey = '';
            if ((isset($params['serviceKey'])) && ($params['serviceKey'] != '')) {
                $serviceKey = ' serviceKey="' . $params['serviceKey'] . '"';
            }
            $element .= '<bindingTemplate' . $bindingKey . $serviceKey . '>';
            if (isset($params['description'])) {
                $element .= $this->getMultiElement('description', 'lang', $params['description']);
            }
            if ((isset($params['accessPoint'])) && ($params['accessPoint'] != '') && 
                (isset($params['URLType'])) && ($params['URLType'] != '')) {
                $element .= '<accessPoint URLType="' . $params['URLType'] . '">';
                $element .= $params['accessPoint'] . '</accessPoint>';
            }
            $element .= '<tModelInstanceDetails>';
            if (isset($params['tModelInstanceInfo']) && (is_array($params['tModelInstanceInfo']))) {
                foreach ($params['tModelInstanceInfo'] as $tModelInstanceInfo) {
                    if ((is_array($tModelInstanceInfo)) && (isset($tModelInstanceInfo['tModelKey']))) {
                        $element .= '<tModelInstanceInfo tModelKey="' . $tModelInstanceInfo['tModelKey'] . '">';
                        if (isset($tModelInstanceInfo['description'])) {
                            $element .= $this->getMultiElement('description', 'lang', $tModelInstanceInfo['description']);
                        }
                        // TODO: include support for instanceDetails
                        $element .= '</tModelInstanceInfo>';
                    }
                }
            }

            $element .= '</tModelInstanceDetails>';
            // TODO: include support for hostingRedirector
            $element .= '</bindingTemplate>';
        }

        $head .= "<$method $attrib xmlns=\"$this->_xmlns\" generic=\"$this->_generic\">";

        $message = $head;
        $message .= $element;
        $message .= $end;

        return $message;
    }

    // }}}
    // {{{ getMultiElement()

    /**
     * Returns the XML representation of an element that can appear several
     * times with an optional attribute. In UDDI this happens with language
     * aware elements (with "lang" attribute) or with other elements that 
     * can have the "useType" attribute. $param can be a simple string 
     * (interpreted as a single element without the attribute) or an array
     * of strings (interpreted as multiple elements without the attribute) 
     * or an array of arrays with keys 'content' and $attribute.
     *
     * @access   public
     * @param    string  $name       element name
     * @param    string  $attribute  attribute name
     * @param    mixed   $param      parameter
     * @return   string  $data       XML representation for the element
     */
    function getMultiElement($name, $attribute, $param)
    {
        $element = '';
        if (is_array($param)) {
            foreach ($param as $entry) {
                if (is_array($entry)) {
                    if (isset($entry['content'])) {
                        $lang = '';
                        if (isset($entry[$attribute]) && ($entry[$attribute] != '')) {
                            $lang = ' ' . $attribute . '="' . $entry[$attribute] . '"';
                        }
                        $element .= '<' . $name . $lang . '>' . $entry['content'] . '</' . $name . '>';
                    }
                }
                else {
                    $element .= '<' . $name . '>' . $entry . '</' . $name . '>';
                }
            }
        }
        else {
            $element .= '<' . $name . '>' . $param . '</' . $name . '>';
        }

        return $element;
    }

    // }}}
    // {{{ find_binding()

    /**
     * Sends find_binding inquiry to UBR (searchs for bindings within a businessService element)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function find_binding($params)
    {
        $data = $this->query('find_binding', $params);
        return $data;
    }

    // }}}
    // {{{ find_business()

    /**
     * Sends find_business inquiry to UBR (searchs businessEntity elements)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function find_business($params)
    {
        $data = $this->query('find_business', $params);
        return $data;
    }

    // }}}
    // {{{ find_relatedBusinesses()

    /**
     * Sends find_relatedBusinesses inquiry to UBR (searchs for related businessEntity elements for a given businessKey)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function find_relatedBusinesses($params)
    {
        $data = $this->query('find_relatedBusinesses', $params);
        return $data;
    }

    // }}}
    // {{{ find_service()

    /**
     * Sends find_service inquiry to UBR (searchs for businessService elements)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function find_service($params)
    {
        $data = $this->query('find_service', $params);
        return $data;
    }

    // }}}
    // {{{ find_tModel()

    /**
     * Sends find_tModel inquiry to UBR (searchs for tModel elements)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function find_tModel($params)
    {
        $data = $this->query('find_tModel', $params);
        return $data;
    }

    // }}}
    // {{{ get_bindingDetail()

    /**
     * Sends get_bindingDetail inquiry to UBR (returns bindingDetail elements for one or more bindingKey elements)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function get_bindingDetail($params)
    {
        $data = $this->query('get_bindingDetail', $params);
        return $data;
    }

    // }}}
    // {{{ get_businessDetail()

    /**
     * Sends get_businessDetail inquiry to UBR (returns information about one or more businessEntity elements)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function get_businessDetail($params)
    {
        $data = $this->query('get_businessDetail', $params);
        return $data;
    }

    // }}}
    // {{{ get_businessDetailExt()

    /**
     * Sends get_businessDetailExt inquiry to UBR (returns extended information about one or more businessEntity elements)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function get_businessDetailExt($params)
    {
        $data = $this->query('get_businessDetailExt', $params);
        return $data;
    }

    // }}}
    // {{{ get_serviceDetail()

    /**
     * Sends get_serviceDetail inquiry to UBR (returns information about one or more businessService elements)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function get_serviceDetail($params)
    {
        $data = $this->query('get_serviceDetail', $params);
        return $data;
    }

    // }}}
    // {{{ get_tModelDetail()

    /**
     * Sends get_tModelDetail inquiry to UBR (returns information about one or more tModel elements)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function get_tModelDetail($params)
    {
        $data = $this->query('get_tModelDetail', $params);
        return $data;
    }

    // }}}
    // {{{ save_business()

    /**
     * Sends save_business publish request to UBR (returns a businessDetail message containing the final results of the call that reflects the new registered information for the businessEntity information provided)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function save_business($params)
    {
        $data = $this->query('save_business', $params);
        return $data;
    }

    // }}}
    // {{{ save_service()

    /**
     * Sends save_service publish request to UBR (returns a serviceDetail message containing the final results of the call that reflects the new registered information for the effected businessService information)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function save_service($params)
    {
        $data = $this->query('save_service', $params);
        return $data;
    }

    // }}}
    // {{{ save_binding()

    /**
     * Sends save_binding publish request to UBR (returns a serviceDetail message containing the final results of the call that reflects the new registered information for the effected bindingTemplate elements)
     *
     * @access   public
     * @param    array   $params     parameters for the query
     * @return   string  $data       response from the registry server
     */
    function save_binding($params)
    {
        $data = $this->query('save_binding', $params);
        return $data;
    }

    // }}}

}

// }}}

?>
