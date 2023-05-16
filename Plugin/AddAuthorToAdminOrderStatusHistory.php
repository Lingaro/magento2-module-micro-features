<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Plugin;

use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Status\History;
use Magento\Sales\Model\ResourceModel\Order\Status\History\Collection as HistoryCollection;

class AddAuthorToAdminOrderStatusHistory
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetStatusHistoryCollection(
        Order $subject,
        HistoryCollection $result
    ): HistoryCollection {
        foreach ($result->getItems() as $item) {
            /** @var $item History */
            if ($item->getComment() && $item->getData('created_by')) {
                $item->setComment(
                    '<i style="font-size: 1.2rem;">' . __('Added by %1', $item->getData('created_by'))
                    . '</i><br />' . $item->getComment()
                );
            }
        }
        return $result;
    }
}
