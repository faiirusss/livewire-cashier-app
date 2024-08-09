<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PopupNotification extends Component
{
    public $message;
    public $iconColor;
    public $iconPath;
    public $timeout;
    public $textColor;

    public function __construct($message, $iconColor, $iconPath, $timeout, $textColor)
    {
        $this->message = $message;
        $this->iconColor = $iconColor;
        $this->iconPath = $iconPath;
        $this->timeout = $timeout;
        $this->textColor = $textColor;
    }
    public function render()
    {
        return view('components.popup-notification');
    }
}
