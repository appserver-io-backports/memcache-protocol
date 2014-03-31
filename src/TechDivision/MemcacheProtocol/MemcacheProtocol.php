<?php

/**
 * TechDivision\MemcacheProtocol\MemcacheProtocol
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category  Library
 * @package   TechDivision_MemcacheProtocol
 * @author    Philipp Dittert <pd@techdivision.com>
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_MemcacheProtocol
 * @link      http://www.appserver.io
 * @link      https://github.com/memcached/memcached/blob/master/doc/protocol.txt
 */

namespace TechDivision\MemcacheProtocol;

/**
 * Memcache protocol constants and helper methods.
 * 
 * @category  Library
 * @package   TechDivision_MemcacheProtocol
 * @author    Philipp Dittert <pd@techdivision.com>
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_MemcacheProtocol
 * @link      http://www.appserver.io
 * @link      https://github.com/memcached/memcached/blob/master/doc/protocol.txt
 */
class MemcacheProtocol
{

    /**
     * The state key for closing the the connection to the client.
     * 
     * @var string
     */
    const STATE_CLOSE = 'close';

    /**
     * The state key for resetting the the connection to the client.
     * 
     * @var string
     */
    const STATE_RESET = 'reset';
}
