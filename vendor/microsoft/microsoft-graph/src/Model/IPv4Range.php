<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* IPv4Range File
* PHP version 7
*
* @category  Library
* @package   Microsoft.Graph
* @copyright 2016 Microsoft Corporation
* @license   https://opensource.org/licenses/MIT MIT License
* @version   GIT: 0.1.0
* @link      https://graph.microsoft.io/
*/
namespace Microsoft\Graph\Model;
/**
* IPv4Range class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright 2016 Microsoft Corporation
* @license   https://opensource.org/licenses/MIT MIT License
* @version   Release: 0.1.0
* @link      https://graph.microsoft.io/
*/
class IPv4Range extends IpRange
{
    /**
    * Gets the lowerAddress
    * Lower IP Address
    *
    * @return string The lowerAddress
    */
    public function getLowerAddress()
    {
        if (array_key_exists("lowerAddress", $this->_propDict)) {
            return $this->_propDict["lowerAddress"];
        } else {
            return null;
        }
    }

    /**
    * Sets the lowerAddress
    * Lower IP Address
    *
    * @param string $val The value of the lowerAddress
    *
    * @return IPv4Range
    */
    public function setLowerAddress($val)
    {
        $this->_propDict["lowerAddress"] = $val;
        return $this;
    }
    /**
    * Gets the upperAddress
    * Upper IP Address
    *
    * @return string The upperAddress
    */
    public function getUpperAddress()
    {
        if (array_key_exists("upperAddress", $this->_propDict)) {
            return $this->_propDict["upperAddress"];
        } else {
            return null;
        }
    }

    /**
    * Sets the upperAddress
    * Upper IP Address
    *
    * @param string $val The value of the upperAddress
    *
    * @return IPv4Range
    */
    public function setUpperAddress($val)
    {
        $this->_propDict["upperAddress"] = $val;
        return $this;
    }
}
