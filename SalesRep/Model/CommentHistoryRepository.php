<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Model;

use Lof\SalesRep\Api\CommentHistoryRepositoryInterface;
use Lof\SalesRep\Api\Data\CommentHistoryInterfaceFactory;
use Lof\SalesRep\Api\Data\CommentHistorySearchResultsInterfaceFactory;
use Lof\SalesRep\Model\ResourceModel\CommentHistory as ResourceCommentHistory;
use Lof\SalesRep\Model\ResourceModel\CommentHistory\CollectionFactory as CommentHistoryCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CommentHistoryRepository
 * @package Lof\SalesRep\Model
 */
class CommentHistoryRepository implements CommentHistoryRepositoryInterface
{

    protected $commentHistoryFactory;

    protected $dataObjectProcessor;

    protected $commentHistoryCollectionFactory;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;

    protected $searchResultsFactory;

    private $storeManager;

    protected $resource;

    protected $dataObjectHelper;

    protected $extensionAttributesJoinProcessor;

    protected $dataCommentHistoryFactory;


    /**
     * @param ResourceCommentHistory $resource
     * @param CommentHistoryFactory $commentHistoryFactory
     * @param CommentHistoryInterfaceFactory $dataCommentHistoryFactory
     * @param CommentHistoryCollectionFactory $commentHistoryCollectionFactory
     * @param CommentHistorySearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceCommentHistory $resource,
        CommentHistoryFactory $commentHistoryFactory,
        CommentHistoryInterfaceFactory $dataCommentHistoryFactory,
        CommentHistoryCollectionFactory $commentHistoryCollectionFactory,
        CommentHistorySearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->commentHistoryFactory = $commentHistoryFactory;
        $this->commentHistoryCollectionFactory = $commentHistoryCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataCommentHistoryFactory = $dataCommentHistoryFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Lof\SalesRep\Api\Data\CommentHistoryInterface $commentHistory
    ) {
        /* if (empty($commentHistory->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $commentHistory->setStoreId($storeId);
        } */

        $commentHistoryData = $this->extensibleDataObjectConverter->toNestedArray(
            $commentHistory,
            [],
            \Lof\SalesRep\Api\Data\CommentHistoryInterface::class
        );

        $commentHistoryModel = $this->commentHistoryFactory->create()->setData($commentHistoryData);

        try {
            $this->resource->save($commentHistoryModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the commentHistory: %1',
                $exception->getMessage()
            ));
        }
        return $commentHistoryModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($commentHistoryId)
    {
        $commentHistory = $this->commentHistoryFactory->create();
        $this->resource->load($commentHistory, $commentHistoryId);
        if (!$commentHistory->getId()) {
            throw new NoSuchEntityException(__('CommentHistory with id "%1" does not exist.', $commentHistoryId));
        }
        return $commentHistory->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->commentHistoryCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\SalesRep\Api\Data\CommentHistoryInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Lof\SalesRep\Api\Data\CommentHistoryInterface $commentHistory
    ) {
        try {
            $commentHistoryModel = $this->commentHistoryFactory->create();
            $this->resource->load($commentHistoryModel, $commentHistory->getCommenthistoryId());
            $this->resource->delete($commentHistoryModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the CommentHistory: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($commentHistoryId)
    {
        return $this->delete($this->get($commentHistoryId));
    }
}
