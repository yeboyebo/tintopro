<?php
namespace Absolute\AdvancedSlider\Block\Adminhtml\Slides\Edit;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
class DeleteButton extends GenericButton implements ButtonProviderInterface
{     
    public function getButtonData()
    {
        if(!$this->getObjectId()) { return []; }
        return [
                'label' => __('Delete Slide'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm( \'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
    }
}
