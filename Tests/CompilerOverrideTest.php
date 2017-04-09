<?php
/**
 * @author Todd Burry <todd@vanillaforums.com>
 */

namespace Symfony\Component\ExpressionLanguage\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\Compiler;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\Node\GetAttrNode;

/**
 * Test overriding expression compilation.
 */
class CompilerOverrideTest extends TestCase {
    /**
     * Test different name patterns.
     */
    public function testNamesCallback() {
        $expr = new ExpressionLanguage();
        $php = $expr->compile('a.b.c', function ($name) {
            return $name.'Foo';
        });
        $this->assertEquals('$aFoo->b->c', $php);
    }

    /**
     *
     */
    public function testObjectToArrayAccess() {
        $expr = new ExpressionLanguage();
        $expr->registerNodeFunction(
            GetAttrNode::class,
            function (Compiler $compiler, GetAttrNode $node) {
                switch ($node->attributes['type']) {
                    case GetAttrNode::METHOD_CALL:
                        $compiler
                            ->compile($node->nodes['node'])
                            ->raw('->')
                            ->raw($node->nodes['attribute']->attributes['value'])
                            ->raw('(')
                            ->compile($node->nodes['arguments'])
                            ->raw(')')
                        ;
                        break;

                    case GetAttrNode::PROPERTY_CALL:
                    case GetAttrNode::ARRAY_CALL:
                        $compiler
                            ->compile($node->nodes['node'])
                            ->raw('[')
                            ->compile($node->nodes['attribute'])->raw(']')
                        ;
                        break;
                }
            });

        $php = $expr->compile('a.b.c', ['a']);
        $this->assertSame('$a["b"]["c"]', $php);
    }

    public function testNamePattern() {
        $expr = new ExpressionLanguage();
        $expr->setNamePattern('/@[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/A');

        $val = $expr->evaluate('@a', ['@a' => 123]);
        $this->assertSame(123, $val);
    }
}
