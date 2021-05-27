<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin;

use Magento\Backend\Model\Auth\Session;
use Magento\Sales\Model\Order\Status\History;

/**
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class AddCreatedByBeforeOrderStatusHistorySave
{
    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function beforeSave(History $subject): array
    {
        $user = $this->session->getUser();
        if ($user) {
            $subject->setData('created_by', $user->getName());
        }
        return [];
    }
}
