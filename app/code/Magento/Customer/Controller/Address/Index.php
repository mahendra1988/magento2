<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Customer\Controller\Address;

use Magento\Customer\Api\CustomerRepositoryInterface;

class Index extends \Magento\Customer\Controller\Address
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Core\App\Action\FormKeyValidator $formKeyValidator
     * @param \Magento\Customer\Model\Metadata\FormFactory $formFactory
     * @param \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
     * @param \Magento\Customer\Api\Data\AddressDataBuilder $addressDataBuilder
     * @param \Magento\Customer\Api\Data\RegionDataBuilder $regionDataBuilder
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor
     * @param CustomerRepositoryInterface $customerRepository
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Core\App\Action\FormKeyValidator $formKeyValidator,
        \Magento\Customer\Model\Metadata\FormFactory $formFactory,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Customer\Api\Data\AddressDataBuilder $addressDataBuilder,
        \Magento\Customer\Api\Data\RegionDataBuilder $regionDataBuilder,
        \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
        parent::__construct(
            $context,
            $customerSession,
            $formKeyValidator,
            $formFactory,
            $addressRepository,
            $addressDataBuilder,
            $regionDataBuilder,
            $dataProcessor,
            $resultRedirectFactory,
            $resultForwardFactory,
            $layoutFactory,
            $resultPageFactory
        );
    }

    /**
     * Customer addresses list
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $addresses = $this->customerRepository->getById($this->_getSession()->getCustomerId())->getAddresses();
        if (count($addresses)) {
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $layout = $this->layoutFactory->create();
            $layout->initMessages();
            $block = $resultPage->getLayout()->getBlock('address_book');
            if ($block) {
                $block->setRefererUrl($this->_redirect->getRefererUrl());
            }
            return $resultPage;
        } else {
            return $this->resultRedirectFactory->create()->setUrl($this->_buildUrl('*/*/new'));
        }
    }
}
