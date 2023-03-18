<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component {

    /**
     * The alert type.
     *
     * @var string
     */
    public $type;

    /**
     * The alert icon.
     *
     * @var string
     */
    public $icon;

    /**
     * The alert message.
     *
     * @var string
     */
    public $message;

    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $icon
     * @param  string  $message
     * @return void
     */
    public function __construct($type, $icon, $message) {
        $this->type = $type;
        $this->icon = $icon;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render() {
        return view('components.alert');
    }

}
