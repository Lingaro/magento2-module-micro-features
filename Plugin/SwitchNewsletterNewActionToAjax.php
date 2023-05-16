<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Plugin;

use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Element\Message\InterpretationStrategyInterface;
use Magento\Newsletter\Controller\Subscriber\NewAction;
use Lingaro\MicroFeatures\Model\Config;

class SwitchNewsletterNewActionToAjax
{
    private Config $config;
    private ManagerInterface $messageManager;
    private InterpretationStrategyInterface $messageInterpreter;
    private ResultFactory $resultFactory;

    public function __construct(
        Config $config,
        ManagerInterface $messageManager,
        InterpretationStrategyInterface $messageInterpreter,
        ResultFactory $resultFactory
    ) {
        $this->config = $config;
        $this->messageManager = $messageManager;
        $this->messageInterpreter = $messageInterpreter;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return Redirect|Json
     */
    public function aroundExecute(NewAction $subject, callable $proceed)
    {
        if (!$this->config->isAjaxNewsletterEnabled() || !$subject->getRequest()->isAjax()) {
            return $proceed();
        }
        $proceed();
        $messagesCollection = $this->messageManager->getMessages();
        $message = $messagesCollection->getLastAddedMessage();
        $data = [
            'type' => $message->getType(),
            'message' => $this->messageInterpreter->interpret($message)
        ];
        $messagesCollection->deleteMessageByIdentifier($message->getIdentifier());
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($data);
    }
}
