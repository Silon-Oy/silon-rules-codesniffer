<?php

namespace Silon\Sniffs\Formatting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class SpaceAroundArrayBracketsSniff implements Sniff
{
    public function register()
    {
        return [T_OPEN_PARENTHESIS, T_CLOSE_PARENTHESIS];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['code'] === T_OPEN_PARENTHESIS) {
            $nextTokenPtr = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);
            if ($tokens[$nextTokenPtr]['code'] === T_OPEN_SHORT_ARRAY) {
                $spaceAfter = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, $nextTokenPtr, false);
                if ($spaceAfter === false) {
                    $error = 'Missing space after opening parenthesis when followed by opening square bracket';
                    $fix = $phpcsFile->addFixableError($error, $stackPtr, 'MissingSpaceAfterOpenParenthesis');
                    if ($fix === true) {
                        $phpcsFile->fixer->addContent($stackPtr, ' ');
                    }
                }
            }
        } elseif ($tokens[$stackPtr]['code'] === T_CLOSE_PARENTHESIS) {
            $prevTokenPtr = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), null, true);
            if ($tokens[$prevTokenPtr]['code'] === T_CLOSE_SHORT_ARRAY) {
                $spaceBefore = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, $prevTokenPtr, false);
                if ($spaceBefore === false) {
                    $error = 'Missing space before closing parenthesis when preceded by closing square bracket';
                    $fix = $phpcsFile->addFixableError($error, $stackPtr, 'MissingSpaceBeforeCloseParenthesis');
                    if ($fix === true) {
                        $phpcsFile->fixer->addContentBefore($stackPtr, ' ');
                    }
                }
            }
        }
    }
}
