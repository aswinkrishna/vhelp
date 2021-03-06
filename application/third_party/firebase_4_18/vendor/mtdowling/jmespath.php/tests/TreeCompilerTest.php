<?php
namespace JmesPath\Tests\Tree;

use JmesPath\TreeCompiler;

/**
 * @covers JmesPath\Tree\TreeCompiler
 */
class TreeCompilerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatesSourceCode()
    {
        $t = new TreeCompiler();
        $source = $t->visit(
            ['type' => 'field', 'value' => 'foo'],
            'testing',
            'foo'
        );
        $this->assertContains('<?php', $source);
        $this->assertContains('$value = isset($value->{\'foo\'}) ? $value->{\'foo\'} : null;', $source);
        $this->assertContains('$value = isset($value[\'foo\']) ? $value[\'foo\'] : null;', $source);
    }
}
