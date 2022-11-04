<?php

/**
 * Celebros (C) 2022. All Rights Reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 */

namespace Celebros\AutoComplete\Plugin\Magento\Search\Helper;

use Magento\Search\Helper\Data as Subj;
use Celebros\AutoComplete\Helper\Data as Helper;

class Data
{
    public const INF_MIN_LENGHT = 99999;

    /**
     * @param Helper $helper
     * @return void
     */
    public function __construct(
        Helper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @param Subj $subj
     * @param int|string $result
     * @return null|string
     */
    public function afterGetSuggestUrl(
        Subj $subj,
        $result
    ) {
        if ($this->helper->isEnabled()) {
            return null;
        }

        return $result;
    }
}
