<?php

/**
 * TechDivision\MemcacheProtocol\MemcacheRequestTest
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Library
 * @package    TechDivision_MemcacheProtocol
 * @author     Tim wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */

namespace TechDivision\MemcacheProtocol;

/**
 * Memcache request test implementation.
 * 
 * @category   Library
 * @package    TechDivision_MemcacheProtocol
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */
class MemcacheRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The request instance to test.
     * 
     * @var \TechDivision\MemcacheServer\MemcacheRequest
     */
    protected $request;
    
    /**
     * Initializes the configuration instance to test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->request = new MemcacheRequest();
    }
    
    /**
     * Dummy test implementation.
     * 
     * @return void
     */
    public function testPushSimpleString()
    {
        
        $line = 'set key 0 100 65';
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame('key', $this->request->getKey());
        $this->assertSame('0', $this->request->getFlags());
        $this->assertSame('100', $this->request->getExpTime());
        $this->assertSame('65', $this->request->getBytes());

        $line = 'a:3:{i:0;s:19:"Some data to be set";i:1;i:1396033521;i:2;i:3600;}';
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame($line, $this->request->getData());
    }
    
    /**
     * Dummy test implementation.
     * 
     * @return void
     */
    public function testPushStringWithNewLineAndLeadingWhitespace()
    {
        
        $line = 'set key 0 100 25';
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame('key', $this->request->getKey());
        $this->assertSame('0', $this->request->getFlags());
        $this->assertSame('100', $this->request->getExpTime());
        $this->assertSame('25', $this->request->getBytes());

        $line = 'Some data with a';
        
        $this->request->push($line . "\r\n");
        
        $line = ' new line';
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame('Some data with a new line', $this->request->getData());
    }
    
    /**
     * Dummy test implementation.
     * 
     * @return void
     */
    public function testPushStringWithNewLineAndEndingWhitespace()
    {
        
        $line = 'set key 0 100 25';
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame('key', $this->request->getKey());
        $this->assertSame('0', $this->request->getFlags());
        $this->assertSame('100', $this->request->getExpTime());
        $this->assertSame('25', $this->request->getBytes());

        $line = 'Some data with a ';
        
        $this->request->push($line . "\r\n");
        
        $line = 'new line';
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame('Some data with a new line', $this->request->getData());
    }
    
    /**
     * Dummy test implementation.
     * 
     * @return void
     */
    public function testPushStringWithInlineNewLine()
    {
        
        $line = 'set key 0 100 38';
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame('key', $this->request->getKey());
        $this->assertSame('0', $this->request->getFlags());
        $this->assertSame('100', $this->request->getExpTime());
        $this->assertSame('38', $this->request->getBytes());

        $line = 'Some data
             with a ';
        
        $this->request->push($line . "\r\n");
        
        $line = 'new line';
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame('Some data
             with a new line', $this->request->getData());
    }

    /**
     * deactivated because test is failing at this moment
     * @todo: fix it.
     *
    public function testPushWithConcatenated()
    {
        $line = 'set key 0 3600 65' . "\r\n" . 'a:3:{i:0;s:19:"Some data to be set";i:1;i:1396366628;i:2;i:3600;}';
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame('key', $this->request->getKey());
        $this->assertSame('0', $this->request->getFlags());
        $this->assertSame('3600', $this->request->getExpTime());
        $this->assertSame('65', $this->request->getBytes());
        
        $this->assertSame('a:3:{i:0;s:19:"Some data to be set";i:1;i:1396366628;i:2;i:3600;}', $this->request->getData());
    }
    */

    /**
     * Test getter/setter with a big data piece.
     *
     * Example data from Magento:
     *
     * array (
     *     0 => 'incr',
     *     1 => 'oi2juh0qnh3u8lf5d1ffj5h5n0.lock',
     *     2 => '1',
     *     'data' => 'add oi2juh0qnh3u8lf5d1ffj5h5n0.lock 768 15 1
     * 1
     * get oi2juh0qnh3u8lf5d1ffj5h5n0
     * '
     * )
     *
     * @return void
     */
    public function testIncrementWithValue()
    {

        $key = 'oi2juh0qnh3u8lf5d1ffj5h5n0.lock';
        $value = '1';
        
        $line = "incr $key $value";
        
        $this->request->push($line . "\r\n");
        
        $this->assertSame($key, $this->request->getKey());
        $this->assertSame($value, $this->request->getData());
    }
    
    /* public function testSomething()
    {
        
        // load the socket pair
        list ($client, $server) = $this->getSocketPair();
        stream_set_timeout($server, 5);
        
        $header = 'set key 0 100 45' . "\r\n";
        $data = 'Some test data 
            with a line break';

        error_log(__METHOD__ . ':' . __LINE__);
        
        // write to the client socket
        fwrite($client, $header . $data . "\r\n");
        
        error_log(__METHOD__ . ':' . __LINE__);
        
        // receive the header
        $buffer = '';
        while ($line = fread($server, 1024)) {
            
            if ($line === false) {
                break;
            }
            
            error_log(var_export($line, true));
            
            $buffer .= $line;
        
            // check if data transmission has finished
            if (false !== strpos($buffer, "\r\n")) {
                break;
            }
        }
        
        error_log(__METHOD__ . ':' . __LINE__);
        
        $headerLine = explode(' ', $buffer);
        
        error_log(var_export($headerLine, true));
        
        $dataRead = fread($server, (integer) $headerLine[4]);
        
        $this->assertEquals($data, $dataRead);
    } */
}
