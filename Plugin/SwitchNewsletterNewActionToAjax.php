<?php

/**
 * @copyright Copyright © 2022 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin;

use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Element\Message\InterpretationStrategyInterface;
use Magento\Newsletter\Controller\Subscriber\NewAction;
use Orba\MicroFeatures\Model\Config;

class SwitchNewsletterNewActionToAjax
{
    private Config $config;
    private ManagerInterface $messageManager;
    private InterpretationStrategyInterface $messageInterpretationStrategy;
    private ResultFactory $resultFactory;

    public function __construct(
        Config $config,
        ManagerInterface $messageManager,
        InterpretationStrategyInterface $messageInterpretationStrategy,
        ResultFactory $resultFactory
    ) {
        $this->config = $config;
        $this->messageManager = $messageManager;
        $this->messageInterpretationStrategy = $messageInterpretationStrategy;
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
            'message' => $this->messageInterpretationStrategy->interpret($message)
        ];
        $messagesCollection->deleteMessageByIdentifier($message->getIdentifier());
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($data);
    }
}
