ExpressionLanguage Component
============================

The ExpressionLanguage component provides an engine that can compile and
evaluate expressions. An expression is a one-liner that returns a value
(mostly, but not limited to, Booleans).

Resources
---------

  * [Documentation](https://symfony.com/doc/current/components/expression_language/introduction.html)
  * [Contributing](https://symfony.com/doc/current/contributing/index.html)
  * [Report issues](https://github.com/symfony/symfony/issues) and
    [send Pull Requests](https://github.com/symfony/symfony/pulls)
    in the [main Symfony repository](https://github.com/symfony/symfony)

Features in this Fork
---------------------

- You can pass a callback for the **$names** argument in the **compile()** method.
- You can add custom node compiler functions that change the way nodes are  compiled using the **addNodeFunction()** method.
- You can customize the regular expression for variables in the lexer using the **setNamePattern()** method.