<?php

namespace My\Form\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ObjectManager;
use My\Form\Model\Customer\ImageUploader;

class Customer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * ImageUploader
     *
     * @var \My\Form\Model\Customer\ImageUploader
     */
    protected $_imageUploader;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('custo_table', 'id');
    }

    /**
     * Perform actions before object save
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Framework\DataObject $object
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $name = $object->getName();
        $image = $object->getImage();

        if (empty($name)) {
            throw new LocalizedException(__('The form name is required.'));
        }

        if (is_array($image)) {
            $object->setImage($image[0]['name']);
        }


        return $this;
    }

    /**
     * Perform actions after object delete
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Framework\DataObject $object
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _afterDelete(\Magento\Framework\Model\AbstractModel $object)
    {
        $imageName = $object->getImage();
        $this->_getImageUploader()->deleteImage($imageName);

        return $this;
    }

    /**
     * Get ImageUploader instance
     *
     * @return ImageUploader
     */
    private function _getImageUploader()
    {
        if ($this->_imageUploader === null) {
            $this->_imageUploader = ObjectManager::getInstance()->get(ImageUploader::class);
        }
        return $this->_imageUploader;
    }
}
