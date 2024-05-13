<?php

namespace application\core\types;

class Type_Header
{
    protected $title;
    protected $buttonsState; //{show | hide}
    protected $buttons;

    // $buttons must be array of the <Type_Button> items
    public function __construct($title = 'HeaderTitle', $state = 'hide')
    {
        $this->title = $title;
        $this->buttonsState = $state;
        $this->buttons = [];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getButtonsState()
    {
        return $this->buttonsState;
    }

    public function setButtonsState($state)
    {
        if ($state == 'show') {
            $state = 'header_buttons';
        }
        $this->buttonsState = $state;
    }

    public function getButtons()
    {
        return $this->buttons;
    }

    public function setButtons($buttons)
    {
        $this->buttons = [];

        foreach ($buttons as $button) {
            $this->buttons[] = new Type_Button($button['id'], $button['name'], $button['action']);
        }

    }

}
