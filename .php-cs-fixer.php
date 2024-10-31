<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->exclude('storage')
    ->exclude('vendor')
    ->exclude('node_modules');

return (new Config())
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules([
        // Applies PSR-12 coding style standard
        '@PSR12' => true,

        // Uses short array syntax []
        'array_syntax' => ['syntax' => 'short'],

        // Ensures arrays are indented correctly
        'array_indentation' => true,

        // Aligns binary operators for readability
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],

        // Ensures blank line after namespace
        'blank_line_after_namespace' => true,

        // Ensures blank line after opening PHP tag
        'blank_line_after_opening_tag' => true,

        // Ensures blank line before return statements
        'blank_line_before_statement' => [
            'statements' => ['return'],
        ],

        // Controls brace placement, allows single-line closures
        'braces' => [
            'allow_single_line_closure' => true,
        ],

        // Ensures single space after type casts
        'cast_spaces' => ['space' => 'single'],

        // Adds blank line between class methods and properties
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
                'property' => 'one',
            ],
        ],

        // Ensures single space around concatenation operators
        'concat_space' => ['spacing' => 'one'],

        // Adds strict types declaration
        'declare_strict_types' => true,

        // Controls function declaration spacing
        'function_declaration' => ['closure_function_spacing' => 'none'],

        // Ensures space between function typehint and parameter
        'function_typehint_space' => true,

        // Enforces parentheses for include and require
        'include' => true,

        // Enforces post-increment/decrement style
        'increment_style' => ['style' => 'post'],

        // Ensures files end with a newline
        'line_ending' => true,

        // Enforces lowercase casting
        'lowercase_cast' => true,

        // Ensures correct casing for magic methods
        'magic_method_casing' => true,

        // Controls spacing around method arguments
        'method_argument_space' => [
            'on_multiline' => 'ignore',
        ],

        // Ensures native function calls are correctly cased
        'native_function_casing' => true,

        // Ensures no blank lines after class opening
        'no_blank_lines_after_class_opening' => true,

        // Ensures no blank lines after PHPDoc
        'no_blank_lines_after_phpdoc' => true,

        // Ensures no closing PHP tag
        'no_closing_tag' => true,

        // Removes empty PHPDoc blocks
        'no_empty_phpdoc' => true,

        // Removes unnecessary empty statements
        'no_empty_statement' => true,

        // Removes extra blank lines
        'no_extra_blank_lines' => [
            'tokens' => [
                'extra',
                'throw',
                'use',
                'use_trait',
                'curly_brace_block',
                'parenthesis_brace_block',
                'square_brace_block',
            ],
        ],

        // Ensures no leading slash in use statements
        'no_leading_import_slash' => true,

        // Ensures no whitespace before namespace
        'no_leading_namespace_whitespace' => true,

        // Consistently uses echo instead of print
        'no_mixed_echo_print' => ['use' => 'echo'],

        // Ensures no whitespace around multi-line array arrows
        'no_multiline_whitespace_around_double_arrow' => true,

        // Ensure multi-line whitespace before semicolons
        'multiline_whitespace_before_semicolons' => true,

        // Disallows short boolean casting
        'no_short_bool_cast' => true,

        // Removes whitespace before semicolons
        'no_singleline_whitespace_before_semicolons' => true,

        // Ensures no spaces around array offsets
        'no_spaces_around_offset' => ['positions' => ['inside', 'outside']],

        // Removes trailing commas in single-line arrays
        'no_trailing_comma_in_singleline' => true,

        // Removes trailing whitespace
        'no_trailing_whitespace' => true,

        // Removes trailing whitespace in comments
        'no_trailing_whitespace_in_comment' => true,

        // Removes unused imports
        'no_unused_imports' => true,

        // Removes unnecessary return statements
        'no_useless_return' => true,

        // Ensures no whitespace before commas in arrays
        'no_whitespace_before_comma_in_array' => true,

        // Removes whitespace in blank lines
        'no_whitespace_in_blank_line' => true,

        // Standardizes array index braces
        'normalize_index_brace' => true,

        // Sorts imports alphabetically
        'ordered_imports' => ['sort_algorithm' => 'alpha'],

        // Aligns PHPDoc tags
        'phpdoc_align' => false,

        // Ensures PHPDoc indentation
        'phpdoc_indent' => true,

        // Removes @access tags from PHPDoc
        'phpdoc_no_access' => true,

        // Removes @package tags from PHPDoc
        'phpdoc_no_package' => true,

        // Removes useless @inheritdoc tags
        'phpdoc_no_useless_inheritdoc' => true,

        // Enforces lowercase scalar types in PHPDoc
        'phpdoc_scalar' => true,

        // Ensures spacing in single-line @var PHPDoc annotations
        'phpdoc_single_line_var_spacing' => true,

        // Disables enforcing period at end of PHPDoc summary
        'phpdoc_summary' => false,

        // Disables conversion of PHPDoc to regular comments
        'phpdoc_to_comment' => false,

        // Trims blank lines in PHPDoc
        'phpdoc_trim' => true,

        // Ensures correct formatting of types in PHPDoc
        'phpdoc_types' => true,

        // Ensures semicolons after instructions
        'semicolon_after_instruction' => true,

        // Ensures single blank line at the end of file
        'single_blank_line_at_eof' => true,

        // Enforces one property per statement
        'single_class_element_per_statement' => ['elements' => ['property']],

        // Ensures one import per statement
        'single_import_per_statement' => true,

        // Ensures single blank line after imports
        'single_line_after_imports' => true,

        // Enforces single quotes for strings where possible
        'single_quote' => true,

        // Ensures space after semicolons in for loops
        'space_after_semicolon' => ['remove_in_empty_for_expressions' => true],

        // Enforces !== and === instead of <>
        'standardize_not_equals' => true,

        // Ensures spaces around ternary operators
        'ternary_operator_spaces' => true,

        // Removes spaces inside array brackets
        'trim_array_spaces' => true,

        // Ensures correct spacing for unary operators
        'unary_operator_spaces' => true,

        // Ensures whitespace after commas in arrays
        'whitespace_after_comma_in_array' => true,

        // Ensures yoda-style conditions (e.g. 1 === $foo) are reversed (e.g. $foo === 1)
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false,
        ],
    ])
    ->setFinder($finder);
