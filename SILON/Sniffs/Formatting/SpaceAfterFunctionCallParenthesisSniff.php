<?php

namespace Silon\Sniffs\Formatting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class SpaceAfterFunctionCallParenthesisSniff implements Sniff
{
    private $builtInFunctions = [
        'array_map',
        'array_filter',
        'usort',
        'uksort',
        'array_walk',
        'array_reduce',
        'array_walk_recursive',
        'call_user_func',
        'call_user_func_array',
        'array_diff_uassoc',
        'array_diff_ukey',
        'array_intersect_uassoc',
        'array_intersect_ukey',
        'array_udiff',
        'array_udiff_assoc',
        'array_udiff_uassoc',
        'array_uintersect',
        'array_uintersect_assoc',
        'array_uintersect_uassoc',
        'uasort',
        'preg_replace_callback',
        'preg_replace_callback_array',
        'register_shutdown_function',
        'register_tick_function',
        'set_error_handler',
        'set_exception_handler',
        'spl_autoload_register',
        'iterator_apply',
        'ob_start',
        'array_keys',
    ];

    public function register()
    {
        return [T_OPEN_PARENTHESIS];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $prevTokenPtr = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), null, true);

        if ($tokens[$prevTokenPtr]['code'] !== T_STRING) {
            return;
        }

        $functionName = $tokens[$prevTokenPtr]['content'];

        if (!in_array($functionName, $this->builtInFunctions, true)) {
            return;
        }

        $nextTokenPtr = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);

        // Find the closure inside the function call
        $closurePtr = $phpcsFile->findNext(T_CLOSURE, $nextTokenPtr);

        if ($closurePtr === false) {
            return;
        }

        $spaceAfter = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, $nextTokenPtr, false);

        if ($spaceAfter === false) {
            $error = "Missing space after opening parenthesis in {$functionName} function call containing an anonymous function";
            $fix = $phpcsFile->addFixableError($error, $stackPtr, 'MissingSpaceAfterFunctionCallOpenParenthesis');
            if ($fix === true) {
                $phpcsFile->fixer->addContent($stackPtr, ' ');
            }
        }
    }
}
