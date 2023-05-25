<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Controller\UpsertQty;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Lingaro\MicroFeatures\Action\UpsertQuantity;

class Index extends Action implements CsrfAwareActionInterface, HttpPostActionInterface
{
    private FormKeyValidator $formKeyValidator;
    private UpsertQuantity $upsertQuantity;

    public function __construct(Context $context, FormKeyValidator $formKeyValidator, UpsertQuantity $upsertQuantity)
    {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->upsertQuantity = $upsertQuantity;
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        return $this->getRequest()->isAjax()
            ? $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($this->upsertQuantity->execute())
            : $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('/');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        $message = __('Invalid Form Key. Please refresh the page.');
        return new InvalidRequestException($this->resultFactory->create(ResultFactory::TYPE_JSON)->setData([
            'success' => false,
            'message' => $message
        ]), [$message]);
    }

    public function validateForCsrf(RequestInterface $request):? bool
    {
        return $this->formKeyValidator->validate($request);
    }
}
