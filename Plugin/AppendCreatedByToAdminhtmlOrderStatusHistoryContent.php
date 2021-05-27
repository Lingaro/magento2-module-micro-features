<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin;

use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Status\History;
use Magento\Sales\Model\ResourceModel\Order\Status\History\Collection as HistoryCollection;

class AppendCreatedByToAdminhtmlOrderStatusHistoryContent
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
