<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Plugin;

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

    public function beforeSave(History $subject): void
    {
        $user = $this->session->getUser();
        if ($user) {
            $subject->setData('created_by', $user->getName());
        }
    }
}
