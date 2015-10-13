<?php

class ComponentsTest extends \PHPUnit_Framework_TestCase {

    public function testCapabilities() {

        $cap = new \Comodojo\RpcServer\Component\Capabilities();

        $add = $cap->add('spacetrip','https://comodojo.org/spacetrip.html',0.1);

        $this->assertTrue($add);

        $get = $cap->get();

        $this->assertInternalType('array', $get);

        $this->assertCount(1, $get);

        $this->assertInternalType('array', $get['spacetrip']);

        $delete = $cap->delete('spacetrip');

        $this->assertTrue($delete);

        $nullget = $cap->get();

        $this->assertInternalType('array', $nullget);

        $this->assertCount(0, $nullget);

    }

    public function testErrors() {

        $err = new \Comodojo\RpcServer\Component\Errors();

        $add = $err->add(-90000,'Test Error');

        $this->assertTrue($add);

        $add = $err->add(-90000,'Test Error');

        $this->assertFalse($add);

        $get = $err->get(-90000);

        $this->assertEquals('Test Error', $get);

        $get = $err->get(-32098);

        $this->assertEquals('Server Error', $get);

        $get = $err->get(-32601);

        $this->assertEquals('Method not found', $get);

        $get = $err->get(-30000);

        $this->assertEquals('Unknown Error', $get);

        $delete = $err->delete(-90000);

        $this->assertTrue($delete);

    }

    public function testMethods() {

        $met = new \Comodojo\RpcServer\Component\Methods();

        $one = \Comodojo\RpcServer\RpcMethod::create("test.one", function($params) { return $params->get(); })
            ->setDescription("Test Method One")
            ->setReturnType('struct');

        $two = \Comodojo\RpcServer\RpcMethod::create("test.two", function($params) { return $params->get(); })
            ->setDescription("Test Method Two")
            ->setReturnType('struct');

        $add = $met->add($one);

        $this->assertTrue($add);

        $add = $met->add($two);

        $this->assertTrue($add);

        $get = $met->get('test.one');

        $this->assertInstanceOf('\Comodojo\RpcServer\RpcMethod', $get);

        $get = $met->get();

        $this->assertInternalType('array', $get);

        $this->assertCount(2, $get);

        $this->assertInstanceOf('\Comodojo\RpcServer\RpcMethod', $get['test.one']);

        $this->assertInstanceOf('\Comodojo\RpcServer\RpcMethod', $get['test.two']);

        $delete = $met->delete('test.one');

        $this->assertTrue($delete);

        $get = $met->get();

        $this->assertInternalType('array', $get);

        $this->assertCount(1, $get);

    }

}