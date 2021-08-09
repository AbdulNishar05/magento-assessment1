<?php

namespace My\Form\Controller\Adminhtml\Form;

class Delete extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $formId = (int)$this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($formId && (int) $formId > 0) {
            try {
                $model = $this->_objectManager->create('My\Form\Model\Customer');
                $model->load($formId);
                $model->delete();
                $this->messageManager->addSuccess(__('The Form has been deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/index');
            }
        }
        $this->messageManager->addError(__('Form doesn\'t exist any longer.'));
        return $resultRedirect->setPath('*/*/index');
    }
}
